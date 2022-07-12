<?php

session_start();
unset($_SESSION['user']);
header("location: /task_16.php");

?>