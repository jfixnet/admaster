/*  공통요소 관련 세팅 시작 */

// Datepicker Setting defaults
// $.fn.datepicker.dates['kr'] = {
//     days: ["일요일", "월요일", "화요일", "수요일", "목요일", "금요일", "토요일"],
//     daysShort: ["일", "월", "화", "수", "목", "금", "토"],
//     daysMin: ["일", "월", "화", "수", "목", "금", "토"],
//     months: ["1월", "2월", "3월", "4월", "5월", "6월", "7월", "8월", "9월", "10월", "11월", "12월"],
//     monthsShort: ["1월", "2월", "3월", "4월", "5월", "6월", "7월", "8월", "9월", "10월", "11월", "12월"],
//     today: "오늘",
//     clear: "비우기",
// };

$('.datepicker').datepicker({
    format: "yyyy-mm-dd",
    titleFormat: "yyyy mm", /* Leverages same syntax as 'format' */
    weekStart: 0,
    todayBtn: "linked",
    keyboardNavigation: true,
    forceParse: false,
    // calendarWeeks: true,
    autoclose: true,
    language: 'kr',
    showMonthAfterYear: true,
});

$('.yearpicker').datepicker({
    format: "yyyy",
    titleFormat: "yyyy", /* Leverages same syntax as 'format' */
    weekStart: 0,
    todayBtn: "linked",
    keyboardNavigation: true,
    forceParse: false,
    // calendarWeeks: true,
    autoclose: true,
    language: 'kr',
    showMonthAfterYear: true,
    viewMode: "years",
    minViewMode: "years",
});

$('.monthpicker').datepicker({
    format: 'yyyy-mm',
    titleFormat: "yyyy", /* Leverages same syntax as 'format' */
    weekStart: 0,
    todayBtn: "linked",
    keyboardNavigation: true,
    forceParse: false,
    // calendarWeeks: true,
    autoclose: true,
    language: 'kr',
    showMonthAfterYear: true,
    viewMode: "months",
    minViewMode: "months",
});

$('.input-daterange').datepicker({
    format: "yyyy-mm-dd",
    titleFormat: "yyyy mm", /* Leverages same syntax as 'format' */
    weekStart: 0,
    todayBtn: "linked",
    keyboardNavigation: true,
    forceParse: false,
    // calendarWeeks: true,
    autoclose: true,
    language: 'kr',
    showMonthAfterYear: true,
});

// Clockpicker Setting defaults
// $('.clockpicker').clockpicker();

// Datatables Setting defaults
$.extend( true, $.fn.dataTable.defaults, {
    retrieve: true,
    // "searching": false,
    // "ordering": false,
    columnDefs: [ { targets: ['no_orderable'], orderable: false } ],
    responsive: true,
    // paginate: false,
    order: [],
    // dom: '<"html5buttons"B>Tfgitp',
    dom: '<"html5buttons pull-left"B><"pull-right"l><"pull-right"f>t<"pull-left"i><"pull-center"p>',
    lengthChange: false,
    "language": {
        "decimal" : "",
        "emptyTable" : "데이터가 없습니다.",
        // "info" : "_START_ - _END_ (Total _TOTAL_ 건)",
        "info" : "Total _TOTAL_ 건 _PAGE_ 페이지",
        "infoEmpty" : "0건",
        "infoFiltered" : "(전체 _MAX_ 건 중 검색결과)",
        "infoPostFix" : "",
        "thousands" : ",",
        "lengthMenu" : "_MENU_",
        // "loadingRecords" : "로딩중...",
        // "loadingRecords": "<div style='padding:25px;'><i class='fa fa-spinner fa-spin fa-3x fa-fw'></i></div>",
        "loadingRecords": "<div style='padding:25px;'><div class='sk-spinner sk-spinner-three-bounce'><div class='sk-bounce1'></div><div class='sk-bounce2'></div><div class='sk-bounce3'></div></div></div>",
        // "processing" : "처리중...",
        // "processing" : "<div style='padding:25px;'><i class='fa fa-spinner fa-spin fa-3x fa-fw'></i></div>",
        "processing": "<div style='padding:25px;'><div class='sk-spinner sk-spinner-three-bounce'><div class='sk-bounce1'></div><div class='sk-bounce2'></div><div class='sk-bounce3'></div></div></div>",
        "search" : "결과내 검색 : ",
        "zeroRecords" : "검색된 데이터가 없습니다.",
        "paginate" : {
            "first" : "첫 페이지",
            "last" : "마지막 페이지",
            "next" : "다음",
            "previous" : "이전"
        },
        "aria" : {
            "sortAscending" : " :  오름차순 정렬",
            "sortDescending" : " :  내림차순 정렬"
        }
    }
});

// Toastr notifications
toastr.options = {
  "closeButton": true,
  "debug": false,
  "progressBar": true,
  "preventDuplicates": false,
  "positionClass": "toast-top-right",
  "onclick": null,
  "showDuration": "400",
  "hideDuration": "1000",
  "timeOut": "7000",
  "extendedTimeOut": "1000",
  "showEasing": "swing",
  "hideEasing": "linear",
  "showMethod": "fadeIn",
  "hideMethod": "fadeOut"
}

// 메시지가 표시되는 시간
toastr.options.timeOut = 3000;

/*  공통요소 관련 세팅 끝 */

