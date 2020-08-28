<?php
$db_host = 'localhost';
$db_name = 'myproject';
$db_user = 'root';
$db_pass = 'iouccc19931107';

$dns = "mysql:host={$db_host};dbname={$db_name};";

$pdo_options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'",
];

$pdo = new PDO($dns, $db_user, $db_pass, $pdo_options);
