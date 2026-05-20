const API_URL = 'http://localhost:8000/api';
const app = document.getElementById('app');

let user = null;
let todos = [];

// Проверяем, есть ли сохраненный пользователь
const savedUser = localStorage.getItem('user');
const savedToken = localStorage.getItem('token');
if (savedUser && savedToken) {
    user = JSON.parse(savedUser);
    loadTodos();
} else {
    showLogin();
}

// Функция для запросов
async function request(url, method = 'GET', data = null) {
    const headers = {
        'Content-Type': 'application/json'
    };
    
    const token = localStorage.getItem('token');
    if (token) {
        headers['Authorization'] = 'Bearer ' + token;
    }
    
    const options = {
        method: method,
        headers: headers
    };
    
    if (data) {
        options.body = JSON.stringify(data);
    }
    
    const response = await fetch(API_URL + url, options);
    const result = await response.json();
    
    if (!response.ok) {
        throw new Error(result.message || 'Ошибка');
    }
    
    return result.data;
}

// Страница входа
function showLogin() {
    app.innerHTML = `
        <h1>Вход</h1>
        <div class="auth-form">
            <input type="email" id="email" placeholder="Email">
            <input type="password" id="password" placeholder="Пароль">
            <button onclick="login()">Войти</button>
        </div>
        <div class="auth-switch">
            <a onclick="showRegister()">Нет аккаунта? Зарегистрироваться</a>
        </div>
    `;
}

// Страница регистрации
function showRegister() {
    app.innerHTML = `
        <h1>Регистрация</h1>
        <div class="auth-form">
            <input type="text" id="name" placeholder="Имя">
            <input type="email" id="email" placeholder="Email">
            <input type="password" id="password" placeholder="Пароль">
            <input type="number" id="age" placeholder="Возраст">
            <button onclick="register()">Зарегистрироваться</button>
        </div>
        <div class="auth-switch">
            <a onclick="showLogin()">Уже есть аккаунт? Войти</a>
        </div>
    `;
}

// Страница с задачами
function showTodos() {
    let html = `
        <div class="todo-header">
            <span class="user-email">${user.email}</span>
            <button class="logout-btn" onclick="logout()">Выйти</button>
        </div>
        <h1>Мои задачи</h1>
        <div class="add-todo-form">
            <input type="text" id="newTodo" placeholder="Новая задача">
            <button onclick="addTodo()">Добавить</button>
        </div>
    `;
    
    if (todos.length === 0) {
        html += '<div class="empty-list">Нет задач. Добавьте первую!</div>';
    } else {
        html += '<ul class="todo-list">';
        todos.forEach(todo => {
            html += `
                <li class="todo-item ${todo.completed ? 'completed' : ''}">
                    <div class="todo-content">
                        <input type="checkbox" class="todo-checkbox" 
                               ${todo.completed ? 'checked' : ''} 
                               onchange="toggleTodo(${todo.id}, this)">
                        <span class="todo-text">${todo.description}</span>
                    </div>
                    <button class="todo-delete" onclick="deleteTodo(${todo.id})">Удалить</button>
                </li>
            `;
        });
        html += '</ul>';
    }
    
    app.innerHTML = html;
}

// Функции входа/регистрации
window.login = async function() {
    const email = document.getElementById('email').value;
    const password = document.getElementById('password').value;
    
    if (!email || !password) {
        alert('Заполните все поля');
        return;
    }
    
    try {
        const data = await request('/login', 'POST', { email, password });
        user = data.user;
        localStorage.setItem('user', JSON.stringify(data.user));
        localStorage.setItem('token', data.accessToken);
        await loadTodos();
        showTodos();
    } catch (error) {
        alert('Ошибка входа: ' + error.message);
    }
};

window.register = async function() {
    const name = document.getElementById('name').value;
    const email = document.getElementById('email').value;
    const password = document.getElementById('password').value;
    const age = document.getElementById('age').value;
    
    if (!name || !email || !password || !age) {
        alert('Заполните все поля');
        return;
    }
    
    try {
        const data = await request('/registration', 'POST', { 
            name, email, password, age: Number(age) 
        });
        user = data.user;
        localStorage.setItem('user', JSON.stringify(data.user));
        localStorage.setItem('token', data.accessToken);
        await loadTodos();
        showTodos();
    } catch (error) {
        alert('Ошибка регистрации: ' + error.message);
    }
};

window.logout = async function() {
    try {
        await request('/logout', 'POST');
    } catch (e) {}
    
    user = null;
    todos = [];
    localStorage.clear();
    showLogin();
};

// Работа с задачами
async function loadTodos() {
    try {
        todos = await request('/todo') || [];
        showTodos();
    } catch (error) {
        console.log('Ошибка загрузки задач');
        todos = [];
    }
}

window.addTodo = async function() {
    const input = document.getElementById('newTodo');
    const text = input.value.trim();
    
    if (!text) {
        alert('Введите текст задачи');
        return;
    }
    
    try {
        const newTodo = await request('/todo', 'POST', { description: text });
        todos.push(newTodo);
        input.value = '';
        showTodos();
    } catch (error) {
        alert('Ошибка при добавлении');
    }
};

window.toggleTodo = async function(id, checkbox) {
    const todo = todos.find(t => t.id === id);
    if (!todo) return;
    
    try {
        const updated = await request('/todo/' + id, 'PUT', { 
            completed: checkbox.checked 
        });
        todo.completed = updated.completed;
    } catch (error) {
        checkbox.checked = !checkbox.checked;
        alert('Ошибка при обновлении');
    }
};

window.deleteTodo = async function(id) {
    if (!confirm('Удалить задачу?')) return;
    
    try {
        await request('/todo/' + id, 'DELETE');
        todos = todos.filter(t => t.id !== id);
        showTodos();
    } catch (error) {
        alert('Ошибка при удалении');
    }
};