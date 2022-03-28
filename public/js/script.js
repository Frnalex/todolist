const btnOpenMenu = document.getElementById('js-open-menu');
const btnCloseMenu = document.getElementById('js-close-menu');
const menu = document.getElementById('js-menu');

btnOpenMenu.addEventListener('click', () => {
    menu.classList.add('open');
});
btnCloseMenu.addEventListener('click', () => {
    menu.classList.remove('open');
});
