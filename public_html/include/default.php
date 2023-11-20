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
$upload_root = $_SERVER['DOCUMENT_ROOT'] . "/upload"; // Root Folder
$upload_file_size = 30; // 메가

?>
