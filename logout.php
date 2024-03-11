<?php
// Ваш код выхода из админ-панели

// Завершение текущей сессии
session_start();
session_unset();
session_destroy();

// Перенаправление на главную страницу или страницу входа
header("Location: index.html"); // Или на другую нужную страницу
exit;

?>