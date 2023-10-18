<script>
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
                url: "/board/board_ajax.php",
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
                        let html = `<a class="article" href="board_view.php?table_name=${table_name}&idx=${row.idx}">${data}</a>`;
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
            searching: false,
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