// script.js
let burgerButton = document.getElementById('burgerBtn');
let closeButton = document.getElementById('closeBtn');
let mobileMenu = document.getElementById('mobileMenu');

function openMenu() {
    mobileMenu.classList.add('active');
}

function closeMenu() {
    mobileMenu.classList.remove('active');
}

burgerButton.addEventListener('click', openMenu);
closeButton.addEventListener('click', closeMenu);