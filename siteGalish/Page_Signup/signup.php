<?php
session_start();
if (isset($_SESSION['user_id'])) {
    header("Location: /Page_Profile/profile.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="Signup.css">
    <link rel="stylesheet" href="/CSS/header_footer.css">
    <link rel="icon" href="/Img/icon.png">

    <title>SLO.OF!</title>
</head>

<body>

    <!-- Хэдэр -->
    <div class="header">
        <div class="header_container">
            <div class="logo">
                <a class="logo_link" href="/index.php">
                    <h1>SLO.OF! </h1>
                </a>
            </div>
            <!-- Поисковик -->
            <div class="search__space">
                <form action="../page_search/search.php" method="get">
                    <input class="input_search" name="query" placeholder="Я хочу найти..." type="search">
                    <!-- Скрытая кнопка для отправки формы при нажатии Enter -->
                    <button type="submit" style="display: none;"></button>
                </form>
            </div>
            <!-- бургер-меню -->
            <div class="header_right">
                <div class="signup">
                    <a class="icon" href="/Page_Signup/signup.php"><img src="/Img/icon-avatar-8750713.png" alt="" width="30" height="30"></a>
                    <div class="signup_name">
                        <?php
                        if (isset($_SESSION['login'])) {
                            $login = $_SESSION['login'];
                            echo $login;
                        } else {
                            echo "Войти.";
                        }
                        ?>
                    </div>
                </div>
                <div class="shop">
                    <a class="icon" href="/Page_busket/busket.php"><img src="/img/shopping-cart-711897.png" alt="" width="30" height="30"></a>
                    <div class="signup_name">Корзина</div>
                    </div>
                    <div class="burger-menu">
                        <a href="" class="burger-menu_button">
                            <spun class="burger-menu_lines"></spun>
                        </a>
                        <nav class="burger-menu_nav">
                        <a href="/Page_busket/busket.php" class="burger-menu_link">Корзина</a>
                        <a href="/Page_Profile/profile.php" class="burger-menu_link">Профиль</a>
                        <a href="/Page_Sell/your_products.php" class="burger-menu_link">Мои товары</a>
                        <a href="/Page_about/about.php" class="burger-menu_link">О нас</a>
                        <button id="logoutButton" onclick="reload_interval(100); return false;" class="burger-menu_link_exit">Выйти</button>

                    </nav>
                        <div class="burger-menu_overlay"></div>
                    </div>
                </div>
            </div>

        </div>
    <!-- интро -->

    <div class="authorization">
        <div class="authorization_container">
            <div class="authorization_input">
                <!-- Форма авторизации -->
                <div class="login_form">
                    <div class="login_text">Авторизация</div>
                    <form action="" method="post">
                        <input class="input_register" type="text" placeholder="Логин" name="login">
                        <input class="input_register" type="password" placeholder="Пароль" name="pass">
                        <input type="hidden" name="form" value="login">
                        <button class="button_register" type="submit"> Войти </button>
                    </form>
                    <div class="login_subtext">Нет аккаунта? <br> <br> Зарегистрируйся! -></div>
                </div>

                <!-- Форма регистрации-->
                <div class="register_form">
                    <div class="login_text">Регистрация</div>
                    <form action="" method="post">
                        <input class="input_register" type="text" placeholder="Почта" name="email">
                        <input class="input_register" type="text" placeholder="Логин" name="login">
                        <input class="input_register" type="password" placeholder="Пароль" name="pass">
                        <input class="input_register" type="password" placeholder="Подтверждение пароля" name="repeatpass">
                        <input type="hidden" name="form" value="register">
                        <button class="button_register" type="submit"> Зарегистрироваться </button>
                    </form>
                </div>
            </div>
            <div class="authorization_output">
                <?php
                require_once('../db.php');
                // Login =================================================================
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    if ($_POST['form'] === 'login') {

                        $login = $_POST['login']; 
                        $pass = $_POST['pass'];
                        if (empty($login) || empty($pass)) { 
                            echo "Заполните все поля";
                        } else {
                            $stmt = $conn->prepare("SELECT * FROM `users` WHERE login = ?"); // Изменен запрос на поиск по login
                            $stmt->bind_param('s', $login); // Привязываем только login
                            $stmt->execute();
                            $result = $stmt->get_result();

                            if ($result->num_rows > 0) {
                                $user = $result->fetch_assoc();
                                if (password_verify($pass, $user['pass'])) {
                                    $user_id = $user['id'];
                                    $login = $user['login']; // Получаем логин пользователя
                                    $isAdmin = $user['admin']; // Получаем значение столбца admin (0 или 1)
                            
                                    $_SESSION['user_id'] = $user_id;
                                    $_SESSION['logged_in'] = true;
                                    $_SESSION['login'] = $login; // Вставляем в сессию логин
                            
                                    if ($isAdmin == 1) {
                                        $_SESSION['is_admin'] = true; // Устанавливаем сессию, обозначающую администратора
                                        echo '<script>window.location.href = "../index.php";</script>';
                                    } else {
                                        $_SESSION['is_admin'] = false;
                                    }
                                } else {
                                    echo "Неправильный пароль.";
                                }
                            } else {
                                echo "Пользователь с таким логином не найден.";
                            }
                        }
                    } elseif ($_POST['form'] === 'register') {

                        $email = $_POST['email']; // Изменяем $name на $email для регистрации
                        $login = $_POST['login']; // Добавляем $login вместо $email
                        $pass = $_POST['pass'];
                        $repeatpass = $_POST['repeatpass'];
                        $admin = 0;
                        $phone = 0;

                        if (empty($email) || empty($login) || empty($pass) || empty($repeatpass)) { // Проверяем $email и $login
                            echo 'Заполните все поля формы.';
                        } elseif ($pass !== $repeatpass) {
                            echo 'Пароли не совпадают.';
                        } else {
                            $stmt = $conn->prepare("SELECT * FROM users WHERE login = ?"); // Проверяем наличие логина
                            $stmt->bind_param('s', $login);
                            $stmt->execute();
                            $result = $stmt->get_result();

                            if ($result->num_rows > 0) {
                                echo "Пользователь с таким логином уже существует!";
                            } else {
                                $hashed_password = password_hash($pass, PASSWORD_BCRYPT);

                                $stmt = $conn->prepare("INSERT INTO `users` (email, login, pass, admin, phone) VALUES (?, ?, ?, ?, ?)"); // Исправляем порядок и названия полей
                                $stmt->bind_param('sssii', $email, $login, $hashed_password, $admin, $phone); // Привязываем параметры в соответствующем порядке
                                $stmt->execute();

                                echo 'Пользователь успешно зарегистрирован.';
                            }
                        }
                    }
                }

                $conn->close();
                ?>
            </div>
        </div>
    </div>
    <footer>
        <div class="footer__container">
            <div class="footer__contact">
                <h1 class="contact">Покупатели
                    <a class="contact_dir" href="/Page_about/about.php">Как сделать заказ</a>
                    <a class="contact_dir" href="/Page_about/about.php">Способы Оплаты</a>
                </h1>
                <h1 class="contact">Партнерам
                    <a class="contact_dir" href="/Page_about/about.php">Продавайте на SLO.OF!</a>
                    <a class="contact_dir" href="/Page_about/about.php">Курьерам</a>
                    <a class="contact_dir" href="/Page_about/about.php">Перевозчикам</a>
                </h1>
                <h1 class="contact">Компания
                    <a class="contact_dir" href="/Page_about/about.php">О нас</a>
                    <a class="contact_dir" href="/Page_about/about.php">Реквизиты</a>
                </h1>
                <h1 class="contact">Мы в соцсетях
                    <a class="contact_dir" href="https://vk.com">Вконтакте</a>
                    <a class="contact_dir" href="https://youtube.com">YouTube</a>
                    <a class="contact_dir" href="https://web.telegram.org">Telegram</a>
                </h1>
            </div>
        </div>
    </footer>
    <div class="footer_copyright">
        <h2>copyright&copy;2023 SLO.OF. Все права защищены.</h2>
    </div>

    <script src="http://code.jquery.com/jquery-1.10.2.js"></script>
    <script src="/path/to/main.js"></script>
    <script src="/js/main.js"></script>
    <script src="/slider.js"></script>

</body>
<script>
document.getElementById("logoutButton").addEventListener("click", function() {
  // Выполнение разлогинивания с использованием AJAX-запроса
  var xhr = new XMLHttpRequest();
  xhr.open("GET", "/logout.php", true);
  xhr.onreadystatechange = function() {
    if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
    }
  };
  xhr.send();
});
function reload_interval(time){
	setTimeout(function(){
		window.location.href = "/index.php";
	}, time);
}
</script>
</html>