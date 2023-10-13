<?php

// Error Report
error_reporting(E_ERROR );
ini_set("display_errors", 1);

// Memory
// ini_set('memory_limit', '512M');
// ini_set('memory_limit','-1');

// 기본 설정
$COMPANY_TITLE = "게시판";
$COPYRIGHT_YEAR = "2023";
$PROVIDER_TITLE = "JFIX";
$COMPANY_ADDRESS = "";

// 함수
include $_SERVER['DOCUMENT_ROOT'] . '/include/function_util.php'; // 유틸리티

// Connect to MySQL database:
include $_SERVER['DOCUMENT_ROOT'] . '/lib/Database.php';

// DB Setting
$dbhost = 'localhost';
$dbuser = 'ad';
$dbpasswd = 'vlrtmtjqj)(@#!';
$dbname = 'ad';
$db = new Database($dbhost, $dbuser, $dbpasswd, $dbname);

// Upload
$upload_root = $_SERVER['DOCUMENT_ROOT'] . "/img"; // Root Folder
$upload_file_size = 30; // 메가

// 세션유지시간 변경
//$session_time = $db->query('SELECT session_time FROM jfm_session_time')->fetchArray();
//session_cache_expire($session_time['session_time']);

// Session Start
// ini_set('session.save_path', $upload_root . '/session');

session_start();
ini_set('memory_limit','-1');

// 루트 url로 접속 시 세션 체크 후 리다이렉트


if ($_SERVER[ "REQUEST_URI" ] == '/ad/') {
    if ($_SESSION['user_code']) {
        Header("Location:/ad/index.php");
    } else {
        Header("Location:/ad/login.php");
    }
} else if (strpos($_SERVER[ "REQUEST_URI" ], '/ad') !== false){
    //Header("Location:/index.php");
}

?>
