<?php
$page_title = '修改會員資料';
$page_name = 'editmember';
require __DIR__ . './parts/__connect_db.php';

if (!empty($_POST['id'])) {
    $sql = "UPDATE `members` SET `mobile`=?, `hash`=?, `nickname`=? WHERE `id`=?";
    $stmt = $pdo->prepare($sql);

    $stmt->execute([
        $_POST['mobile'],
        $_POST['avatar'],
        $_POST['nickname'],
        $_POST['id'],
    ]);

    if ($stmt->rowCount()) {
        $modified = true;
    };
};

$row = $pdo->query("SELECT * FROM members WHERE id=3")->fetch();

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
        <input type="hidden" name="id" value="3">
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" id="email" value="<?= $row['email'] ?>" disabled>
        </div>
        <div class="form-group">
            <label for="nickname">nickname</label>
            <input type="text" class="form-control" id="nickname" value="<?= $row['nickname'] ?>" name="nickname">
        </div>
        <div class="form-group">
            <label for="mobile">mobile</label>
            <input type="text" class="form-control" id="mobile" value="<?= $row['mobile'] ?>" name="mobile">
        </div>


        <button type="button" class="btn btn-primary" id="uploadBtn">更換頭貼</button>
        <input type="hidden" id="avatar" name="avatar">
        <img src="./../uploads/<?= $row['hash'] ?>" alt="" id="myImg" width="250px">
        <div class="d-flex justify-content-end">
            <input type="submit" value="確定修改" class="btn btn-success">
        </div>
    </form>

    <input type="file" style="display: none;" id="uploadInput">

</div>


<?php include __DIR__ . '/parts/__script_page.php'; ?>
<script>
    const uploadInput = document.querySelector('#uploadInput');
    const uploadBtn = document.querySelector('#uploadBtn');
    const avatar = document.querySelector('#avatar');

    uploadBtn.addEventListener('click', () => {
        uploadInput.click();
    });

    uploadInput.addEventListener('change', function() {
        // const fd = new FormData();
        console.log(uploadInput.files);

        const formData = new FormData();
        formData.append('myfile', uploadInput.files[0]);

        fetch('upload-files-simple-api.php', {
                method: 'POST',
                body: formData,
            })
            .then(r => r.json())
            .then(obj => {
                avatar.value = obj.filename;
                document.querySelector('#myImg').src = './../uploads/' + obj.filename;
            });

    });
</script>

<?php include __DIR__ . '/parts/__foot_page.php'; ?>