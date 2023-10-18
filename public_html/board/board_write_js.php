<script>
    let userName = '<?=$_SESSION['user_name']?>';

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

    // 모달 저장
    $("#form").on("submit", function() {
        create();
        return false;
    });

    // 모달 저장
    function create() {
        let process_mode = "create"; // 등록 모드

        $("#content").val( $(".summernote").summernote("code") ); // 에디터 처리
        $("#idx").val( idx ); // 에디터 처리
        $("#form_table_name").val( table_name ); // 에디터 처리
        let user_name = $("#user_name").val();

        var formData = new FormData( $("#form")[0] );
        formData.append("process_mode", process_mode);
        formData.append("user_name", user_name);

        $.ajax({
            type: "post",
            // data: $("#form").serialize() + "&process_mode=" + process_mode+ "&table_name=" + table_name+ "&idx=" + idx,
            data: formData,
            processData: false, // 첨부파일 처리
            contentType: false, // 첨부파일 처리
            url: "/board/board_ajax.php",
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
            callbacks: {
                onImageUpload: function (files) {
                    for (var i = 0; i < files.length; i++) {
                        sendFile($summernote, files[i]);
                    }
                }
            }
        });

    });

    $("#return_list").click(function() {
        window.location.href = `/board/board.php?table_name=${table_name}`;
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


    $(function() {

        fileUploadAdd(0);
    });

</script>