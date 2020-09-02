<?php
require __DIR__ . './parts/__connect_db.php';

$sql = "SELECT * FROM `categories`";

$rows = $pdo->query($sql)->fetchAll();

$cates = [];

foreach ($rows as $k => $v) {
    if ($v['parent_sid'] == '0') {
        $cates[] = $v;
    };
};

//$cates[] 進行push的意思

foreach ($cates as $k => $v) {
    foreach ($rows as $k2 => $v2) {
        if ($v['sid'] == $v2['parent_sid']) {
            $cates[$k]['children'][] = $v2;
        }
    }
}

$page_title = '首頁';
$page_name = 'home';
?>

<?php include __DIR__ . '/parts/__head_page.php'; ?>
<div class="container">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">Navbar</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <?php foreach ($cates as $k => $v) : ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="?cate=<?= $v['sid'] ?>" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <?= $v['name'] ?>
                        </a>

                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <?php foreach ($v['children'] as $k2 => $v2) : ?>
                                <a class="dropdown-item" href="?cate=<?= $v2['sid'] ?>"><?= $v2['name'] ?></a>
                            <?php endforeach; ?>
                        </div>

                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </nav>

</div>

<div class="content container">
    <h1>你好~</h1>
</div>
<?php include __DIR__ . '/parts/__script_page.php'; ?>
<?php include __DIR__ . '/parts/__foot_page.php'; ?>