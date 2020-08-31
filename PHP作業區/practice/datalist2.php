<?php
$page_title = '產品列表';
$page_name = 'dataListPage';
require __DIR__ . '/parts/__connect_db.php';

$perPage = 5;

$page = isset($_GET['page']) ? $_GET['page'] : 1;

$t_sql = "SELECT COUNT(1) FROM `address_book`";
$totalRows =  $pdo->query($t_sql)->fetch(PDO::FETCH_NUM)[0];
//die('~~~'); //exit; // 結束程式
$totalPage = ceil($totalRows / $perPage);

$data = [];
if ($totalRows > 0) {
    if ($page < 1) $page = 1;
    if ($page > $totalPage) $page = $totalPage;


    $sql = sprintf("SELECT * FROM `address_book` LIMIT %s, %s", ($page - 1) * $perPage, $perPage);
    $statement = $pdo->query($sql);
    $data = $statement->fetchAll();
};

?>

<style>
    img {
        width: 50%;
        margin: 0 auto;
        margin-top: 20px;
    }

    .modal-body {
        text-align: center;
    }
</style>

<?php include __DIR__ . '/parts/__head_page.php'; ?>
<?php include __DIR__ . '/parts/__navbar_page.php'; ?>
<div class="content">
    <table class="table table-striped">

        <thead>
            <tr>
                <?php if (isset($_SESSION['admin'])) : ?>
                    <th scope="col"></th>
                <?php endif; ?>
                <th scope="col">#</th>
                <th scope="col">姓名</th>
                <th scope="col">手機</th>
                <th scope="col">電子郵件</th>
                <th scope="col">生日</th>
                <th scope="col">地址</th>
                <th scope="col">創建日期</th>
                <?php if (isset($_SESSION['admin'])) : ?>
                    <th scope="col">編輯</th>
                <?php endif; ?>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($data as $row) : ?>
                <tr class="dataTr">
                    <?php if (isset($_SESSION['admin'])) : ?>
                        <td><a href="dataDelete.php?id=<?= $row['id'] ?>" data-toggle="modal" data-target="#exampleModal"><i class="fas fa-trash-alt trashcan" data-id="<?= $row['id'] ?>"></a></td>
                    <?php endif; ?>
                    <td><?= $row['id'] ?></td>
                    <td><?= $row['name'] ?></td>
                    <td><?= $row['mobile'] ?></td>
                    <td><?= $row['email'] ?></td>
                    <td><?= $row['birthday'] ?></td>
                    <td><?= $row['address'] ?></td>
                    <td><?= $row['created_date'] ?></td>
                    <?php if (isset($_SESSION['admin'])) : ?>
                        <td><a href="data-edit.php?id=<?= $row['id'] ?>"><i class="fas fa-edit"></i></a></td>
                    <?php endif; ?>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="container">
        <nav aria-label="Page navigation example">
            <ul class="pagination d-flex justify-content-center">
                <li class="page-item <?= $page == 1 ? 'disabled' : '' ?>"><a class="page-link" href="?page=<?= $page - 1 ?>">Previous</a></li>

                <?php for ($i = $page - 3; $i <= $page + 3; $i++) :
                    if ($i < 1) continue;
                    if ($i > $totalPage) break;
                ?>
                    <li class="page-item <?= $i == $page ? 'active' : '' ?>"><a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a></li>
                <?php endfor; ?>

                <li class="page-item <?= $page == $totalPage ? 'disabled' : '' ?>"><a class="page-link" href="?page=<?= $page + 1 ?>">Next</a></li>
            </ul>
        </nav>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">警告</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <img src="乾阿捏.jpg" alt="乾阿捏.jpg">
            <div class="modal-body">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">取消</button>
                <button type="button" class="btn btn-danger confirmDelete">確定</button>
            </div>
        </div>
    </div>
</div>


<script>
    const deleteBtn = document.querySelectorAll('.trashcan');
    const confirmDelete = document.querySelector('.confirmDelete');
    const modalBody = document.querySelector('.modal-body');
    console.log(confirmDelete);
    deleteBtn.forEach((btn) => {
        btn.addEventListener('click', (event) => {
            const id = event.target.dataset.id;
            console.log(event);
            modalBody.innerHTML = `確定要刪除編號${id}的項目?`;
            confirmDelete.setAttribute('data-id', `${id}`);
            event.preventDefault();
        });
    });
    confirmDelete.addEventListener('click', (event) => {
        const id = event.target.dataset.id;
        location.href = `dataDelete.php?id=${id}`;
    });


    const deleteData = () => {};
</script>

<?php include __DIR__ . '/parts/__script_page.php'; ?>
<?php include __DIR__ . '/parts/__foot_page.php'; ?>