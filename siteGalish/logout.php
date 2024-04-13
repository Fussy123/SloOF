<?php
// Начало сессии
session_start();

// Очистка всех переменных сессии
$_SESSION = array();

// Уничтожение сессии
session_destroy();

// Перенаправление на страницу входа или на другую нужную вам страницу
header("Location: index.php");
exit;
?>