const dot = document.getElementById('dot');

let servicebtn = document.getElementById('servicebtn');
let socialbtn = document.getElementById('socialbtn');
let blogbtn = document.getElementById('blogbtn');

//animation dot

function moveDot(targetButton) {
    const buttonRect = targetButton.getBoundingClientRect();
    dot.style.left = buttonRect.left + buttonRect.width / 2 - dot.offsetWidth / 2 + 'px';
}

servicebtn.addEventListener('click', function () {
    moveDot(servicebtn);
});

socialbtn.addEventListener('click', function () {
    moveDot(socialbtn);
});

blogbtn.addEventListener('click', function () {
    moveDot(blogbtn);
});

// modal login

let loginbtn = document.getElementById('loginbtn');

let signModal = document.getElementById('signModal');
let closesignModal = document.getElementById('closeSignBtn');
let main = document.getElementById('main');

let profileModal = document.getElementById('profileModal');
let closeProfileBtn = document.getElementById('closeProfileBtn');

let modalIsOpened = false;

let menuLoginbtn = document.getElementById('menuLoginbtn')

menuLoginbtn.addEventListener('click', function() {
    loginbtn.click();
});

// Обработчик для открытия модального окна
loginbtn.addEventListener('click', function () {
    modalIsOpened = true;
    main.style.filter = 'blur(5px)';
    signModal.classList.remove('-top-1/2');
    signModal.classList.add('top-1/2');
    profileModal.classList.remove('-top-1/2');
    profileModal.classList.add('top-1/2');
});

function closemodal() {
    signModal.classList.remove('top-1/2');
    signModal.classList.add('-top-1/2');
    profileModal.classList.remove('top-1/2');
    profileModal.classList.add('-top-1/2');
    main.style.filter = 'blur(0px)';
    modalIsOpened = false;
};

closeProfileBtn.addEventListener('click', function () {
    closemodal();
});

closesignModal.addEventListener('click', function () {
    closemodal();
});

document.addEventListener('click', function (event) {
    if (modalIsOpened) {
        if (signModal.contains(event.target)) {
            // Если клик был выполнен внутри signModal, ничего не делаем
            return;
        }

        if (profileModal.contains(event.target)) {
            // Если клик был выполнен внутри profileModal, ничего не делаем
            return;
        }

        // Если клик был выполнен вне обоих модальных окон и не на кнопке открытия, закрываем оба модальных окна
        if (event.target !== loginbtn && event.target !== menuLoginbtn) {
            signModal.classList.remove('top-1/2');
            signModal.classList.add('-top-1/2');
            profileModal.classList.remove('top-1/2');
            profileModal.classList.add('-top-1/2');
            main.style.filter = 'blur(0px)';
            modalIsOpened = false;
        }
    }
});


//value login

function login_check_value() {
    if (user_login !== '') {
        document.getElementById('loginbtn').innerHTML = user_login;
        signModal.style.top = "-1000px"
        setInterval(function () {
            signModal.classList.add('hidden');
        }, 500);
        setInterval(function () {
            profileModal.classList.add('my-opacity')
            profileModal.classList.remove('hidden');
        }, 200);
    } else {
        document.getElementById('loginbtn').innerHTML = 'login';
        signModal.classList.remove('hidden');
        profileModal.classList.add('hidden');
    }
}
login_check_value();

// error output

let errorModal = document.getElementById('error_modal');
let errorOutput = document.getElementById('error_output');
let signInsubmit = document.getElementById('signInSubmit');
let signUpsubmit = document.getElementById('signUpSubmit');
let verifyAdminSubmit = document.getElementById('verifyAdminSubmit');

function goerror() {
    errorModal.classList.add('right-5');

    let timerString = '////////////////////////////////////////';
    let timer = 3000; // Initialize timer outside of setInterval

    let intervalId = setInterval(() => {
        // Ваш код, который будет выполняться каждые 100 миллисекунд
        timer = timer - 50; // Subtract 1 from timer
        timerString = timerString.substring(0, timerString.length - 1); // Remove one slash from the end

        document.getElementById('errorTimer').textContent = timerString; // Update error timer content

        // Условие для остановки интервала (если нужно)
        if (timer === 0) {
            clearInterval(intervalId);
        }
    }, 50);

    setTimeout(function () {
        errorModal.classList.remove('right-5');
    }, 2500);
}

signInsubmit.onclick = function () {
    goerror();
};

signUpsubmit.onclick = function () {
    goerror();
};

verifyAdminSubmit.onclick = function () {
    goerror();
};

let headerMenuBtn = document.getElementById('headerMenuBtn');
let headerMenu = document.getElementById('headerMenu');

// Добавляем обработчик для открытия меню при клике на кнопку
headerMenuBtn.addEventListener('click', function() {
    headerMenu.classList.add('right-0');
});

// Добавляем обработчик для закрытия меню при клике вне модального окна
document.addEventListener('click', function(event) {
    // Проверяем, был ли клик вне модального окна
    if (!headerMenu.contains(event.target) && event.target !== headerMenuBtn) {
        headerMenu.classList.remove('right-0');
    }
});
