<?php include_once $_SERVER['DOCUMENT_ROOT'] . "/include/default.php"; ?>

<?php

// 변수
$process_mode = sanitize($_REQUEST['process_mode']);

// 저장
if ($process_mode == "login") {

    $code = sanitize($_REQUEST['code']);
    $password = sanitize($_REQUEST['password']);
    $password = enc($password);

    var_dump($code);
    exit;

}