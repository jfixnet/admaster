<script>

    function view() {
        let process_mode = 'view'

        $.ajax({
            type: "post",
            data: $("#form").serialize() + "&process_mode=" + process_mode,
            url: "/page/user_edit/user_edit_ajax.php",
            dataType: "json",
            cache: false,
            async: false,
        }).done(function(result) {
            if (result) {
                $("#code").val(result.code);
                $("#name").val(result.name);
                $("#phone").val(result.phone);
                $("#email").val(result.email);
            } else {
            }
        });
    }

    $("#form_main").on("submit", function() {
        userEdit();
        return false;
    });

    function userEdit() {
        $.ajax({
            type: "post",
            data: $("#form_main").serialize() + "&process_mode=update",
            url: "/page/user_edit/user_edit_ajax.php",
            dataType: "json",
            cache: false,
            async: false,
        }).done(function (data) {
            if (data.status) {
                toastr["success"](data.message);
            } else {
                toastr["error"](data.message);
            }
        })
    };

    $(function() {
        view();
    });

</script>