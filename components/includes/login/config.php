<?php
define('HOSTNAME', 'localhost');
define('DATANAME', 'test');
define('USER_SERV', 'root');
define('PASS_SERV', '');

$dsn = "mysql:host=" . HOSTNAME . ";dbname=" . DATANAME;
$options = array(
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
);

try {
    $conn = new PDO($dsn, USER_SERV, PASS_SERV, $options);
} catch (PDOException $e) {
    die("ERREUR : Impossible de se connecter. " . $e->getMessage());
}