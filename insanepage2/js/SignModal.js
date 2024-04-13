let signInForm = document.getElementById('signInForm');
let signUpForm = document.getElementById('signUpForm');
let goToSignUp = document.getElementById('goToSignUp');
let goToSignIn = document.getElementById('goToSignIn');

goToSignIn.onclick = function (event) {
    event.preventDefault();
    signUpForm.classList.add('hidden');
    signInForm.classList.remove('hidden');
};
goToSignUp.onclick = function (event) {
    event.preventDefault();
    signInForm.classList.add('hidden');
    signUpForm.classList.remove('hidden');
};

// Опечатка исправлена
let errorOutputElement = document.getElementById('error_output');
let parentElement = errorOutputElement.parentNode;

//register form
signUpForm.addEventListener('submit', function (event) {
    event.preventDefault(); // Предотвращаем отправку формы по умолчанию

    // Получаем значения полей формы
    let form = 'signUp';
    let login = signUpForm.querySelector('input[name="login"]').value.trim();
    let password = signUpForm.querySelector('input[name="pass_signup"]').value.trim();
    let repeat_password = signUpForm.querySelector('input[name="repeat_pass_signup"]').value.trim();

    // Обновляем текст существующего элемента
    if (login == '' || password == '' || repeat_password == '') {
        errorOutputElement.textContent = 'Please fill in all fields';
        return;
    }

    if (login.length > 20 || password.length > 30 || repeat_password.length > 30) {
        errorOutputElement.textContent = 'Login or password is too long';
        return;
    }

    if (password !== repeat_password) {
        errorOutputElement.textContent = 'Passwords do not match';
        return;
    }

    if (password.length < 6) {
        errorOutputElement.textContent = 'Password must be at least 6 characters long';
        return;
    }

    // Здесь вы можете отправить данные на сервер или выполнить другие действия

    gofetch(form, login, password, repeat_password);

    // Очистка полей формы (если нужно)
    // signUpForm.reset();
});

signInForm.addEventListener('submit', function (event) {
    event.preventDefault(); // Предотвращаем отправку формы по умолчанию

    // Получаем значения полей формы
    let form = 'signIn';
    let login = signInForm.querySelector('input[name="login"]').value.trim();
    let password = signInForm.querySelector('input[name="pass_signin"]').value.trim();
    let repeat_password = null;

    // Ваши действия с полученными данными
    if (login == '' || password == '') {
        errorOutputElement.textContent = 'Please fill in all fields';
        return;
    }

    // Здесь вы можете отправить данные на сервер или выполнить другие действия

    gofetch(form, login, password, repeat_password);

    // Очистка полей формы (если нужно)
    // signInForm.reset();
});

function gofetch(form, login, password, repeat_password) {
    // Создаем объект с данными для передачи
    let data = {
        form: form,
        login: login,
        password: password,
        repeat_password: repeat_password,
    };

    // Опции запроса
    let options = {
        method: 'POST', // Метод запроса
        headers: {
            'Content-Type': 'application/json', // Устанавливаем заголовок Content-Type для JSON
        },
        body: JSON.stringify(data), // Преобразуем данные в JSON
    };

    // Отправляем запрос на сервер
    fetch('../php/sign.php', options)
        .then((response) => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.text(); // Получаем текст ответа
        })
        .then((data) => {
            errorOutputElement.textContent = data;
            checkcookie();
            login_check_value();
            checkadmin().then(isAdmin => {
                if (isAdmin == true) {
                    verifyAdminForm.classList.remove('hidden');
                } else {
                    isAdmin == false
                }
            });            
        })
        .catch((error) => {
            console.error('There has been a problem with your fetch operation:', error);
        });
}
