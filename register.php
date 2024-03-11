<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Регистрация</title>
    <link rel="stylesheet" href="style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">
</head>
<body style = "margin-top: 100px; margin-left: 100px;">

<h2 style = "color: white;">Регистрация</h2>

<form id="registrationForm" action="process-register.php" method="post">
    <label for="name">Имя:</label>
    <input type="text" name="name" required><br>

    <label for="email">Email:</label>
    <input type="email" name="email" required><br>

    <label for="password">Пароль:</label>
    <input type="password" name="password" required><br>

    <button type="submit" style =  "border: none;border-radius: 30px;width: 200px;height: 40px;background: pink; margin-top: 20px; font-size: 16px;">Зарегистрироваться</button>
</form>

<p>Уже есть аккаунт? <a href="login.php">Войдите здесь</a>.</p>

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
$(document).ready(function() {
    $('#registrationForm').submit(function(e) {
        e.preventDefault();

        $.ajax({
            type: 'POST',
            url: 'process-register.php',
            data: $('#registrationForm').serialize(),
            success: function(response) {
                var data = JSON.parse(response);

                if (data.success) {
                    alert(data.message);
                    window.location.href = "login.php";
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
