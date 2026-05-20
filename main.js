import Pizza from './Pizza.js';

const myPizza = new Pizza("Маргарита", "Большая");


myPizza.addTopping("сливочная моцарелла");
myPizza.addTopping("сырный борт");

console.log("\n--- ПОСЛЕ ДОБАВЛЕНИЯ ---");
myPizza.getToppings();
myPizza.calculatePrice();
myPizza.calculateCalories();


myPizza.removeTopping("сливочная моцарелла");

console.log("\n--- ПОСЛЕ УДАЛЕНИЯ ---");
myPizza.getToppings();
myPizza.calculatePrice();
myPizza.calculateCalories();

myPizza.getSize();
myPizza.getStuffing();


console.log("\n======================================");
const pizza2 = new Pizza("Пепперони", "Маленькая");
pizza2.addTopping("чедер и пармезан");
pizza2.getToppings();
pizza2.calculatePrice();
pizza2.calculateCalories();