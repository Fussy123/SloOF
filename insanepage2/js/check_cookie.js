let user_login = '';

function checkcookie() {
    
    // Получить все куки
    let allCookies = document.cookie;

    // Разделить куки на отдельные части
    let cookiesArray = allCookies.split(';');

    // Цикл для перебора куки
    for (let i = 0; i < cookiesArray.length; i++) {
        let cookie = cookiesArray[i].trim(); // Удалить лишние пробелы
        let cookieParts = cookie.split('='); // Разделить имя и значение куки

        let cookieName = cookieParts[0]; // Имя куки
        let cookieValue = cookieParts[1]; // Значение куки
        if (cookieName == 'login') {
            user_login = cookieValue;
        }
    }
    return user_login;
}

checkcookie();
