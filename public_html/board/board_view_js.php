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

    function list() {
        let process_mode = 'view'

        $.ajax({
            type: "post",
            data: $("#form").serialize() + "&process_mode=" + process_mode+ "&table_name=" + table_name+ "&idx=" + idx,
            url: "/board/board_ajax.php",
            dataType: "json",
            cache: false,
            async: false,
        }).done(function(result) {
            if (result) {
                $("#title").text(result.title);
                $("#content").html( result.content );
                $("#user_name").text(result.user_name);
                $("#create_date").text(result.create_date);
                $("#view_count").text('조회 '+ result.view_count);

                // 첨부파일 표시
                if (result.files.length > 0) {
                    result.files.forEach(function(item, index) {
                        if (item) {
                            fileViewAdd(index);
                            $(".modal_view_file_place").eq( item.sort ).show();
                            $(".modal_view_file_place").eq( item.sort ).find("a").attr("href", "/lib/download.php?code=" + item.file_tmp_name);
                            $(".modal_view_file_place").eq( item.sort ).find("span").text(item.file_name);
                            $(".modal_view_file_place").eq( item.sort ).find("button").data({ code: item.file_tmp_name,  sort : item.sort });
                        }
                    })
                }

            } else {
                toastr["error"](result.message);
            }
        });
    }

    $(document).ready(function() {

        $("#return_list").click(function() {
            window.location.href = "/board/board.php?table_name="+table_name;
        });

        $("#update").click(function() {
            if (userName) {
                window.location.href = `/board/board_update.php?table_name=${table_name}&idx=${idx}`;
            } else {
                window.location.href = `/board/board_password.php?table_name=${table_name}&idx=${idx}`;
            }

        });

        $("#delete").click(function() {

            if (confirm("삭제한 데이터는 복구가 불가능합니다.\r\n삭제하시겠습니까?")) {

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
        });

    });

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

    $(function() {
        list();
    });

</script>