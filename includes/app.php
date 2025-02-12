<?php



require __DIR__ . '/../vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->safeload();
require 'config/database.php';
require 'funciones.php';

$db = conectarDB();

use Model\ActiveRecord;

ActiveRecord::setDB($db);
