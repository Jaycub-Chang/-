<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>color</title>
    <style>
        td {
            width: 50px;
            height: 50px;
        }
    </style>
</head>

<body>

    <table>
        <?php for ($i = 0; $i <= 255; $i += 17) : ?>
            <tr>
                <?php for ($j = 0; $j <= 255; $j += 17) : ?>
                    <td style="background-color: #<?= sprintf("00%'.02X%'.02X", $i, $j) ?>;">
                    </td>
                <?php endfor ?>
            </tr>
        <?php endfor ?>
    </table>

    <script>
        const tableColor = document.querySelector('table');
        tableColor.addEventListener('click', (event) => console.log(event.target.style.backgroundColor));
    </script>
</body>

</html>