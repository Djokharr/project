<?php

$name = $_POST['name'];
$email = $_POST['email'];
$pass = $_POST['pass'];

if (empty($name) || empty($email) || empty($pass)) {
	echo "Одно из полей не заполнено" . "<br>";
	echo "
		<a href='create.html'> попробовать еще раз</a>";
	exit;
};

$pic_name = $_FILES['image']['name'];
$tmp_name = $_FILES['image']['tmp_name'];


if (empty($pic_name)) {
	echo "нет фото";
	echo "
		<a href='create.html'> попробовать еще раз</a>";
	exit;
}

if(isset($pic_name)) {
	$pic_name = uniqid($pic_name) . ".png";
}

//$db = mysqli_connect('localhost', 'root', '', 'qwerty');
//mysqli_query($db, "INSERT INTO users VALUES (NULL, '$name', '$email', '$pass', '$pick_name')"); 

$pdo = new PDO('mysql:host=localhost;dbname=qwerty;charset=utf8;', 'root' , '');
$sql = "INSERT INTO users VALUES (NULL, '$name', '$email', '$pass', '$pic_name')";
$pdo->query($sql);

move_uploaded_file($tmp_name, "uploads/" . $pic_name);

header("location: index.php");

?>