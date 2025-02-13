<?php

function conectarDB(): mysqli
{
    $db = new mysqli(
        $_ENV['DB_HOST'] ?? getenv('DB_HOST'),
        $_ENV['DB_USER'] ?? getenv('DB_USER'),
        $_ENV['DB_PASS'] ?? getenv('DB_PASS'),
        $_ENV['DB_NAME'] ?? getenv('DB_NAME')
    );

    if ($db->connect_error) {
        die('Error de conexión: ' . $db->connect_error);
    }

    return $db;
}

// $db = mysqli_connect(
//     $_ENV['DB_HOST'],
//     $_ENV['DB_USER'],
//     $_ENV['DB_PASS'],
//     $_ENV['DB_NAME']
// );
// $db->set_charset("utf8");
