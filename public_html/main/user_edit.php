<?php include "../lib/config.php"; ?>

<?php include "../lib/auth.php"; ?>

<?php include "head.php"; ?>

<?php include "nav_top.php"; ?>

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

    <script>

        function view() {
            let process_mode = 'user_info_view'

            $.ajax({
                type: "post",
                data: $("#form").serialize() + "&process_mode=" + process_mode,
                url: "../lib/user_ajax.php",
                dataType: "json",
                cache: false,
                async: false,
            }).done(function(result) {
                if (result) {
                    $("#code").val(result.code);
                    $("#name").val(result.name);
                    $("#phone").val(result.phone);
                    $("#email").val(result.email);
                } else {
                }
            });
        }

        $("#form_main").on("submit", function() {
            userEdit();
            return false;
        });

        function userEdit() {
            $.ajax({
                type: "post",
                data: $("#form_main").serialize() + "&process_mode=user_info_update",
                url: "../lib/user_ajax.php",
                dataType: "json",
                cache: false,
                async: false,
            }).done(function (data) {
                if (data.status) {
                    toastr["success"](data.message);
                } else {
                    toastr["error"](data.message);
                }
            })
        };

        $(function() {
            view();
        });

    </script>

<?php include "tail.php"; ?>