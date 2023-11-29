<?php include_once "../../include/config.php"; ?>

<?php include_once "../../include/auth.php"; ?>

<?php include_once "../../layout/header.php"; ?>

<?php include_once "../../layout/nav_top.php"; ?>

<div class="wrapper wrapper-content">

    <div class="container">

        <div class="row">
            <span class="font-bold" style="font-size: 20px;" id="page_title"></span>
        </div>
        
        <div class="row">
            <div class="col-sm-2 offset-sm-7">
                <select form="form_main" id="srch_key" name="srch_key" class="form-select form-control-sm">
                    <option value="title">제목</option>
                    <option value="user_name">작성자</option>
                </select>
            </div>

            <div class="col-sm-3">
                <div class="input-group">
                    <input form="form_main" type="text" id="srch_keyword" name="srch_keyword" placeholder="검색어" class="form-control form-control-sm" autocomplete="off">
                    <span class="input-group-btn">
                        <button form="form_main" type="button" class="btn btn-primary" id="search_btn"><i class="fa fa-search"></i></button>
                    </span>
                </div>
            </div>
        </div>

        <div class="table-responsive m-t-md m-b-md">
            <table id="dataTables_1" class="table table-striped table-bordered table-hover" style="width: 100%; height: auto;">
                <colgroup>
                    <col style="width: 100px">
                    <col style="">
                    <col style="width: 100px">
                    <col style="width: 100px">
                    <col style="width: 100px">
                </colgroup>
                <thead>
                <tr>
                    <th class="no_orderable text-center">번호</th>
                    <th class="no_orderable text-center">제목</th>
                    <th class="no_orderable text-center">작성자</th>
                    <th class="text-center">조회</th>
                    <th class="text-center">작성일</th>
                </tr>
                </thead>
            </table>
        </div>

        <div class="row write_setting" style="display: none;">
            <div class="col-xs-6 text-right">
                <button type="button" class="btn btn-primary btn-sm" id="board_write">글쓰기</button>
            </div>
        </div>

        </div>

    <form id="form_main" name="form_main">
        <input type="hidden" id="idx" name="idx">
    </form>

</div>

<?php include_once "../../page/board/board_js.php"; ?>

<?php include_once "../../layout/footer.php"; ?>