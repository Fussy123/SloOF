function logout() {
    fetch('../php/logout.php', {
        method: 'POST', // Метод запроса
    })
    .then(response => {
        if (response.ok) {
            console.log('Выход выполнен успешно');
            window.location.href = 'index.html';

            // Дополнительные действия после успешного выхода, например, перенаправление на другую страницу
        } else {
            console.error('Ошибка при выполнении выхода:', response.statusText);
        }
    })
    .catch(error => {
        console.error('Произошла ошибка при выполнении выхода:', error);
    });
}

// Вызов функции logout() при клике на кнопку "Выход"
document.getElementById('logoutButton').addEventListener('click', logout);
