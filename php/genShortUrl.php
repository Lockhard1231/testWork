<?php
// Подключение к базе данных
require 'db_connect.php';

// Получение оригинального URL-адреса из POST-запроса
$originalUrl = $_POST['originalUrl'];

// Функция для генерации уникального короткого URL-адреса
function generateShortCode($connect) {
    $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    do {
        $token = '';
        for ($i = 0; $i < 6; $i++) {
            $token .= $characters[rand(0, strlen($characters) - 1)];
        }
        $checkUniqueQuery = $connect->prepare("SELECT original_url FROM urls WHERE token = :token");
        $checkUniqueQuery->execute([':token' => $token]);
        $row = $checkUniqueQuery->fetch(PDO::FETCH_ASSOC);
        
    } while ($row); 

    return $token;
}

// Присвоение переменной $shortcode, значения функции генерации короткого URL-адреса
$token = generateShortCode($connect);

//Подготовка и выполнение запроса на добавление в базу данных
$query = $connect->prepare("INSERT INTO urls (original_url, token, validity) VALUES (?, ?, DATE_ADD(NOW(), INTERVAL 1 MINUTE))");
$query->execute([$originalUrl, $token]);

// Вывод короткого URL-адреса
echo 'http://localhost/'.$token;

// Закрытие соединения с базой данных
$connect = null;
?>