<?php

use Model\ActiveRecord;

require __DIR__ . '/../vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();
require 'funciones.php';
require 'database.php';

$db = conectarDB();

ActiveRecord::setDB($db);
