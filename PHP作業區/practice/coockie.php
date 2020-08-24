<?php
setcookie('value', 666);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <div>
        <?php
        echo $_COOKIE['value'];

        ?>
    </div>


</body>

</html>