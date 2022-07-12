<?php

session_start();

$_SESSION['email'] = $_POST['email'];

header("location: /task_14.php");

?>