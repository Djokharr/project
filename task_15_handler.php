<?php

session_start();
$_SESSION['count']++;
header("location: /task_15.php");

?>