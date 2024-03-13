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

// Обрезает URL-адрес до основной части "http://domain/".
$pattern = "/^(https?:\/\/[^\/]+?)\/.*/";
$replacement = "$1/";
$shortenURL = preg_replace($pattern, $replacement, $originalUrl);

// Генерация уникального короткого кода
$shortCode = $shortenURL.generateShortCode();

// Внесение данных в базу данных
$query = $connect->prepare("INSERT INTO urls (original_url, short_url, validity) VALUES (?, ?, DATE_ADD(NOW(), INTERVAL 10 MINUTE))");
$query->execute([$originalUrl, $shortCode]);



// Вывод короткой ссылки
echo $shortCode;

$connect = null;
?>