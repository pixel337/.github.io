<?php
// session_start();

// if (!isset($_SESSION["admin"]) || !$_SESSION["admin"]) {
//     header("Location: index.html");
//     exit;
// }

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $price = $_POST["price"];
    $quantity = $_POST["quantity"];
    $category = $_POST["category"];

    // Подключение к базе данных
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "your_database";

    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $stmt = $conn->prepare("INSERT INTO products (name, price, quantity, category) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("sids", $name, $price, $quantity, $category); // Исправлено sii на sids
    $stmt->execute();
    $stmt->close();

    $conn->close();

    header("Location: admin-panel.php");
    exit;
}
?>
