<script>
    function getParameterByName(name) {
        name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
        var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
            results = regex.exec(location.search);
        return results == null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
    }

    let table_name = getParameterByName('table_name');

    $("#form_main").on("submit", function() {
        list();
        return false;
    });

    function list() {

        // 초기화
        $('#dataTables_1').DataTable({buttons: []}).destroy();
        $('#dataTables_1').DataTable({
            ajax: {
                type: "post",
                data: function() {
                    var param = $("#form_main").serializeObject();
                    param.process_mode = "list";
                    param.table_name = table_name;
                    return param;
                },
                url: "/board/board_ajax.php",
                dataType: "json",
                processing: true,
                serverSide: true,
                cache: false,
                async: false,
                dataSrc: '',
            },
            createdRow: function (row, data, index) { },
            drawCallback: function(settings, json) { },
            columns: [
                { data: "no", className: "text-center" },
                { data: "title", className: "text-left" ,  render: function(data, type, row, meta) {
                        let html = `<a class="article" href="board_view.php?table_name=${table_name}&idx=${row.idx}">${data}</a>`;
                        return html;
                    }
                },
                { data: "user_name", className: "text-center" },
                { data: "create_date", className: "text-center",  render: function(data, type, row, meta) {
                        let html = data.slice(0,10);
                        return html;
                    }
                },
            ],
            pageLength: 10,
            lengthChange: false,
            searching: false,
            lengthMenu:[ [10,15,25,50,100, -1],[10,15,25,50,100, "ALL"] ],
            // dom: 't<"pull-left"i><"pull-center"p>',
            buttons: []
        });
    }

    $(document).ready(function() {
        $("#board_write").click(function() {
            window.location.href = "/board/board_write.php?table_name="+table_name;
        });
    });

    $(function() {
        list(); // 목록
    });

</script>