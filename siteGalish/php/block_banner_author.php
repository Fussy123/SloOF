<?php
require_once('../db.php');
// Получаем общее количество продуктов
$result = $conn->query("SELECT count(*) as total FROM banner");
$row = $result->fetch_assoc();
$count = $row['total'];

// Создаем массив из всех возможных значений product_id
$productIds = range(1, $count);

// Перемешиваем массив
shuffle($productIds);

// Берем первые пять уникальных значений для выбора продуктов
$login = $_SESSION['login'];
// Берем первые пять уникальных значений для выбора продуктов

$stmt = $conn->prepare("SELECT * FROM `banner` WHERE login = ?"); // Изменен запрос на поиск по login
$stmt->bind_param('s', $login); // Привязываем только login
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    while ($productRow = $result->fetch_assoc()) {
        echo '<a class="squere4" href="' . "../Page_banner/banner.php?banner_id=" . $productRow["id"] . '">';
        echo '<img src="' . $productRow["img"] . '" width="410px" height="180px" style="border-radius: 40px;">';;
        echo '</a>';
    }
} else {
    echo "Упс...";
}
