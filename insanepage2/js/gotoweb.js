let button_web = document.getElementById('gotoweb');
let intro = document.getElementById('intro');
let services = document.getElementById('services');
let social = document.getElementById('social');
let header = document.getElementById('header')
let footer = document.getElementById('footer')

// animation intro
let logoFirst = document.getElementById('logoFirst');
let LogoSecond = document.getElementById('logoSecond');

function animationLogo() {

    setTimeout(function () {
        logoFirst.classList.add('-translate-y-12');
        LogoSecond.classList.add('-translate-y-6');
    }, 2500);
    setTimeout(function () {
        const text = 'ake your mark on the web with Insane Page';
        const textContainer = document.getElementById('text-container');
        let index = 0;

        function typeWriter() {
            if (index < text.length) {
                textContainer.innerHTML += text.charAt(index);
                index++;
                setTimeout(typeWriter, 35);
            } else {
                const cursorChar = document.createElement('span');
                cursorChar.innerHTML = '|';
                textContainer.appendChild(cursorChar);

                setInterval(function () {
                    cursorChar.style.visibility = cursorChar.style.visibility == 'visible' ? 'hidden' : 'visible';
                }, 500);
            }
        }

        typeWriter();
    }, 500);
}

animationLogo();
