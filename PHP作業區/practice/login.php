<?php
session_start();

$Accounts = [
    'jl55661688' => [
        'pw' => '123456789',
        'nickname' => 'Jay',
    ],
    'shardbearer' => [
        'pw' => 'stu19931107',
        'nickname' => '小杰',
    ],
];

if (isset($_POST['Account'])) {
    if (!empty($Accounts[$_POST['Account']])) {
        $name = $Accounts[$_POST['Account']];
        if ($_POST['Password'] == $name['pw']) {
            $_SESSION['member'] = [
                'username' => $_POST['Account'],
                'usernickname' => $name['nickname'],
            ];
        } else {
            echo '3';
        };
    } else {
        echo '2';
    };
} else {
    echo '1';
};

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>login</title>
    <link rel="stylesheet" href="./bootstrap/css/bootstrap.css">
    <style>
        nav {
            margin-bottom: 20px;
        }

        .memberInfo {
            text-align: center;
        }
    </style>
</head>

<body>
    <?php if (isset($_SESSION['member'])) : ?>
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="alert alert-info memberInfo" role="alert">

                        <h1>
                            <?=
                                $_SESSION['member']['usernickname'] ?> 您好
                        </h1>
                        <br>
                        <img src="./下載.jpg" alt="">
                        <h1>罐罐呢?還不拿出來!!!</h1>
                        <a href="./logout.php">登出</a>

                    </div>
                </div>
            </div>
        </div>
    <?php else : ?>
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <form method="post">
                        <div class="form-group">
                            <label for="Account">Account</label>
                            <input type="text" class="form-control" id="Account" placeholder="Enter Account" name="Account">
                        </div>
                        <div class="form-group">
                            <label for="Password">Password</label>
                            <input type="password" class="form-control" id="Password" placeholder="Password" name="Password">
                        </div>
                        <button type="submit" class="btn btn-primary" id="submitBtn">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    <?php endif; ?>
    <script src="./jquery-3.5.1.min.js"></script>
    <script src="./bootstrap/js/bootstrap.js"></script>
</body>

</html>