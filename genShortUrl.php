<?php
// Включение файла подключения к базе данных
require 'db_connect.php';

// Получение оригинального URL-адреса из запроса
$originalUrl = $_POST['originalUrl'];

// Функция для генерации уникального короткого кода
function generateShortCode() {
    $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    $shortCode = '';
    for ($i = 0; $i < 6; $i++) {
        $shortCode .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $shortCode;
}

// Генерация уникального короткого кода
$shortCode = generateShortCode();

// Внесение данных в базу данных
$query = $connect->prepare("INSERT INTO urls (original_url, token, validity) VALUES (?, ?, DATE_ADD(NOW(), INTERVAL 1 MINUTE))");
$query->execute([$originalUrl, $shortCode]);

// Вывод короткой ссылки
echo 'http://localhost/'.$shortCode;

$connect = null;
?>