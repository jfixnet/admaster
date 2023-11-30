<?php include "../lib/config.php"; ?>

<?php include "head.php"; ?>

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
        <button form="form_main" type="button" id="btn_login" class="btn btn-default btn-lg block full-width m-b font-bold" onclick="location.href='index.php'">취소</button>
    </div>
</div>

<form id="form_main" name="form_main">
    <input type="hidden" id="idx" name="idx">
</form>

<script>

    $("#form_main").on("submit", function() {
        save();
        return false;
    });

    function save() {

        let password = $("#password").val();
        let rePassword = $("#re_password").val();
        if (password != rePassword) {
            alert('비밀번호가 다릅니다. 확인해주세요.');
            return false;
        }

        $.ajax({
            type: "post",
            data: $("#form_main").serialize() + "&process_mode=join",
            url: "../lib/user_ajax.php",
            dataType: "json",
            cache: false,
            async: false,
        }).done(function(data) {

            if (data.status) {
                toastr["success"](data.message);
                document.location.href = data.redirect;
            } else {
                toastr["error"](data.message);
            }
        });
    }

    $('#code').on('input', function() {
        const user_code = $(this).val().trim();

        if (user_code.length === 0) {
            $('#code_check').text('');
            return;
        }

        let regExp = /[ㄱ-ㅎ|ㅏ-ㅣ|가-힣]/;
        if (regExp.test($(this).val())) {
            $(this).val($(this).val().replace(/[ㄱ-ㅎ|ㅏ-ㅣ|가-힣]/g, ''));
        }

        let re_user_code = $(this).val();

        if (re_user_code) {
            $.ajax({
                type: "post",
                data: $("#form_main").serialize() + "&process_mode=code_check",
                url: "../lib/user_ajax.php",
                dataType: "json",
                cache: false,
                async: false,
            }).done(function(data) {

                if (data.status) {
                    $('#code_check').text('사용 가능한 아이디입니다.').removeClass('invalid').addClass('valid');
                } else {
                    $('#code_check').text('이미 사용 중인 아이디입니다.').removeClass('valid').addClass('invalid');
                }
            });
        }
    });

</script>
