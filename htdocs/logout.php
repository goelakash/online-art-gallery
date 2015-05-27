<?php
session_start();
session_unset();
session_destroy();
header('Location: localhost:81/about.php'); 
//sleep(5);
header('Location: localhost:81/index.php'); 
?>
