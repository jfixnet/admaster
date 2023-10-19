<script>
    let userName = '<?=$_SESSION['user_name']?>';
    let userCode = '<?=$_SESSION['user_code']?>';
    let isAdmin = '<?=$_SESSION['is_admin']?>';

    function getParameterByName(name) {
        name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
        var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
            results = regex.exec(location.search);
        return results == null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
    }

    let table_name = getParameterByName('table_name');
    let idx = getParameterByName('idx');
    let type = getParameterByName('type');

    function view() {
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

                commentList(table_name, idx);
            } else {
                toastr["error"](result.message);
            }
        });
    }

    $("#btn_comment_save").click(function() {
        commentCreate();
    });

    function commentCreate(){
        let process_mode = 'comment_create'
        let comment = $("#comment").val();

        $.ajax({
            type: "post",
            data: $("#form").serialize() + "&process_mode=" + process_mode + "&table_name=" + table_name + "&idx=" + idx + "&user_name=" + userName + "&comment=" + comment,
            url: "/board/board_ajax.php",
            dataType: "json",
            cache: false,
            async: false,
        }).done(function(result) {
            if (result.status) {
                commentList(table_name, idx)
            } else {
                toastr["error"](result.message);
            }
        });
    }

    $("#return_list").click(function() {
        window.location.href = "/board/board.php?table_name="+table_name;
        return false;
    });

    $("#update").click(function() {
        if (isAdmin) {
            window.location.href = `/board/board_update.php?table_name=${table_name}&idx=${idx}`;
        } else {
            window.location.href = `/board/board_password.php?table_name=${table_name}&idx=${idx}`;
        }
        return false;
    });

    $("#delete").click(function() {
        if (isAdmin) {
            deleteBoard();
            return false;
        }
        window.location.href = `/board/board_password.php?table_name=${table_name}&idx=${idx}&type=d`;
        return false;
    });

    function deleteBoard(){
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

    function commentAdd(comment_idx, user_name, comment, datetime) {
        let html = `
                    <div class="row m-t-md">
                        <div class="col-sm-2 text-left">
                            <strong>${user_name}</strong>
                        </div>
                        <div class="col-sm-7 text-left">
                            <div class="well">${comment}</div>
                        </div>
                        <div class="col-sm-3 text-right">
                            <small class="text-muted m-r-sm">${datetime}</small>
                            <button type="button" class="btn btn-xs btn-danger" onclick="commentDelete(${comment_idx})">삭제</button>
                        </div>
                    </div>
                    <hr style="border-bottom: 1px solid #f4f4f4;">
        `;

        $("#comment_list").append(html);
    }

    // 의견 삭제
    function commentDelete(comment_idx) {
        $.ajax({
            type: "POST",
            data: {
                process_mode: 'comment_delete',
                idx: comment_idx
            },
            url: "/board/board_ajax.php",
            dataType: 'json',
            cache: false,
            async: false,
        }).done(function (result) {
            if (result.status) {
                commentList(table_name, idx)
            } else {
                toastr["error"](result.message,'오류');
            }
        });
    }

    function commentList(table_name, idx) {

        let process_mode = 'comment_list'

        $.ajax({
            type: "GET",
            data: {
                process_mode : process_mode,
                table_name : table_name,
                idx : idx,
            },
            url: "/board/board_ajax.php",
            dataType: 'json',
            cache: false,
            async: false,
        }).done(function(result) {

            $("#comment_list").empty();
            $("#comment").val('');
            if (result) {
                $.each(result, function(key, val) {
                    commentAdd(val.idx, val.user_name, val.comment, val.create_date);
                });
                $("#comment_total").text(result.length);
            } else {
                let html = `<div class="text-center" style="padding: 80px 0 !important">등록된 댓글이 없습니다</div>`;
                $("#comment_list").append(html);
            }
        });
    }

    function pageSetting() {
        let process_mode = 'page_setting'

        $.ajax({
            type: "post",
            data: $("#form").serialize() + "&process_mode=" + process_mode+ "&table_name=" + table_name,
            url: "/board/board_ajax.php",
            dataType: "json",
            cache: false,
            async: false,
        }).done(function(result) {
            if (result) {
                console.log(result);
                $("#page_title").text(result.table_title);

                $("#comment_div").hide();
                if (result.comment_mode == 'Y') {
                    $("#comment_div").show();
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

        pageSetting();
        view();

        deleteCookie('view_status');
    });

</script>