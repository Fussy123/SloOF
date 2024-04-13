<?php
require_once('../db.php');

$login = $_SESSION['login'];
// Берем первые пять уникальных значений для выбора продуктов

$stmt = $conn->prepare("SELECT * FROM `product` WHERE login = ?");
$stmt->bind_param('s', $login);
$stmt->execute();
$result = $stmt->get_result();

// Запросы к базе данных для получения случайных продуктов
if ($result->num_rows > 0) {
    while ($productRow = $result->fetch_assoc()) {
        echo '<a class="squere1" href="../Page_product/product.php?product_id=' . $productRow["product_id"] . '">';
            echo '<img src="' . $productRow["img"] . '" alt="" width="260" height="300" style="border-radius: 20px;">';
            echo '<div class="cost">' . $productRow["cost"] . '</div>';
            echo '<div class="title_text">' . $productRow["title_text"] . ' </div>';
            echo '<div class="seller">'. 'Продавец: ' . $productRow["login"] . '</div>'; 
        echo '</a>';
    }
} else {
    echo "Упс...";
}
?>
