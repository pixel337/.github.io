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

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $productId = (int)$_GET['id'];

    if (!isset($_SESSION['cart'][$productId])) {
        $_SESSION['cart'][$productId] = array("quantity" => 1);
    } else {
        $_SESSION['cart'][$productId]["quantity"]++;
    }

    $sql = "SELECT * FROM products WHERE id = $productId";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $product = $result->fetch_assoc();
        // Добавляем цену в массив корзины
        $_SESSION['cart'][$productId]["price"] = $product['price'];
        echo '<li>' . $product['name'] . ' - ' . $_SESSION['cart'][$productId]['quantity'] . ' шт.</li>';
    }
} else {
    echo "Error";
}

$conn->close();
?>
