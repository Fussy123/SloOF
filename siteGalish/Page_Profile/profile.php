<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: /Page_Signup/signup.php");
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
    <link rel="stylesheet" href="Profile.css">
    <link rel="stylesheet" href="/CSS/header_footer.css">
    <link rel="icon" href="/Img/favicon.png">

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
                    <a class="icon" href="/Page_Signup/signup.php"><img src="/Img/icon-avatar-8750713.png" alt="" width="30" height="30">
                    </a>
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
    <main>
        <div class="profile">
            <div class="profile_container">
                <div class="profile_top">
                    <div class="profile_icon">
                        <img src="/Img/icon-avatar-8750713.png" alt="" height="100px" width="100px">
                    </div>
                    <div class="profile_text">
                        <div class="profile_title">
                            <h1>Ваш профиль</h1>
                        </div>
                        <div class="profile_hello">
                            <?php
                            if (isset($_SESSION['login'])) {
                                $login = $_SESSION['login'];
                                echo "Здравствуйте " . $login . ".<br> Добро пожаловать в SLO.OF!";
                            } else {
                                echo "Войти.";
                            }
                            ?>
                        </div>
                    </div>
                </div>
                <div class="profile_bottom">
                    <div class="authorization_input">
                        <div class="seller_form">
                            <a class="button_seller" href="/Page_Sell/your_products.php"> <div>Мои товары</div> </a>
                        </div>
                        <!-- Форма смены почты-->
                        <div class="change_form">
                            <div class="form_text">Смена почты</div>
                            <form class="form_row" action="" method="post">
                                <input class="input_register" type="text" placeholder="Ваша новая почта" name="email">
                                <input type="hidden" name="form" value="email">
                                <button class="button_change" type="submit"> Сменить почту </button>
                            </form>
                        </div>
                        <!-- Форма добавления номера -->
                        <div class="change_form">
                            <div class="form_text">Добавьте номер телефона</div>
                            <form class="form_row" action="" method="post">
                                <input class="input_register" type="text" placeholder="Ваш номер" name="number">
                                <input type="hidden" name="form" value="number_phone">
                                <button class="button_change" type="submit"> Сменить номер </button>
                            </form>
                        </div>
                    </div>
                    <div class="authorization_output">
                        <?php
                        require_once('../db.php');

                        // php запрос =================================================================
                        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                            if ($_POST['form'] === 'number_phone') {

                                $new_number = $_POST['number'];

                                if (empty($new_number)) {
                                    echo "Вы отправили пустой номер.";
                                } else {
                                    // Поиск пользователя по логину без ID
                                    $stmt = $conn->prepare("SELECT * FROM users WHERE login = ?"); // Проверяем наличие логина
                                    $stmt->bind_param('s', $login);
                                    $stmt->execute();
                                    $result = $stmt->get_result();

                                    if ($result->num_rows > 0) {
                                        $stmt = $conn->prepare("UPDATE users SET phone = ? WHERE login = ?"); // Проверяем наличие логина
                                        $stmt->bind_param('ss', $new_number, $login);
                                        $stmt->execute();
                                        echo "Ваш новый номер " . $new_number;
                                    }
                                }
                            } elseif ($_POST['form'] === 'email') {

                                $new_email = $_POST['email'];

                                if (empty($new_email)) {
                                    echo "Вы отправили пустой номер.";
                                } else {
                                    // Поиск пользователя по логину без ID
                                    $stmt = $conn->prepare("SELECT * FROM users WHERE login = ?"); // Проверяем наличие логина
                                    $stmt->bind_param('s', $login);
                                    $stmt->execute();
                                    $result = $stmt->get_result();

                                    if ($result->num_rows > 0) {
                                        $stmt = $conn->prepare("UPDATE users SET email = ? WHERE login = ?"); // Проверяем наличие логина
                                        $stmt->bind_param('ss', $new_email, $login);
                                        $stmt->execute();
                                        echo "Ваш новый номер " . $new_email;
                                    }
                                }
                            }
                        }

                        $conn->close();
                        ?>
                    </div>
                </div>
            </div>
    </main>

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
            if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {}
        };
        xhr.send();
    });

    function reload_interval(time) {
        setTimeout(function() {
            location.reload();
        }, time);
    }
</script>

</html>