<?php

session_start();



$qwe = $_GET['file'];

$pdo = new PDO("mysql:host=localhost;dbname=marlin;", "root", "root");
$sql = "DELETE FROM images WHERE image=:image";
$statement = $pdo->prepare($sql);
$statement->execute(['image' => $qwe]);



unlink("img/demo/gallery/" . $qwe);



header("location: /task_19.php");

?>