<?php
session_start();
define('DB_SERVER', '127.0.0.1:3307');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'work_dbs');


function dbConnect() {
    $connection = new mysqli(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
    if ($connection->connect_error) {
        die('Connection failed: ' . $connection->connect_error);
    }
    $connection->set_charset("utf8mb4");
    return $connection;
}
?>
