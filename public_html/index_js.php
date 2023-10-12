<script>

    function list() {
        $.ajax({
            type: "post",
            data: $("#form_main").serialize() + "&process_mode=list",
            url: "/index_ajax.php",
            dataType: "json",
            cache: false,
            async: false,
        }).done(function (result) {
            console.log(result.data);
        })
    }

    $(function() {
        list(); // 목록
    });
</script>