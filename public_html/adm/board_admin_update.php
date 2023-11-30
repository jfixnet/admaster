<?php include "../lib/config.php"; ?>

<?php include "../lib/auth.php"; ?>

<?php include "head.php"; ?>

<?php include "nav_top.php"; ?>

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
            <button form="form" type="submit" class="btn btn-primary btn-sm">수정</button>
        </div>
    </div>

</div>

<form id="form" name="form">
    <input type="hidden" id="idx" name="idx">
    <input type="hidden" id="form_table_name" name="form_table_name">
</form>

<script>
    function getParameterByName(name) {
        name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
        var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
            results = regex.exec(location.search);
        return results == null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
    }

    let table_name = getParameterByName('table_name');


    // 모달 저장
    $("#form").on("submit", function() {
        update();
        return false;
    });

    // 모달 저장
    function update() {

        let form_table_name =  $("#form_table_name").val();

        if (!form_table_name) {
            window.location.href="board_admin.php"
            return false;
        }

        let process_mode = "board_update"

        $.ajax({
            type: "post",
            data: $("#form").serialize() + "&process_mode=" + process_mode,
            url: "../lib/admin_ajax.php",
            dataType: "json",
            cache: false,
            async: false,
        }).done(function(data) {
            if (data.status) {
                let alertText = '생성'
                if (process_mode == 'board_update') {
                    alertText = '수정'
                }
                alert('게시판이 '+ alertText + '되었습니다.');
                window.location.href="board_admin.php"
            } else {
                toastr["error"](data.message);
            }
        });
    }

    function view(){

        $("#form_table_name").val(table_name);

        if (table_name) {

            $.ajax({
                type: 'POST',
                data: {
                    process_mode : 'board_view',
                    table_name : table_name
                },
                url: "../lib/admin_ajax.php",
                dataType: 'json',
                cache: false,
                async: false
            }).done(function(result) {
                console.log(result)
                $("#table_name").val(result.data.table_name);
                $("#table_title").val(result.data.table_title);
                $("#secret_mode").val(result.data.secret_mode);
                $("#admin_only").val(result.data.admin_only);
                $("#comment_mode").val(result.data.comment_mode);
                $("#memo").val(result.data.memo);
            });
        }
    }

    $("#return_list").click(function() {
        window.location.href = `board_admin.php`;
    });

    $(function() {
        view();
    });

</script>
