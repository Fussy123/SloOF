<?php
require_once('db.php');
// Получаем все существующие product_id из базы данных
$result = $conn->query("SELECT id FROM banner");
$productIds = [];
while ($row = $result->fetch_assoc()) {
    $productIds[] = $row['id'];
}

// Перемешиваем массив productIds
shuffle($productIds);

// Берем первые пять уникальных значений для выбора продуктов
$selectedProductIds = array_slice($productIds, 0, 2);

// Преобразуем выбранные ID в строку для использования в SQL-запросе
$selectedProductIdsString = implode(',', $selectedProductIds);

// Запрос к базе данных для получения выбранных продуктов
$sql = "SELECT * FROM banner WHERE id IN ($selectedProductIdsString)";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($productRow = $result->fetch_assoc()) {
        echo '<a class="squere3" href="' . "product_id_" . $productRow["id"] . '">';
        echo '<img class="squere3_img" src="' . $productRow["img"] . '" width="650px" height="180px" style="border-radius: 40px;">';;
        echo '</a>';
    }
} else {
    echo "Упс...";
}
