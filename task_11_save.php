<?php

$text = $_POST['text'];

$pdo = new PDO("mysql:host=localhost;dbname=marlin;", "root", "root");
$sql = "INSERT INTO users (name) VALUES (:name)";
$statement = $pdo->prepare($sql);
$statement->execute(['name' => $text]);
?>