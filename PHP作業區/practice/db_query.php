<?php
require __DIR__ . '/parts/__connect_db.php';
$statement = $pdo->query('SELECT * FROM `address_book` LIMIT 5');

echo json_encode($statement->fetchAll(), JSON_UNESCAPED_UNICODE);
