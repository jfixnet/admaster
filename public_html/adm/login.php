<?php include "../include/config.php"; ?>
<?php include "header.php"; ?>

<div class="wrapper wrapper-content" style="margin-top: 200px;">
    <div class="container text-center" style="width: 450px;">

        <h1>관리자 페이지</h1>

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

        <button form="form_main" type="submit" id="btn_login" class="btn btn-success btn-lg block full-width m-b font-bold">로그인</button>
        <p class="m-t"> <small><strong>Copyright</strong>&copy;<?=$COPYRIGHT_YEAR?> <?=$PROVIDER_TITLE?>. All rights reserved.</small> </p>
    </div>
</div>

<form id="form_main" name="form_main">
    <input type="hidden" id="idx" name="idx">
</form>

<script>

    $("#form_main").on("submit", function() {
        login();
        return false;
    });

    function login() {
        $.ajax({
            type: "post",
            data: $("#form_main").serialize() + "&process_mode=login",
            url: "/ad/login_ajax.php",
            dataType: "json",
            cache: false,
            async: false,
        }).done(function (data) {

            $(".setting_password").text(data.setting_password);

            if (data.status == 1) {
                toastr["success"](data.message);
                document.location.href = data.redirect;
            } else if (data.status == 3) {
                // toastr["error"](data.message);
                $("#password_error_num").text(data.message);
                $("#form_main").trigger("reset");
            } else if (data.status == 4) {
                $("#form_main").trigger("reset");
            } else {
                toastr["error"](data.message);
                $("#form_main").trigger("reset");
            }
        })
    };

    var userInputId = getCookie("userInputId");
    $("input[name='code']").val(userInputId);

    if ($("input[name='code']").val() != "") { // 그 전에 ID를 저장해서 처음 페이지 로딩 시, 입력 칸에 저장된 ID가 표시된 상태라면,
        $("#id_save").attr("checked", true); // ID 저장하기를 체크 상태로 두기.
    }

    $("#id_save").change(function () { // 체크박스에 변화가 있다면,
        if ($("#id_save").is(":checked")) { // ID 저장하기 체크했을 때,
            var userInputId = $("input[name='code']").val();
            setCookie("userInputId", userInputId); // 7일 동안 쿠키 보관
        } else { // ID 저장하기 체크 해제 시,
            deleteCookie("userInputId");
        }
    });

    // ID 저장하기를 체크한 상태에서 ID를 입력하는 경우, 이럴 때도 쿠키 저장.
    $("input[name='code']").keyup(function () { // ID 입력 칸에 ID를 입력할 때,
        if ($("#id_save").is(":checked")) { // ID 저장하기를 체크한 상태라면,
            var userInputId = $("input[name='code']").val();
            setCookie("userInputId", userInputId, 7); // 7일 동안 쿠키 보관
        }
    });

    function setCookie(cookieName, value, exdays) {
        var exdate = new Date();
        exdate.setDate(exdate.getDate() + exdays);
        var cookieValue = escape(value) + ((exdays == null) ? "" : "; expires=" + exdate.toGMTString());
        document.cookie = cookieName + "=" + cookieValue;
    }

    function deleteCookie(cookieName) {
        var expireDate = new Date();
        expireDate.setDate(expireDate.getDate() - 1);
        document.cookie = cookieName + "= " + "; expires=" + expireDate.toGMTString();
    }

    function getCookie(cookieName) {
        cookieName = cookieName + '=';
        var cookieData = document.cookie;
        var start = cookieData.indexOf(cookieName);
        var cookieValue = '';
        if (start != -1) {
            start += cookieName.length;
            var end = cookieData.indexOf(';', start);
            if (end == -1) end = cookieData.length;
            cookieValue = cookieData.substring(start, end);
        }
        return unescape(cookieValue);
    }

</script>