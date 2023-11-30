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
                <button type="button" class="btn btn-primary btn-sm" id="board_write">글쓰기</button>
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
                        tbodyHtml += `<div class="col-sm-3 m-b-sm">
                                        <div class="gall_img" style="height:124px;max-height:124px">`;

                        let href = `board_view.php?table_name=${table_name}&idx=${val.idx}&type=v`;
                        if (val.is_secret == 'Y') {
                            if (isAdmin != 'Y') {
                                href = `board_password.php?table_name=${table_name}&idx=${val.idx}&type=s`;
                            }
                        }

                        tbodyHtml += `
                                        <a href="${href}" style="display: flex; justify-content: center;">
                                            <img src="${val.attach_file_url}" alt="" title="" style="display: block;height:124px;max-height:124px"></a>
                                        </div>
                                        <div class="gall_text_href">
                                            <a href="https://demo.sir.kr/gnuboard5/bbs/board.php?bo_table=gallery&amp;wr_id=680" class="bo_tit" style="color:black; text-decoration-line: none;">${val['title']}</a>
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

        function pageDisplayCount(fromRecord, remainingCounter, totalCount) {
            let first_record = fromRecord + 1;
            let last_record = fromRecord + 10
            if (remainingCounter < 10) {
                last_record = totalCount;
            }

            let pageUrl = `${first_record} - ${last_record} (총 ${totalCount} 건)`;

            return pageUrl;
        }

        function pageLink(curPage, totalPages, funName) {
            let pageUrl = "";

            let pageLimit = 5;
            let startPage = parseInt((curPage - 1) / pageLimit) * pageLimit + 1;
            let endPage = startPage + pageLimit - 1;

            if (totalPages < endPage) {
                endPage = totalPages;
            }

            // 이전 페이지
            if (curPage == 1) {
                pageUrl += `<li><a class=''>이전</a></li>`;
            } else {
                pageUrl += `<li><a class='' href='javascript:${funName}(${curPage} - 1);'>이전</a></li>`;
            }

            if (totalPages < 8) {
                for (let i = 1; i <= totalPages; i++) {
                    if (i == curPage) {
                        pageUrl += `<li><a href='#' class='paging-active'>${i}</a></li>`
                    } else {
                        pageUrl += `<li><a href='javascript:${funName}(${i});'>${i}</a></li>`;
                    }
                }
            } else {
                if (curPage <= 4) {
                    for (let i = 1; i <= 5; i++) {
                        if (i == curPage) {
                            pageUrl += `<li><a href='#' class='paging-active'>${i}</a></li>`
                        } else {
                            pageUrl += `<li><a href='javascript:${funName}(${i});'>${i}</a></li>`;
                        }
                    }

                    pageUrl += `<li><a class=''>...</a></li>`;
                } else {
                    pageUrl += `<li><a class='' href='javascript:${funName}(1);'>1</a></li>`;
                    pageUrl += `<li><a class=''>...</a></li>`;

                    if (curPage + 4 <= totalPages) {
                        for (let i = curPage - 1; i <= curPage + 1; i++) {
                            if (i == curPage) {
                                pageUrl += `<li><a href='#' class='paging-active'>${i}</a></li>`
                            } else {
                                pageUrl += `<li><a href='javascript:${funName}(${i});'>${i}</a></li>`;
                            }
                        }
                        pageUrl += `<li><a class=''>...</a></li>`;
                    } else {
                        for (let i = totalPages - 4; i <= totalPages - 1; i++) {
                            if (i == curPage) {
                                pageUrl += `<li><a href='#' class='paging-active'>${i}</a></li>`
                            } else {
                                pageUrl += `<li><a href='javascript:${funName}(${i});'>${i}</a></li>`;
                            }
                        }
                    }
                }

                if (curPage == totalPages) {
                    pageUrl += `<li><a class='paging-active' href='javascript:${funName}(${totalPages});'>${totalPages}</a></li>`;
                } else {
                    pageUrl += `<li><a class='' href='javascript:${funName}(${totalPages});'>${totalPages}</a></li>`;
                }
            }

            //다음 페이지
            if (curPage == totalPages) {
                pageUrl += `<li><a>다음</a></li>`;
            } else {
                pageUrl += `<li><a class='' href='javascript:${funName}(${curPage} + 1);'>다음</a></li>`;
            }

            return pageUrl;
        }

        $(function() {
            pageSetting();
            list();
        });

    </script>

<?php include_once "tail.php"; ?>