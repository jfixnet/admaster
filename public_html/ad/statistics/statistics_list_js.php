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
                    process_mode : 'list',
                    srch_start_date : srch_start_date,
                    srch_end_date : srch_end_date,
                },
                url: "/ad/statistics/statistics_list_ajax.php",
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
        //             param.process_mode = "list";
        //             param.srch_start_date = srch_start_date;
        //             param.srch_end_date = srch_end_date;
        //             return param;
        //         },
        //         url: "/ad/statistics/statistics_list_ajax.php",
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
                    param.process_mode = "list2";
                    param.srch_start_date = srch_start_date;
                    param.srch_end_date = srch_end_date;
                    return param;
                },
                url: "/ad/statistics/statistics_list_ajax.php",
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
                    param.process_mode = "list3";
                    param.srch_start_date = srch_start_date;
                    param.srch_end_date = srch_end_date;
                    return param;
                },
                url: "/ad/statistics/statistics_list_ajax.php",
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
                    param.process_mode = "list4";
                    param.srch_start_date = srch_start_date;
                    param.srch_end_date = srch_end_date;
                    return param;
                },
                url: "/ad/statistics/statistics_list_ajax.php",
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
                    param.process_mode = "list5";
                    param.srch_start_date = srch_start_date;
                    param.srch_end_date = srch_end_date;
                    return param;
                },
                url: "/ad/statistics/statistics_list_ajax.php",
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
                    param.process_mode = "list6";
                    param.srch_start_date = srch_start_date;
                    param.srch_end_date = srch_end_date;
                    return param;
                },
                url: "/ad/statistics/statistics_list_ajax.php",
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
                    param.process_mode = "list7";
                    param.srch_start_date = srch_start_date;
                    param.srch_end_date = srch_end_date;
                    return param;
                },
                url: "/ad/statistics/statistics_list_ajax.php",
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
                    param.process_mode = "list8";
                    param.srch_start_date = srch_start_date;
                    param.srch_end_date = srch_end_date;
                    return param;
                },
                url: "/ad/statistics/statistics_list_ajax.php",
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
                    param.process_mode = "list9";
                    param.srch_start_date = srch_start_date;
                    param.srch_end_date = srch_end_date;
                    return param;
                },
                url: "/ad/statistics/statistics_list_ajax.php",
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
                    param.process_mode = "list10";
                    param.srch_start_date = srch_start_date;
                    param.srch_end_date = srch_end_date;
                    return param;
                },
                url: "/ad/statistics/statistics_list_ajax.php",
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