<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "your_database";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_POST["user_id"];
    $blocked = $_POST["blocked"];

    $stmt = $conn->prepare("UPDATE users SET blocked = ? WHERE id = ?");
    $stmt->bind_param("ii", $blocked, $user_id);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo json_encode(["success" => true, "message" => "Статус блокировки пользователя успешно изменен."]);
    } else {
        echo json_encode(["success" => false, "message" => "Пользователь с указанным идентификатором не найден."]);
    }

    $stmt->close();
} else {
    echo json_encode(["success" => false, "message" => "Неверные параметры запроса."]);
}

$conn->close();
?>
