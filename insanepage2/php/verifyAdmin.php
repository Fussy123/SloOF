<?php
// Получаем данные из тела запроса
$data = json_decode(file_get_contents('php://input'), true);

// Проверяем, были ли данные отправлены
if (!empty($data)) {
    // Доступ к данным
    $form = $data['form'];
    $adminPassword = $data['adminPassword'];
    $user_login = $data['user_login'];

    if ($form = 'adminWerify') {
        verifyAdminForm($adminPassword, $user_login);
    }


} else {
    // Если данные не были отправлены, возвращаем ошибку
    echo ('Ошибка при отправке данных на сервер ');
}

function verifyAdminForm($adminPassword, $user_login) {
    require_once('db.php');
    $stmt = $conn->prepare("SELECT * FROM `admins` WHERE login = ?");
    $stmt->bind_param('s', $user_login);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $admin = $result->fetch_assoc();
        if (password_verify($adminPassword, $admin['password'])) {
            echo "admin.html";
            
        } else {
            echo "wrong password";
        }
    } else {
        echo "Incorrect login or password";
    }
};