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
                    <a class="nav-link" href="./datalist2.php">產品列表</a>
                </li>
                <li class="nav-item <?= $page_name == 'addDataPage' ? 'active' : '' ?>">
                    <a class="nav-link" href="./addDataList.php">新增資料</a>
                </li>
            </ul>
        </div>
    </div>

</nav>

<style>
    .active {
        background-color: lightseagreen;
        border-radius: 5px;
    }
</style>