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

    $("#write_password_check").click(function() {
       passwordCheck();
    });

    function passwordCheck() {
        let process_mode = 'password_check'
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
                setCookie('update_status', idx, 1);
                window.location.href = `/board/board_update.php?table_name=${table_name}&idx=${idx}`;
            } else {
                toastr["error"](result.message);
            }
        });
    }

    $(function() {

    });

</script>