<?php

//ini_set('memory_limit','-1');

// 루트 url로 접속 시 세션 체크 후 리다이렉트
session_start();

if ($_SESSION['is_admin'] == 'N') {
	Header("Location:/ad/login.php");
	exit;
}

if (!$_SESSION['user_code']) {
	Header("Location:/ad/login.php");
	exit;
}

?>
