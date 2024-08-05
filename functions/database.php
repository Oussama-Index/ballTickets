<?php

use Dotenv\Dotenv;
require_once '../vendor/autoload.php';
$dotenv = Dotenv::createImmutable('../');
$dotenv->load();

$pdo = new PDO("mysql:host=". $_SERVER['DB_HOST'] .";
dbname=". $_SERVER['DB_DATABASE'] ."", 
$_SERVER['DB_USERNAME'], 
$_SERVER['DB_PASSWORD']);


?>