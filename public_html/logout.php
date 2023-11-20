<?php include_once $_SERVER['DOCUMENT_ROOT'] . "/include/default.php"; ?>

<?php
//세션 유지
session_start();
// 세션 삭제
session_destroy();

// 이동
Header("Location:/index.php");

?>
