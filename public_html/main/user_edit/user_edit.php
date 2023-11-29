<?php include_once $_SERVER['DOCUMENT_ROOT'] . "/include/config.php"; ?>

<?php include_once $_SERVER['DOCUMENT_ROOT'] . "/include/auth.php"; ?>

<?php include_once $_SERVER['DOCUMENT_ROOT'] . "/layout/header.php"; ?>

<?php include_once $_SERVER['DOCUMENT_ROOT'] . "/layout/nav_top.php"; ?>

<div class="wrapper wrapper-content" style="">
    <div class="container text-center" style="width: 450px;">

        <div class="form-group" style="margin-bottom: 15px;">
            <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-user" style="font-size:20px; width: 25px;"></i></span>
                <input form="form_main" type="text" id="code" name="code" class="form-control input-lg" placeholder="아이디" autocomplete="off" readonly>
            </div>
        </div>

        <div class="form-group" style="margin-bottom: 20px;">
            <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-lock" style="font-size:22px; width: 25px;"></i></span>
                <input form="form_main" type="password" id="password" name="password" class="form-control input-lg" placeholder="기존 비밀번호" required>
            </div>
        </div>

        <div class="form-group" style="margin-bottom: 20px;">
            <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-lock" style="font-size:22px; width: 25px;"></i></span>
                <input form="form_main" type="password" id="new_password" name="new_password" class="form-control input-lg" placeholder="신규 비밀번호" required>
            </div>
        </div>

        <div class="form-group" style="margin-bottom: 20px;">
            <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-user" style="font-size:22px; width: 25px;"></i></span>
                <input form="form_main" type="text" id="name" name="name" class="form-control input-lg" placeholder="이름" autocomplete="off" >
            </div>
        </div>

        <div class="form-group" style="margin-bottom: 20px;">
            <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-phone" style="font-size:22px; width: 25px;"></i></span>
                <input form="form_main" type="text" id="phone" name="phone" class="form-control input-lg" placeholder="연락처" autocomplete="off" >
            </div>
        </div>

        <div class="form-group" style="margin-bottom: 20px;">
            <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-envelope " style="font-size:22px; width: 25px;"></i></span>
                <input form="form_main" type="text" id="email" name="email" class="form-control input-lg" placeholder="이메일" autocomplete="off" >
            </div>
        </div>

        <button form="form_main" type="submit" id="btn_login" class="btn btn-success btn-lg block full-width m-b font-bold">수정</button>
    </div>
</div>

<form id="form_main" name="form_main">
    <input type="hidden" id="idx" name="idx">
</form>

<?php include_once $_SERVER['DOCUMENT_ROOT'] . "/page/user_edit/user_edit_js.php"; ?>

<?php include_once $_SERVER['DOCUMENT_ROOT'] . "/layout/footer.php"; ?>