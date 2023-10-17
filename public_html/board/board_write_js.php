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

    $(function() {

    });

</script>