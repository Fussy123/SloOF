function getnews() {
    // Опции запроса
    let options = {
        method: 'GET', // Метод запроса
    };

    // Отправляем запрос на сервер
    fetch('../php/getnews.php', options)
        .then((response) => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json(); // Получаем JSON-данные
        })
        .then((data) => {

            // Получаем ссылку на блок "blog"
            let blogDiv = document.getElementById('blog');

            // Вставляем полученные данные в HTML
            data.forEach((news) => {
                let newsDiv = document.createElement('div');
                newsDiv.classList.add(
                    'relative',
                    'flex',
                    'flex-row',
                    'bg-gradient-to-r',
                    'from-ip-red',
                    'to-ip-burgundy',
                    'w-full',
                    'my-5',
                    'rounded-3xl',
                    'z-30'
                );

                newsDiv.innerHTML = `
                <div class="flex bg-zinc-900 w-1/3 text-white justify-center items-center xs:text-xl sm:text-xl md:text-xl lg:text-2xl xl:text-3xl font-chambers rounded-l-3xl">
                    News
                </div>
                <div class="flex flex-col w-full">
                    <div class="flex xs:text-xl sm:text-xl md:text-xl lg:text-2xl xl:text-3xl text-white p-5 w-10/12 justify-start mx-auto">${news.title}</div>
                    <div class="flex justify-start xs:text-xl sm:text-xl md:text-xl lg:text-xl xl:text-2xl text-white p-5">${news.content}</div>
                    <img src="../images_news/${news.image}" alt="${news.title}" class="w-full max-h-96 object-cover">
                </div>
            `;

                blogDiv.appendChild(newsDiv);
                
            });
        })
        .catch((error) => {
            // Обработка ошибки
            console.error('Error:', error);
            // Здесь вы можете добавить логику для отображения сообщения об ошибке или других действий
        });
}

getnews();
