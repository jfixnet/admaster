<?php include_once $_SERVER['DOCUMENT_ROOT'] . "/include/default.php"; ?>

<?php
session_start();
// 세션 삭제
session_destroy();

// 이동
Header("Location:/ad");

?>
