<?php
// Подключение к базе данных
require_once('../db.php');

// Проверяем, был ли отправлен поисковый запрос
if (isset($_GET['query']) && !empty($_GET['query'])) {
    $search_query = $_GET['query'];

    // SQL-запрос для поиска продуктов по названию
    $sql = "SELECT * FROM product WHERE title_text LIKE ?";
    $stmt = $conn->prepare($sql);

    // Добавляем символы % для поиска совпадений в любом месте названия продукта
    $search_param = "%" . $search_query . "%";
    $stmt->bind_param('s', $search_param);
    $stmt->execute();
    $result = $stmt->get_result();

    // Вывод результатов поиска
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $product_id = $row['product_id'];

            $stmt = $conn->prepare("SELECT * FROM `product` WHERE product_id = ?");
            $stmt->bind_param('s', $product_id);
            $stmt->execute();
            $result2 = $stmt->get_result();

            // Запросы к базе данных для получения случайных продуктов
            if ($result2->num_rows > 0) {
                while ($productRow = $result2->fetch_assoc()) {
                    echo '<a class="squere1" href="../Page_product/product.php?product_id=' . $productRow["product_id"] . '">';
                    echo '<img src="' . $productRow["img"] . '" alt="" width="260" height="300" style="border-radius: 20px;">';
                    echo '<div class="cost">' . $productRow["cost"] . '</div>';
                    echo '<div class="title_text">' . $productRow["title_text"] . ' </div>';
                    echo '<div class="seller">' . 'Продавец: ' . $productRow["login"] . '</div>';
                    echo '</a>';
                }
            }
        }
    } else {
        echo '<div class="error_text">Или не нашли но мы пытались... :(</div>';
    }
} else {
    echo '<div class="error_text">Введите запрос для поиска</div>';
}
?>