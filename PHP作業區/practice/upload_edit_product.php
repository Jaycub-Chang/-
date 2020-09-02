<?php
$page_title = '修改產品資料';
$page_name = 'editproduct';
require __DIR__ . './parts/__connect_db.php';

if (!empty($_POST['sid'])) {
    $sql = "UPDATE `products` SET `bookname`=?, 
                                    `category_sid`=?, 
                                    `price`=? ,
                                    `introduction`=?
                                    WHERE `sid`=?";
    $stmt = $pdo->prepare($sql);

    $stmt->execute([
        $_POST['bookname'],
        $_POST['category_sid'],
        $_POST['price'],
        json_encode($_POST['hobbies'] ?? []),
        $_POST['sid'],
    ]);

    if ($stmt->rowCount()) {
        $modified = true;
    };
};

$row = $pdo->query("SELECT * FROM products WHERE sid=2")->fetch();
$c_sql = "SELECT * FROM categories WHERE parent_sid=0 ORDER BY sid DESC";
$cates = $pdo->query($c_sql)->fetchAll();
$h_sql = "SELECT * FROM `hobbies` WHERE `visible`=1 ORDER BY `sequence`";
$hobbies = $pdo->query($h_sql)->fetchAll();
$h_sids = json_decode($row['introduction'], true);
if ($h_sids === null) {
    $h_sids = [];
};

?>

<?php include __DIR__ . '/parts/__head_page.php'; ?>
<?php include __DIR__ . '/parts/__navbar_page.php'; ?>


<div class="container">
    <?php if (isset($modified)) : ?>
        <div class="alert alert-success" role="alert">
            修改成功
        </div>
    <?php endif ?>
    <form action="" method="post">
        <input type="hidden" name="sid" value="2">
        <div class="form-group">
            <label for="bookname">bookname</label>
            <input type="text" class="form-control" id="bookname" value="<?= $row['bookname'] ?>" name="bookname">
        </div>

        <!-- 後端作法 -->
        <!-- <div class="form-group">
            <label for="category_sid2">分類</label>
            <select class="form-control" id="category_sid2" name="category_sid2">
                <?php foreach ($cates as $c) : ?>
                    <option value="<?= $c['sid'] ?>" <?= $row['category_sid'] == $c['sid'] ? 'checked' : '' ?>><?= $c['name'] ?></option>
                <?php endforeach; ?>
            </select>
        </div> -->

        <!-- 前端作法 -->
        <div class="form-group">
            <label for="category_sid">category</label>
            <select class="form-control" id="category_sid" name="category_sid" data-val="<?= $row['category_sid'] ?>">
                <?php foreach ($cates as $c) : ?>
                    <option value="<?= $c['sid'] ?>"><?= $c['name'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <!-- <div class="form-group">
            <label for="category_sid">分類 (radio button group)</label><br>
            <?php foreach ($cates as $c) : ?>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" <?php echo $row['category_sid'] == $c['sid'] ? 'checked' : ''
                                                                    ?> name="category_sid3" id="cate<?= $c['sid'] ?>" value="<?= $c['sid'] ?>">
                    <label class="form-check-label" for="cate<?= $c['sid'] ?>"><?= $c['name'] ?></label>
                </div>
            <?php endforeach; ?>
        </div> -->

        <div class="form-group">
            <label for="">Hobbies</label><br>
            <?php foreach ($hobbies as $h) : ?>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" name="hobbies[]" id="hobbies<?= $h['sid'] ?>" value="<?= $h['sid'] ?>" <?= in_array($h['sid'], $h_sids) ? 'checked' : '' ?>>
                    <label class="form-check-label" for="hobbies<?= $h['sid'] ?>"><?= $h['hobbyName'] ?></label>
                </div>
            <?php endforeach; ?>
        </div>


        <div class="form-group">
            <label for="price">price</label>
            <input type="text" class="form-control" id="price" value="<?= $row['price'] ?>" name="price">
        </div>


        <div class="d-flex justify-content-end">
            <input type="submit" value="確定修改" class="btn btn-success">
        </div>
    </form>

    <input type="file" style="display: none;" id="uploadInput">

</div>


<?php include __DIR__ . '/parts/__script_page.php'; ?>

<script>
    const category_sid = document.querySelector('#category_sid');
    let val = category_sid.getAttribute('data-val');
    category_sid.value = val;
</script>


<?php include __DIR__ . '/parts/__foot_page.php'; ?>