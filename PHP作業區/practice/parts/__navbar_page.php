<?php
if (!isset($page_name)) $page_name = '';
?>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
        <a class="navbar-brand" href="#">小杰的後台</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item <?= $page_name == 'home' ? 'active' : '' ?>">
                    <a class="nav-link" href="./compose_page.php">首頁<span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item <?= $page_name == 'dataListPage' ? 'active' : '' ?>">
                    <a class="nav-link" href="./datalist2.php">產品列表(由php生成)</a>
                </li>
                <li class="nav-item <?= $page_name == 'data-list3' ? 'active' : '' ?>">
                    <a class="nav-link" href="./datalist3.php">產品列表(由js生成)</a>
                </li>
                <li class="nav-item <?= $page_name == 'addDataPage' ? 'active' : '' ?>">
                    <a class="nav-link" href="./addDataList.php">新增資料</a>
                </li>
            </ul>
            <?php if (isset($_SESSION['admin'])) : ?>
                <ul class="navbar-nav">
                    <li class="nav-item ">
                        <a class="nav-link"><?= $_SESSION['admin']['nickname'] ?></a>
                    </li>
                    <li class="nav-item ">
                        <a class="nav-link" href="./logoutsql.php">登出</a>
                    </li>
                </ul>
            <?php else : ?>
                <ul class="navbar-nav">
                    <li class="nav-item <?= $page_name == 'loginSqlPage' ? 'active' : '' ?>">
                        <a class="nav-link" href="./loginsql.php">登入</a>
                    </li>
                </ul>
            <?php endif; ?>
        </div>
    </div>

</nav>

<style>
    .active {
        background-color: lightseagreen;
        border-radius: 5px;
    }
</style>