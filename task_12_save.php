<?php

session_start();

$text = $_POST['text'];

$pdo = new PDO("mysql:host=localhost;dbname=marlin;", "root", "root");
$sql = "SELECT * FROM users WHERE name=:name";
$statement = $pdo->prepare($sql);
$statement->execute(['name' => $text]);

$case = $statement->fetch(PDO::FETCH_ASSOC);

if(!empty($case)){
    $message = "Эта запись уже имеется в базе";
    $_SESSION['message'] = $message;
    $_SESSION['frameColor'] = 'danger';
    header("location: /task_12.php");
    exit;
}

$pdo = new PDO("mysql:host=localhost;dbname=marlin;", "root", "root");
$sql = "INSERT INTO users (name) VALUES (:name)";
$statement = $pdo->prepare($sql);
$statement->execute(['name' => $text]);

$message = "Запись успешно записана";
$_SESSION['success'] = $message;

header("location: /task_12.php");

?>