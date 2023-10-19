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
        create();
        return false;
    });

    // 모달 저장
    function create() {

        let form_table_name =  $("#form_table_name").val();
        let process_mode = "create"; // 등록 모드
        if (form_table_name) {
            process_mode = "update"
        }

        $.ajax({
            type: "post",
            data: $("#form").serialize() + "&process_mode=" + process_mode,
            url: "/ad/board/board_management_ajax.php",
            dataType: "json",
            cache: false,
            async: false,
        }).done(function(data) {
            if (data.status) {
                let alertText = '생성'
                if (process_mode == 'update') {
                    alertText = '수정'
                }
                alert('게시판이 '+ alertText + '되었습니다.');
                window.location.href="/ad/board/board_management.php"
            } else {
                toastr["error"](data.message);
            }
        });
    }

    $("#return_list").click(function() {
        window.location.href = `/ad/board/board_management.php`;
    });

    $(function() {

    });

</script>