<?php include "../lib/config.php"; ?>

<?php include "../lib/auth.php"; ?>

<?php include "head.php"; ?>

<?php include "nav_top.php"; ?>

<div class="wrapper wrapper-content">
    <div class="container">

        <div class="row mb-3">
            <span class="font-bold" style="font-size: 20px;" id="page_title"></span>
        </div>

        <div class="row mb-3">
            <div class="col-sm-12">
                <h2><span class="font-bold" id="title"></span></h2>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-sm-6">
                <span class="m-r-sm font-bold" id="user_name"></span> | <span id="create_date"></span> | <span id="view_count"></span>
            </div>
            <div class="col-sm-6 text-right" style="font-size: 15px;">
                <a id="return_list" class="m-r-sm" style="color:#676a6c" title="목록으로"><i class="fa fa-list"></i></a>
                <a id="update" class="m-r-sm" style="color:#676a6c" title="글수정"><i class="fa fa-pencil-square"></i></a>
                <a id="delete" class="m-r-sm" style="color:#676a6c" title="글삭제"><i class="fa fa-trash"></i></a>
            </div>
        </div>

        <hr>

        <div class="row mb-3">
            <div class="col-sm-12">
                <div class="" id="image_view"></div>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-sm-12">
                <div class="" id="content" style="min-height: 200px;"></div>
            </div>
        </div>

        <div class="form-group file_div" style="display: none;">
            <label class="col-xs-2 control-label">첨부파일</label>
            <div class="col-xs-10">
                <div class="file_view_list">
                </div>
            </div>
        </div>

        <div id="comment_div" style="display: none;">

            <div class="div_comment_list">
                <button type="button" class="cmt_btn"><b>댓글</b><span id="comment_total">0</span><span class="cmt_more"></span></button>

                <div class="text-center" id="comment_list">
                    등록된 댓글이 없습니다
                </div>
            </div>

            <div class="div_comment_textarea">
                <div class="feed-activity-list">
                    <div class="feed-element mt-3" style="border-bottom: 0px;">
                        <div class="media-body">
                            <textarea form="form" class="form-control well" name="comment" id="comment" rows="2" placeholder="댓글내용을 입력해주세요."></textarea>
                            <div class="text-right">
                                <button form="form" type="button" class="btn btn-sm btn-success" id="btn_comment_save">댓글등록</button>
                            </div>
                        </div>
                    </div>
                </div>
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
        let skin = getParameterByName('skin');

        function view() {
            let process_mode = 'view'

            $.ajax({
                type: "post",
                data: $("#form").serialize() + "&process_mode=" + process_mode+ "&table_name=" + table_name+ "&idx=" + idx,
                url: "../lib/board_ajax.php",
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
                        $(".file_div").show();

                        result.files.forEach(function(item, index) {
                            if (item) {
                                fileViewAdd(index);
                                $(".modal_view_file_place").eq( index ).show();
                                $(".modal_view_file_place").eq( index ).find("a").attr("href", "../lib/download.php?code=" + item.file_tmp_name);
                                $(".modal_view_file_place").eq( index ).find("span").text(item.file_name);
                                $(".modal_view_file_place").eq( index ).find("button").data({ code: item.file_tmp_name,  sort : index });
                            }
                        })
                    }

                    // 이미지 표시
                    if (result.img_url.length > 0) {
                        let html = '';
                        result.img_url.forEach(function(item, index) {
                            if (item) {
                                html += `
                                    <div class="row m-b-xs">
                                        <div class="col-sm-12">
                                            <img src="${item}" alt="" title="" style="max-height: 200px;">
                                        </div>
                                    </div>
                                `;
                            }
                        });

                        html += `<hr>`;

                        $("#image_view").append(html);
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
                url: "../lib/board_ajax.php",
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
            if (skin == 'gallery') {
                window.location.href = `board_g.php?table_name=${table_name}`;
            } else {
                window.location.href = `board.php?table_name=${table_name}`;
            }
            return false;
        });

        $("#update").click(function() {
            if (isAdmin == 'Y') {
                window.location.href = `board_update.php?table_name=${table_name}&idx=${idx}&skin=${skin}`;
            } else {
                window.location.href = `board_password.php?table_name=${table_name}&idx=${idx}&skin=${skin}`;
            }
            return false;
        });

        $("#delete").click(function() {
            if (isAdmin == 'Y') {
                deleteBoard();
                return false;
            }
            window.location.href = `board_password.php?table_name=${table_name}&idx=${idx}&type=d&skin=${skin}`;
            return false;
        });

        function deleteBoard(){
            if (confirm("삭제한 데이터는 복구가 불가능합니다.\r\n삭제하시겠습니까?")) {

                $.ajax({
                    type: "post",
                    data: $("#form").serialize() + "&process_mode=delete"+ "&table_name=" + table_name+ "&idx=" + idx,
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

        function commentAdd(comment_idx, user_name, comment, datetime, delete_auth) {
            let html = `
                    <div class="row m-t-md">
                        <div class="col-sm-2 text-left">
                            <strong>${user_name}</strong>
                        </div>
                        <div class="col-sm-7 text-left">
                            <div class="well">${comment}</div>
                        </div>
                        <div class="col-sm-3 text-right">
                            <small class="text-muted m-r-sm">${datetime}</small>`;
            if (delete_auth == 'Y') {
                html += `<button type="button" class="btn btn-xs btn-danger" onclick="commentDelete(${comment_idx})">삭제</button>`;
            }

            html +=`
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
                url: "../lib/board_ajax.php",
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
                url: "../lib/board_ajax.php",
                dataType: 'json',
                cache: false,
                async: false,
            }).done(function(result) {

                $("#comment_list").empty();
                $("#comment").val('');
                if (result) {
                    $.each(result, function(key, val) {
                        commentAdd(val.idx, val.user_name, val.comment, val.create_date, val.delete_auth);
                    });
                    $("#comment_total").text(result.length);
                } else {
                    let html = `<div class="text-center" style="padding: 80px 0 !important">등록된 댓글이 없습니다</div>`;
                    $("#comment_total").text(0);
                    $("#comment_list").append(html);
                }
            });
        }

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
                    $("#page_title").text(result.data.table_title);

                    $("#comment_div").hide();
                    if (result.data.comment_mode == 'Y') {
                        $("#comment_div").show();
                        $(".div_comment_textarea").show();
                    }

                    if (!isAdmin || isAdmin == 'N') {
                        $(".div_comment_textarea").hide();
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
                        window.location.href = `board_password.php?table_name=${table_name}&idx=${idx}&type=v`;
                        return false;
                    }
                }
            }

            pageSetting();
            view();

            deleteCookie('view_status');
        });

    </script>

<?php include "tail.php"; ?>