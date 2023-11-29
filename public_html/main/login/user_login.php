<?php include_once $_SERVER['DOCUMENT_ROOT'] . "/include/config.php"; ?>

<?php include_once $_SERVER['DOCUMENT_ROOT'] . "/layout/header.php"; ?>

<style>
    input::-webkit-input-placeholder {
        font-size: 15px;
    }
</style>

<div class="wrapper wrapper-content" style="margin-top: 200px;">
    <div class="container text-center" style="width: 450px;">

        <div class="form-group" style="margin-bottom: 15px;">
            <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-user" style="font-size:20px; width: 25px;"></i></span>
                <input form="form_main" type="text" id="code" name="code" class="form-control input-lg" placeholder="아이디" required autocomplete="off">
            </div>
        </div>

        <div class="form-group" style="margin-bottom: 20px;">
            <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-lock" style="font-size:22px; width: 25px;"></i></span>
                <input form="form_main" type="password" id="password" name="password" class="form-control input-lg" placeholder="비밀번호" required>
            </div>
        </div>

        <div class="form-group" style="margin-bottom: 20px;">
            <div class="custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input" id="id_save" style="width: 20px; height: 20px;vertical-align: middle;  position: relative;  bottom: 3px;">
                <label class="custom-control-label" for="id_save" data-toggle="popover" data-trigger="hover" data-placement="top" title="" data-content="아이디는 저장한 날로부터 7일간 유효합니다." data-original-title="">&nbsp아이디 기억하기</label>
            </div>
        </div>

        <div class="form-group" style="margin-bottom: 20px;">
            <a href="/page/join/join.php">회원가입</a>
        </div>

        <button form="form_main" type="submit" id="btn_login" class="btn btn-success btn-lg block full-width m-b font-bold">로그인</button>
        <button form="form_main" type="button" id="btn_login" class="btn btn-default btn-lg block full-width m-b font-bold" onclick="location.href='/index.php'">취소</button>
        <p class="m-t"> <small><strong>Copyright</strong>&copy;<?=$COPYRIGHT_YEAR?> <?=$PROVIDER_TITLE?>. All rights reserved.</small> </p>
    </div>
</div>

<form id="form_main" name="form_main">
    <input type="hidden" id="idx" name="idx">
</form>

<?php include_once $_SERVER['DOCUMENT_ROOT'] . "/page/login/user_login_js.php"; ?>
<?php //include_once $_SERVER['DOCUMENT_ROOT'] . "/layout/footer.php"; ?>
