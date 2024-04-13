// Функция для обработки события прокрутки
function handleScroll() {
    let blocks = document.querySelectorAll('.serviceblock');
    let screenHeight = window.innerHeight;
    let screenMiddle = screenHeight / 2;

    blocks.forEach(function (block, index) {
        let blockPosition = block.getBoundingClientRect().top + (block.offsetHeight / 2);
        if (blockPosition < screenHeight && blockPosition > screenMiddle) {
            block.style.opacity = 1;
            block.classList.add(index % 2 === 0 ? 'slide-in-right' : 'slide-in-left');
        }
    });
}

// Функция для обработки события загрузки DOM
function handleDOMContentLoaded() {
    let blocks = document.querySelectorAll('.serviceblock');
    let screenWidth = window.innerWidth;
    let isMobile = screenWidth <= 768; // Adjust this value according to your design needs for mobile devices

    blocks.forEach(function (block, index) {
        if (isMobile) {
            block.style.opacity = 1;
            block.classList.add(index % 2 === 0 ? 'slide-in-right' : 'slide-in-left');
        }
    });
}

// Привязываем функции к соответствующим событиям
window.addEventListener('scroll', handleScroll);
window.addEventListener('DOMContentLoaded', handleDOMContentLoaded);
