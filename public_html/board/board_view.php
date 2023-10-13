<?php include_once $_SERVER['DOCUMENT_ROOT'] . "/include/default.php"; ?>

<?php include_once $_SERVER['DOCUMENT_ROOT'] . "/layout/header.php"; ?>

<?php include_once $_SERVER['DOCUMENT_ROOT'] . "/layout/nav_top.php"; ?>

<div class="container mt-5">

    <div class="row mb-3">
        <div class="col-sm-12">
            <h2><span class="font-bold" id="title"></span></h2>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-sm-6">
            <span class="m-r-sm font-bold" id="user_name"></span><i class="fa fa-clock"></i> <span id="create_date"></span>
        </div>
        <div class="col-sm-6 text-right" style="font-size: 15px;">
            <a id="return_list" class="m-r-sm" style="color:#676a6c"><i class="fa fa-list"></i></a>
            <a id="update" class="m-r-sm" style="color:#676a6c"><i class="fa fa-pencil"></i></a>
            <a id="delete" class="m-r-sm" style="color:#676a6c"><i class="fa fa-trash"></i></a>
        </div>
    </div>

    <hr>

    <div class="row mb-3">
        <div class="col-sm-12">
            <div class="" id="content" style="min-height: 200px;"></div>
        </div>
    </div>

    <!--<div class="row">-->
    <!--    <div class="col-sm-12 text-center">-->
    <!--        <button type="button" class="btn btn-primary btn-sm" id="return_list">목록으로</button>-->
    <!--    </div>-->
    <!--</div>-->

</div>

<form id="form" name="form">
    <input type="hidden" id="idx" name="idx">
    <input type="hidden" id="form_table_name" name="form_table_name">
</form>

<?php include_once $_SERVER['DOCUMENT_ROOT'] . "/board/board_view_js.php"; ?>
