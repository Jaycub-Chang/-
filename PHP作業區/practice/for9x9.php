<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>for</title>
</head>

<body>

    <table border="1">
        <?php for ($i = 1; $i < 10; $i++) : ?>
            <tr>
                <?php for ($j = 1; $j < 10; $j++) : ?>
                    <td>
                        <?= sprintf("%s*%s=%s", $i, $j, $i * $j) ?>
                    </td>
                <?php endfor ?>
            </tr>
        <?php endfor ?>
    </table>


</body>

</html>