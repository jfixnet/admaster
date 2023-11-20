<script>
    let userName = '<?=$_SESSION['user_name']?>';

    // $("#login_check_div").show();
    // if (userName) {
    //     $("#login_check_div").hide();
    // }

    function getParameterByName(name) {
        name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
        var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
            results = regex.exec(location.search);
        return results == null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
    }

    let table_name = getParameterByName('table_name');
    let idx = getParameterByName('idx');
    let type = getParameterByName('type');

    // 모달 저장
    $("#form").on("submit", function() {
        update();
        return false;
    });

    // 모달 저장
    function update() {
        let process_mode = "update"

        $("#content").val( $(".summernote").summernote("code") ); // 에디터 처리
        $("#idx").val( idx ); // 에디터 처리
        $("#form_table_name").val( table_name ); // 에디터 처리

        $("#is_secret").prop("disabled", false);

        var formData = new FormData( $("#form")[0] );
        formData.append("process_mode", process_mode);

        $.ajax({
            type: "post",
            // data: $("#form").serialize() + "&process_mode=" + process_mode+ "&table_name=" + table_name+ "&idx=" + idx,
            data: formData,
            processData: false, // 첨부파일 처리
            contentType: false, // 첨부파일 처리
            url: "/page/board/board_ajax.php",
            dataType: "json",
            cache: false,
            async: false,
        }).done(function(data) {
            if (data.status) {
                window.location.href="/board/board.php?table_name="+table_name;
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
            url: "/page/board/board_ajax.php",
            dataType: "json",
            cache: false,
            async: false,
        }).done(function(result) {
            if (result) {
                $("#user_name").val(result.user_name);
                $("#title").val(result.title);
                $(".summernote").summernote("code", result.content); // 에디터 처리

                $("#is_secret").prop("checked", false);
                if (result.is_secret == 'Y') {
                    $("#is_secret").prop("checked", true);
                }

                $("#update_btn").show();

                // 첨부파일 표시
                if (result.files.length > 0) {
                    result.files.forEach(function(item, index) {
                        if (item) {
                            fileUploadAdd(index);
                            $(".modal_file_place").eq( item.sort ).show();
                            $(".modal_file_place").eq( item.sort ).find("a").attr("href", "/lib/download.php?code=" + item.file_tmp_name);
                            $(".modal_file_place").eq( item.sort ).find("span").text(item.file_name);
                            $(".modal_file_place").eq( item.sort ).find("button").data({ code: item.file_tmp_name,  sort : item.sort });
                        }
                    })
                } else {
                    fileUploadAdd(0);
                }

            } else {
                toastr["error"](result.message);
            }
        });
    }

    $(document).ready(function() {

        var $summernote = $('.summernote').summernote({
            lang: 'ko-KR', // default: 'en-US'
            tabsize: 2,
            height: 200,
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'underline', 'clear']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['table', ['table']],
                ['insert', ['link', 'picture', 'video']],
                ['view', ['codeview', 'help']]
            ],
            // callbacks: {
            //     onImageUpload: function (files) {
            //         for (var i = 0; i < files.length; i++) {
            //             sendFile($summernote, files[i]);
            //         }
            //     }
            // }
        });

    });

    $("#return_list").click(function() {
        window.location.href = "/board/board.php?table_name="+table_name;
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

    // 첨부 파일 삭제
    $(document).on("click", ".modal_btn_file_delete", function() {

        if (confirm("삭제한 데이터는 복구가 불가능합니다.\r\n삭제하시겠습니까?")) {

            var code = $(this).data("code");
            var sort = $(this).data("sort");

            $.ajax({
                type: "post",
                data: "code=" + code + "&process_mode=delete_file",
                url: "/page/board/board_ajax.php",
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
            url: "/page/board/board_ajax.php",
            dataType: "json",
            cache: false,
            async: false,
        }).done(function(result) {
            if (result) {
                console.log(result);
                $("#page_title").text(result.table_title);

                if (result.secret_mode == 'A') {
                    $("#is_secret").prop("disabled", true);
                }

            } else {
                console.log('페이지 세팅 오류');
            }
        });
    }

    $(function() {

        if (type == 's') {
            if (!userName) {
                if (!getCookie('view_status') || getCookie('view_status') != idx){
                    window.location.href = `/board/board_password.php?table_name=${table_name}&idx=${idx}&type=v`;
                    return false;
                }
            }
        }

        deleteCookie('update_status');
        pageSetting();
        view();
    });

</script>