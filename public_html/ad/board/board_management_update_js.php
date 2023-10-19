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
            window.location.href="/ad/board/board_management.php"
            return false;
        }

        let process_mode = "update"

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

    function view(){

        $("#form_table_name").val(table_name);

        if (table_name) {

            $.ajax({
                type: 'POST',
                data: {
                    process_mode : 'view',
                    table_name : table_name
                },
                url: "/ad/board/board_management_ajax.php",
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
        window.location.href = `/ad/board/board_management.php`;
    });

    $(function() {
        view();
    });

</script>