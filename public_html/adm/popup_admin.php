<?php include "../lib/config.php"; ?>

<?php include "../lib/auth.php"; ?>

<?php include "head.php"; ?>

<?php include "nav_top.php"; ?>

<div class="container mt-5">

    <div class="table-responsive m-t-md m-b-md">
        <table id="dataTables_1" class="table table-striped table-bordered table-hover" style="width: 100%; height: auto;">
            <colgroup>
                <col style="">
                <col style="width: 200px">
                <col style="width: 200px">
                <col style="width: 200px">
                <col style="width: 100px">
            </colgroup>
            <thead>
            <tr>
                <th class="text-center">팝업 제목</th>
                <th class="text-center">시작일</th>
                <th class="text-center">종료일</th>
                <th class="text-center">상태</th>
                <th class="no_orderable">관리</th>
            </tr>
            </thead>
        </table>
    </div>

    <div class="row">
        <div class="col-xs-6 text-right">
            <button type="button" class="btn btn-success btn-sm" onclick="location.href='popup_admin_write.php'">등록</button>
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
                    param.process_mode = "popup_list";
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
                { data: "popup_title", className: "text-center" ,
                    render: function(data, type, row, meta) {
                        let html = `<a class="article" href="../main/board.php?table_name=${data}" target='_blank'>${data}</a>`;
                        return html;
                    }
                },
                { data: "start_date", className: "text-center" },
                { data: "end_date", className: "text-center" },
                { data: "status", className: "text-center"  ,
                    render: function(data, type, row, meta) {
                        return data == 'Y' ? '활성' : '비활성';
                    }
                },
                { data: "idx", className: "text-center",
                    render: function(data, type, row, meta) {
                        let html = `<button type='button' class='btn btn-default btn-xs btn_update' onclick="location.href='popup_admin_update.php?idx=${row.idx}'">수정</button>
                                    <button type='button' class='btn btn-danger btn-xs btn_delete' data-idx='${data}'>삭제</button>`;
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

    $(document).on("click", ".btn_delete", function() {

        if (confirm("삭제한 데이터는 복구가 불가능합니다.\r\n삭제하시겠습니까?")) {

            var idx = $(this).data("idx");
            $("#idx").val( idx ); // 삭제를 위한 번호 지정

            $.ajax({
                type: "post",
                data: $("#form_main").serialize() + "&process_mode=popup_delete",
                url: "../lib/admin_ajax.php",
                dataType: "json",
                cache: false,
                async: false,
            }).done(function(data) {

                $("#idx").val(""); // 안전을 위해 비워두기

                if (data.status) {
                    list();
                    alert(data.message);
                } else {
                    alert(data.message);
                }
            });
        }
    });


    $(function() {
        list(); // 목록
    });

</script>
