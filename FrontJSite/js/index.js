const navigation = document.querySelector('.header-navigation')

const burgerButton = document.querySelector('.burger-menu')
const burgerButtonClose = document.querySelector('.close__button')

burgerButton.addEventListener('click', function () {
    navigation.classList.toggle('header-navigation-active')
})

burgerButtonClose.addEventListener('click', function () {
    navigation.classList.remove('header-navigation-active')
})

document.addEventListener('mousedown', function (e) {
    if (e.target.closest('.navigation') === null) {
        navigation.classList.remove('header-navigation-active')
    }
})