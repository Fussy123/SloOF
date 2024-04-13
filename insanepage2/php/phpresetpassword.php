<?php
require_once('db.php');
// Ваши данные пользователя
$user_login = "slatt";
$user_password = "slattAdmin";

// Подключение к базе данных
$conn = new mysqli($servername, $username, $password, $dbname);

// Проверка подключения
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Хеширование пароля
$hashed_password = password_hash($user_password, PASSWORD_BCRYPT);

// Создание SQL-запроса для обновления пароля
$sql = "UPDATE admins SET password = '$hashed_password' WHERE login = '$user_login'";

// Выполнение SQL-запроса
if ($conn->query($sql) === TRUE) {
    echo "Пароль успешно обновлен.";
} else {
    echo "Ошибка при обновлении пароля: " . $conn->error;
}

// Закрытие соединения с базой данных
$conn->close();

?>
