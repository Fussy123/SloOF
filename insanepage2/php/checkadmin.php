<?php
require_once('db.php');
// Получаем данные из тела запроса
$data = json_decode(file_get_contents('php://input'), true);

// Проверяем, были ли данные отправлены
if (!empty($data)) {
    // Доступ к данным
    $login = $data['login'];

    $stmt = $conn->prepare("SELECT * FROM admins WHERE login = ?"); // Проверяем наличие логина
    $stmt->bind_param('s', $login);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "true";
    } else {
        echo "false";
    }

} else {
    // Если данные не были отправлены, возвращаем ошибку
    echo ('Ошибка при отправке данных на сервер ');
}
