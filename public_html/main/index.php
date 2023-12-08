<?php include "../lib/config.php"; ?>

<?php include "../lib/auth.php"; ?>

<?php include "head.php"; ?>

<?php include "nav_top.php"; ?>

<div class="wrapper wrapper-content">
    <div class="container">

        <div class="row">
            <div class="col-xs-12">

                사용자 페이지

            </div>
        </div>

    </div>
</div>

<!-- popup container-->
<div id="popupContainer" class="pop-container"></div>


<script>

    function visitorCount() {
        let referrer = document.referrer;

        $.ajax({
            type: "post",
            data: $("#form_main").serialize() + "&process_mode=visitor_count&referrer=" + referrer,
            url: "../lib/user_ajax.php",
            dataType: "json",
            cache: false,
            async: false,
        }).done(function (result) {

        })
    }

    function popup(){
        $('#popupContainer').empty(); // 기존 팝업 내용 비우기

        $.ajax({
            type: "post",
            data: $("#form_main").serialize() + "&process_mode=popup_view",
            url: "../lib/user_ajax.php",
            dataType: "json",
            cache: false,
            async: false,
        }).done(function (result) {
            if (result.length > 0) {

                result.forEach(function(val, key) {
                    let popupIdx = val.idx;

                    if (getCookie('popup_'+popupIdx)) {
                        return;
                    };

                    //  popup css code is in css/style.css
                    let popupContent = `
                        <div class="popup-container p_container" style="z-index: ${9999 - key}; top: ${val.popup_top_size}px; left: ${val.popup_left_size}px;">
                            <div class="popup-content" style="margin: 5px 5px 5px 5px;  width: ${val.popup_width_size}px; height: ${val.popup_height_size}px; min-width: 200px;">
                                <div class="popup-content-${key}"></div>
                            </div>

                            <div class="popup-btn-group clearfix">
                                <button class="btn close-button-today float-start" id="" data-idx="${popupIdx}" type="button">1일 동안 보지 않음</button>
                                <button class="btn close-button float-end" id="" type="button">닫기</button>
                            </div>
                        </div>
                    `;

                    $('#popupContainer').append(popupContent);
                    $(`.popup-content-${key}`).html(val.popup_content);

                });

                $('#popupContainer').show();
            }

        })
    }

    $(document).on("click", ".close-button-today", function() {
        let popupIdx = $(this).data("idx");
        setCookie('popup_'+popupIdx, 1, 1);
        popupClose(this);
    });

    $(document).on("click", ".close-button", function() {
        popupClose(this);
    });

    function popupClose(element){
        $(element).closest('.p_container').hide();
    }

    $(function() {
        visitorCount();
        popup();

        // 팝업 드래그
        $(".popup-container").draggable();
    });
</script>

<?php include "tail.php"; ?>