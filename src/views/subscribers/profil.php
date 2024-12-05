<?php 

session_start();

if (!isset($_SESSION['id'])) {
    echo "yes";
    header("Location: ../subscribers/login.php");
}

?>