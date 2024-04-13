<?php
session_start();
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
    <link rel="stylesheet" href="your_product.css">
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
        <div class="product" style="margin-bottom: 100px;">
            <div class="product_container">
                <div class="product_input">
                    <!-- Форма регистрации-->
                    <div class="product_text">Регистрация товара</div>
                    <form class="product_form" action="" method="post" enctype="multipart/form-data">
                        <input class="input_product" type="file" name="product_image">
                        <input class="input_product" type="text" placeholder="Название товара" name="title_text">
                        <textarea class="input_product" placeholder="Описание товара" name="description_text"></textarea>
                        <input class="input_product" type="text" placeholder="Количество товара" name="quantity">
                        <input class="input_product" type="text" placeholder="цена товара" name="cost">
                        <input type="hidden" name="form" value="product">
                        <button class="button_product" type="submit"> Создать товар </button>
                    </form>
                </div>
                <div class="product_output">
                    <?php
                    require_once('../db.php');

                    // php запрос =================================================================
                    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                        if ($_POST['form'] === 'product') {
                            $target_dir = "../image/"; // Создайте папку 'upload' для сохранения загруженных файлов
                            $target_file = $target_dir . basename($_FILES["product_image"]["name"]);
                            $uploadOk = 1;
                            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

                            $title_text = $_POST['title_text'];
                            $description_text = $_POST['description_text'];
                            $quantity = $_POST['quantity'];
                            $cost = $_POST['cost'];
                            $login = $_SESSION['login'];
                            $category = '0';
                            $priority = '0';
                            // Проверка размера файла (здесь установлен лимит в 4MB)
                            if ($_FILES["product_image"]["size"] > 4000000) {
                                echo "Упс... Файл слишком большой.";
                                $uploadOk = 0;
                            }
                            // Позволяет загрузку только изображений
                            if (
                                $imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "webp"
                            ) {
                                echo "Допускается загрузка файлов png, jpeg, jpg. ";
                                $uploadOk = 0;
                            } else {

                                // Проверка на ошибки при загрузке
                                if ($uploadOk == 0) {
                                    echo "Вы отправили пустое изображение.";

                                    // Если все проверки прошли успешно, загрузите файл на сервер
                                } else {
                                    if (empty($title_text) || empty($description_text) || empty($quantity) || empty($login) || empty($cost)) {
                                        echo "Вы оставили пустые поля.";
                                    } else {
                                        $uniqid = uniqid("file_");
                                        if (move_uploaded_file($_FILES['product_image']['tmp_name'], $target_dir . $uniqid . "." . "png")) {
                                            $img = $target_dir . $uniqid . "." . "png";
                                            $stmt = $conn->prepare("INSERT INTO `product` (img, title_text, description_text,  priority, category, quantity, cost, login) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
                                            $stmt->bind_param('sssiisss', $img, $title_text, $description_text, $priority, $category, $quantity, $cost, $login);
                                            $stmt->execute();

                                            echo 'Товар создан.';
                                        } else {
                                            echo "Ошибка загрузки файла";
                                        }
                                    }
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