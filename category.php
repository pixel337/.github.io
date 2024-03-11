<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "your_database";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Получаем значения фильтров из запроса
$category = isset($_GET['category']) ? $_GET['category'] : '';
$priceFrom = isset($_GET['price_from']) ? $_GET['price_from'] : '';
$priceTo = isset($_GET['price_to']) ? $_GET['price_to'] : '';
$quantity = isset($_GET['quantity']) ? $_GET['quantity'] : '';

// Запрос для получения всех уникальных категорий
$categoriesQuery = "SELECT DISTINCT category FROM products";
$categoriesResult = $conn->query($categoriesQuery);

// Запрос для получения товаров с учетом фильтров
$sql = "SELECT * FROM products WHERE 1";

// Добавляем условия для каждого фильтра, если они заданы
if (!empty($category)) {
    $sql .= " AND category = '$category'";
}
if (!empty($priceFrom)) {
    $sql .= " AND price >= $priceFrom";
}
if (!empty($priceTo)) {
    $sql .= " AND price <= $priceTo";
}
if (!empty($quantity)) {
    $sql .= " AND quantity >= $quantity";
}

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>La santé - Категория <?php echo $category; ?></title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">

    <style>
        body{
            width: 1920px;
            background: #fab6cd;;
            font-family: 'Inter';
            margin: 0;
            padding: 0;
            overflow-x: 0;
        }
        main {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-around;
            gap: 40px;
        }
        .product {
            border-radius: 20px;
            width: 532px;
            height: 672px;
            background: rgba(255, 255, 255, 0.2);
        }

        .product img {
            border-radius: 20px;
            width: 458px;
            height: 400px;
            margin-left: 37px;
            padding-top: 15px;
        }

        .product p {
            font-family: var(--font-family);
            font-weight: 700;
            font-size: 40px;
            text-align: center;
            color: #b984a0;
            text-align: left;
            margin-top: 0px;
            padding-left: 37px;
        }

        .product button {
            border-radius: 15px;
            width: 361px;
            height: 66px;
            box-shadow: 0 4px 4px 0 rgba(0, 0, 0, 0.25);
            background: #b984a0;
            margin-left: 85px;
            margin-top: -10px;
        }

        form{
            display: flex;
            flex-direction: column;
        }
    </style>
</head>
<body>

<header>
    <menu>
            <p><a href="#categories">Товары</a></p>
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
    <form action="" method="get" style="margin-bottom: 20px;">
        <label for="category">Категория:</label>
        <select name="category">
            <option value="">Все категории</option>
            <?php
            while ($row = $categoriesResult->fetch_assoc()) {
                echo "<option value='" . $row['category'] . "'";
                if ($row['category'] == $category) {
                    echo " selected";
                }
                echo ">" . $row['category'] . "</option>";
            }
            ?>
        </select>

        <label for="price_from">Цена от:</label>
        <input type="text" name="price_from" value="<?php echo $priceFrom; ?>">

        <label for="price_to">Цена до:</label>
        <input type="text" name="price_to" value="<?php echo $priceTo; ?>">

        <label for="quantity">Количество:</label>
        <input type="text" name="quantity" value="<?php echo $quantity; ?>">

        <button type="submit">Применить фильтры</button>
    </form>

    <?php
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<a href='product.php?id={$row['id']}' class='product-link'>";
            echo "<div class='product'>";
            echo "<img src='" . $row['image'] . "' alt='" . $row['name'] . "'>";
            echo "<p>" . $row['name'] . "</p>";
            echo "<p>Цена: " . $row['price'] . " руб.</p>";
            echo "<button>В карточку</button>";
            echo "</div>";
        }
    } else {
        echo "Нет товаров в данной категории";
    }

    $conn->close();
    ?>
</main>
<script>
function addToCart(productId) {
    fetch('add_to_cart.php?product_id=' + productId)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Товар добавлен в корзину');
            } else {
                alert('Не удалось добавить товар в корзину');
            }
        })
        .catch(error => {
            console.error('Ошибка:', error);
        });
}
</script>
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