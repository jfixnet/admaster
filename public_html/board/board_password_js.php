<script>
    let userName = '<?=$_SESSION['user_name']?>';

    function getParameterByName(name) {
        name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
        var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
            results = regex.exec(location.search);
        return results == null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
    }

    let table_name = getParameterByName('table_name');
    let idx = getParameterByName('idx');
    let type = getParameterByName('type');

    $("#write_password_check").click(function() {
       boardPasswordCheck();
    });

    function boardPasswordCheck() {
        let process_mode = 'board_password_check'
        let write_password = $("#write_password").val();

        $.ajax({
            type: "post",
            data: {
                process_mode : process_mode,
                table_name : table_name,
                idx : idx,
                write_password: write_password,
            },
            url: "/board/board_ajax.php",
            dataType: "json",
            cache: false,
            async: false,
        }).done(function(result) {
            if (result.status == true) {

                if (type == 's') {
                    setCookie('view_status', idx, 1);
                    window.location.href = `/board/board_view.php?table_name=${table_name}&idx=${idx}`;
                    return false;
                } else if (type == 'd'){
                    deleteBoard();
                    return false;
                }

                setCookie('update_status', idx, 1);
                window.location.href = `/board/board_update.php?table_name=${table_name}&idx=${idx}`;
            } else {
                toastr["error"](result.message);
            }
        });
    }

    function deleteBoard(){
        $.ajax({
            type: "post",
            data: $("#form").serialize() + "&process_mode=delete"+ "&table_name=" + table_name+ "&idx=" + idx,
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

    $(function() {
        let titleText = '';
        let bodyText = '';
        if (type == 's') {
            titleText = '비밀글 기능으로 보호된 글입니다.';
            bodyText = '작성자 본인이라면, 글 작성시 입력한 비밀번호를 입력하여 글을 삭제할 수 있습니다.';
        } else if (type == 'd') {
            titleText = '작성자만 글을 삭제할 수 있습니다.';
            bodyText = '비밀번호를 입력해주세요.';
        } else {
            titleText = '작성자만 글을 수정할 수 있습니다.';
            bodyText = '비밀번호를 입력해주세요.';
        }
        $("#password_title_text").text(titleText);
        $("#password_body_text").text(bodyText);
    });

</script>