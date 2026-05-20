import { TYPESPIZZA } from './pizzas.js';
import { TYPETOPPINGS} from './toppings.js';

class Pizza {
    constructor(namePizza, sizePizza) {     
        const typePizza = TYPESPIZZA[namePizza];
        if (!typePizza) {
            console.log(` Ошибка: пицца "${namePizza}" не найдена`);
            console.log("Доступные пиццы:", Object.keys(TYPESPIZZA).join(", "));
            return;
        }
        
        // Проверяем размер
        if (sizePizza !== "Большая" && sizePizza !== "Маленькая") {
            console.log(` Ошибка: размер "${sizePizza}" неверный`);
            console.log("Доступные размеры: Большая, Маленькая");
            return;
        }
        
        // Базовые характеристики
        this.name = typePizza.name;
        this.basePrice = typePizza.price;
        this.baseCalories = typePizza.calories;
        this.size = sizePizza;
        this.toppings = [];
        
        // Итоговые цена и калории (пока равны базовым + размер)
        this.totalPrice = this.basePrice + (this.size === "Большая" ? 200 : 100);
        this.totalCalories = this.baseCalories + (this.size === "Большая" ? 200 : 100);
    }

    addTopping(toppingName) {
        // Проверяем, есть ли такая добавка
        const toppingData = TYPETOPPINGS[toppingName];
        if (!toppingData) {
            console.log(` Ошибка: добавка "${toppingName}" не найдена`);
            console.log("Доступные добавки:", Object.keys(TYPETOPPINGS).join(", "));
            return;
        }
        
        // Получаем цену с учётом размера
        let price = toppingData.price;
        if (toppingData.dependsOnSize) {
            price = this.size === "Большая" ? toppingData.price.large : toppingData.price.small;
        }
        
        // Создаём объект добавки
        const topping = {
            name: toppingData.name,
            price: price,
            calories: toppingData.calories,
            key: toppingName
        };
        
        // Добавляем в массив
        this.toppings.push(topping);
        
        // Обновляем итоговые цену и калории
        this.totalPrice += price;
        this.totalCalories += toppingData.calories;
        
        console.log(` Добавлено: ${toppingData.name} (+${price} руб, +${toppingData.calories} ккал)`);
    }

    removeTopping(toppingName) {
        // Ищем добавку в массиве
        const index = this.toppings.findIndex(t => t.key === toppingName || t.name === toppingName);
        
        if (index === -1) {
            console.log(` Добавка "${toppingName}" не найдена в пицце`);
            return;
        }
        
 
        const removedTopping = this.toppings[index];
        
  
        this.totalPrice -= removedTopping.price;
        this.totalCalories -= removedTopping.calories;
        
  
        this.toppings.splice(index, 1);
        
        console.log(` Удалено: ${removedTopping.name} (-${removedTopping.price} руб, -${removedTopping.calories} ккал)`);
    }

    getToppings() {
        if (this.toppings.length === 0) {
            console.log(' Добавки: отсутствуют');
        } else {
            console.log(' ДОБАВКИ:');
            console.log('──────────────────────────────────────');
            for (let i = 0; i < this.toppings.length; i++) {
                console.log(`  ${i+1}. ${this.toppings[i].name}: +${this.toppings[i].price} руб, +${this.toppings[i].calories} ккал`);
            }
            console.log('──────────────────────────────────────');
        }
        return this.toppings;
    }

    getSize() {
        console.log(` Размер пиццы: ${this.name}`);
        return this.size;
    }

    getStuffing() {
        console.log(` Размер пиццы (getStuffing): ${this.size}`);
        return this.size;
    }

    calculatePrice() {
        console.log(` Итоговая цена: ${this.totalPrice} рублей`);
        return this.totalPrice;
    }

    calculateCalories() {
        console.log(`Калорийность: ${this.totalCalories} ккал`);
        return this.totalCalories;
    }
    

}

export default Pizza;