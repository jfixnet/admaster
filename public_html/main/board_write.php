<?php include "../lib/config.php"; ?>

<?php include "../lib/auth.php"; ?>

<?php include "head.php"; ?>

<?php include "nav_top.php"; ?>

<div class="wrapper wrapper-content">
    <div class="container">

        <div class="row mb-3">
            <span class="font-bold" style="font-size: 20px;" id="page_title"></span>
        </div>
        
        <div class="row mb-3" id="login_check_div">
            <div class="col-sm-6">
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
                <input form="form" type="text" id="title" name="title" class="form-control form-control-sm required" autocomplete="off" placeholder="제목을 입력해주세요." required>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-sm-12">
                <!--<label class="col-sm-2 form-label"><span class="text-danger"></span> 내용</label>-->
                <textarea form="form" id="content" name="content" class=""></textarea>
            </div>
        </div>

        <div class="row mb-3">
                <div class="form-group">
                    <!--<label class="col-xs-2 control-label">첨부파일</label>-->
                    <div class="col-xs-10">

                        <div class="file_list">

                        </div>

                    </div>
                </div>
        </div>

        <div class="row">
            <div class="col-sm-12 text-center">
                <button form="form" type="button" class="btn btn-default btn-sm" id="return_list">취소</button>
                <button form="form" type="submit" class="btn btn-primary btn-sm">등록</button>
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
        let isAdmin = '<?=$_SESSION['is_admin']?>';
        let editor;

        $("#login_check_div").show();
        if (userName) {
            console.log(userName)
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

        // 모달 저장
        $("#form").on("submit", function(event) {
            create();
            return false;
        });


        // 모달 저장
        function create() {
            let process_mode = "create"; // 등록 모드

            // $("#content").val($(".summernote").summernote("code")); // 에디터 처리
            $("#idx").val(idx); // 에디터 처리
            $("#form_table_name").val(table_name); // 에디터 처리
            $("#is_secret").prop("disabled", false);

            let user_name = $("#user_name").val();

            var formData = new FormData( $("#form")[0] );
            formData.append("process_mode", process_mode);
            formData.append("user_name", user_name);

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
                    window.location.href="board.php?table_name="+table_name;
                } else {
                    toastr["error"](data.message);
                }
            });
        }



        $("#return_list").click(function() {
            window.location.href = `board.php?table_name=${table_name}`;
        });


        function fileUploadAdd(index) {
            let html = '';

            if ($(".file_row").length >= 3) {
                toastr["error"]("첨부파일은 3개 이하로 등록 가능합니다.");
                return false;
            }

            html = `
                <div class="file_row">
                    <div class="modal_file_place" style="display: none;">
                        <a href="#" class="btn btn-w-m btn-default"><i class="fa fa-download"></i> <span></span></a>
                        <button class="btn btn-danger btn-sm modal_btn_file_delete">파일 삭제</button>
                    </div>

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
                        <a href="#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput"><!-- Remove -->비우기</a>
                        `;
            if (index == 0) {
                html += `<span class="input-group-addon btn btn-success" onclick="fileUploadAdd()">+</span>`
            } else {
                html += `<span class="input-group-addon btn btn-danger fileUploadRemove">-</span>`;
            }
            html += `</div>
                    <!--<div class="hr-line-dashed"></div>-->
                </div>
        `

            $(".file_list").append(html);
        }

        function fileViewAdd(index) {
            let html = '';

            html = `
                <div class="file_row m-b-xs">
                    <div class="modal_view_file_place" style="display: none;">
                        <a href="#" class="btn btn-w-m btn-default"><i class="fa fa-download"></i> <span></span></a>
                    </div>
                </div>
        `
            $(".file_view_list").append(html);
        }

        $(document).on('click', '.fileUploadRemove', function() {
            $(this).parent().parent().remove();
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
                    console.log(result);
                    $("#page_title").text(result.table_title);

                    $("#secret_div").show();
                    if (result.secret_mode == 'N') {
                        $("#secret_div").hide();
                    }

                    $("#is_secret").prop("checked", false);
                    if (result.secret_mode == 'A') {
                        $("#is_secret").prop("checked", true);
                        $("#is_secret").prop("disabled", true);
                    }

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
                        'imageUpload',
                        'blockQuote',
                        '|',
                        'undo',
                        'redo'
                    ]
                },
                simpleUpload: {
                    uploadUrl: '/your_upload_endpoint', // 이미지 업로드를 처리할 서버 측 엔드포인트 URL
                }
            } )
            .then( newEditor => {
                editor = newEditor;
            } )
            .catch( error => {
                console.error( error );
            } );

        $(function() {

            pageSetting();
            fileUploadAdd(0);
        });

    </script>

<?php include "tail.php"; ?>