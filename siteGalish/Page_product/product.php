<?php
session_start();

$guest = true; // Предположим, что по умолчанию пользователь является гостем
// Проверка, установлен ли $_SESSION['login']
if (isset($_SESSION['login']) && !empty($_SESSION['login'])) {
    $guest = false; // Пользователь залогинен
}

require_once('../db.php');

if (isset($_GET['product_id'])) {
    $product_id = $_GET['product_id'];
    // Дальнейшие действия с полученным product_id
    // Например, выполнение запроса к базе данных или другая обработка

    $sql = "SELECT * FROM product WHERE product_id = ?";
    // Подготовка запроса
    $stmt = $conn->prepare($sql);

    // Привязка параметра к запросу
    $stmt->bind_param("i", $product_id); // "i" указывает на тип параметра (целое число)
    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        while ($productRow = $result->fetch_assoc()) {

            $login_seller = $productRow["login"];
            $cost = $productRow["cost"];
            $title_text = $productRow["title_text"];
            $description_text = $productRow["description_text"];
            $img = $productRow["img"];
        }
    } else {
        echo "Упс...";
    }

    $stmt->close(); // Закрытие подготовленного запроса
} else {
    echo "Не передан идентификатор продукта";
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
    <link rel="stylesheet" href="page.css">
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
    <div class="intro">

    </div>
    <main>
        <div class="title_text">
            <?php
            echo $title_text;
            ?>
        </div>
        <div class="product_container">
            <?php
            echo '<img src=' . $img . ' alt="" width="500px" height="500px" style="border-radius: 40px;">';
            ?>
            <div class="product_text">
                <div class="seller_text">
                    <?php
                    echo 'Продавец ' . $login_seller;
                    ?>
                </div>
                <div class="description_text">
                    Описание <br>
                    <?php
                    echo $description_text;
                    ?>
                </div>
            </div>
            <div class="button_sells">
                <a href="/Page_about/about.php" class="button_sell">
                    Купить
                    </a>
                <?php
                $stmt = $conn->prepare("SELECT * FROM `busket` WHERE login = ? AND product_id = ?");
                $stmt->bind_param('si', $login, $product_id);
                $stmt->execute();
                $result1 = $stmt->get_result();
                if ($result1->num_rows > 0) {
                    while ($row = $result1->fetch_assoc()) {
                        echo '<a class="button_sell" href="../Page_busket/busket.php">Уже в корзине</a>';
                    }
                } else {
                    echo '<form method="post">';
                    echo '<button class="button_sell" type="submit" name="busket_product">В корзину</button>';
                    echo '</form>';
                    if (isset($_POST['busket_product'])) {
                        $user_quantity = 1;

                        $delete_stmt = $conn->prepare("INSERT INTO busket (login, product_id, user_quantity) VALUES (?,?,?)");
                        $delete_stmt->bind_param("sii", $login, $product_id, $user_quantity);
                        $delete_stmt->execute();
                    }
                }
                ?>
                <div class="cost">
                    <?php
                    echo $cost;
                    ?>
                </div>
            </div>
        </div>
        <?php
        if ($guest == 1) {
        } else {
            if ($login == $login_seller || $_SESSION['is_admin'] == 1) {
                echo '<form method="post" style="display: flex;justify-content: center;margin-top: 30px;">';
                echo '<input type="hidden" name="product_id" value="' . $product_id . '">';
                echo '<button class="button_delete" type="submit" name="delete_product">Удалить товар</button>';
                echo '</form>';
            }
        }
        ?>
        <?php
        // Ваш предыдущий PHP-код...

        // Обработка кнопки удаления продукта
        if (isset($_POST['delete_product'])) {
            if ($_SESSION['is_admin'] == 1 || $_SESSION['login'] == $login_seller) {
                $product_id_to_delete = $_POST['product_id'];

                // Здесь выполните SQL-запрос для удаления продукта из базы данных по $product_id_to_delete
                // Например:
                unlink($img);
                $delete_stmt = $conn->prepare("DELETE FROM product WHERE product_id = ?");
                $delete_stmt->bind_param("i", $product_id_to_delete);
                $delete_stmt->execute();
                // После удаления продукта можете вывести сообщение об успешном удалении или выполнить другие действия
                echo '<script>window.location.href = "../Page_sell/your_products.php";</script>';
                exit;
            }
        }
        ?>

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