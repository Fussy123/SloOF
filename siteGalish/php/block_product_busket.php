<?php
require_once('../db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['product_id'])) {
        $product_id = $_POST['product_id'];
        $action = $_POST['action']; // Получаем действие (увеличить или уменьшить количество)

        $stmt = $conn->prepare("SELECT user_quantity FROM `busket` WHERE product_id = ?");
        $stmt->bind_param('s', $product_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $user_quantity = $row['user_quantity'];

            if ($action === 'increase') {
                // Увеличиваем количество товара на 1
                $user_quantity += 1;
            } elseif ($action === 'decrease') {
                // Уменьшаем количество товара на 1
                if ($user_quantity > 0) {
                    $user_quantity -= 1;
                }
            }

            // Обновляем количество товара в базе данных
            $update_stmt = $conn->prepare("UPDATE `busket` SET user_quantity = ? WHERE product_id = ?");
            $update_stmt->bind_param('ii', $user_quantity, $product_id);

            if ($update_stmt->execute()) {
            } else {
            }
        }
    }
}

$login = $_SESSION['login'];

$stmt = $conn->prepare("SELECT * FROM `busket` WHERE login = ?");
$stmt->bind_param('s', $login);
$stmt->execute();
$result1 = $stmt->get_result();

if ($result1->num_rows > 0) {
    while ($row = $result1->fetch_assoc()) {
        $product_id = $row['product_id'];
        $user_quantity = $row['user_quantity'];

        $stmt = $conn->prepare("SELECT * FROM `product` WHERE product_id = ?");
        $stmt->bind_param('s', $product_id);
        $stmt->execute();
        $result2 = $stmt->get_result();

        if ($result2->num_rows > 0) {
            while ($productRow = $result2->fetch_assoc()) {
                echo '<div class="block_product">';
                echo '<div class="title_text">' . $productRow["title_text"] . ' </div>';
                echo '<div class="seller">' . 'Продавец: ' . $productRow["login"] . '</div>';
                echo '<div class="squere1" href="../Page_product/product.php?product_id=' . $productRow["product_id"] . '">';
                echo '<a href="../Page_product/product.php?product_id=' . $productRow["product_id"] . '">';
                echo '<img src="' . $productRow["img"] . '" alt="" width="260" height="300" style="border-radius: 20px; padding-top:20px;">';
                echo '</a>';
                echo '<div class="product_right">';
                echo '<form method="post" action="">';
                echo '<input type="hidden" name="product_id" value="' . $productRow["product_id"] . '">';

                // кнопка удаления продукта из каризны
                if ($user_quantity == 0) {
                    echo '<form method="post" style="display: flex;justify-content: center; padding-right: 30px;">';
                    echo '<input type="hidden" name="product_id" value="' . $product_id . '">';
                    echo '<button class="button_delete" type="submit" name="delete_product">Убрать товар из корзины?</button>';
                    echo '</form>';
                } else {

                }
                if (isset($_POST['delete_product'])) {
                    $product_id_to_delete = $_POST['product_id'];

                    // Здесь выполните SQL-запрос для удаления продукта из базы данных по $product_id_to_delete
                    // Например:
                    $delete_stmt = $conn->prepare("DELETE FROM busket WHERE product_id = ?");
                    $delete_stmt->bind_param("i", $product_id_to_delete);
                    $delete_stmt->execute();
                    // После удаления продукта можете вывести сообщение об успешном удалении или выполнить другие действия
                    echo '<script>window.location.href = "../Page_busket/busket.php";</script>';
                    exit;
                }

                echo '<div class="block_quantity">';

                echo '<input type="hidden" name="action" value="decrease">'; // Скрытое поле для уменьшения количества
                echo '<div class="quantity">';
                echo '<button class="quantity_submit" type="submit" name="decrease">-</button>';
                echo '</div>';
                echo '</form>';

                echo '<div class="quantity_value">' . $user_quantity . '</div>';

                echo '<form method="post" action="">';
                echo '<input type="hidden" name="product_id" value="' . $productRow["product_id"] . '">';
                echo '<input type="hidden" name="action" value="increase">'; // Скрытое поле для увеличения количества
                echo '<div class="quantity">';
                echo '<button class="quantity_submit" type="submit" name="increase">+</button>';
                echo '</div>';
                echo '</form>';

                echo '</div>';
                echo '<div class="cost">' . $productRow["cost"] * $user_quantity . '</div>';
                echo '</div>';
                echo '</div>';

                echo '</div>';
            }
        } else {
            echo "Упс...";
        }
    }
} else {
    echo "Корзина пуста";
}

$conn->close();
