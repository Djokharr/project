<?php

session_start();

$email = $_POST['email'];
$password = $_POST['password'];

$pdo = new PDO("mysql:host=localhost;dbname=marlin;", "root", "root");
$sql = "SELECT * FROM email_base WHERE email=:email";
$statement = $pdo->prepare($sql);
$statement->execute(['email' => $email]);

$case = $statement->fetch(PDO::FETCH_ASSOC);

if(!empty($case)){
    $message = "Такая почта уже существует";
    $_SESSION['danger'] = $message;
    header("location: /task_13.php");
    exit;
}

$pdo = new PDO("mysql:host=localhost;dbname=marlin;", "root", "root");
$sql = "INSERT INTO email_base (email, password) VALUES (:email, :password)";
$statement = $pdo->prepare($sql);
$statement->execute(['email' => $email,'password' => $password]);

$message = "Пользователь успешно добавлен";
$_SESSION['success'] = $message;

header("location: /task_13.php");

?>