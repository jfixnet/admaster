<?php include "../lib/config.php"; ?>

<?php include "../lib/auth.php"; ?>

<?php include "head.php"; ?>

<?php include "nav_top.php"; ?>

<div class="wrapper wrapper-content">
    <div class="container">

        <div class="row mb-3">
            <span class="font-bold" style="font-size: 20px;" id="page_title"></span>
        </div>

        <div class="row mb-3">
            <div class="col-sm-6" id="login_check_div">
                <!--<label class="col-sm-2 form-label"><span class="text-danger">*</span> 이름</label>-->
                <input form="form" type="text" id="user_name" name="user_name" class="form-control form-control-sm required" autocomplete="off" placeholder="이름">
            </div>
            <div class="col-sm-6">
                <!--<label class="col-sm-2 form-label"><span class="text-danger">*</span> 비밀번호</label>-->
                <input form="form" type="password" id="write_password" name="write_password" class="form-control form-control-sm required" autocomplete="off" placeholder="비밀번호">
            </div>
        </div>

        <div class="row mb-3" id="secret_div">
            <div class="col-sm-12">
                <div class="custom-control custom-checkbox">
                    <input form="form" type="checkbox" class="custom-control-input" id="is_secret" name="is_secret" style="width: 20px; height: 20px;vertical-align: middle;  position: relative;  bottom: 3px;">
                    <label class="custom-control-label" for="is_secret" data-toggle="popover" data-trigger="hover" data-placement="top" title="비밀글일 경우 체크해주세요."  data-original-title="">&nbsp비밀글여부</label>
                </div>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-sm-12">
                <!--<label class="col-sm-2 form-label"><span class="text-danger">*</span> 제목</label>-->
                <input form="form" type="text" id="title" name="title" class="form-control form-control-sm required" autocomplete="off" placeholder="제목을 입력해주세요." maxlength="50" required>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-sm-12">
                <label class="col-sm-2 form-label"><span class="text-danger"></span> 내용</label>
                <textarea form="form" id="content" name="content" class="form-control form-control-sm summernote"></textarea>
            </div>
        </div>

        <div class="row mb-3">
            <div class="form-group">
                <label class="col-xs-2 control-label">첨부파일</label>
                <div class="col-xs-10">

                    <div class="file_list">

                    </div>

                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12 text-center">
                <button form="form" type="button" class="btn btn-default btn-sm" id="return_list">취소</button>
                <button form="form" type="submit" class="btn btn-success btn-sm" id="update_btn">글수정</button>
            </div>
        </div>

    </div>

    <form id="form" name="form">
        <input type="hidden" id="idx" name="idx">
        <input type="hidden" id="form_table_name" name="form_table_name">
    </form>

</div>

