<?php include_once $_SERVER['DOCUMENT_ROOT'] . "/include/config.php"; ?>

<?php include_once $_SERVER['DOCUMENT_ROOT'] . "/include/auth.php"; ?>

<?php include_once $_SERVER['DOCUMENT_ROOT'] . "/layout/header.php"; ?>

<?php include_once $_SERVER['DOCUMENT_ROOT'] . "/layout/nav_top.php"; ?>

<div class="wrapper wrapper-content">
    <div class="container">

        <div class="row mb-3">
            <span class="font-bold" style="font-size: 20px;" id="page_title"></span>
        </div>

        <div class="row mb-3">
            <div class="col-sm-12">
                <h2><span class="font-bold" id="title"></span></h2>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-sm-6">
                <span class="m-r-sm font-bold" id="user_name"></span> | <span id="create_date"></span> | <span id="view_count"></span>
            </div>
            <div class="col-sm-6 text-right" style="font-size: 15px;">
                <a id="return_list" class="m-r-sm" style="color:#676a6c" title="목록으로"><i class="fa fa-list"></i></a>
                <a id="update" class="m-r-sm" style="color:#676a6c" title="글수정"><i class="fa fa-pencil-square"></i></a>
                <a id="delete" class="m-r-sm" style="color:#676a6c" title="글삭제"><i class="fa fa-trash"></i></a>
            </div>
        </div>

        <hr>

        <div class="row mb-3">
            <div class="col-sm-12">
                <div class="" id="content" style="min-height: 200px;"></div>
            </div>
        </div>

        <div class="form-group">
            <label class="col-xs-2 control-label">첨부파일</label>
            <div class="col-xs-10">
                <div class="file_view_list">
                </div>
            </div>
        </div>

        <div id="comment_div" style="display: none;">

            <div class="div_comment_list">
                <button type="button" class="cmt_btn"><b>댓글</b><span id="comment_total">0</span><span class="cmt_more"></span></button>

                <div class="text-center" id="comment_list">
                    등록된 댓글이 없습니다
                </div>
            </div>

            <div class="div_comment_textarea">
                <div class="feed-activity-list">
                    <div class="feed-element mt-3" style="border-bottom: 0px;">
                        <div class="media-body">
                            <textarea form="form" class="form-control well" name="comment" id="comment" rows="2" placeholder="댓글내용을 입력해주세요."></textarea>
                            <div class="text-right">
                                <button form="form" type="button" class="btn btn-sm btn-success" id="btn_comment_save">댓글등록</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>

    <form id="form" name="form">
        <input type="hidden" id="idx" name="idx">
        <input type="hidden" id="form_table_name" name="form_table_name">
    </form>

</div>
<?php include_once $_SERVER['DOCUMENT_ROOT'] . "/page/board/board_view_js.php"; ?>

<?php include_once $_SERVER['DOCUMENT_ROOT'] . "/layout/footer.php"; ?>