<?php include_once $_SERVER['DOCUMENT_ROOT'] . "/include/default.php"; ?>

<?php include_once $_SERVER['DOCUMENT_ROOT'] . "/layout/header.php"; ?>

<?php include_once $_SERVER['DOCUMENT_ROOT'] . "/layout/ad_nav_top.php"; ?>

<div class="container mt-5">

    <div class="row">
        <div class="col-sm-3 offset-sm-9">
            <div class="input-group">
                <input type="text" form="form_main" class="form-control form-control-sm" id="srch_start_date" name="srch_start_date" autocomplete="off" required>
                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                <input type="text" form="form_main" class="form-control form-control-sm" id="srch_end_date" name="srch_end_date" autocomplete="off" required>
            <button form="form_main" type="button" class="btn btn-primary" id="search_btn"><i class="fa fa-search"></i></button>
            </div>
        </div>
    </div>

    <ul class="nav nav-tabs m-t-md m-b-md" id="myTabs">
        <li class="nav-item">
            <a class="nav-link tab_link active" id="tab1" data-tab-num="1" href="#tab-content-1">접속자</a>
        </li>
        <li class="nav-item">
            <a class="nav-link tab_link" id="tab11" data-tab-num="11" href="#tab-content-11">도메인</a>
        </li>
        <li class="nav-item">
            <a class="nav-link tab_link" id="tab3" data-tab-num="3" href="#tab-content-3">브라우저</a>
        </li>
        <li class="nav-item">
            <a class="nav-link tab_link" id="tab4" data-tab-num="4" href="#tab-content-4">운영체제</a>
        </li>
        <li class="nav-item">
            <a class="nav-link tab_link" id="tab5" data-tab-num="5" href="#tab-content-5">접속기기</a>
        </li>
        <li class="nav-item">
            <a class="nav-link tab_link" id="tab6" data-tab-num="6" href="#tab-content-6">시간</a>
        </li>
        <li class="nav-item">
            <a class="nav-link tab_link" id="tab7" data-tab-num="7" href="#tab-content-7">요일</a>
        </li>
        <li class="nav-item">
            <a class="nav-link tab_link" id="tab8" data-tab-num="8" href="#tab-content-8">일</a>
        </li>
        <li class="nav-item">
            <a class="nav-link tab_link" id="tab9" data-tab-num="9" href="#tab-content-9">월</a>
        </li>
        <li class="nav-item">
            <a class="nav-link tab_link" id="tab10" data-tab-num="10" href="#tab-content-10">년</a>
        </li>
    </ul>

    <div class="tab-content">
        <div class="table-responsive m-t-md m-b-md tab-pane active" id="tab-content-1">
            <table id="dataTables_1" class="table table-striped table-bordered table-hover tab-pane active" style="width: 100%; height: auto;">
                <colgroup>
                    <col style="width: 150px">
                    <col style="">
                    <col style="width: 150px">
                    <col style="width: 100px">
                    <col style="width: 100px">
                    <col style="width: 150px">
                </colgroup>
                <thead>
                <tr>
                    <th class="no_orderable text-center">ip</th>
                    <th class="no_orderable text-center">접속경로</th>
                    <th class="no_orderable text-center">브라우저</th>
                    <th class="no_orderable text-center">OS</th>
                    <th class="no_orderable text-center">접속기기</th>
                    <th class="no_orderable text-center">일시</th>
                </tr>
                </thead>
            </table>
        </div>

        <div class="table-responsive m-t-md m-b-md tab-pane" id="tab-content-11">
            <table id="dataTables_2" class="table table-striped table-bordered table-hover tab-pane active" style="width: 100%; height: auto;">
                <colgroup>
                    <col style="width: 100px">
                    <col style="width: 250px">
                    <col style="">
                    <col style="width: 100px">
                    <col style="width: 100px">
                </colgroup>
                <thead>
                <tr>
                    <th class="no_orderable text-center">순위</th>
                    <th class="no_orderable text-center">접속 도메인</th>
                    <th class="no_orderable text-center">그래프</th>
                    <th class="no_orderable text-center">접속자수</th>
                    <th class="no_orderable text-center">비율(%)</th>
                </tr>
                </thead>
            </table>
        </div>
        <div class="table-responsive m-t-md m-b-md tab-pane" id="tab-content-3">
            <table id="dataTables_3" class="table table-striped table-bordered table-hover tab-pane active" style="width: 100%; height: auto;">
                <colgroup>
                    <col style="width: 100px">
                    <col style="width: 150px">
                    <col style="">
                    <col style="width: 100px">
                    <col style="width: 100px">
                </colgroup>
                <thead>
                <tr>
                    <th class="no_orderable text-center">순위</th>
                    <th class="no_orderable text-center">브라우저</th>
                    <th class="no_orderable text-center">그래프</th>
                    <th class="no_orderable text-center">접속자수</th>
                    <th class="no_orderable text-center">비율(%)</th>
                </tr>
                </thead>
            </table>
        </div>
        <div class="table-responsive m-t-md m-b-md tab-pane" id="tab-content-4">
            <table id="dataTables_4" class="table table-striped table-bordered table-hover tab-pane active" style="width: 100%; height: auto;">
                <colgroup>
                    <col style="width: 100px">
                    <col style="width: 150px">
                    <col style="">
                    <col style="width: 100px">
                    <col style="width: 100px">
                </colgroup>
                <thead>
                <tr>
                    <th class="no_orderable text-center">순위</th>
                    <th class="no_orderable text-center">운영체제</th>
                    <th class="no_orderable text-center">그래프</th>
                    <th class="no_orderable text-center">접속자수</th>
                    <th class="no_orderable text-center">비율(%)</th>
                </tr>
                </thead>
            </table>
        </div>
        <div class="table-responsive m-t-md m-b-md tab-pane" id="tab-content-5">
            <table id="dataTables_5" class="table table-striped table-bordered table-hover tab-pane active" style="width: 100%; height: auto;">
                <colgroup>
                    <col style="width: 100px">
                    <col style="width: 150px">
                    <col style="">
                    <col style="width: 100px">
                    <col style="width: 100px">
                </colgroup>
                <thead>
                <tr>
                    <th class="no_orderable text-center">순위</th>
                    <th class="no_orderable text-center">접속기기</th>
                    <th class="no_orderable text-center">그래프</th>
                    <th class="no_orderable text-center">접속자수</th>
                    <th class="no_orderable text-center">비율(%)</th>
                </tr>
                </thead>
            </table>
        </div>
        <div class="table-responsive m-t-md m-b-md tab-pane" id="tab-content-6">
            <table id="dataTables_6" class="table table-striped table-bordered table-hover tab-pane active" style="width: 100%; height: auto;">
                <colgroup>
                    <col style="width: 100px">
                    <col style="">
                    <col style="width: 100px">
                    <col style="width: 100px">
                </colgroup>
                <thead>
                <tr>
                    <th class="no_orderable text-center">시간</th>
                    <th class="no_orderable text-center">그래프</th>
                    <th class="no_orderable text-center">접속자수</th>
                    <th class="no_orderable text-center">비율(%)</th>
                </tr>
                </thead>
            </table>
        </div>
        <div class="table-responsive m-t-md m-b-md tab-pane" id="tab-content-7">
            <table id="dataTables_7" class="table table-striped table-bordered table-hover tab-pane active" style="width: 100%; height: auto;">
                <colgroup>
                    <col style="width: 100px">
                    <col style="">
                    <col style="width: 100px">
                    <col style="width: 100px">
                </colgroup>
                <thead>
                <tr>
                    <th class="no_orderable text-center">요일</th>
                    <th class="no_orderable text-center">그래프</th>
                    <th class="no_orderable text-center">접속자수</th>
                    <th class="no_orderable text-center">비율(%)</th>
                </tr>
                </thead>
            </table>
        </div>
        <div class="table-responsive m-t-md m-b-md tab-pane" id="tab-content-8">
            <table id="dataTables_8" class="table table-striped table-bordered table-hover tab-pane active" style="width: 100%; height: auto;">
                <colgroup>
                    <col style="width: 100px">
                    <col style="">
                    <col style="width: 100px">
                    <col style="width: 100px">
                </colgroup>
                <thead>
                <tr>
                    <th class="no_orderable text-center">년-월-일</th>
                    <th class="no_orderable text-center">그래프</th>
                    <th class="no_orderable text-center">접속자수</th>
                    <th class="no_orderable text-center">비율(%)</th>
                </tr>
                </thead>
            </table>
        </div>
        <div class="table-responsive m-t-md m-b-md tab-pane" id="tab-content-9">
            <table id="dataTables_9" class="table table-striped table-bordered table-hover tab-pane active" style="width: 100%; height: auto;">
                <colgroup>
                    <col style="width: 100px">
                    <col style="">
                    <col style="width: 100px">
                    <col style="width: 100px">
                </colgroup>
                <thead>
                <tr>
                    <th class="no_orderable text-center">년-월</th>
                    <th class="no_orderable text-center">그래프</th>
                    <th class="no_orderable text-center">접속자수</th>
                    <th class="no_orderable text-center">비율(%)</th>
                </tr>
                </thead>
            </table>
        </div>
        <div class="table-responsive m-t-md m-b-md tab-pane" id="tab-content-10">
            <table id="dataTables_10" class="table table-striped table-bordered table-hover tab-pane active" style="width: 100%; height: auto;">
                <colgroup>
                    <col style="width: 100px">
                    <col style="">
                    <col style="width: 100px">
                    <col style="width: 100px">
                </colgroup>
                <thead>
                <tr>
                    <th class="no_orderable text-center">연</th>
                    <th class="no_orderable text-center">그래프</th>
                    <th class="no_orderable text-center">접속자수</th>
                    <th class="no_orderable text-center">비율(%)</th>
                </tr>
                </thead>
            </table>
        </div>
    </div>

</div>

<?php include_once $_SERVER['DOCUMENT_ROOT'] . "/ad/statistics/statistics_list_js.php"; ?>