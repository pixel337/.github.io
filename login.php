<!-- Ваш файл login.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Авторизация</title>
</head>
<body style="margin-top: 100px; margin-left: 100px;">
<link rel="stylesheet" href="style.css">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">
<h2 style="color: white;">Авторизация</h2>

<form id="loginForm" action="process-login.php" method="post">
    <label for="email">Email:</label>
    <input type="email" name="email" required><br>

    <label for="password">Пароль:</label>
    <input type="password" name="password" required><br>

    <button type="submit" style="border: none;border-radius: 30px;width: 200px;height: 40px;background: pink; margin-top: 20px; font-size: 16px;">Войти</button>
</form>

<p>Нет аккаунта? <a href="register.php">Зарегистрируйтесь здесь</a>.</p>

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
$(document).ready(function() {
    $('#loginForm').submit(function(e) {
        e.preventDefault();

        $.ajax({
            type: 'POST',
            url: 'process-login.php',
            data: $('#loginForm').serialize(),
            dataType: 'json', // Указываем, что ожидаем JSON-ответ
            success: function(data) {
                if (data.success) {
                    alert(data.message);
                    window.location.href = data.redirect;
                } else {
                    alert(data.message);
                }
            },
            error: function(error) {
                console.log(error);
            }
        });
    });
});
</script>

</body>
</html>