<?php

session_start();

if (!isset($_SESSION["role"]) || $_SESSION["role"] !== 1) {
    header("Location: /ParisEcran/src/views/film/index-film.php");
    exit();
}

require_once __DIR__ . "/../../../vendor/autoload.php";

?>