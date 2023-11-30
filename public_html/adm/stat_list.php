<?php include "../lib/config.php"; ?>

<?php include "../lib/auth.php"; ?>

<?php include "head.php"; ?>

<?php include "nav_top.php"; ?>

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

<script>
    let listNum = 1;

    function getParameterByName(name) {
        name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
        var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
            results = regex.exec(location.search);
        return results == null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
    }

    $("#search_btn").on("click", function () {

        switch (listNum) {
            case 1 : list();
                break;
            case 2 : list2();
                break;
            case 3 : list3();
                break;
            case 4 : list4();
                break;
            case 5 : list5();
                break;
            case 6 : list6();
                break;
            case 7 : list7();
                break;
            case 8 : list8();
                break;
            case 9 : list9();
                break;
            case 10 : list10();
                break;
        }
    });

    function list() {
        let srch_start_date = $("#srch_start_date").val();
        let srch_end_date = $("#srch_end_date").val();

        // 초기화
        $('#dataTables_1').DataTable({buttons: []}).destroy();
        new DataTable('#dataTables_1', {
            ajax: {
                data : {
                    process_mode : 'stat_list',
                    srch_start_date : srch_start_date,
                    srch_end_date : srch_end_date,
                },
                url: "../lib/admin_ajax.php",
                dataType: "json",
            },
            processing: true,
            serverSide: true,
            columns: [
                { data: "ip", className: "text-center" },
                { data: "route", className: "text-center" },
                { data: "browser", className: "text-center" },
                { data: "os", className: "text-center" },
                { data: "device", className: "text-center" },
                { data: "create_date", className: "text-center" },
            ],
            searching: false,
        });
        // $('#dataTables_1').DataTable({
        //     ajax: {
        //         type: "post",
        //         data: function() {
        //             var param = $("#form_main").serializeObject();
        //             param.process_mode = "stat_list";
        //             param.srch_start_date = srch_start_date;
        //             param.srch_end_date = srch_end_date;
        //             return param;
        //         },
        //         url: "../lib/admin_ajax.php",
        //         dataType: "json",
        //         cache: false,
        //         async: false,
        //         dataSrc: '',
        //     },
        //     createdRow: function (row, data, index) { },
        //     drawCallback: function(settings, json) { },
        //     columns: [
        //         { data: "ip", className: "text-center" },
        //         { data: "route", className: "text-center" },
        //         { data: "browser", className: "text-center" },
        //         { data: "os", className: "text-center" },
        //         { data: "device", className: "text-center" },
        //         { data: "create_date", className: "text-center" },
        //     ],
        //     paging: false,
        //     info: false,
        //     pageLength: 15,
        //     lengthChange: false,
        //     searching: false,
        //     lengthMenu:[ [10,15,25,50,100, -1],[10,15,25,50,100, "ALL"] ],
        //     // dom: 't<"pull-left"i><"pull-center"p>',
        //     buttons: []
        // });
    }

    $(".tab_link").on("click", function(e) {
        e.preventDefault();
        listNum = $(this).data("tab-num");
        $('#myTabs a[href="#tab-content-'+listNum+'"]').tab('show');

        switch (listNum) {
            case 1 : list();
                break;
            // case 2 : list2();
            //     break;
            case 3 : list3();
                break;
            case 4 : list4();
                break;
            case 5 : list5();
                break;
            case 6 : list6();
                break;
            case 7 : list7();
                break;
            case 8 : list8();
                break;
            case 9 : list9();
                break;
            case 10 : list10();
                break;
            case 11 : list2();
                break;
        }
    });

    function list2() {
        let srch_start_date = $("#srch_start_date").val();
        let srch_end_date = $("#srch_end_date").val();

        // 초기화
        $('#dataTables_2').DataTable({buttons: []}).destroy();
        $('#dataTables_2').DataTable({
            ajax: {
                type: "post",
                data: function() {
                    var param = $("#form_main").serializeObject();
                    param.process_mode = "stat_list2";
                    param.srch_start_date = srch_start_date;
                    param.srch_end_date = srch_end_date;
                    return param;
                },
                url: "../lib/admin_ajax.php",
                dataType: "json",
                cache: false,
                async: false,
                dataSrc: '',
            },
            createdRow: function (row, data, index) { },
            drawCallback: function(settings, json) { },
            columns: [
                { data: "rank", className: "text-center" },
                { data: "route", className: "text-center" },
                { data: "per", className: "text-center", render:function (data, type, row, meta) {
                        let html = `<div class="progress" role="progressbar" aria-label="Basic example" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
                                    <div class="progress-bar" style="width: ${data}%"></div>
                                </div>`;
                        return html;
                    }},
                { data: "count", className: "text-center" },
                { data: "per", className: "text-center" },
            ],
            paging: false,
            info: false,
            pageLength: 15,
            lengthChange: false,
            searching: false,
            lengthMenu:[ [10,15,25,50,100, -1],[10,15,25,50,100, "ALL"] ],
            // dom: 't<"pull-left"i><"pull-center"p>',
            buttons: [],
        });
    }

    function list3() {
        let srch_start_date = $("#srch_start_date").val();
        let srch_end_date = $("#srch_end_date").val();

        // 초기화
        $('#dataTables_3').DataTable({buttons: []}).destroy();
        $('#dataTables_3').DataTable({
            ajax: {
                type: "post",
                data: function() {
                    var param = $("#form_main").serializeObject();
                    param.process_mode = "stat_list3";
                    param.srch_start_date = srch_start_date;
                    param.srch_end_date = srch_end_date;
                    return param;
                },
                url: "../lib/admin_ajax.php",
                dataType: "json",
                cache: false,
                async: false,
                dataSrc: '',
            },
            createdRow: function (row, data, index) { },
            drawCallback: function(settings, json) { },
            columns: [
                { data: "rank", className: "text-center" },
                { data: "browser", className: "text-center" },
                { data: "per", className: "text-center", render:function (data, type, row, meta) {
                        let html = `<div class="progress" role="progressbar" aria-label="Basic example" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
                                    <div class="progress-bar" style="width: ${data}%"></div>
                                </div>`;
                        return html;
                    }},
                { data: "count", className: "text-center" },
                { data: "per", className: "text-center" },
            ],
            paging: false,
            info: false,
            pageLength: 15,
            lengthChange: false,
            searching: false,
            lengthMenu:[ [10,15,25,50,100, -1],[10,15,25,50,100, "ALL"] ],
            // dom: 't<"pull-left"i><"pull-center"p>',
            buttons: []
        });
    }

    function list4() {
        let srch_start_date = $("#srch_start_date").val();
        let srch_end_date = $("#srch_end_date").val();

        // 초기화
        $('#dataTables_4').DataTable({buttons: []}).destroy();
        $('#dataTables_4').DataTable({
            ajax: {
                type: "post",
                data: function() {
                    var param = $("#form_main").serializeObject();
                    param.process_mode = "stat_list4";
                    param.srch_start_date = srch_start_date;
                    param.srch_end_date = srch_end_date;
                    return param;
                },
                url: "../lib/admin_ajax.php",
                dataType: "json",
                cache: false,
                async: false,
                dataSrc: '',
            },
            createdRow: function (row, data, index) { },
            drawCallback: function(settings, json) { },
            columns: [
                { data: "rank", className: "text-center" },
                { data: "os", className: "text-center" },
                { data: "per", className: "text-center", render:function (data, type, row, meta) {
                        let html = `<div class="progress" role="progressbar" aria-label="Basic example" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
                                    <div class="progress-bar" style="width: ${data}%"></div>
                                </div>`;
                        return html;
                    }},
                { data: "count", className: "text-center" },
                { data: "per", className: "text-center" },
            ],
            paging: false,
            info: false,
            pageLength: 15,
            lengthChange: false,
            searching: false,
            lengthMenu:[ [10,15,25,50,100, -1],[10,15,25,50,100, "ALL"] ],
            // dom: 't<"pull-left"i><"pull-center"p>',
            buttons: []
        });
    }

    function list5() {
        let srch_start_date = $("#srch_start_date").val();
        let srch_end_date = $("#srch_end_date").val();

        // 초기화
        $('#dataTables_5').DataTable({buttons: []}).destroy();
        $('#dataTables_5').DataTable({
            ajax: {
                type: "post",
                data: function() {
                    var param = $("#form_main").serializeObject();
                    param.process_mode = "stat_list5";
                    param.srch_start_date = srch_start_date;
                    param.srch_end_date = srch_end_date;
                    return param;
                },
                url: "../lib/admin_ajax.php",
                dataType: "json",
                cache: false,
                async: false,
                dataSrc: '',
            },
            createdRow: function (row, data, index) { },
            drawCallback: function(settings, json) { },
            columns: [
                { data: "rank", className: "text-center" },
                { data: "device", className: "text-center" },
                { data: "per", className: "text-center", render:function (data, type, row, meta) {
                        let html = `<div class="progress" role="progressbar" aria-label="Basic example" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
                                    <div class="progress-bar" style="width: ${data}%"></div>
                                </div>`;
                        return html;
                    }},
                { data: "count", className: "text-center" },
                { data: "per", className: "text-center" },
            ],
            paging: false,
            info: false,
            pageLength: 15,
            lengthChange: false,
            searching: false,
            lengthMenu:[ [10,15,25,50,100, -1],[10,15,25,50,100, "ALL"] ],
            // dom: 't<"pull-left"i><"pull-center"p>',
            buttons: []
        });
    }

    function list6() {
        let srch_start_date = $("#srch_start_date").val();
        let srch_end_date = $("#srch_end_date").val();

        // 초기화
        $('#dataTables_6').DataTable({buttons: []}).destroy();
        $('#dataTables_6').DataTable({
            ajax: {
                type: "post",
                data: function() {
                    var param = $("#form_main").serializeObject();
                    param.process_mode = "stat_list6";
                    param.srch_start_date = srch_start_date;
                    param.srch_end_date = srch_end_date;
                    return param;
                },
                url: "../lib/admin_ajax.php",
                dataType: "json",
                cache: false,
                async: false,
                dataSrc: '',
            },
            createdRow: function (row, data, index) { },
            drawCallback: function(settings, json) { },
            columns: [
                { data: "hour", className: "text-center" },
                { data: "per", className: "text-center", render:function (data, type, row, meta) {
                        let html = `<div class="progress" role="progressbar" aria-label="Basic example" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
                                    <div class="progress-bar" style="width: ${data}%"></div>
                                </div>`;
                        return html;
                    }},
                { data: "count", className: "text-center" },
                { data: "per", className: "text-center" },
            ],
            paging: false,
            info: false,
            pageLength: 15,
            lengthChange: false,
            searching: false,
            lengthMenu:[ [10,15,25,50,100, -1],[10,15,25,50,100, "ALL"] ],
            // dom: 't<"pull-left"i><"pull-center"p>',
            buttons: []
        });
    }

    function list7() {
        let srch_start_date = $("#srch_start_date").val();
        let srch_end_date = $("#srch_end_date").val();

        // 초기화
        $('#dataTables_7').DataTable({buttons: []}).destroy();
        $('#dataTables_7').DataTable({
            ajax: {
                type: "post",
                data: function() {
                    var param = $("#form_main").serializeObject();
                    param.process_mode = "stat_list7";
                    param.srch_start_date = srch_start_date;
                    param.srch_end_date = srch_end_date;
                    return param;
                },
                url: "../lib/admin_ajax.php",
                dataType: "json",
                cache: false,
                async: false,
                dataSrc: '',
            },
            createdRow: function (row, data, index) { },
            drawCallback: function(settings, json) { },
            columns: [
                { data: "day_ko", className: "text-center" },
                { data: "per", className: "text-center", render:function (data, type, row, meta) {
                        let html = `<div class="progress" role="progressbar" aria-label="Basic example" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
                                    <div class="progress-bar" style="width: ${data}%"></div>
                                </div>`;
                        return html;
                    }},
                { data: "count", className: "text-center" },
                { data: "per", className: "text-center" },
            ],
            paging: false,
            info: false,
            pageLength: 15,
            lengthChange: false,
            searching: false,
            lengthMenu:[ [10,15,25,50,100, -1],[10,15,25,50,100, "ALL"] ],
            // dom: 't<"pull-left"i><"pull-center"p>',
            buttons: []
        });
    }

    function list8() {
        let srch_start_date = $("#srch_start_date").val();
        let srch_end_date = $("#srch_end_date").val();

        // 초기화
        $('#dataTables_8').DataTable({buttons: []}).destroy();
        $('#dataTables_8').DataTable({
            ajax: {
                type: "post",
                data: function() {
                    var param = $("#form_main").serializeObject();
                    param.process_mode = "stat_list8";
                    param.srch_start_date = srch_start_date;
                    param.srch_end_date = srch_end_date;
                    return param;
                },
                url: "../lib/admin_ajax.php",
                dataType: "json",
                cache: false,
                async: false,
                dataSrc: '',
            },
            createdRow: function (row, data, index) { },
            drawCallback: function(settings, json) { },
            columns: [
                { data: "day", className: "text-center" },
                { data: "per", className: "text-center", render:function (data, type, row, meta) {
                        let html = `<div class="progress" role="progressbar" aria-label="Basic example" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
                                    <div class="progress-bar" style="width: ${data}%"></div>
                                </div>`;
                        return html;
                    }},
                { data: "count", className: "text-center" },
                { data: "per", className: "text-center" },
            ],
            paging: false,
            info: false,
            pageLength: 15,
            lengthChange: false,
            searching: false,
            lengthMenu:[ [10,15,25,50,100, -1],[10,15,25,50,100, "ALL"] ],
            // dom: 't<"pull-left"i><"pull-center"p>',
            buttons: []
        });
    }

    function list9() {
        let srch_start_date = $("#srch_start_date").val();
        let srch_end_date = $("#srch_end_date").val();

        // 초기화
        $('#dataTables_9').DataTable({buttons: []}).destroy();
        $('#dataTables_9').DataTable({
            ajax: {
                type: "post",
                data: function() {
                    var param = $("#form_main").serializeObject();
                    param.process_mode = "stat_list9";
                    param.srch_start_date = srch_start_date;
                    param.srch_end_date = srch_end_date;
                    return param;
                },
                url: "../lib/admin_ajax.php",
                dataType: "json",
                cache: false,
                async: false,
                dataSrc: '',
            },
            createdRow: function (row, data, index) { },
            drawCallback: function(settings, json) { },
            columns: [
                { data: "day", className: "text-center" },
                { data: "per", className: "text-center", render:function (data, type, row, meta) {
                        let html = `<div class="progress" role="progressbar" aria-label="Basic example" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
                                    <div class="progress-bar" style="width: ${data}%"></div>
                                </div>`;
                        return html;
                    }},
                { data: "count", className: "text-center" },
                { data: "per", className: "text-center" },
            ],
            paging: false,
            info: false,
            pageLength: 15,
            lengthChange: false,
            searching: false,
            lengthMenu:[ [10,15,25,50,100, -1],[10,15,25,50,100, "ALL"] ],
            // dom: 't<"pull-left"i><"pull-center"p>',
            buttons: []
        });
    }

    function list10() {
        let srch_start_date = $("#srch_start_date").val();
        let srch_end_date = $("#srch_end_date").val();

        // 초기화
        $('#dataTables_10').DataTable({buttons: []}).destroy();
        $('#dataTables_10').DataTable({
            ajax: {
                type: "post",
                data: function() {
                    var param = $("#form_main").serializeObject();
                    param.process_mode = "stat_list10";
                    param.srch_start_date = srch_start_date;
                    param.srch_end_date = srch_end_date;
                    return param;
                },
                url: "../lib/admin_ajax.php",
                dataType: "json",
                cache: false,
                async: false,
                dataSrc: '',
            },
            createdRow: function (row, data, index) { },
            drawCallback: function(settings, json) { },
            columns: [
                { data: "day", className: "text-center" },
                { data: "per", className: "text-center", render:function (data, type, row, meta) {
                        let html = `<div class="progress" role="progressbar" aria-label="Basic example" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
                                    <div class="progress-bar" style="width: ${data}%"></div>
                                </div>`;
                        return html;
                    }},
                { data: "count", className: "text-center" },
                { data: "per", className: "text-center" },
            ],
            paging: false,
            info: false,
            pageLength: 15,
            lengthChange: false,
            searching: false,
            lengthMenu:[ [10,15,25,50,100, -1],[10,15,25,50,100, "ALL"] ],
            // dom: 't<"pull-left"i><"pull-center"p>',
            buttons: []
        });
    }

    $(function() {

        $.fn.datepicker.dates['ko'] = {
            days: ["일", "월", "화", "수", "목", "금", "토", "일"],
            daysShort: ["일", "월", "화", "수", "목", "금", "토", "일"],
            daysMin: ["일", "월", "화", "수", "목", "금", "토", "일"],
            months: ["1월", "2월", "3월", "4월", "5월", "6월", "7월", "8월", "9월", "10월", "11월", "12월"],
            monthsShort: ["1월", "2월", "3월", "4월", "5월", "6월", "7월", "8월", "9월", "10월", "11월", "12월"],
            today: "오늘"
        };

        let dtpickerOpt = {
            format: 'yyyy-mm-dd',
            language: "ko",
            orientation: "bottom"
        };

        $('#srch_start_date').datepicker(dtpickerOpt).on('hide', function (e) {
            e.stopPropagation();
        });
        $('#srch_end_date').datepicker(dtpickerOpt).on('hide', function (e) {
            e.stopPropagation();
        });

        $("#srch_start_date").datepicker('setDate', dayjs().format('YYYY-MM-01'));
        $('#srch_end_date').datepicker('setDate', new Date());

        list(); // 목록
    });

</script>