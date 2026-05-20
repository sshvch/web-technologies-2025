import Pizza from './Pizza.js';
import { TYPETOPPINGS } from './toppings.js';

// Создаем пиццу по умолчанию
let currentPizza = new Pizza("Маргарита", "Большая");

// Элементы на странице
const sizeBtns = document.querySelectorAll('.size-btn');
const typeBtns = document.querySelectorAll('.type-btn');
const toppingsDiv = document.getElementById('toppings-container');
const priceSpan = document.getElementById('total-price');
const kcalSpan = document.getElementById('total-calories');

// Данные для отображения добавок
const toppingsList = [
    { key: 'сырный борт', name: 'Сырный бортик', calories: 50 },
    { key: 'сливочная моцарелла', name: 'Моцарелла', calories: 20 },
    { key: 'чедер и пармезан', name: 'Чеддер и пармезан', calories: 50 }
];

// Показать добавки
function showToppings() {
    toppingsDiv.innerHTML = '';
    
    toppingsList.forEach(t => {
        const div = document.createElement('div');
        div.className = 'topping-item';
        
        // Подсветка если добавка уже есть
        if (currentPizza.toppings.some(t2 => t2.key === t.key)) {
            div.classList.add('selected');
        }
        
        // Цена зависит от размера
        let price = 0;
        const toppingData = TYPETOPPINGS[t.key];
        if (toppingData.dependsOnSize) {
            price = currentPizza.size === 'Большая' ? toppingData.price.large : toppingData.price.small;
        } else {
            price = toppingData.price;
        }
        
        div.innerHTML = `
            <span>${t.name}</span>
            <span>+${price}₽ / +${t.calories}ккал</span>
        `;
        
        // Клик по добавке
        div.onclick = () => {
            const exists = currentPizza.toppings.some(t2 => t2.key === t.key);
            if (exists) {
                currentPizza.removeTopping(t.key);
            } else {
                currentPizza.addTopping(t.key);
            }
            
            showToppings(); // Обновить список
            updateTotal();   // Обновить цену
        };
        
        toppingsDiv.appendChild(div);
    });
}

// Обновить цену и калории
function updateTotal() {
    priceSpan.textContent = currentPizza.totalPrice;
    kcalSpan.textContent = currentPizza.totalCalories;
}

// Выбор размера
sizeBtns.forEach(btn => {
    btn.onclick = () => {
        // Убрать подсветку со всех
        sizeBtns.forEach(b => b.classList.remove('active'));
        btn.classList.add('active');
        
        const oldToppings = [...currentPizza.toppings];
        const oldType = currentPizza.name;
        
        // Создать новую пиццу
        currentPizza = new Pizza(oldType, btn.dataset.size);
        
        // Добавить старые топпинги
        oldToppings.forEach(t => currentPizza.addTopping(t.key));
        
        showToppings();
        updateTotal();
    };
});

// Выбор типа
typeBtns.forEach(btn => {
    btn.onclick = () => {
        typeBtns.forEach(b => b.classList.remove('active'));
        btn.classList.add('active');
        
        const oldToppings = [...currentPizza.toppings];
        const oldSize = currentPizza.size;
        
        currentPizza = new Pizza(btn.dataset.type, oldSize);
        oldToppings.forEach(t => currentPizza.addTopping(t.key));
        
        showToppings();
        updateTotal();
    };
});

// Кнопка в корзину
document.getElementById('add-to-cart').onclick = () => {
    alert(`Добавлено: ${currentPizza.name} (${currentPizza.size})\nЦена: ${currentPizza.totalPrice}₽, ${currentPizza.totalCalories} ккал`);
};

// Активируем кнопки по умолчанию
document.querySelector('[data-size="Большая"]').classList.add('active');
document.querySelector('[data-type="Маргарита"]').classList.add('active');

// Показываем всё
showToppings();
updateTotal();