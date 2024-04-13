function checkadmin() {
    let data = {
        login: user_login,
    };

    let options = {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(data),
    };

    return fetch('../php/checkadmin.php', options)
        .then((response) => {
            if (response.ok) {
                return response.text();
            } else {
                throw new Error('Ошибка при выполнении запроса: ' + response.statusText);
            }
        })
        .then((isAdmin) => {
            return isAdmin === 'true';
        })
        .catch((error) => {
            console.error('Произошла ошибка при выполнении проверки:', error);
            return false; // Возвращаем false в случае ошибки
        });
}

// Вызываем функцию checkadmin() и обрабатываем результат
checkadmin().then((isAdmin) => {
    if (isAdmin == true) {
        verifyAdminForm.classList.remove('hidden');
    } else {
        isAdmin == false;
    }
});

//verify admin form

let verifyAdminForm = document.getElementById('verifyAdminForm');

verifyAdminForm.addEventListener('submit', function (event) {
    event.preventDefault();
    let form = 'adminWerify';
    let adminPassword = verifyAdminForm.querySelector('input[name="adminPassword"]').value.trim();

    gofetchAdmin(form, adminPassword);
});

function gofetchAdmin(form, adminPassword) {
    // Создаем объект с данными для передачи
    let data = {
        form: form,
        adminPassword: adminPassword,
        user_login: user_login,
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
    fetch('../php/verifyAdmin.php' , options)
        .then((response) => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.text(); // Получаем текст ответа
        })
        .then((data) => {

            if (data === 'wrong password') {
                errorOutputElement.textContent = data;
                console.log(data)
            } else {
                window.location.href = data;
            }

        })
        .catch((error) => {
            console.error('There has been a problem with your fetch operation:', error);
        });
}
