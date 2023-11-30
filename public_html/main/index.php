<?php include "../lib/config.php"; ?>

<?php include "../lib/auth.php"; ?>

<?php include "head.php"; ?>

<?php include "nav_top.php"; ?>

<?php var_dump($_SERVER['DOCUMENT_ROOT']);?>

<div class="wrapper wrapper-content">
    <div class="container">

        <div class="row">
            <div class="col-xs-12">

                사용자 페이지

            </div>
        </div>
    </div>

</div>

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
            console.log(result.data);
        })
    }

    $(function() {
        visitorCount();
    });
</script>

<?php include "tail.php"; ?>