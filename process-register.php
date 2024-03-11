<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "your_database";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $name = $_POST["name"];
    $email = $_POST["email"];
    $password = $_POST["password"];

    file_put_contents('register_log.txt', "[" . date("Y-m-d H:i:s") . "] Зарегистрирован пользователь: $name, Email: $email, Password: $password\n", FILE_APPEND);

    $stmt = $conn->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $email, $password);
    
    if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "Регистрация успешна! Теперь вы можете авторизоваться.", "redirect" => "login.php"]);
    } else {
        echo json_encode(["success" => false, "message" => "Ошибка при регистрации: " . $stmt->error]);
    }

    $stmt->close();
    $conn->close();
} else {
    http_response_code(405);
    echo json_encode(["success" => false, "message" => "Метод не разрешен"]);
}
?>