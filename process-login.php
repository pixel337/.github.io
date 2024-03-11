<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "your_database";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        echo json_encode(["success" => false, "message" => "Connection failed: " . $conn->connect_error]);
        exit;
    }

    $email = $_POST["email"];
    $password = $_POST["password"];

    $stmt = $conn->prepare("SELECT id, name, email, password, is_admin, blocked FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt_result = $stmt->execute();

    if ($stmt_result) {
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();

            if ($user["blocked"]) {
                echo json_encode(["success" => false, "message" => "Ваш аккаунт заблокирован. Обратитесь к администратору за помощью."]);
            } elseif ($password === $user["password"]) {
                $_SESSION["user_id"] = $user["id"];
                $_SESSION["user_name"] = $user["name"];

                if ($user["is_admin"]) {
                    $_SESSION["is_admin"] = true;
                    echo json_encode(["success" => true, "message" => "Авторизация успешна! Добро пожаловать, " . $user["name"] . "!", "redirect" => "admin-panel.php"]);
                } else {
                    echo json_encode(["success" => true, "message" => "Авторизация успешна! Добро пожаловать, " . $user["name"] . "!", "redirect" => "index.html"]);
                }
            } else {
                echo json_encode(["success" => false, "message" => "Неправильные email или пароль."]);
            }
        } else {
            echo json_encode(["success" => false, "message" => "Неправильные email или пароль."]);
        }
    } else {
        echo json_encode(["success" => false, "message" => "Ошибка при выполнении запроса: " . $conn->error]);
    }

    $stmt->close();
    $conn->close();
} else {
    http_response_code(405);
    echo json_encode(["success" => false, "message" => "Метод не разрешен"]);
}
?>