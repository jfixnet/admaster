<?php include "../lib/config.php"; ?>

<?php include "../lib/auth.php"; ?>

<?php include "head.php"; ?>

<?php include "nav_top.php"; ?>

<div class="wrapper wrapper-content">

    <div class="container">

        <div class="row">
            <span class="font-bold" style="font-size: 20px;" id="page_title"></span>
        </div>
        
        <div class="row">
            <div class="col-sm-2 offset-sm-7">
                <select form="form_main" id="srch_key" name="srch_key" class="form-select form-control-sm">
                    <option value="title">제목</option>
                    <option value="user_name">작성자</option>
                </select>
            </div>

            <div class="col-sm-3">
                <div class="input-group">
                    <input form="form_main" type="text" id="srch_keyword" name="srch_keyword" placeholder="검색어" class="form-control form-control-sm" autocomplete="off">
                    <span class="input-group-btn">
                        <button form="form_main" type="button" class="btn btn-primary" id="search_btn"><i class="fa fa-search"></i></button>
                    </span>
                </div>
            </div>
        </div>

        <div class="table-responsive m-t-md m-b-md">
            <table id="dataTables_1" class="table table-striped table-bordered table-hover" style="width: 100%; height: auto;">
                <colgroup>
                    <col style="width: 100px">
                    <col style="">
                    <col style="width: 100px">
                    <col style="width: 100px">
                    <col style="width: 100px">
                </colgroup>
                <thead>
                <tr>
                    <th class="no_orderable text-center">번호</th>
                    <th class="no_orderable text-center">제목</th>
                    <th class="no_orderable text-center">작성자</th>
                    <th class="text-center">조회</th>
                    <th class="text-center">작성일</th>
                </tr>
                </thead>
            </table>
        </div>

        <div class="row write_setting" style="display: none;">
            <div class="col-xs-6 text-right">
                <button type="button" class="btn btn-primary btn-sm" id="board_write">글쓰기</button>
            </div>
        </div>

        </div>

    <form id="form_main" name="form_main">
        <input type="hidden" id="idx" name="idx">
    </form>

</div>

    <script>
        let isAdmin = '<?=$_SESSION['is_admin']?>';
        
        function getParameterByName(name) {
            name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
            var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
                results = regex.exec(location.search);
            return results == null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
        }

        let table_name = getParameterByName('table_name');

        $("#search_btn").on("click", function () {
            list();
        });

        function list() {
            let srch_key = $("#srch_key").val();
            let srch_keyword = $("#srch_keyword").val();

            $('#dataTables_1').DataTable({buttons: []}).destroy();
            new DataTable('#dataTables_1', {
                ajax: {
                    data : {
                        process_mode : 'list',
                        table_name : table_name,
                        srch_key : srch_key,
                        srch_keyword : srch_keyword,
                    },
                    url: "../lib/board_ajax.php",
                    dataType: "json",
                },
                processing: true,
                serverSide: true,
                columns: [
                    { data: "no", className: "text-center", render:function (data, type, row, meta) {
                            // return meta.row + meta.settings._iDisplayStart + 1;
                            // return meta.settings._iDisplayStart;
                            // return meta.row;
                            return meta.settings._iRecordsTotal - meta.settings._iDisplayStart - meta.row;
                        }},
                    { data: "title", className: "text-left" ,  render: function(data, type, row, meta) {
                            let secret_icon = ``;
                            let comment_icon = ``;
                            if (row.is_secret == "Y") {
                                secret_icon = `&nbsp&nbsp<i class="fa fa-lock"></i>`;
                            }
                            if (row.comment_count && row.comment_count > 0) {
                                comment_icon = `&nbsp<span style="color: red; font-weight: bold;">[${row.comment_count}]</span>`;
                            }

                            let href = `board_view.php?table_name=${table_name}&idx=${row.idx}&type=v`;
                            if (row.is_secret == 'Y') {
                                if (isAdmin != 'Y') {
                                    href = `board_password.php?table_name=${table_name}&idx=${row.idx}&type=s`;
                                }
                            }
                            let html = `<a class="article" href="${href}">${data} ${secret_icon} ${comment_icon}</a>`;

                            return html;
                        }
                    },
                    { data: "user_name", className: "text-center" },
                    { data: "view_count", className: "text-center" },
                    { data: "create_date", className: "text-center",  render: function(data, type, row, meta) {
                            let html = data.slice(0,10);
                            return html;
                        }},
                ],
                pageLength: 15,
                searching: false,
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
                if (result.status) {
                    $("#page_title").text(result.data.table_title);
                    if (result.data.admin_only == 'N' || isAdmin) {
                        $(".write_setting").show();
                    }
                } else {
                    toastr["error"](result.message);
                    document.location.href = result.redirect;
                }
            });
        }

        $("#board_write").click(function() {
            window.location.href = "board_write.php?table_name="+table_name;
        });

        $(function() {
            pageSetting();
            list();
        });

    </script>

<?php include_once "tail.php"; ?>