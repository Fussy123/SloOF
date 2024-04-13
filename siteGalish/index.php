<?php
session_start();
$guest = null; // Установить значение $guest по умолчанию

// Проверка, залогинен ли пользователь
if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    $guest = true; // Установить $guest как гостя
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
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="CSS/header_footer.css">
    <link rel="icon" href="Img/favicon.png">

    <title>SLO.OF!</title>
</head>

<body>
    <!-- Хэдэр -->
    <div class="header">
        <div class="header_container">
            <div class="logo">
                <a class="logo_link" href="index.php">
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
                    <a class="icon" href="Page_Signup/signup.php"><img src="Img/icon-avatar-8750713.png" alt="" width="30" height="30">
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
                    <a class="icon" href="/Page_busket/busket.php"><img src="img/shopping-cart-711897.png" alt="" width="30" height="30"></a>
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
    <div class="intro__container">
        <div class="main__head">
            <h1 class="discount">Белая пятница!</h1>
        </div>
    </div>
    <!-- 2 блок(Лучшее от продвавцов)-->
    <div class="seller_container">
        <div class="best__sellers">
            <h1>Лучшее от продавцов!</h1>
        </div>
        <div class="categ">
            <?php
            // Добавить содержимое вашего PHP-файла
            include('php/block_product_high.php');
            include('php/block_product_high.php');
            ?>
        </div>
        <div class="reco">
            <div class="reco__text">
                <h1>Рекомендуем</h1>
            </div>
            <!-- Рекомендуемые товары -->
            <div class="categ__reco">
                <?php
                // Добавить содержимое вашего PHP-файла
                include('php/block_product_low.php');
                include('php/block_product_low.php');
                ?>
            </div>
            <!-- Продолжение (прямоуголные квадраты) -->
            <div class="categ__reco">
                <?php
                // Добавить содержимое вашего PHP-файла
                include('php/block_banner.php');
                ?>
                <!-- продолжение (вертикальные прямоуголные квадраты) -->
            </div>

            <div class="categ__reco">
                <?php
                // Добавить содержимое вашего PHP-файла
                include('php/block_product_low.php');
                include('php/block_product_low.php');
                ?>
            </div>
            <!-- Продолжение (прямоуголные квадраты) -->
            <div class="categ__reco3">
                <?php
                // Добавить содержимое вашего PHP-файла
                include('php/block_banner_small.php');
                ?>
            </div>

        </div>
        <div class="why__us">
            <div class="why__us__header">
                <h1>Почему именно мы ?</h1>
            </div>
            <div class="why__us__text">


                Добро пожаловать в наш интернет-магазин, где каждая деталь имеет свой смысл и значение.<br>
                Мы стремимся предложить нечто большее, чем просто товары<br>
                - мы создаем удобство, надежность и качество для наших клиентов.<br>
                <br>
                1. Широкий ассортимент продукции: Мы предлагаем огромный выбор товаров,<br> чтобы каждый клиент мог
                найти
                именно то, что отвечает его потребностям и предпочтениям.<br>
                <br>
                2. Качество на первом месте: Мы стремимся к исключительному качеству продукции.<br> Все товары проходят
                строгий отбор, чтобы удовлетворить самые высокие стандарты.<br>
                <br>
                3. Доступные цены: Мы ценим наших клиентов и
                предлагаем адекватные и конкурентоспособные цены,<br>чтобы каждый мог позволить себе качественные
                товары.<br>
                <br>
                4. Профессиональный сервис: Наша команда профессионалов готова помочь вам с выбором,<br>ответить на
                вопросы
                и обеспечить отличный опыт покупок.<br>
                <br>
                Выбирая нас, вы выбираете надежность, качество и удобство.<br> Благодарим за доверие и ждем вас снова в
                нашем интернет-магазине!
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