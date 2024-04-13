document.getElementById('createNewsForm').addEventListener('submit', function(event) {
    event.preventDefault(); // Предотвращаем отправку формы по умолчанию

    let formData = new FormData(document.getElementById('createNewsForm')); // Создаем объект FormData из формы

    // Получаем значения полей формы
    let title = document.getElementById('newsTitle').value.trim();
    let content = document.getElementById('newsContent').value.trim();
    let image = document.getElementById('newsImage').files[0]; // Получаем первый выбранный файл

    // Добавляем значения полей в объект FormData
    formData.append('title', title);
    formData.append('content', content);
    formData.append('image', image);

    // Опции запроса
    let options = {
        method: 'POST', // Метод запроса
        body: formData, // Используем объект FormData в качестве тела запроса
    };

    // Отправляем запрос на сервер
    fetch('../php/createnews.php', options)
        .then((response) => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.text(); // Получаем текст ответа
        })
        .then(data => {
            // Обработка успешного ответа от сервера
            console.log('Success:', data);
            getnews()
            // Здесь вы можете добавить логику для отображения сообщения об успешном создании новости или перенаправления пользователя
        })
        .catch(error => {
            // Обработка ошибки
            console.error('Error:', error);
            // Здесь вы можете добавить логику для отображения сообщения об ошибке или других действий
        });
});
