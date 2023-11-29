<?php include_once $_SERVER['DOCUMENT_ROOT'] . "/include/config.php"; ?>

<?php include_once $_SERVER['DOCUMENT_ROOT'] . "/layout/header.php"; ?>

<style>
    input::-webkit-input-placeholder {
        font-size: 15px;
    }
    .valid {
        color: green;
    }
    .invalid {
        color: red;
    }
</style>

<div class="wrapper wrapper-content" style="margin-top: 200px;">
    <div class="container text-center" style="width: 450px;">

        <div class="form-group" style="margin-bottom: 15px;">
            <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-user" style="font-size:20px; width: 25px;"></i></span>
                <input form="form_main" type="text" id="code" name="code" class="form-control input-lg" placeholder="아이디" autocomplete="off" required>
            </div>
            <div class="m-t-sm text-left">
                <span id="code_check"></span>
            </div>
        </div>

        <div class="form-group" style="margin-bottom: 20px;">
            <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-lock" style="font-size:22px; width: 25px;"></i></span>
                <input form="form_main" type="password" id="password" name="password" class="form-control input-lg" placeholder="비밀번호" required>
            </div>
        </div>

        <div class="form-group" style="margin-bottom: 20px;">
            <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-lock" style="font-size:22px; width: 25px;"></i></span>
                <input form="form_main" type="password" id="re_password" name="re_password" class="form-control input-lg" placeholder="비밀번호 재입력" required>
            </div>
        </div>

        <div class="form-group" style="margin-bottom: 20px;">
            <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-user" style="font-size:22px; width: 25px;"></i></span>
                <input form="form_main" type="text" id="name" name="name" class="form-control input-lg" placeholder="이름" autocomplete="off" required>
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

        <div class="form-group" style="margin-bottom: 20px;">
            <div class="custom-control custom-checkbox">
                <input form="form_main" type="checkbox" class="custom-control-input" id="reception_status_check" name="reception_status_check" style="width: 20px; height: 20px;vertical-align: middle;  position: relative;  bottom: 3px;">
                <label class="custom-control-label" for="reception_status_check" data-toggle="popover" data-trigger="hover" data-placement="top" title="" data-content="아이디는 저장한 날로부터 7일간 유효합니다." data-original-title="">&nbsp 이메일 수신여부</label>
            </div>
        </div>

        <button form="form_main" type="submit" id="btn_login" class="btn btn-success btn-lg block full-width m-b font-bold">회원가입</button>
        <button form="form_main" type="button" id="btn_login" class="btn btn-default btn-lg block full-width m-b font-bold" onclick="location.href='/index.php'">취소</button>
    </div>
</div>

<form id="form_main" name="form_main">
    <input type="hidden" id="idx" name="idx">
</form>

<?php include_once $_SERVER['DOCUMENT_ROOT'] . "/page/join/join_js.php"; ?>
