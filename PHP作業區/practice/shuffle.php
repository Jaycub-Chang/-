<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>shuffle</title>
</head>

<body>
    <pre>
        <?php
        $ar1 = [];
        for ($i = 1; $i <= 52; $i++) {
            $ar1[] = $i;
        };
        shuffle($ar1);
        print_r($ar1);

        ?>
    </pre>

</body>

</html>