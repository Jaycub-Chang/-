<div>
    <?php
    $now = date("Y-m-d H:i:s");
    $after30days = date("Y-m-d H:i:s", time() + 30 * 24 * 60 * 60);
    $day1 = date("Y-m-d D", strtotime('2020-08-23'));
    echo "now: $now<br>";
    echo "after30days: $after30days<br>";
    echo "day1: $day1<br>";
    ?>
</div>