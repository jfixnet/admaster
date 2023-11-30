<?php include "../lib/config.php"; ?>

<?php include "../lib/auth.php"; ?>

<?php include "head.php"; ?>

<?php include "nav_top.php"; ?>

<div class="container mt-5">

    <div class="table-responsive m-t-md m-b-md">
        <table id="dataTables_1" class="table table-striped table-bordered table-hover" style="width: 100%; height: auto;">
            <colgroup>
                <col style="width: 400px">
                <col style="width: 400px">
                <col style="">
                <col style="width: 100px">
            </colgroup>
            <thead>
            <tr>
                <th class="text-center">테이블</th>
                <th class="text-center">게시판 제목</th>
                <th class="text-center">설명</th>
                <th class="no_orderable">관리</th>
            </tr>
            </thead>
        </table>
    </div>

    <div class="row">
        <div class="col-xs-6 text-right">
            <button type="button" class="btn btn-primary btn-sm" onclick="location.href='board_admin_write.php'">등록</button>
        </div>
    </div>

</div>

<form id="form_main" name="form_main">
    <input type="hidden" id="idx" name="idx">
</form>

<script>

    function list() {

        // 초기화
        $('#dataTables_1').DataTable({buttons: []}).destroy();
        $('#dataTables_1').DataTable({
            ajax: {
                type: "post",
                data: function() {
                    var param = $("#form_main").serializeObject();
                    param.process_mode = "board_list";
                    return param;
                },
                url: "../lib/admin_ajax.php",
                dataType: "json",
                cache: false,
                async: false,
                dataSrc: '',
            },
            createdRow: function (row, data, index) { },
            drawCallback: function(settings, json) { },
            columns: [
                { data: "table_name", className: "text-center" ,
                    render: function(data, type, row, meta) {
                        let html = `<a class="article" href="../main/board.php?table_name=${data}" target='_blank'>${data}</a>`;
                        return html;
                    }
                },
                { data: "table_title", className: "text-center" },
                { data: "memo", className: "text-left" },
                { data: "idx", className: "text-center",
                    render: function(data, type, row, meta) {
                        let html = `<button type='button' class='btn btn-default btn-xs btn_update' onclick="location.href='board_admin_update.php?table_name=${row.table_name}'">수정</button>`;
                        return html;
                    }
                },
            ],
            pageLength: 15,
            lengthChange: false,
            searching: false,
            lengthMenu:[ [10,15,25,50,100, -1],[10,15,25,50,100, "ALL"] ],
            // dom: 't<"pull-left"i><"pull-center"p>',
            buttons: []
        });
    }

    $(function() {
        list(); // 목록
    });

</script>
