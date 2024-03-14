<?php
// Подключение к базе данных
require 'db_connect.php';

// Получение оригинального URL-адреса из POST-запроса
$originalUrl = $_POST['originalUrl'];

// Функция для генерации уникального короткого URL-адреса
function generateShortCode() {
    $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    $shortCode = '';
    for ($i = 0; $i < 6; $i++) {
        $shortCode .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $shortCode;
}

// Присвоение переменной $shortcode, значения функции генерации короткого URL-адреса
$shortCode = generateShortCode();

//Подготовка и выполнение запроса на добавление в базу данных
$query = $connect->prepare("INSERT INTO urls (original_url, token, validity) VALUES (?, ?, DATE_ADD(NOW(), INTERVAL 1 MINUTE))");
$query->execute([$originalUrl, $shortCode]);

// Вывод короткого URL-адреса
echo 'http://localhost/'.$shortCode;

// Закрытие соединения с базой данных
$connect = null;
?>