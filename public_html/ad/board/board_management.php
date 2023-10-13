<?php include_once $_SERVER['DOCUMENT_ROOT'] . "/include/default.php"; ?>

<?php include_once $_SERVER['DOCUMENT_ROOT'] . "/layout/header.php"; ?>

<?php include_once $_SERVER['DOCUMENT_ROOT'] . "/layout/ad_nav_top.php"; ?>

<div class="container">

    <div class="table-responsive m-t-md m-b-md">
        <table id="dataTables_1" class="table table-striped table-bordered table-hover" style="width: 100%; height: auto;">
            <colgroup>
                <col style="width: 400px">
                <col style="">
                <col style="width: 100px">
            </colgroup>
            <thead>
            <tr>
                <th class="text-center">테이블명</th>
                <th class="text-center">설명</th>
                <th class="no_orderable">관리</th>
            </tr>
            </thead>
        </table>
    </div>

    <div class="row">
        <div class="col-xs-6 text-right">
            <button type="button" class="btn btn-primary btn-sm" onclick="location.href='/ad/board/board_management_write.php'">등록</button>
        </div>
    </div>

</div>

<form id="form_main" name="form_main">
    <input type="hidden" id="idx" name="idx">
</form>


<?php include_once $_SERVER['DOCUMENT_ROOT'] . "/ad/board/board_management_js.php"; ?>
