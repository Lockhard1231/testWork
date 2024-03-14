<?php
// Подключение к базе данных
require 'db_connect.php';


// Получаем токен из GET-запроса или устанавливаем пустую строку по умолчанию
$token = $_GET['token'] ?? '';

//Подготовка и выполнение запроса на получение оригинального URL-адреса из базы данных
$query = $connect->prepare("SELECT original_url, validity FROM urls WHERE token = :token AND validity > NOW()");
$query->execute([':token' => $token]);

//Получение результата запроса из базы данных
$row = $query->fetch(PDO::FETCH_ASSOC);

//Перенаправление на оригинальный URL-адрес или на форму ввода новой ссылки в случае отсутствия короткого URL-адреса
if ($row) {
    header("Location: " . $row['original_url']);
    exit();
} else {
    
    header("Location: " . '/testWork/index.html');
    exit();
}
?>
