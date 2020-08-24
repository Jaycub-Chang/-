<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>if else</title>
</head>

<body>
    <?php
    if (!empty($_GET['age']) and $_GET['age'] >= 18) : ?>
        <img src="./下載 (1).jpg" alt="">
    <?php else : ?>
        <img src="./下載.jpg" alt="">
    <?php endif; ?>

</body>

</html>