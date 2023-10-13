<?php include_once $_SERVER['DOCUMENT_ROOT'] . "/include/default.php"; ?>

<?php include_once $_SERVER['DOCUMENT_ROOT'] . "/layout/header.php"; ?>

<?php include_once $_SERVER['DOCUMENT_ROOT'] . "/layout/nav_top.php"; ?>

<div class="container mt-5">

    <div class="row mb-3">
        <div class="col-sm-12">
            <label class="col-sm-2 form-label"><span class="text-danger">*</span> 제목</label>
            <input form="form" type="text" id="title" name="title" class="form-control form-control-sm" autocomplete="off">
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-sm-12">
            <label class="col-sm-2 form-label"><span class="text-danger"></span> 내용</label>
            <textarea form="form" id="content" name="content" class="form-control form-control-sm summernote"></textarea>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12 text-center">
            <button form="form" type="button" class="btn btn-default btn-sm" id="return_list">취소</button>
            <button form="form" type="submit" class="btn btn-primary btn-sm">글수정</button>
        </div>
    </div>

</div>

<form id="form" name="form">
    <input type="hidden" id="idx" name="idx">
    <input type="hidden" id="form_table_name" name="form_table_name">
</form>

<?php include_once $_SERVER['DOCUMENT_ROOT'] . "/board/board_update_js.php"; ?>
