<?php include_once $_SERVER['DOCUMENT_ROOT'] . "/include/default.php"; ?>

<?php

// 변수
$process_mode = sanitize($_REQUEST['process_mode']);

if ($process_mode == "list") {

    $temp = array(
        "status" => 0,
        "message" => '비활성화된 계정입니다. 관리자에게 문의해주세요.',
        "data" => $_SERVER['HTTP_REFERER'],
    );

    echo json_encode($temp);
    exit;
}