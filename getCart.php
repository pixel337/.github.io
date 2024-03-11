<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "your_database";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT p.name, p.price, c.quantity FROM cart c
        INNER JOIN products p ON c.product_id = p.id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $cartItems = array();
    $totalPrice = 0;

    while ($row = $result->fetch_assoc()) {
        $cartItems[] = array(
            "name" => $row["name"],
            "price" => $row["price"],
            "quantity" => $row["quantity"]
        );

        $totalPrice += $row["price"] * $row["quantity"];
    }

    echo json_encode(array("cartItems" => $cartItems, "totalPrice" => $totalPrice));
} else {
    echo json_encode(array("cartItems" => array(), "totalPrice" => 0));
}

$conn->close();
?>
