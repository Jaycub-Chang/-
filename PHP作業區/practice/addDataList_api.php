<?php
require __DIR__ . './parts/__connect_db.php';
header('Content-Type: application/json');

$output = [
    'success' => false,
    'postData' => $_POST,
    'error' => '',
    'code' => '',
];

if (mb_strlen($_POST['name']) <= 1) {
    $output['code'] = '401';
    $output['error'] = '名稱字數需大於1!';
    echo json_encode($output, JSON_UNESCAPED_UNICODE);
    exit;
};

if (!preg_match('/^09\d{2}-?\d{3}-?\d{3}$/', $_POST['mobile'])) {
    $output['code'] = '402';
    $output['error'] = '請輸入正確手機號碼格式!';
    echo json_encode($output, JSON_UNESCAPED_UNICODE);
    exit;
};


if (!preg_match('/^09\d{2}-?\d{3}-?\d{3}$/', $_POST['mobile'])) {
    $output['code'] = '402';
    $output['error'] = '請輸入正確手機號碼格式!';
    echo json_encode($output, JSON_UNESCAPED_UNICODE);
    exit;
};


$sql = "INSERT INTO `address_book`(`name`, `mobile`, `email`, `birthday`, `address`, `created_date`) VALUES (?, ?, ?, ?, ?, NOW())";

$stmt = $pdo->prepare($sql);
$stmt->execute([
    $_POST['name'],
    $_POST['mobile'],
    $_POST['email'],
    $_POST['birthday'],
    $_POST['address'],
]);

if ($stmt->rowCount()) {
    $output['success'] = true;
};

// $name = ['惡', '魔', '貓', '男', '卑', '鄙', '原', '之', '助', '海', '龍', '王', '彼', '得'];
// for ($i = 0; $i < 10; $i++) {
//     shuffle($name);
//     $sql = sprintf("INSERT INTO `address_book`(`name`, `mobile`, `email`, `birthday`, `address`, `created_date`) VALUES ('%s', '0918123456', 'shin@test.com', '2000-01-01', '台北市', NOW())", implode('', array_slice($name, 0, 3)));
//     $stmt = $pdo->query($sql);
// };
echo json_encode($output, JSON_UNESCAPED_UNICODE);
