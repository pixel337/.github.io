<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "your_database";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$product_id = $_GET['id'];

$sql = "SELECT * FROM products WHERE id = $product_id";
$result = $conn->query($sql);

if ($result->num_rows == 0) {
    die("Товар не найден");
}

$product = $result->fetch_assoc();

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>La santé - <?php echo $product['name']; ?></title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">
    <style>
        body{
            font-family: 'Inter';
        }

        main {
            text-align: center;
            margin-top: 20px;
        }

        .product-details {
            display: inline-block;
            text-align: left;
            margin: 20px;
            padding: 20px;
            border-radius: 20px;
            background: rgba(255, 255, 255, 0.2);
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .product-details img{
            margin-left: 0px;
        }

        .product-details p, .product-details h1{
            color: white;
        }

        .cart {
            position: fixed;
            top: 0;
            right: 0;
            background: #f7b5cd;
            border-radius: 0 0 0 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        menu{
            margin-left: 400px;
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
        <a href="cart.php"><img src="img/cart.svg fill.png" id="cart-img" alt=""></a>
    </menu>
</header>

<main>
    <div class="product-details">
        <h1><?php echo $product['name']; ?></h1>
        <img src="<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>">
        <p>Цена: <?php echo $product['price']; ?> руб.</p>
        <p id="total-price"></p>
        <button onclick="addToCart(<?php echo $product_id; ?>)">Добавить в корзину</button>
    </div>
</main>

<script>
function addToCart(productId) {
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4) {
            console.log("Ответ сервера:", xhr.responseText);

            document.getElementById("cart-items").innerHTML += xhr.responseText;
            updateTotalPrice();
        }
    };

    xhr.open("GET", "addToCart.php?id=" + productId, true);
    xhr.send();
}

function updateTotalPrice() {
    var total = 0;
    var items = document.querySelectorAll('#cart-items li');

    items.forEach(function (item) {
        var itemText = item.innerText;
        var quantityMatches = itemText.match(/(\d+)\s*шт/);
        var priceMatches = itemText.match(/Цена:\s*([\d.,]+)\s*руб/);

        if (quantityMatches && quantityMatches.length > 1 && priceMatches && priceMatches.length > 1) {
            var quantity = parseInt(quantityMatches[1]);
            var productPrice = parseFloat(priceMatches[1].replace(/\s+/g, '').replace(',', '.'));
            var itemTotal = calculateItemPrice(quantity, productPrice);
            total += itemTotal;
        }
    });

    var totalPriceElement = document.getElementById('total-price');
    if (totalPriceElement) {
        totalPriceElement.innerText = 'Общая сумма: ' + total.toFixed(2) + ' руб.';
    } else {
        console.error("Элемент 'total-price' не найден");
    }
}






function calculateItemPrice(quantity, price) {
    return quantity * price;
}


</script>

<a href="cart.php">
    <div class="cart" id="cart">
    <h2>Корзина</h2>
    <ul id="cart-items"></ul>
</div>
</a>

<div class="input">
        <div class="labels">
            <p>Полезная рассылка</p>
            <input type="text" placeholder="Введите ваш email">
            <button>Подписаться</button>
        </div>
        <p class="disclaimer">Нажимая на кнопку “Подписаться”, Вы соглашаетесь с условиями использования сайта.</p>
    </div>

</body>
</html>