<!-- edit_product.php -->
<?php
// session_start();

// if (!isset($_SESSION["admin"]) || !$_SESSION["admin"]) {
//     header("Location: index.html");
//     exit;
// }

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["id"])) {
    $product_id = $_GET["id"];

    // Подключение к базе данных
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "your_database";

    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $product = $result->fetch_assoc();
    } else {
        echo "Товар не найден.";
        exit;
    }

    $stmt->close();
} elseif ($_SERVER["REQUEST_METHOD"] == "POST") {
    $product_id = $_POST["id"];
    $name = $_POST["name"];
    $price = $_POST["price"];
    $quantity = $_POST["quantity"];

    // Подключение к базе данных
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "your_database";

    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $stmt = $conn->prepare("UPDATE products SET name = ?, price = ?, quantity = ? WHERE id = ?");
    $stmt->bind_param("siii", $name, $price, $quantity, $product_id);
    $stmt->execute();
    $stmt->close();

    header("Location: admin-panel.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">
    <title>Редактирование товара</title>
</head>
<body>
    <h2>Редактирование товара</h2>

    <form action="edit_product.php" method="post">
        <input type="hidden" name="id" value="<?php echo $product["id"]; ?>">
        <label for="name">Название товара:</label>
        <input type="text" name="name" value="<?php echo $product["name"]; ?>" required><br>

        <label for="price">Цена:</label>
        <input type="number" name="price" value="<?php echo $product["price"]; ?>" required><br>

        <label for="quantity">Количество:</label>
        <input type="number" name="quantity" value="<?php echo $product["quantity"]; ?>" required><br>

        <button type="submit">Сохранить изменения</button>
    </form>
</body>
</html>
