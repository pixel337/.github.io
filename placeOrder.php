<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "your_database";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$cartItems = isset($_SESSION['cart']) ? $_SESSION['cart'] : array();

if (!empty($cartItems)) {
    $userId = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 0;

    echo "Отладка: Товары в корзине:<br>";
    foreach ($cartItems as $productId => $item) {
        echo "Отладка: Товар ID: $productId, Количество: {$item['quantity']}, Цена: {$item['price']} руб.<br>";
    }

    // Вычислить общую стоимость заказа
    $totalPrice = calculateTotalPrice($cartItems);

    // Отладочный вывод
    echo "Отладка: Общая стоимость заказа: $totalPrice руб.<br>";


    $insertOrderQuery = "INSERT INTO orders (user_id, total_price) VALUES (?, ?)";
    $insertOrderStmt = $conn->prepare($insertOrderQuery);
    $insertOrderStmt->bind_param("id", $userId, $totalPrice);
    
    if ($insertOrderStmt->execute()) {
        $orderId = $conn->insert_id;

        $insertOrderItemsQuery = "INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)";
        $insertOrderItemsStmt = $conn->prepare($insertOrderItemsQuery);

        foreach ($cartItems as $productId => $item) {
            $quantity = $item['quantity'];
            $price = $item['price'];
        
            // Отладочный вывод для каждого товара в корзине
            echo "Отладка: Товар ID: $productId, Количество: $quantity, Цена: $price руб.";
        
            $insertOrderItemsStmt->bind_param("iiid", $orderId, $productId, $quantity, $price);
            $insertOrderItemsStmt->execute();
        }
        
        $insertOrderItemsStmt->close();
        unset($_SESSION['cart']);

        echo "Заказ успешно размещен!";
    } else {
        echo "Ошибка при размещении заказа: " . $conn->error;
    }

    $insertOrderStmt->close();
} else {
    echo "Корзина пуста!";
}

function calculateTotalPrice($cartItems) {
    $totalPrice = 0;

    foreach ($cartItems as $productId => $item) {
        $totalPrice += $item['price'] * $item['quantity'];
    }

    return $totalPrice;
}

$conn->close();
?>
