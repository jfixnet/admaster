<?php include "../lib/config.php"; ?>

<?php
session_start();

// 세션 삭제
session_destroy();

// 이동
Header("Location:index.php");

?>