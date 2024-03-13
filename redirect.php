<?php
require 'db_connect.php';

$shortUrl = $_GET['shortUrl'] ?? '';


// $query = $connect->prepare("SELECT original_url, validity FROM urls WHERE short_url = ? AND validity > NOW()");
// $query->execute([$shortUrl]);

$query = $connect->prepare("SELECT original_url, validity FROM urls WHERE short_url = :shortUrl AND validity > NOW()");
$query->execute([':shortUrl' => $shortUrl]);

$row = $query->fetch(PDO::FETCH_ASSOC);


if ($row) {
    // Instead of redirecting, send back a JSON response
    echo json_encode(['url' => $row['original_url']]);
    exit;
} else {
    //Если короткая ссылка не найдена или устарела, перенаправляем на форму ввода новой ссылки
    // Instead of redirecting, send back a JSON response
    echo json_encode(['url' => 'index.html']);
    exit;
}
?>