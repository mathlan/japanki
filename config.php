<?php
define('HOSTNAME', 'localhost');
define('DATANAME', 'anki');
define('USER_SERV', 'root');
define('PASS_SERV', '');

$conn = "mysql:host=" . HOSTNAME . ";dbname=" . DATANAME;
$options = array(
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
);

try {
    $conn = new PDO($conn, USER_SERV, PASS_SERV, $options);
} catch (PDOException $e) {
    die("ERREUR : Impossible de se connecter. " . $e->getMessage());
}