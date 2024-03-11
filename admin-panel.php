<?php
// session_start();

// if (!isset($_SESSION["admin"]) || !$_SESSION["admin"]) {
//     header("Location: index.html");
//     exit;
// }

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "your_database";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Управление товарами
    if (isset($_POST["add_product"])) {
        $name = $_POST["name"];
        $price = $_POST["price"];
        $quantity = $_POST["quantity"];
        $category = $_POST["category"];

        $stmt = $conn->prepare("INSERT INTO products (name, price, quantity, category) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("siss", $name, $price, $quantity, $category);
        $stmt->execute();
        $stmt->close();
    }

    // Управление пользователями
    if (isset($_POST["change_password"])) {
        $user_email = $_POST["user_email"];
        $new_password = $_POST["new_password"];

        // Обновление пароля пользователя
        $update_password_stmt = $conn->prepare("UPDATE users SET password = ? WHERE email = ?");
        $update_password_stmt->bind_param("ss", $new_password, $user_email);
        $update_password_stmt->execute();
        $update_password_stmt->close();
    }

    if (isset($_POST["block_user"])) {
        $user_email = $_POST["user_email"];
        $blocked = $_POST["blocked"];

        // Блокировка/Разблокировка пользователя
        $stmt = $conn->prepare("UPDATE users SET blocked = ? WHERE email = ?");
        $stmt->bind_param("is", $blocked, $user_email);
        $stmt->execute();
        $stmt->close();
    }
}

// Получение данных пользователей
$user_sql = "SELECT * FROM users";
$user_result = $conn->query($user_sql);

$sql = "SELECT * FROM products";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">
    <title>Админ-панель</title>
</head>
<body>
    <h2>Управление товарами</h2>

    <form action="admin-panel.php" method="post">
        <label for="name">Название товара:</label>
        <input type="text" name="name" required><br>

        <label for="price">Цена:</label>
        <input type="number" name="price" required><br>

        <label for="quantity">Количество:</label>
        <input type="number" name="quantity" required><br>

        <label for="category">Категория:</label>
        <input type="text" name="category" required><br>

        <button type="submit" name="add_product">Добавить товар</button>
    </form>

    <table border="1">
        <tr>
            <th>ID</th>
            <th>Название</th>
            <th>Цена</th>
            <th>Количество</th>
            <th>Категория</th>
            <th>Действия</th>
        </tr>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["id"] . "</td>";
                echo "<td>" . $row["name"] . "</td>";
                echo "<td>" . $row["price"] . "</td>";
                echo "<td>" . $row["quantity"] . "</td>";
                echo "<td>" . $row["category"] . "</td>";
                echo "<td><a href='edit_product.php?id=" . $row["id"] . "'>Редактировать</a> | <a href='delete_product.php?id=" . $row["id"] . "'>Удалить</a></td>";
                echo "</tr>";
            }
        } else {
            echo "Нет товаров в базе данных";
        }
        ?>
    </table>

    <h2>Управление пользователями</h2>

    <table border="1">
        <tr>
            <th>ID</th>
            <th>Имя</th>
            <th>Email</th>
            <th>Заблокирован</th>
        </tr>
        <?php
        if ($user_result->num_rows > 0) {
            while ($user_row = $user_result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $user_row["id"] . "</td>";
                echo "<td>" . $user_row["name"] . "</td>";
                echo "<td>" . $user_row["email"] . "</td>";
                echo "<td>" . $user_row["blocked"] . "</td>";
                echo "</tr>";
            }
        } else {
            echo "Нет пользователей в базе данных";
        }
        ?>
    </table>

    <form action="admin-panel.php" method="post">
        <h3>Изменение пароля пользователя</h3>
        <label for="user_email">Email пользователя:</label>
        <input type="text" name="user_email" required><br>

        <label for="new_password">Новый пароль:</label>
        <input type="password" name="new_password" required><br>

        <button type="submit" name="change_password">Изменить пароль</button>

        <h3>Блокировка/Разблокировка пользователя</h3>
        <label for="user_email_block">Email пользователя:</label>
        <input type="text" name="user_email" required><br>

        <label for="blocked">Заблокировать (1) / Разблокировать (0):</label>
        <input type="text" name="blocked" required><br>

        <button type="submit" name="block_user">Изменить статус блокировки</button>
    </form>

    <br>
    <a href="logout.php">Выйти из админ-панели</a>
</body>
</html>

<?php
$conn->close();
?>
