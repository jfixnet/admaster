<?php include_once $_SERVER['DOCUMENT_ROOT'] . "/include/default.php"; ?>

<?php include_once $_SERVER['DOCUMENT_ROOT'] . "/layout/header.php"; ?>

<?php include_once $_SERVER['DOCUMENT_ROOT'] . "/layout/ad_nav_top.php"; ?>

<div class="container mt-5">

    <div class="row mb-3">
        <div class="col-sm-6">
            <label class="col-sm-2 form-label"><span class="text-danger"></span> 테이블</label>
            <input form="form" type="text" id="table_name" name="table_name" class="form-control form-control-sm required" autocomplete="off" required>
        </div>

        <div class="col-sm-6">
            <label class="col-sm-2 form-label"><span class="text-danger"></span> 게시판 제목</label>
            <input form="form" type="text" id="table_title" name="table_title" class="form-control form-control-sm required" autocomplete="off" required>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-sm-3">
            <label class="col-sm-3 form-label"><span class="text-danger"></span> 비밀글 사용</label>
            <select form="form" class='form-select' name="secret_mode" id="secret_mode">
                <option value='N'>사용하지않음</option>
                <option value='Y'>체크박스</option>
                <option value='A'>무조건</option>
            </select>
        </div>
        <div class="col-sm-3">
            <label class="col-sm-3 form-label"><span class="text-danger"></span> 코멘트 사용</label>
            <select form="form" class='form-select' name="comment_mode" id="comment_mode">
                <option value='N'>N</option>
                <option value='Y'>Y</option>
            </select>
        </div>
        <div class="col-sm-3">
            <label class="col-sm-3 form-label"><span class="text-danger"></span> 관리자 전용</label>
            <select form="form" class='form-select' name="admin_only" id="admin_only">
                <option value='N'>N</option>
                <option value='Y'>Y</option>
            </select>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-sm-12">
            <label class="col-sm-2 form-label"><span class="text-danger"></span> 설명</label>
            <input form="form" type="text" id="memo" name="memo" class="form-control form-control-sm" autocomplete="off">
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12 text-center">
            <button form="form" type="button" class="btn btn-default btn-sm" id="return_list">취소</button>
            <button form="form" type="submit" class="btn btn-primary btn-sm">생성</button>
        </div>
    </div>

</div>

<form id="form" name="form">
    <input type="hidden" id="idx" name="idx">
    <input type="hidden" id="form_table_name" name="form_table_name">
</form>

<?php include_once $_SERVER['DOCUMENT_ROOT'] . "/ad/board/board_management_write_js.php"; ?>
