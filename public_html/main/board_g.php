<?php include "../lib/config.php"; ?>

<?php include "../lib/auth.php"; ?>

<?php include "head.php"; ?>

<?php include "nav_top.php"; ?>

<link href="css/paging.css" rel="stylesheet">

<div class="wrapper wrapper-content">

    <div class="container">

        <div class="row m-b-lg" id="gallery_content">

        </div>

        <div class="row paging-wrap">
            <ul id="pagination"></ul>
        </div>

        <div class="row write_setting" style="display: none;">
            <div class="col-xs-6 text-right">
                <button type="button" class="btn btn-success btn-sm" id="board_write">글쓰기</button>
            </div>
        </div>

    </div>

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

        function list(num) {

            let curPage = num;
            if (!num) {
                curPage = 1;
            }
            let pageSize = 12;
            let tbodyHtml = `<tr><td colspan="12" class="text-center">데이터가 없습니다.</td></tr>`;

            $.ajax({
                type: "post",
                data: $("#form").serialize() + "&process_mode=gallery_list&table_name=" + table_name + "&page="+curPage + "&sort_column="+sortColumn+ "&sort_type="+sortType,
                url: "../lib/board_ajax.php",
                dataType: "json",
                cache: false,
                async: false,
            }).done(function(result) {
                let listData = result.data
                let pagingData = result.paging

                if (pagingData.total_count != 0) {
                    tbodyHtml = '';

                    $.each(result.data, function(key, val) {
                        let title = truncateString(val['title'], 20);

                        tbodyHtml += `<div class="col-sm-3 m-b-sm">
                                        <div class="gall_img" style="height:124px;max-height:124px">`;

                        let href = `board_view.php?table_name=${table_name}&idx=${val.idx}&type=v&skin=gallery`;
                        if (val.is_secret == 'Y' && isAdmin != 'Y') {
                            href = `board_password.php?table_name=${table_name}&idx=${val.idx}&type=s&skin=gallery`;
                        }

                        tbodyHtml += `
                                        <a href="${href}" style="display: flex; justify-content: center;">
                                            <img src="${val.attach_file_url}" alt="" title="" style="display: block;max-height:124px; max-width: 210px;"></a>
                                        </div>
                                        <div class="gall_text_href">
                                            <a href="${href}" class="bo_tit" style="color:black; text-decoration-line: none;">${title}</a>
                                        </div>
                                    </div>`;
                    });

                    let totalCount = pagingData.total_count;
                    let fromRecord = pagingData.from_record;
                    let remainingCounter = pagingData.counter;
                    let totalPages = Math.ceil(totalCount / pageSize);

                    let htmlDisplayCount = pageDisplayCount(fromRecord, remainingCounter, totalCount );
                    $("#displayCount").html(htmlDisplayCount);

                    let htmlStr = pageLink(curPage, totalPages, "list");
                    $("#pagination").html(htmlStr);
                }

                $("#gallery_content").html(tbodyHtml);

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
                    console.log(isAdmin)
                    if (result.data.admin_only == 'N' || isAdmin == 'Y') {
                        $(".write_setting").show();
                    }
                } else {
                    toastr["error"](result.message);
                    document.location.href = result.redirect;
                }
            });
        }

        $("#board_write").click(function() {
            window.location.href = "board_write.php?table_name="+table_name+"&skin=gallery";
        });

        $(function() {
            pageSetting();
            list();
        });

    </script>

<?php include_once "tail.php"; ?>