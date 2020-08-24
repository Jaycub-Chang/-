<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>array</title>
</head>

<body>
    <div>
        <?php
        $ar1 = [
            'name' => 'Jay',
            'id' => 46,
            'Gender' => 'Boy',
            'birth' => [82, 11, 07],
        ];
        $ar2 = array(1, 2, 3, 4);


        $ar3 = $ar1;

        $ar1['class'] = 'MFEE09';
        //print_r($ar1);

        $ar4 = &$ar1;
        foreach ($ar4 as $k => $v) {
            if (is_array($v)) {
                printf("%s => %s <br>", $k, implode(',', $v));
            } else {
                printf("%s => %s <br>", $k, $v);
            };
        };


        ?>
    </div>

</body>

</html>