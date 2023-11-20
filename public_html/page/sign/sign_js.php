<script>
    var width = 1080;
    var height = 1920;

    // first we need Konva core things: stage and layer
    var stage = new Konva.Stage({
        container: 'container',
        width: width,
        height: height,
    });

    var layer = new Konva.Layer();
    stage.add(layer);

    var isPaint = false;
    var mode = 'brush';
    var lastLine;

    stage.on('mousedown touchstart', function (e) {
        isPaint = true;
        var pos = stage.getPointerPosition();
        lastLine = new Konva.Line({
            stroke: '#000000',
            strokeWidth: 5,
            globalCompositeOperation:
                mode === 'brush' ? 'source-over' : 'destination-out',
            // round cap for smoother lines
            lineCap: 'round',
            lineJoin: 'round',
            // add point twice, so we have some drawings even on a simple click
            points: [pos.x, pos.y, pos.x, pos.y],
        });
        layer.add(lastLine);
    });

    stage.on('mouseup touchend', function () {
        isPaint = false;
    });

    // and core function - drawing
    stage.on('mousemove touchmove', function (e) {
        if (!isPaint) {
            return;
        }

        // prevent scrolling on touch devices
        e.evt.preventDefault();

        const pos = stage.getPointerPosition();
        var newPoints = lastLine.points().concat([pos.x, pos.y]);
        lastLine.points(newPoints);
    });

    // var select = document.getElementById('tool');
    // select.addEventListener('change', function () {
    //     mode = select.value;
    // });

    let apply_url_1 = '';

    $("#btn_save").on("click", function () {
        apply_url_1 = stage.toDataURL();
        $("#sign_view").html('<img form="form" id="sign"  src="' + apply_url_1 + '">');

        create();
    });

    function create() {
        let process_mode = "create"; // 등록 모드

        var formData = new FormData( $("#form")[0] );
        formData.append("process_mode", process_mode);

        const imgBase64 = stage.toDataURL();
        const decodImg = atob(imgBase64.split(',')[1]);

        let array = [];
        for (let i = 0; i < decodImg.length; i++) {
            array.push(decodImg.charCodeAt(i));
        }

        const file = new Blob([new Uint8Array(array)], {type: 'image/jpeg'});
        const fileName = 'sign_' + new Date().getMilliseconds() + '.jpg';

        formData.append('sign[]', file, fileName);

        $.ajax({
            type: "post",
            // data: $("#form").serialize() + "&process_mode=" + process_mode+ "&table_name=" + table_name+ "&idx=" + idx,
            data: formData,
            processData: false, // 첨부파일 처리
            contentType: false, // 첨부파일 처리
            url: "/page/sign/sign_ajax.php",
            dataType: "json",
            cache: false,
            async: false,
        }).done(function(data) {
            if (data.status) {
                alert('저장');
                $("#sign_download_div").show();
                $("#btn_download").attr("href", "/lib/download.php?code=" + data.tmp_name);

            } else {
                alert('저장 오류');
            }
        });
    }

    $("#btn_create").on("click", function () {
        $("#modal_sign").modal("show");
    });
</script>