<?php include "../lib/config.php"; ?>

<?php include "../lib/auth.php"; ?>

<?php include "head.php"; ?>

<?php include "nav_top.php"; ?>

<div class="container mt-5">

    <div class="row">
        <div class="col-sm-12 text-right">
            <button form="form" type="submit" class="btn btn-success btn-sm">저장</button>
        </div>
    </div>

    <div class="board-setting-div">
        <div class="m-b-sm">
            <span class="font-bold" style="color: darkblue">게시판 기본 설정</span>
        </div>

        <div class="row mb-3">
            <div class="col-sm-6">
                <label class="col-sm-12 form-label"><span class="text-danger">*</span> 업로드 확장자 (확장자와 확장자 사이는 | 로 구분)</label>
                <input form="form" type="text" id="extension" name="extension" class="form-control input-lg" placeholder="업로드 확장자를 입력해주세요." required autocomplete="off">
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-sm-12">
                <label class="col-sm-12 form-label"><span class="text-danger">*</span> 단어 필터링 (단어와 단어 사이는 ,로 구분)</label>
                <textarea form="form" class="form-control well" name="filtering" id="filtering" rows="8" placeholder="필터링 단어를 입력해주세요."></textarea>
            </div>
        </div>
    </div>

    <div class="join-setting-div m-t-lg">
        <div class="m-b-sm">
            <span class="font-bold" style="color: darkblue">회원가입 설정</span>
        </div>

        <div class="row mb-3">
            <div class="col-sm-3">
                <label class="col-sm-12 form-label"><span class="text-danger"></span> 연락처 입력</label>
                <select form="form" class='form-select' name="phone_check" id="phone_check">
                    <option value='Y'>활성</option>
                    <option value='N'>비활성</option>
                </select>
            </div>

            <div class="col-sm-3">
                <label class="col-sm-12 form-label"><span class="text-danger"></span> 이메일 입력</label>
                <select form="form" class='form-select' name="email_check" id="email_check">
                    <option value='Y'>활성</option>
                    <option value='N'>비활성</option>
                </select>
            </div>

            <div class="col-sm-3">
                <label class="col-sm-12 form-label"><span class="text-danger"></span> 주소 입력</label>
                <select form="form" class='form-select' name="address_check" id="address_check">
                    <option value='Y'>활성</option>
                    <option value='N'>비활성</option>
                </select>
            </div>
        </div>
    </div>

</div>

<form id="form" name="form">
    <input type="hidden" id="idx" name="idx">
</form>

<script>

    // 모달 저장
    $("#form").on("submit", function() {
        update();
        return false;
    });

    // 모달 저장
    function update() {
        let process_mode = "board_setting_update"

        $.ajax({
            type: "post",
            data: $("#form").serialize() + "&process_mode=" + process_mode,
            url: "../lib/admin_ajax.php",
            dataType: "json",
            cache: false,
            async: false,
        }).done(function(data) {
            if (data.status) {
                toastr["success"]('저장 되었습니다.');
            } else {
                toastr["error"](data.message);
            }
        });
    }

    function view(){

        $.ajax({
            type: 'POST',
            data: {
                process_mode : 'board_setting_view'
            },
            url: "../lib/admin_ajax.php",
            dataType: 'json',
            cache: false,
            async: false
        }).done(function(result) {
            $("#extension").val(result.data.extension);
            $("#filtering").val(result.data.filtering);
            $("#phone_check").val(result.data.phone_check);
            $("#email_check").val(result.data.email_check);
            $("#address_check").val(result.data.address_check);
        });
    }

    $("#return_list").click(function() {
        window.location.href = `board_admin.php`;
    });

    $(function() {
        view();
    });
</script>
