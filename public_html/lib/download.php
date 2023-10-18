<?php include_once $_SERVER['DOCUMENT_ROOT'] . "/include/default.php"; ?>
<?php include_once $_SERVER['DOCUMENT_ROOT'] . "/include/auth.php"; ?>
<?php

// 변수
$code = sanitize($_REQUEST['code']);

// 첨부파일 표시
$sql = "
                SELECT *
                FROM attach_file
                WHERE file_tmp_name = '$code'
                LIMIT 1
";
//echo $sql;
$result = $db->query($sql)->fetchArray();

$file_name = $result['file_name'];
$file_size = $result['file_size'];
$target = $upload_root . "/" . $result['file_tmp_name'];

if (is_file($target)) {

    if (@preg_match("/MSIE/", $_SERVER['HTTP_USER_AGENT'])) {

        header('Content-Description: File Transfer');
        header("Content-type: application/octet-stream");
        header("Content-Length: ${file_size}");
        header("Content-Disposition: attachment; filename=${file_name}");
        header("Content-Transfer-Encoding: binary");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("Pragma: public");
        header("Expires: 0");

    } else {

        header('Content-Description: File Transfer');
        header("Content-type: file/unknown");
        header("Content-Length: ${file_size}");
        header("Content-Disposition: attachment; filename=${file_name}");
        header("Content-Description: PHP3 Generated Data");
        header("Pragma: no-cache");
        header("Expires: 0");

    }

    ob_clean();
    flush();
    readfile($target);
    exit;

//    $fp = fopen($target, "rb");
//    fpassthru($fp);
//    fclose($fp);

}

?>
