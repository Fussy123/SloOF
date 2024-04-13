<?php
require_once('db.php');

// Получаем все существующие product_id из базы данных
$result = $conn->query("SELECT product_id FROM product");
$productIds = [];
while ($row = $result->fetch_assoc()) {
    $productIds[] = $row['product_id'];
}

// Перемешиваем массив productIds
shuffle($productIds);

// Берем первые пять уникальных значений для выбора продуктов
$selectedProductIds = array_slice($productIds, 0, 5);

// Преобразуем выбранные ID в строку для использования в SQL-запросе
$selectedProductIdsString = implode(',', $selectedProductIds);

// Запрос к базе данных для получения выбранных продуктов
$sql = "SELECT * FROM product WHERE product_id IN ($selectedProductIdsString)";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($productRow = $result->fetch_assoc()) {
        echo '<a class="squere1" href="' . "Page_product/product.php?product_id=" . $productRow["product_id"] . '">';
        echo '<img class="squere1_img" src="' . $productRow["img"] . '" alt="" width="300" height="300" style="border-radius: 20px;">';
        echo '<div class="cost">' . $productRow["cost"] . '</div>';
        echo '<div class="title_text">' . $productRow["title_text"] . ' </div>';
        echo '<div class="seller">' . 'Продавец: ' . $productRow["login"] . '</div>';
        echo '</a>';
    }
} else {
    echo "Упс...";
}
?>
