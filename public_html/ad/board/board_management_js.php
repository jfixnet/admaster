<script>
    function getParameterByName(name) {
        name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
        var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
            results = regex.exec(location.search);
        return results == null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
    }

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
                { data: "table_name", className: "text-center" },
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

    // 모달 저장
    $("#form").on("submit", function() {
        create();
        return false;
    });

    // 모달 저장
    function create() {

        let form_table_name =  $("#form_table_name").val();
        let process_mode = "create"; // 등록 모드
        if (form_table_name) {
            process_mode = "update"
        }

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


    $(document).ready(function() {
        let table_name = getParameterByName('table_name');

        $("#form_table_name").val(table_name);

        if (table_name) {
            // let params = "process_mode=view&table_name="+table_name;

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
                $("#memo").val(result.data.memo);
            });
        }

    });

    $("#return_list").click(function() {
        window.location.href = `/ad/board/board_management.php`;
    });

    $(function() {
        list(); // 목록
    });

</script>