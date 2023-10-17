<script>

    function visitorCount() {
        $.ajax({
            type: "post",
            data: $("#form_main").serialize() + "&process_mode=visitor_count",
            url: "/index_ajax.php",
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