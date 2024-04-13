<?php
// Получаем данные из тела запроса
$data = json_decode(file_get_contents('php://input'), true);

// Проверяем, были ли данные отправлены
// Получаем данные из тела запроса
if (!empty($_POST)) {
    // Доступ к данным
    $title = $_POST['title'];
    $content = $_POST['content'];

    // Проверяем наличие изображения в данных
    if (!empty($_FILES['image']['name'])) {
        // Данные изображения
        $image = $_FILES['image'];

        // Папка для загрузки изображений
        $target_dir = "../images_news/";
        // Проверяем наличие ошибок при загрузке изображения
        if ($image['error'] === UPLOAD_ERR_OK && $image['size'] <= 10000000) {
            // Генерируем уникальное имя для изображения
            $unique_name = uniqid('image_') . '.' . pathinfo($image['name'], PATHINFO_EXTENSION);
            $target_file = $target_dir . $unique_name;

            // Перемещаем изображение в папку для загрузки
            if (move_uploaded_file($image['tmp_name'], $target_file)) {
                // Вывод информации о загруженном изображении

                createNews($title, $content, $target_file);
            } else {
                echo "Ошибка при перемещении изображения на сервер";
            }
        } else {
            echo "Произошла ошибка при загрузке изображения или изображение слишком большое";
        }
    } else {
        echo "Изображение не было загружено";
    }
    // Теперь вы можете использовать $title, $content и $target_file для выполнения дальнейших операций, например, сохранения в базу данных
} else {
    // Если данные не были отправлены, возвращаем ошибку
    echo 'Ошибка при отправке данных на сервер';
}


function createNews($title, $content, $target_file) {
    require_once('db.php');
    echo "$title, $content, $target_file";
    
    $stmt = $conn->prepare("INSERT INTO `news` (title, content, image) VALUES (?, ?, ?)"); // Исправляем порядок и названия полей
    $stmt->bind_param('sss', $title, $content, $target_file); // Привязываем параметры в соответствующем порядке
    $stmt->execute();
    $stmt->close();
    $conn->close();   
}