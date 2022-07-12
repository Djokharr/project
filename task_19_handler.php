<?php

session_start();

// 1. принимаем данные из формы в переменные

$img = $_FILES['image']['name'];
$img_tmp = $_FILES['image']['tmp_name'];

// 2. ищем в базе файл с таким же названием
$pdo = new PDO("mysql:host=localhost;dbname=marlin;", "root", "root");
$sql = "SELECT * FROM images WHERE image=:image";
$statement = $pdo->prepare($sql);
$statement->execute(['image' => $img]);

$case = $statement->fetch(PDO::FETCH_ASSOC);

// 3. если такой файл найден, то генерируем ему новое имя

if (!empty($case)) {
    $img = uniqid() . ".png";
}

// 4. отправляем уникальное имя файла в базу

$sql = "INSERT INTO images (image) VALUES (:image)";
$statement = $pdo->prepare($sql);
$statement->execute(['image' => $img]);

// 5. перемещаем файл из временного хранилища в папку на сервере

move_uploaded_file($img_tmp, "img/demo/gallery/" . $img);

// 6. формируем массив из названий всех фотографий и передаем его в сессию, чтобы вывести список на главной странице

$sql = "SELECT image FROM images";
$statement = $pdo->prepare($sql);
$statement->execute();
$_SESSION['array'] = $statement->fetchAll();

// 7. Функционал удаления картинок с базы и сервера

$qwe = $_GET['file'];

if (!empty($qwe)) {

$pdo = new PDO("mysql:host=localhost;dbname=marlin;", "root", "root");
$sql = "DELETE FROM images WHERE image=:image";
$statement = $pdo->prepare($sql);
$statement->execute(['image' => $qwe]);

unlink("img/demo/gallery/" . $qwe);
}


// 8. возвращаемся на гланую

header("location: /task_19.php");

?>