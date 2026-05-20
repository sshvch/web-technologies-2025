const API_BASE = 'https://jsonplaceholder.typicode.com';
const app = document.getElementById('app');

// Функция для получения параметра из URL
function getQueryParam(param) {
    const urlParams = new URLSearchParams(window.location.search);
    return urlParams.get(param);
}

// Универсальная функция для запросов с обработкой ошибок
async function fetchWithErrorHandling(url) {
    try {
        const response = await fetch(url);
        
        if (!response.ok) {
            throw new Error(`HTTP ошибка! Статус: ${response.status}`);
        }
        
        const data = await response.json();
        return { data, error: null };
    } catch (error) {
        console.error('Ошибка запроса:', error);
        return { 
            data: null, 
            error: error.message || 'Произошла ошибка при загрузке данных' 
        };
    }
}

// Функция для загрузки всех постов
async function loadPosts() {
    const { data: posts, error } = await fetchWithErrorHandling(`${API_BASE}/posts`);
    
    if (error) {
        showError(error);
        return;
    }
    
    renderPosts(posts);
}

// Функция для загрузки конкретного поста и его комментариев
async function loadPostWithComments(postId) {
    if (!postId) {
        showError('ID поста не указан');
        return;
    }

    // Показываем загрузку
    app.innerHTML = '<div class="loading">Загрузка поста...</div>';

    try {
        // Загружаем пост и комментарии параллельно для оптимизации
        const [postResult, commentsResult] = await Promise.all([
            fetchWithErrorHandling(`${API_BASE}/posts/${postId}`),
            fetchWithErrorHandling(`${API_BASE}/posts/${postId}/comments`)
        ]);

        // Проверяем ошибки
        if (postResult.error) {
            showError(`Ошибка загрузки поста: ${postResult.error}`);
            return;
        }

        if (!postResult.data) {
            showError('Пост не найден');
            return;
        }

        // Если есть ошибка при загрузке комментариев, показываем предупреждение
        if (commentsResult.error) {
            console.warn('Ошибка загрузки комментариев:', commentsResult.error);
        }

        renderPostWithComments(postResult.data, commentsResult.data || []);
    } catch (error) {
        showError('Неожиданная ошибка: ' + error.message);
    }
}

// Функция для отображения списка постов
function renderPosts(posts) {
    if (!posts || posts.length === 0) {
        app.innerHTML = '<div class="no-data">Посты не найдены</div>';
        return;
    }

    const postsHTML = `
        <h1> Список постов</h1>
        <div class="posts-grid">
            ${posts.map(post => `
                <div class="post-card">
                    <h2 class="post-title">${escapeHtml(post.title)}</h2>
                    <p class="post-body">${escapeHtml(post.body)}</p>
                    <a href="/posts?id=${post.id}" class="post-link">Читать далее →</a>
                </div>
            `).join('')}
        </div>
    `;
    
    app.innerHTML = postsHTML;
}

// Функция для отображения поста с комментариями
function renderPostWithComments(post, comments) {
    const commentsHTML = comments && comments.length > 0 
        ? comments.map(comment => `
            <div class="comment">
                <div class="comment-name">${escapeHtml(comment.name)}</div>
                <div class="comment-email">${escapeHtml(comment.email)}</div>
                <div class="comment-body">${escapeHtml(comment.body)}</div>
            </div>
        `).join('')
        : '<p>Комментариев пока нет</p>';

    const pageHTML = `
        <a href="/" class="back-link">← Назад к постам</a>
        <h1> Пост #${post.id}</h1>
        <div class="post-card" style="margin-bottom: 30px;">
            <h2 class="post-title">${escapeHtml(post.title)}</h2>
            <p class="post-body">${escapeHtml(post.body)}</p>
        </div>
        
        <div class="comments-section">
            <h2 style="margin-bottom: 20px;"> Комментарии (${comments ? comments.length : 0})</h2>
            ${commentsHTML}
        </div>
    `;
    
    app.innerHTML = pageHTML;
}

// Функция для отображения ошибки
function showError(message) {
    app.innerHTML = `
        <div class="error-message">
            <strong>Ошибка:</strong> ${escapeHtml(message)}
            <button onclick="window.location.reload()">Повторить попытку</button>
        </div>
    `;
}

// Функция для экранирования HTML-спецсимволов
function escapeHtml(text) {
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}

// Функция для обновления ссылок в истории браузера
function handleNavigation() {
    const postId = getQueryParam('id');
    
    if (postId) {
        loadPostWithComments(postId);
    } else {
        loadPosts();
    }
}

// Обработчик изменения URL (для кнопок назад/вперед)
window.addEventListener('popstate', handleNavigation);

// Переопределяем переходы по ссылкам для SPA-поведения
document.addEventListener('click', (e) => {
    const link = e.target.closest('a');
    if (!link) return;

    const href = link.getAttribute('href');
    
    // Обрабатываем только внутренние ссылки
    if (href.startsWith('/')) {
        e.preventDefault();
        
        // Обновляем URL
        window.history.pushState({}, '', href);
        
        // Загружаем  контент
        handleNavigation();
    }
});

// Инициализация при загрузке страницы
handleNavigation();