<?php

session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php"); // Перенаправьте на страницу входа
    exit;
}


$servername = "localhost";
$username = "root";
$password = "";
$dbname = "your_database";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$cartItems = isset($_SESSION['cart']) ? $_SESSION['cart'] : array();
$totalPrice = calculateTotalPrice($cartItems);

function calculateTotalPrice($cartItems) {
    $totalPrice = 0;

    foreach ($cartItems as $productId => $item) {
        $product = getProductFromDatabase($productId);
        if ($product) {
            $totalPrice += $product['price'] * $item['quantity'];
        }
    }

    return $totalPrice;
}

function getProductFromDatabase($productId) {
    global $conn;

    $sql = "SELECT * FROM products WHERE id = $productId";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        return $result->fetch_assoc(); 
    } else {
        return null; 
    }
}
if (isset($_GET['action']) && $_GET['action'] == 'get_cart') {
    $cartDetails = array(
        'cartItems' => $cartItems,
        'totalPrice' => calculateTotalPrice($cartItems)
    );

    echo json_encode($cartDetails);
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>La santé - Корзина</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
            background-color: pink;
        }

        th {
            background-color: #f2f2f2;
        }

    </style>
</head>
<body>

<header>
    <menu>
    <p><a href="index.html">Товары</a></p>
        <p class="logo"><a href="index.html" style="font-family: var(--font-family);
                font-weight: 900;
                font-size: 36px;
                text-align: center;
                color: #fef6f2;">La santé</a></p>
        <p><a href="register.php">Регистрация</a></p>
        <p><a href="login.php">Авторизация</a></p>
    </menu>
</header>
<main>
    <h1>Корзина</h1>

    <?php if (!empty($cartItems)) : ?>
        <table>
            <thead>
            <tr>
                <th>Наименование</th>
                <th>Цена</th>
                <th>Количество</th>
                <th>Сумма</th>
            </tr>
            </thead>
            <tbody>
            <?php
                foreach ($cartItems as $productId => $item) {
                    $product = getProductFromDatabase($productId);
                
                    if ($product) {
                        echo "<tr>";
                        echo "<td>" . $product['name'] . "</td>";
                        echo "<td>" . $product['price'] . ' руб.' . "</td>";
                        echo "<td>" . $item['quantity'] . "</td>";
                        echo "<td>" . $product['price'] * $item['quantity'] . ' руб.' . "</td>";
                        echo "</tr>";
                    }
                }
            ?>
            </tbody>
        </table>

        <button style="margin-top: 28px;" onclick="placeOrder()">Заказать</button>
    <?php else : ?>
        <p>Ваша корзина пуста</p>
    <?php endif; ?>
</main>
<script>
function placeOrder() {
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4) {
            if (xhr.status === 200) {
                console.log("Ответ сервера:", xhr.responseText);
                openModal();
                updateCart();
            } else {
                console.error("Ошибка при размещении заказа");
            }
        }
    };

    xhr.open("POST", "placeOrder.php", true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.send("place_order=true");
}


function updateCart() {
    var cartItemsElement = document.getElementById("cart-items");
    var totalPriceElement = document.getElementById("total-price");

    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            var response = JSON.parse(xhr.responseText);
            var cartItems = response.cartItems;
            var totalPrice = response.totalPrice;

            // cartItemsElement = ""; 

            for (var productId in cartItems) {
                if (cartItems.hasOwnProperty(productId)) {
                    var cartItem = cartItems[productId];
                    var li = document.createElement("li");
                    li.textContent = cartItem.name + " - " + cartItem.quantity + " шт.";
                    cartItemsElement.appendChild(li);
                }
            }

            totalPriceElement = "Общая сумма: " + totalPrice + " руб.";
        }
    };
    xhr.open("GET", "cart.php?action=get_cart", true);
    xhr.send();
}
</script>


<div id="success-modal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal()">&times;</span>
        <p>Заказ успешно размещен!</p>
    </div>
</div>
<script>

function openModal() {
    var modal = document.getElementById("success-modal");
    modal.style.display = "block";
}

function closeModal() {
    var modal = document.getElementById("success-modal");
    modal.style.display = "none";
}


</script>
<style>
.modal {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
}

.modal-content {
    background-color: #fefefe;
    margin: 15% auto;
    padding: 20px;
    border: 1px solid #888;
    width: 80%;
    max-width: 400px;
    text-align: center;
    position: relative;
}

.close {
    position: absolute;
    top: 0;
    right: 0;
    font-size: 20px;
    font-weight: bold;
    cursor: pointer;
}
</style>



</body>
</html>
