<?php

// Получаем данные из тела запроса
$data = json_decode(file_get_contents('php://input'), true);

// Проверяем, были ли данные отправлены
if (!empty($data)) {
    // Доступ к данным
    $form = $data['form'];
    $login = $data['login'];
    $user_password = $data['password'];
    $repeat_password = $data['repeat_password'];

    if ($form == 'signUp') {
        // echo('отправлена форма sign up');
  
        signup($login, $user_password, $repeat_password);
    }

    if ($form == 'signIn') {
        // echo('отправлена форма sign in');

        signin($login, $user_password);
    }
} else {
    // Если данные не были отправлены, возвращаем ошибку
    echo ('Ошибка при отправке данных на сервер ');
}

function signup($login, $user_password, $repeat_password)
{
    require_once('db.php');

    if (empty($login) || empty($user_password) || empty($repeat_password)) {
        echo ('Please fill in all fields');
        return;
    }
    if (strlen($login) > 20 || strlen($user_password) > 30 || strlen($repeat_password) > 30) {
        echo ('Login or password is too long');
        return;
    }

    if ($user_password !== $repeat_password) {
        echo ('Passwords do not match');
        return;
    }

    if (strlen($user_password) < 6) {
        echo ('Password must be at least 6 characters long');
        return;
    }

    $stmt = $conn->prepare("SELECT * FROM users WHERE login = ?"); // Проверяем наличие логина
    $stmt->bind_param('s', $login);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "A user with this login already exists";
    } else {
        $hashed_password = password_hash($user_password, PASSWORD_BCRYPT);

        $stmt = $conn->prepare("INSERT INTO `users` (login, password) VALUES (?, ?)"); // Исправляем порядок и названия полей
        $stmt->bind_param('ss', $login, $hashed_password); // Привязываем параметры в соответствующем порядке
        $stmt->execute();

        echo 'User successfully registered';
    }
}

function signin($login, $user_password)
{
    require_once('db.php');

    if (empty($login) || empty($user_password)) {
        echo ('Please fill in all fields');
        return;
    } else {
        $stmt = $conn->prepare("SELECT * FROM `users` WHERE login = ?");
        $stmt->bind_param('s', $login);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            if (password_verify($user_password, $user['password'])) {
                $_SESSION["login"] = $login;
                echo "Welcome to InsanePage, $login!";
                setcookie('login', $login, time() + 3600, '/');
            } else {
                echo "Incorrect login or password";
            }
        } else {
            echo "Incorrect login or password";
        }
    }
}