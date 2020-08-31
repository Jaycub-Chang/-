<?php
session_start();
$page_title = '登入列表';
$page_name = 'loginSqlPage';
require __DIR__ . '/parts/__connect_db.php';
?>

<?php include __DIR__ . '/parts/__head_page.php'; ?>
<?php include __DIR__ . '/parts/__navbar_page.php'; ?>

<div class="container">
    <div class="row">
        <div class="col-lg-6">
            <form method="post" onsubmit="checkForm(); return false;" name="form1">
                <div class="form-group">
                    <label for="Account">Account</label>
                    <input type="text" class="form-control" id="Account" placeholder="Enter Account" name="account">
                </div>
                <div class="form-group">
                    <label for="Password">Password</label>
                    <input type="password" class="form-control" id="Password" placeholder="Password" name="password">
                </div>
                <button type="submit" class="btn btn-primary" id="submitBtn">登入</button>
            </form>
        </div>
    </div>
</div>
<?php include __DIR__ . '/parts/__script_page.php'; ?>

<script>
    const checkForm = () => {
        const fd = new FormData(document.form1);
        fetch('loginsqlapi.php', {
                method: 'POST',
                body: fd,
            })
            .then(res => res.json())
            .then(obj => {
                console.log(obj);
                if (obj.success) {
                    alert('登入成功');
                    location.href = 'datalist2.php';
                } else {
                    alert('登入失敗');
                };
            })
    };
</script>

<?php include __DIR__ . '/parts/__foot_page.php'; ?>