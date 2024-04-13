<?php
// Подключаемся к базе данных
require_once('db.php');

// Получаем новости из базы данных
$stmt = $conn->prepare("SELECT title, content, image FROM news");
$stmt->execute();
$result = $stmt->get_result();

// Создаем массив для хранения новостей
$newsArray = array();

// Проверяем, есть ли новости
if ($result->num_rows > 0) {
    // Добавляем новости в массив
    while ($row = $result->fetch_assoc()) {
        $newsArray[] = $row;
    }
}

// Возвращаем новости в формате JSON
header('Content-Type: application/json');
echo json_encode($newsArray);

// Закрываем соединение с базой данных
$stmt->close();
$conn->close();
?>
