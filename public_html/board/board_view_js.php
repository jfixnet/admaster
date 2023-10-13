<script>
    function getParameterByName(name) {
        name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
        var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
            results = regex.exec(location.search);
        return results == null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
    }

    let table_name = getParameterByName('table_name');
    let idx = getParameterByName('idx');

    function list() {
        let process_mode = 'view'

        $.ajax({
            type: "post",
            data: $("#form").serialize() + "&process_mode=" + process_mode+ "&table_name=" + table_name+ "&idx=" + idx,
            url: "/board/board_ajax.php",
            dataType: "json",
            cache: false,
            async: false,
        }).done(function(result) {
            if (result) {
                $("#title").text(result.title);
                $("#content").html( result.content );
                $("#user_name").text(result.user_name);
                $("#create_date").text(result.create_date);

            } else {
                toastr["error"](result.message);
            }
        });
    }

    $(document).ready(function() {

        $("#return_list").click(function() {
            window.location.href = "/board/board.php?table_name="+table_name;
        });

        $("#update").click(function() {
            window.location.href = `/board/board_update.php?table_name=${table_name}&idx=${idx}`;
        });

    });

    $(function() {
        list();
    });

</script>