<?php

session_start();

$email = $_POST['email'];
$password = $_POST['password'];

$pdo = new PDO("mysql:host=localhost;dbname=marlin;", "root", "root");
$sql = "SELECT * FROM users_task WHERE email=:email";
$statement = $pdo->prepare($sql);
$statement->execute(['email' => $email]);

$user = $statement->fetch(PDO::FETCH_ASSOC);


if (empty($user)){
    $message = "Неправильная почта или пароль";
    $_SESSION['danger'] = $message;
    header("location: /task_16.php");
    exit;
}

if (!password_verify($password, $user['password'])){
    $_SESSION['danger'] = "Неправильная почта или пароль";
    header("location: /task_16.php");
    exit;
}

$_SESSION['user'] = ["email" => $user['email'], "id" => $user['id']];

header("location: /task_17.php");

?>