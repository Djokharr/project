<?php

session_start();

$img = $_FILES['image']['name'];
$img_tmp = $_FILES['image']['tmp_name'];

$pdo = new PDO("mysql:host=localhost;dbname=marlin;", "root", "root");
$sql = "SELECT * FROM images WHERE image=:image";
$statement = $pdo->prepare($sql);
$statement->execute(['image' => $img]);

$case = $statement->fetch(PDO::FETCH_ASSOC);

if (!empty($case)) {
    $img = uniqid() . ".png";
}
    $sql = "INSERT INTO images (image) VALUES (:image)";
    $statement = $pdo->prepare($sql);
    $statement->execute(['image' => $img]);

move_uploaded_file($img_tmp, "img/demo/gallery/" . $img);

$sql = "SELECT image FROM images";
$statement = $pdo->prepare($sql);
$statement->execute();
$_SESSION['array'] = $statement->fetchAll();

header("location: /task_18.php");

?>

