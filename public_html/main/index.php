<?php include "../lib/config.php"; ?>

<?php include "../lib/auth.php"; ?>

<?php include "head.php"; ?>

<?php include "nav_top.php"; ?>
    <style>
        .popup-container {
            /*display: none;*/
            position: fixed;
            top: 0;
            left: 0;
            /*width: 100%;*/
            /*height: 100%;*/
            /*background: rgba(0, 0, 0, 0.8);*/
            z-index: 9999;
            justify-content: center;
            align-items: center;
            overflow: auto;
        }

        .popup-content {
            display: block;
            max-width: 90%;
            max-height: 90%;
        }

        .popup-content img {
            display: block;
            width: auto;
            height: auto;
            max-width: 100%;
            max-height: 100%;
            margin: 0 auto;
        }

        .close-button {
            position: absolute;
            top: 20px;
            right: 20px;
            color: #fff;
            font-size: 24px;
            cursor: pointer;
        }
    </style>

<div class="wrapper wrapper-content">
    <div class="container">

        <div class="row">
            <div class="col-xs-12">

                사용자 페이지

            </div>
        </div>

    </div>
</div>


    <div id="popupContainer" class=""></div>


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
                    var popupContent = `
                      <div class="popup-container p_container" style="z-index: ${9999 - key};">
                        <div class="popup-content" style="width: ${val.popup_width_size}px; height: ${val.popup_height_size}px;">
                          <span class="close-button">&times;</span>
                          <div class="popup-content-${key}"></div>
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

    $(function() {
        visitorCount();
        popup();

        // 팝업 관리
        $(".popup-container").draggable();
        $(`.popup-content .close-button`).click(function() {
            $(this).closest('.p_container').hide();
        });
    });
</script>

<?php include "tail.php"; ?>