<?php
$page_title = '編輯檔案頁面';
$page_name = 'editDataPage';
require __DIR__ . '/parts/__connect_db.php';
require __DIR__ . '/parts/__admin_required.php';

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if (empty($id)) {
    header('Location: datalist2.php');
    exit;
}

$sql = " SELECT * FROM address_book WHERE id=$id";
$row = $pdo->query($sql)->fetch();
if (empty($row)) {
    header('Location: datalist2.php');
    exit;
}



?>
<style>
    small.errorMsg {
        color: red;
    }

    span.star {
        color: red;
    }
</style>


<?php include __DIR__ . '/parts/__head_page.php'; ?>
<?php include __DIR__ . '/parts/__navbar_page.php'; ?>
<div class="content container">
    <div class="alert alert-success" role="alert" style="display: none;" id="postMsg">
    </div>
    <div class="card col-lg-6">

        <div class="card-body">
            <h5 class="card-title">編輯資料頁面</h5>
            <form method="post" name="form1" onsubmit="checkForm(); return false;" novalidate>
                <input type="hidden" name="id" value="<?= $row['id'] ?>">
                <div class="form-group">
                    <label for="name"><span class="star">**</span>姓名</label>
                    <input type="text" class="form-control" id="name" placeholder="Enter name" name="name" required value="<?= htmlentities($row['name']) ?>">
                    <small class="errorMsg form-text"></small>
                </div>
                <div class="form-group">
                    <label for="mobile"><span class="star">**</span>行動電話</label>
                    <input type="tel" class="form-control" id="mobile" placeholder="Enter mobile" name="mobile" pattern="09\d{2}-?\d{3}-?\d{3}" required value="<?= htmlentities($row['mobile']) ?>">
                    <small class="errorMsg form-text"></small>
                </div>
                <div class="form-group">
                    <label for="email"><span class="star">**</span>電子信箱</label>
                    <input type="email" class="form-control" id="email" placeholder="Enter email" name="email" required value="<?= htmlentities($row['email']) ?>">
                    <small class="errorMsg form-text"></small>
                </div>
                <div class="form-group">
                    <label for="birthday">生日</label>
                    <input type="date" class="form-control" id="birthday" placeholder="Enter birthday" name="birthday" value="<?= htmlentities($row['birthday']) ?>">
                </div>
                <div class="form-group">
                    <label for="address">地址</label>
                    <textarea class="form-control" name="address" id="address" rows="3" placeholder="Enter address"><?= htmlentities($row['address']) ?></textarea>
                </div>
                <button type="submit" class="btn btn-primary" id="submitBtn">確認送出</button>
            </form>
        </div>
    </div>
</div>
<?php include __DIR__ . '/parts/__script_page.php'; ?>
<script>
    const userName = document.querySelector('#name');
    const userMobile = document.querySelector('#mobile');
    const userEmail = document.querySelector('#email');
    const emailPattern = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;
    const mobilePattern = /^09\d{2}-?\d{3}-?\d{3}$/;

    const validateInput = [userName, userMobile, userEmail];

    const postMsg = document.querySelector('#postMsg');
    const submitBtn = document.querySelector('button[type=submit]');

    const checkForm = () => {
        submitBtn.style.display = 'none';

        validateInput.forEach((item) => {
            item.style.borderColor = '#cccccc';
            item.nextElementSibling.innerHTML = '';
        });

        let isPass = true;
        if (userName.value.trim().length <= 1) {
            isPass = false;
            userName.nextElementSibling.innerHTML = '請輸入正確的姓名格式！';
            userName.style.borderColor = 'red';
        };

        if (!emailPattern.test(userEmail.value)) {
            isPass = false;
            userEmail.nextElementSibling.innerHTML = '請輸入正確的電子信箱格式！';
            userEmail.style.borderColor = 'red';
        };

        if (!mobilePattern.test(userMobile.value)) {
            isPass = false;
            userMobile.nextElementSibling.innerHTML = '請輸入正確的行動電話格式！';
            userMobile.style.borderColor = 'red';
        };

        const fd = new FormData(document.form1);
        if (isPass) {
            fetch('editDataList_api.php', {
                    method: 'POST',
                    body: fd,
                })
                .then(res => res.json())
                .then(str => {
                    console.log(str);
                    if (str.success) {
                        postMsg.innerHTML = '修改成功';
                        postMsg.className = 'alert alert-success';
                        setTimeout(() => {
                            location.href = '<?= $_SERVER['HTTP_REFERER'] ?? "data-list.php" ?>;
                        }, 3000);
                    } else {
                        postMsg.innerHTML = str.error || '修改失敗';
                        postMsg.className = 'alert alert-danger';
                        submitBtn.style.display = 'block';
                    }
                    postMsg.style.display = 'block';
                })
        } else {
            submitBtn.style.display = 'block';
        };
    }
</script>
<?php include __DIR__ . '/parts/__foot_page.php'; ?>