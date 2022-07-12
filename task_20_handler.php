<?php

session_start();

// 1. Функционал удаления картинок с базы и сервера.
// Потавил на первое место, так как мне пришлось каждый раз удалять записи из сессии, так как название в массиве сохраняется после удаления и браузер пытается что-то выдать на главной странице, хотя ни на сервере, ни в базе этой картинки уже нет. Сиссия будет перезаписана на последнем шаге и вернет уже массив без удаленной картинки.

$qwe = $_GET['file'];

if (!empty($qwe)) {

$pdo = new PDO("mysql:host=localhost;dbname=marlin;", "root", "root");
$sql = "DELETE FROM images WHERE image=:image";
$statement = $pdo->prepare($sql);
$statement->execute(['image' => $qwe]);

unlink("img/demo/gallery/" . $qwe);
unset($_SESSION['array']);
}

// 2. Создаем функцию для загрузки картинов на сервер и в базу

function upload_file($name, $tmp_name) {
$result = pathinfo($name);
$uniq_name = uniqid() . "." . $result['extension'];
move_uploaded_file($tmp_name, "img/demo/gallery/" . $uniq_name);

$pdo = new PDO("mysql:host=localhost;dbname=marlin;", "root", "root");
$sql = "INSERT INTO images (image) VALUES (:image)";
$statement = $pdo->prepare($sql);
$statement->execute(['image' => $uniq_name]);


};

// Возможно, тут я туплю с дополнительным условием. Проблема в том, что, если я просто хочу удалить и в $_FILES['image'] ничего не передается, он не дает мне обратно вернуться на главную, выдавая предупреждения о том, какой тип данных должен быть передан в функцию.

if ($_FILES['image'] != null) {

for ($i=0; $i < count($_FILES['image']['name']) ; $i++) { 
	upload_file($_FILES['image']['name'][$i], $_FILES['image']['tmp_name'][$i]);
}

}

// 3. формируем массив из названий всех фотографий и передаем его в сессию, чтобы вывести список на главной странице

$pdo = new PDO("mysql:host=localhost;dbname=marlin;", "root", "root");
$sql = "SELECT image FROM images";
$statement = $pdo->prepare($sql);
$statement->execute();
$_SESSION['array'] = $statement->fetchAll();

// 4. возвращаемся на гланую

header("location: /task_20.php");

?>