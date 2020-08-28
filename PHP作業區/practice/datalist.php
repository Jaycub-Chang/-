<?php
$page_title = '首頁';
require __DIR__ . '/parts/__connect_db.php';
$statement = $pdo->query('SELECT * FROM `address_book`');
$data = $statement->fetchAll();
?>

<?php include __DIR__ . '/parts/__head_page.php'; ?>
<?php include __DIR__ . '/parts/__navbar_page.php'; ?>
<div class="content">
    <table class="table table-striped">

        <thead>
            <tr>
                <th scope="col"></th>
                <th scope="col">#</th>
                <th scope="col">姓名</th>
                <th scope="col">手機</th>
                <th scope="col">電子郵件</th>
                <th scope="col">生日</th>
                <th scope="col">地址</th>
                <th scope="col">創建日期</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($data as $row) : ?>
                <tr data-index="<?= $row['id'] ?>" class="dataTr">
                    <td><a href="#" data-index="<?= $row['id'] ?>"><i class="fas fa-trash-alt trashcan"></a></td>
                    <td><?= $row['id'] ?></td>
                    <td><?= $row['name'] ?></td>
                    <td><?= $row['mobile'] ?></td>
                    <td><?= $row['email'] ?></td>
                    <td><?= $row['birthday'] ?></td>
                    <td><?= $row['address'] ?></td>
                    <td><?= $row['created_date'] ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>

    </table>
</div>
<?php include __DIR__ . '/parts/__script_page.php'; ?>
<script>
    const table = document.querySelector('table');

    table.addEventListener('click', (event) => {
        const t = event.target;
        console.log(t.classList.contains('trashcan'));

        if (t.classList.contains('trashcan')) {
            t.closest('tr').remove();
        }
    });
</script>
<?php include __DIR__ . '/parts/__foot_page.php'; ?>