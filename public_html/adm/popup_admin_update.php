<?php include "../lib/config.php"; ?>

<?php include "../lib/auth.php"; ?>

<?php include "head.php"; ?>

<?php include "nav_top.php"; ?>

<div class="container mt-5">

    <div class="row mb-3">
        <div class="col-sm-6">
            <label class="col-sm-12 form-label"><span class="text-danger"></span> 팝업 제목</label>
            <input form="form" type="text" id="popup_title" name="popup_title" class="form-control form-control-sm required" autocomplete="off" required>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-sm-2">
            <label class="col-sm-12 form-label"><span class="text-danger"></span> 시작일</label>
            <input form="form" type="text" id="start_date" name="start_date" class="form-control form-control-sm required" autocomplete="off" required>
        </div>
        <div class="col-sm-2">
            <label class="col-sm-12 form-label"><span class="text-danger"></span> 종료일</label>
            <input form="form" type="text" id="end_date" name="end_date" class="form-control form-control-sm required" autocomplete="off" required>
        </div>
        <div class="col-sm-2">
            <label class="col-sm-12 form-label"><span class="text-danger"></span> 팝업창 가로 사이즈</label>
            <input form="form" type="text" id="popup_width_size" name="popup_width_size" class="form-control form-control-sm required" autocomplete="off" required>
        </div>
        <div class="col-sm-2">
            <label class="col-sm-12 form-label"><span class="text-danger"></span> 팝업창 세로 사이즈</label>
            <input form="form" type="text" id="popup_height_size" name="popup_height_size" class="form-control form-control-sm required" autocomplete="off" required>
        </div>
        <div class="col-sm-2">
            <label class="col-sm-12 form-label"><span class="text-danger"></span> 팝업창 위치(TOP)</label>
            <input form="form" type="text" id="popup_top_size" name="popup_top_size" class="form-control form-control-sm required" autocomplete="off" required>
        </div>
        <div class="col-sm-2">
            <label class="col-sm-12 form-label"><span class="text-danger"></span> 팝업창 위치(LEFT)</label>
            <input form="form" type="text" id="popup_left_size" name="popup_left_size" class="form-control form-control-sm required" autocomplete="off" required>
        </div>

    </div>

    <div class="row mb-3">
        <div class="col-sm-3">
            <label class="col-sm-12 form-label"><span class="text-danger"></span> 팝업 상태</label>
            <select form="form" class='form-select' name="status" id="status">
                <option value='Y' selected>사용중</option>
                <option value='N'>종료</option>
            </select>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-sm-12">
            <textarea form="form" id="popup_content" name="popup_content" class="summernote" style="width:100%;"></textarea>
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
</form>

<script>
    function getParameterByName(name) {
        name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
        var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
            results = regex.exec(location.search);
        return results == null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
    }

    let idx = getParameterByName('idx');

    // 모달 저장
    $("#form").on("submit", function() {
        update();
        return false;
    });

    // 모달 저장
    function update() {

        let process_mode = "popup_update"
        $("#popup_content").val($(".summernote").summernote("code")); // 에디터 처리

        var formData = new FormData( $("#form")[0] );
        formData.append("process_mode", process_mode);

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
                window.location.href="popup_admin.php"
            } else {
                toastr["error"](data.message);
            }
        });
    }

    function view(){

        $("#idx").val(idx);
        $(".summernote").summernote("code", ""); // 에디터 처리

        if (idx) {

            $.ajax({
                type: 'POST',
                data: {
                    process_mode : 'popup_view',
                    idx : idx
                },
                url: "../lib/admin_ajax.php",
                dataType: 'json',
                cache: false,
                async: false
            }).done(function(result) {

                $("#popup_title").val(result.popup_title);
                $("#start_date").datepicker('setDate', result.start_date);
                $("#end_date").datepicker('setDate', result.end_date);
                $("#popup_width_size").val(result.popup_width_size);
                $("#popup_height_size").val(result.popup_height_size);
                $("#popup_top_size").val(result.popup_top_size);
                $("#popup_left_size").val(result.popup_left_size);
                $("#status").val(result.status);

                $(".summernote").summernote("code", result.popup_content); // 에디터 처리
            });
        }
    }

    $("#return_list").click(function() {
        window.location.href = `popup_admin.php`;
    });

    $(function() {

        $.fn.datepicker.dates['ko'] = {
            days: ["일", "월", "화", "수", "목", "금", "토", "일"],
            daysShort: ["일", "월", "화", "수", "목", "금", "토", "일"],
            daysMin: ["일", "월", "화", "수", "목", "금", "토", "일"],
            months: ["1월", "2월", "3월", "4월", "5월", "6월", "7월", "8월", "9월", "10월", "11월", "12월"],
            monthsShort: ["1월", "2월", "3월", "4월", "5월", "6월", "7월", "8월", "9월", "10월", "11월", "12월"],
            today: "오늘"
        };

        let dtpickerOpt = {
            format: 'yyyy-mm-dd',
            language: "ko",
            orientation: 'auto bottom'
        };

        $('#start_date').datepicker(dtpickerOpt).on('hide', function (e) {
            e.stopPropagation();
        });
        $('#end_date').datepicker(dtpickerOpt).on('hide', function (e) {
            e.stopPropagation();
        });

        // summernote 적용
        var $summernote = $('.summernote').summernote({
            lang: 'ko-KR', // default: 'en-US'
            tabsize: 2,
            height: 400,
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'underline', 'clear']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['table', ['table']],
                ['insert', ['link', 'picture', 'video']],
                ['view', ['help']]
            ],
            callbacks: {
                onImageUpload: function (files) {
                    for (var i = 0; i < files.length; i++) {
                        sendFile($summernote, files[i]);
                    }
                }
            }
        });

        view();
    });

</script>
