<?php
session_start();

// Проверка, авторизован ли пользователь
if (!isset($_SESSION['user_id'])) {
    // Перенаправление на страницу регистрации
    echo '<script>window.location.href = "../index.php";</script>';
    exit();
}

$all_cost = 0;
$new_cost = 0;
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
    <link rel="stylesheet" href="/CSS/header_footer.css">
    <link rel="stylesheet" href="page.css">
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
    <div class="intro"></div>
    <main>
        <div class="busket_text">
            <h1>Ваша корзина</h1>
        </div>
        <div class="busket_container">
            <div class="busket_block_left">
                <?php
                include('../php/block_product_busket.php');
                ?>
            </div>
            <div class="busket_right">
                <a href="/Page_about/about.php" class="button_buy" type="submit" name="busket_product">Оформить заказ</a>
                <div class="busket_cost">
                    <?php
                    include("../db.php");
                    $stmt = $conn->prepare("SELECT * FROM `busket` WHERE login = ?");
                    $stmt->bind_param('s', $login);
                    $stmt->execute();
                    $result1 = $stmt->get_result();

                    if ($result1->num_rows > 0) {
                        while ($row = $result1->fetch_assoc()) {
                            $product_id = $row['product_id'];
                            $user_quantity = $row['user_quantity'];

                            $stmt = $conn->prepare("SELECT * FROM `product` WHERE product_id = ?");
                            $stmt->bind_param('s', $product_id);
                            $stmt->execute();
                            $result2 = $stmt->get_result();

                            if ($result2->num_rows > 0) {
                                while ($productRow = $result2->fetch_assoc()) {
                                    $cost = $productRow['cost'];
                                    $new_cost = $cost * $user_quantity;
                                    $all_cost = $all_cost + $new_cost;
                                }
                            }
                        }
                    }
                    echo $all_cost;
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