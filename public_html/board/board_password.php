<?php include_once $_SERVER['DOCUMENT_ROOT'] . "/include/default.php"; ?>

<?php include_once $_SERVER['DOCUMENT_ROOT'] . "/layout/header.php"; ?>

<?php include_once $_SERVER['DOCUMENT_ROOT'] . "/layout/nav_top.php"; ?>

<div class="wrapper wrapper-content">
    <div class="container mt-5" style="width: 450px;">

        <div class="row mb-3">
            <div class="col-sm-12 text-center">
                <h3><span class="font-bold text-danger" id="password_title_text">작성자만 글을 수정할 수 있습니다.</span></h3>
            </div>
            <div class="col-sm-12 mb-5 text-center" id="password_body_text">
                비밀번호를 입력해주세요.
            </div>
            <div class="col-sm-12">
                <input type="password" id="write_password" name="write_password" class="form-control form-control-sm required" autocomplete="off" placeholder="비밀번호" required>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12 text-center">
                <button type="button" class="btn btn-default btn-sm" onclick="history.back();">취소</button>
                <button type="button" class="btn btn-primary btn-sm" id="write_password_check">확인</button>
            </div>
        </div>

    </div>
</div>

<!--<form id="form" name="form">-->
<!--    <input type="hidden" id="idx" name="idx">-->
<!--    <input type="hidden" id="form_table_name" name="form_table_name">-->
<!--</form>-->

<?php include_once $_SERVER['DOCUMENT_ROOT'] . "/board/board_password_js.php"; ?>

