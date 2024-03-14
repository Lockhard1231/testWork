<?php
require 'db_connect.php';

$token = $_GET['token'] ?? '';

$query = $connect->prepare("SELECT original_url, validity FROM urls WHERE token = :token AND validity > NOW()");
$query->execute([':token' => $token]);

$row = $query->fetch(PDO::FETCH_ASSOC);


if ($row) {
    header("Location: " . $row['original_url']);
    exit();
} else {
    //Если короткая ссылка не найдена или устарела, перенаправляем на форму ввода новой ссылки
    header("Location: " . '/testWork/testWork/index.html');
    exit();
}
?>