<script>
    let userName = '<?=$_SESSION['user_name']?>';
    let editor;
    let attachFileNum;

    $("#login_check_div").show();
    if (userName) {
        $("#login_check_div").hide();
    }

    function getParameterByName(name) {
        name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
        var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
            results = regex.exec(location.search);
        return results == null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
    }

    let table_name = getParameterByName('table_name');
    let idx = getParameterByName('idx');
    let type = getParameterByName('type');
    let skin = getParameterByName('skin');

    // 모달 저장
    $("#form").on("submit", function() {
        update();
        return false;
    });

    // 모달 저장
    function update() {
        let process_mode = "update"

        $("#idx").val( idx ); // 에디터 처리
        $("#form_table_name").val( table_name ); // 에디터 처리

        $("#is_secret").prop("disabled", false);

        var formData = new FormData( $("#form")[0] );
        formData.append("process_mode", process_mode);

        const editorData = editor.getData();
        formData.append("content", editorData);

        $.ajax({
            type: "post",
            // data: $("#form").serialize() + "&process_mode=" + process_mode+ "&table_name=" + table_name+ "&idx=" + idx,
            data: formData,
            processData: false, // 첨부파일 처리
            contentType: false, // 첨부파일 처리
            url: "../lib/board_ajax.php",
            dataType: "json",
            cache: false,
            async: false,
        }).done(function(data) {
            if (data.status) {
                if (skin == 'gallery') {
                    window.location.href = `board_g.php?table_name=${table_name}`;
                } else {
                    window.location.href = `board.php?table_name=${table_name}`;
                }
                return false;
            } else {
                toastr["error"](data.message);
            }
        });
    }

    function view() {
        let process_mode = 'view'

        $.ajax({
            type: "post",
            data: $("#form").serialize() + "&process_mode=" + process_mode+ "&table_name=" + table_name+ "&idx=" + idx,
            url: "../lib/board_ajax.php",
            dataType: "json",
            cache: false,
            async: false,
        }).done(function(result) {
            if (result) {
                $("#user_name").val(result.user_name);
                $("#title").val(result.title);

                editor.setData(result.content);

                $("#is_secret").prop("checked", false);
                if (result.is_secret == 'Y') {
                    $("#is_secret").prop("checked", true);
                }

                $("#update_btn").show();

                // 첨부파일 표시
                if (result.files.length > 0) {
                    console.log(result.files.length)

                    result.files.forEach(function(item, index) {
                        if (item) {
                            fileUploadAdd(index, 'link');
                            $(".modal_file_place").eq( item.sort ).show();
                            $(".modal_file_place").eq( item.sort ).find("a").attr("href", "../lib/download.php?code=" + item.file_tmp_name);
                            $(".modal_file_place").eq( item.sort ).find("span").text(item.file_name);
                            $(".modal_file_place").eq( item.sort ).find("button").data({ code: item.file_tmp_name,  sort : item.sort });
                        }
                    })

                    fileUploadAdd(0,'');
                } else {
                    fileUploadAdd(0,'');
                }

            } else {
                toastr["error"](result.message);
            }
        });
    }

    $("#return_list").click(function() {
        if (skin == 'gallery') {
            window.location.href = `board_g.php?table_name=${table_name}`;
        } else {
            window.location.href = `board.php?table_name=${table_name}`;
        }
        return false;
    });

    function fileUploadAdd(index, type) {
        let html = '';

        if ($(".file_row").length >= attachFileNum) {
            toastr["error"]("첨부파일은 총" + attachFileNum + "개까지 첨부가 가능합니다.");
            return false;
        }

        if (type) {
            html = `
                <div class="file_row">
                    <div class="modal_file_place m-t-xs" style="display: none;">
                        <a href="#" class="btn btn-w-m btn-sm btn-default m-r-xs"><i class="fa fa-download"></i> <span></span></a>
                        <button class="btn btn-danger btn-sm modal_btn_file_delete">파일 삭제</button>
                    </div>
                </div>`;
        } else {
            html = `<div class="file_row">
                        <div class="fileinput fileinput-new input-group m-t-xs" data-provides="fileinput">
                            <div class="form-control input-sm" data-trigger="fileinput">
                                <i class="glyphicon glyphicon-file fileinput-exists"></i>
                                <span class="fileinput-filename" style="font-size: 11px; margin-top: -4px;"></span>
                            </div>
                            <span class="input-group-addon btn btn-default btn-file">
                                <span class="fileinput-new"><!-- Select file -->파일 선택</span>
                                <span class="fileinput-exists"><!-- Change -->변경</span>
                                <input form="form" type="file" name="file[]" data-input-name="file[]">
                            </span>
                            <a href="#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput"><!-- Remove -->비우기</a>`;

            if (index == 0) {
                html += `<span class="input-group-addon btn btn-success" onclick="fileUploadAdd()">+</span>`
            } else {
                html += `<span class="input-group-addon btn btn-danger fileUploadRemove">-</span>`;
            }

            html += `</div>
                </div>`;
        }

        $(".file_list").append(html);
    }

    $(document).on('click', '.fileUploadRemove', function() {
        $(this).parent().parent().remove();
    });

    // 첨부 파일 삭제
    $(document).on("click", ".modal_btn_file_delete", function() {

        if (confirm("삭제한 데이터는 복구가 불가능합니다.\r\n삭제하시겠습니까?")) {

            var code = $(this).data("code");
            var sort = $(this).data("sort");

            $.ajax({
                type: "post",
                data: "code=" + code + "&process_mode=delete_file",
                url: "../lib/board_ajax.php",
                dataType: "json",
                cache: false,
                async: false,
            }).done(function(data) {
                if (data.status) {

                    // 빈 여백 처리
                    $(".modal_file_place").eq( sort ).fadeOut(function() {
                        $(".modal_file_place").eq( sort ).find("a").attr("href", "");
                        $(".modal_file_place").eq( sort ).find("span").text("");
                        $(".modal_file_place").eq( sort ).find("button").data({ code: "", sort: "" });
                    });

                    toastr["success"](data.message);
                } else {
                    toastr["error"](data.message);
                }
            });
        }
    });

    function pageSetting() {
        let process_mode = 'page_setting'

        $.ajax({
            type: "post",
            data: $("#form").serialize() + "&process_mode=" + process_mode+ "&table_name=" + table_name,
            url: "../lib/board_ajax.php",
            dataType: "json",
            cache: false,
            async: false,
        }).done(function(result) {
            if (result) {
                $("#page_title").text(result.data.table_title);

                if (result.data.secret_mode == 'A') {
                    $("#is_secret").prop("disabled", true);
                }

                attachFileNum = result.data.attach_file_num;

            } else {
                console.log('페이지 세팅 오류');
            }
        });
    }

    ClassicEditor
        .create( document.querySelector( '#content' ),{
            language: "ko",
            toolbar: {
                items: [
                    'heading',
                    '|',
                    'bold',
                    'italic',
                    '|',
                    'bulletedList',
                    'numberedList',
                    '|',
                    // 'imageUpload',
                    'blockQuote',
                    '|',
                    'undo',
                    'redo'
                ]
            },
        } )
        .then( newEditor => {
            editor = newEditor;
        } )
        .catch( error => {
            console.error( error );
        } );

    $(function() {

        if (type == 's') {
            if (!userName) {
                if (!getCookie('view_status') || getCookie('view_status') != idx){
                    window.location.href = `board_password.php?table_name=${table_name}&idx=${idx}&type=v`;
                    return false;
                }
            }
        }

        deleteCookie('update_status');
        pageSetting();
        view();
    });

</script>

<?php include "tail.php"; ?>