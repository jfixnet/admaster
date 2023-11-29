<script>
    let isAdmin = '<?=$_SESSION['is_admin']?>';

    console.log(isAdmin);
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
                url: "/page/board/board_ajax.php",
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

                        let href = `/page/board/board_view.php?table_name=${table_name}&idx=${row.idx}&type=v`;
                        if (row.is_secret == 'Y') {
                            if (isAdmin != 'Y') {
                                href = `/page/board/board_password.php?table_name=${table_name}&idx=${row.idx}&type=s`;
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
            url: "/page/board/board_ajax.php",
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
        window.location.href = "/page/board/board_write.php?table_name="+table_name;
    });

    $(function() {
        pageSetting();
        list();
    });

</script>