// serializeObject
// https://github.com/macek/jquery-serialize-object
$.fn.serializeObject = function () {
    'use strict';
    var result = {};
    var extend = function (i, element) {
        var node = result[element.name];
        if ('undefined' !== typeof node && node !== null) {
            if ($.isArray(node)) {
                node.push(element.value);
            } else {
                result[element.name] = [node, element.value];
            }
        } else {
            result[element.name] = element.value;
        }
    };
    $.each(this.serializeArray(), extend);
    return result;
};

// 숫자 자릿수 콤마
function addNumberComma(str) {
    if (!str) str = 0;
    str = str.toString();

    if (str.length > 1) {
        str = str.replace(/^0+/g, '');
    }

    str = str.replace(/[^\d-]+/g, '');
    str = str.replace(/(\d)(?=(?:\d{3})+(?!\d))/g, '$1,');
    return str;
}

$(document).on("keyup focus", ".number_format", function() {
    var str = $(this).val();
    var result = addNumberComma(str);
    $(this).val( result );
});

// 숫자 소수점
function addNumberPoint(str) {
    if (!str) str = 0;
    str = str.toString();
    str = str.replace(/[^\d,\.]+/g, '');

    let bExists = str.indexOf(".", 0);
    let strArray = str.split('.');

    strArray[0] = addNumberComma(strArray[0]);

    if (bExists > -1) {
        str = strArray[0] + "." + strArray[1];
    } else {
        str = strArray[0];
    }

    return str;
}

$(document).on("keyup focus", ".decimal_format", function() {
    var str = $(this).val();
    var result = addNumberPoint(str);
    // console.log(result);
    $(this).val( result );
});

// 타이틀 변경
$(function() {
    if ($(".page-title").text()) {
        $("title").text( $("title").text() + " > " + $(".page-title").text() );
    }
});

// 쿠키 처리
var setCookie = function(name, value, day) {
    var date = new Date();
    date.setTime(date.getTime() + day * 60 * 60 * 24 * 1000);
    document.cookie = name + '=' + value + ';expires=' + date.toUTCString() + ';path=/';
};

var getCookie = function(name) {
    var value = document.cookie.match('(^|;) ?' + name + '=([^;]*)(;|$)');
    return value? value[2] : null;
};

var deleteCookie = function(name) {
    var date = new Date();
    document.cookie = name + "= " + "; expires=" + date.toUTCString() + "; path=/";
}

// Select2 기본 세팅
$.fn.select2.defaults.set("width", "100%");

// URL 파라미터 값 가져오기
function getParameterByName(name) {
    name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
    var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
        results = regex.exec(location.search);
    return results == null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
}

// 숫자 금액을 한글로 변환
function num2han(num) {
    num = parseInt((num + '').replace(/[^0-9]/g, ''), 10) + ''; // 숫자/문자/돈 을 숫자만 있는 문자열로 변환
    if(num == '0')
        return '영';
    let number = ['영', '일', '이', '삼', '사', '오', '육', '칠', '팔', '구'];
    let unit = ['', '만', '억', '조'];
    let smallUnit = ['천', '백', '십', ''];
    let result = []; //변환된 값을 저장할 배열
    let unitCnt = Math.ceil(num.length / 4); //단위 갯수. 숫자 10000은 일단위와 만단위 2개이다.
    num = num.padStart(unitCnt * 4, '0') //4자리 값이 되도록 0을 채운다
    let regexp = /[\w\W]{4}/g; //4자리 단위로 숫자 분리
    let array = num.match(regexp);

    //낮은 자릿수에서 높은 자릿수 순으로 값을 만든다(그래야 자릿수 계산이 편하다)
    for(let i = array.length - 1, unitCnt = 0; i >= 0; i--, unitCnt++) {
        let hanValue = _makeHan(array[i]); //한글로 변환된 숫자
        if(hanValue == '') //값이 없을땐 해당 단위의 값이 모두 0이란 뜻.
            continue;
        result.unshift(hanValue + unit[unitCnt]); //unshift는 항상 배열의 앞에 넣는다.
    }

    //여기로 들어오는 값은 무조건 네자리이다. 1234 -> 일천이백삼십사
    function _makeHan(text) {
        let str = '';
        for(let i = 0; i < text.length; i++) {
            let num = text[i];
            if(num == '0') //0은 읽지 않는다
                continue;
            str += number[num] + smallUnit[i];
        }
        return str;
    }

    return result.join('');
}


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

let sortColumn = '';
let sortType = '';
function tableSorting(t){
    sortColumn = t.data("th-value");

    $(".th_s").not(t).children().attr('class', 'glyphicon glyphicon-sort sort_non opacity');

    switch (sortType) {
        case 'asc':
            t.children().attr('class','glyphicon glyphicon-sort-by-attributes-alt sort_desc');
            sortType = 'desc';
            break;
        case 'desc':
            t.children().attr('class','glyphicon glyphicon-sort-by-attributes sort_asc');
            sortType = 'asc';
            break;
        default :
            t.children().attr('class','glyphicon glyphicon-sort-by-attributes sort_asc');
            sortType = 'asc';
            break;
    }
}

function excelDownload(table, columns, fileName) {
    document.location.href = `/lib/excel_download.php?table=${table}&columns=${columns}&file_name=${fileName}`;
}