<script>

    function list() {

        // 초기화
        $('#dataTables_1').DataTable({buttons: []}).destroy();
        $('#dataTables_1').DataTable({
            ajax: {
                type: "post",
                data: function() {
                    var param = $("#form_main").serializeObject();
                    param.process_mode = "list";
                    return param;
                },
                url: "/ad/board/board_management_ajax.php",
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
                        let html = `<a class="article" href="/page/board/board.php?table_name=${data}" target='_blank'>${data}</a>`;
                        return html;
                    }
                },
                { data: "table_title", className: "text-center" },
                { data: "memo", className: "text-left" },
                { data: "idx", className: "text-center",
                    render: function(data, type, row, meta) {
                        let html = `<button type='button' class='btn btn-default btn-xs btn_update' onclick="location.href='/ad/board/board_management_update.php?table_name=${row.table_name}'">수정</button>`;
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