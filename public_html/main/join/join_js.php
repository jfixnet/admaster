<script>

    $("#form_main").on("submit", function() {
        save();
        return false;
    });

    function save() {

        let password = $("#password").val();
        let rePassword = $("#re_password").val();
        if (password != rePassword) {
            alert('비밀번호가 다릅니다. 확인해주세요.');
            return false;
        }

        $.ajax({
            type: "post",
            data: $("#form_main").serialize() + "&process_mode=join",
            url: "/page/join/join_ajax.php",
            dataType: "json",
            cache: false,
            async: false,
        }).done(function(data) {

            if (data.status) {
                toastr["success"](data.message);
                document.location.href = data.redirect;
            } else {
                toastr["error"](data.message);
            }
        });
    }

    $('#code').on('input', function() {
        const user_code = $(this).val().trim();

        if (user_code.length === 0) {
            $('#code_check').text('');
            return;
        }

        let regExp = /[ㄱ-ㅎ|ㅏ-ㅣ|가-힣]/;
        if (regExp.test($(this).val())) {
            $(this).val($(this).val().replace(/[ㄱ-ㅎ|ㅏ-ㅣ|가-힣]/g, ''));
        }

        let re_user_code = $(this).val();

        if (re_user_code) {
            $.ajax({
                type: "post",
                data: $("#form_main").serialize() + "&process_mode=code_check",
                url: "/page/join/join_ajax.php",
                dataType: "json",
                cache: false,
                async: false,
            }).done(function(data) {

                if (data.status) {
                    $('#code_check').text('사용 가능한 아이디입니다.').removeClass('invalid').addClass('valid');
                } else {
                    $('#code_check').text('이미 사용 중인 아이디입니다.').removeClass('valid').addClass('invalid');
                }
            });
        }
    });

</script>