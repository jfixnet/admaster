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

//var_dump($_SERVER['DOCUMENT_ROOT']);
// 함수
//include './include/function_util.php'; // 유틸리티
include '/home/hanilam/public_html/include/function_util.php'; // 유틸리티

// Connect to MySQL database:
//include './lib/Database.php';
include '/home/hanilam/public_html/lib/Database.php';

// DB Setting
$dbhost = 'ns2.jfix.net';
$dbuser = 'hanilam';
$dbpasswd = 'wpdlvlrtm12!';
$dbname = 'hanilam';
$db = new Database($dbhost, $dbuser, $dbpasswd, $dbname);

// Upload
//$upload_root = $_SERVER['DOCUMENT_ROOT'] . "/data"; // Root Folder
$upload_root = "../data"; // Root Folder
$upload_file_size = 30; // 메가

?>