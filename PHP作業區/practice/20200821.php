<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <?php
    define('MY_CONST', 123456);
    echo MY_CONST;
    echo '<br>';
    print MY_CONST;
    echo '<br>';
    $apple = array();
    echo empty($apple) ? 'empty' : 'not empty';
    echo '<br>';
    if ($apple) print MY_CONST;
    $a = '浪漫duke';
    echo '$a<br>';
    echo "$a<br>";
    echo $z ?? 'Zedd<br>';
    $z = 'Marry';
    echo "{$z}<br>" ?? 'Zedd<br>';
    echo "{$a}幫你找回屬於你的浪漫！<br>";

    $x = 13;
    $y = 27;

    echo var_dump($x && $y) . '<br>';
    echo var_dump($x and $y) . '<br>';
    $c = $x && $y;
    echo var_dump($c) . '<br>';
    $c = $x and $y;
    echo var_dump($c) . '<br>';



    ?>
</body>

</html>