<?php

// 암호화
// https://aircook.tistory.com/entry/AES-SHA-%EC%95%94%ED%98%B8%ED%99%94-6-PHP
function enc($str)
{
    return base64_encode(hash('SHA256', trim($str), true));
}

// Sanitize a String
function sanitize($str)
{
    $str = trim($str);
    $str = filter_var($str, FILTER_SANITIZE_STRING);
    return $str;
}

// by https://github.com/ttodua/useful-php-scripts
function EXPORT_DATABASE($host, $user, $pass, $name, $tables = false, $backup_name = false)
{
    set_time_limit(3000);
    $mysqli = new mysqli($host, $user, $pass, $name);
    $mysqli->select_db($name);
    $mysqli->query("SET NAMES 'utf8'");
    $queryTables = $mysqli->query('SHOW TABLES');
    while ($row = $queryTables->fetch_row()) {
        $target_tables[] = $row[0];
    }
    if ($tables !== false) {
        $target_tables = array_intersect($target_tables, $tables);
    }
    $content = "SET SQL_MODE = \"NO_AUTO_VALUE_ON_ZERO\";\r\nSET time_zone = \"+00:00\";\r\n\r\n\r\n/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;\r\n/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;\r\n/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;\r\n/*!40101 SET NAMES utf8 */;\r\n--\r\n-- Database: `" . $name . "`\r\n--\r\n\r\n\r\n";
    foreach ($target_tables as $table) {
        if (empty($table)) {
            continue;
        }
        $result = $mysqli->query('SELECT * FROM `' . $table . '`');
        $fields_amount = $result->field_count;
        $rows_num = $mysqli->affected_rows;
        $res = $mysqli->query('SHOW CREATE TABLE ' . $table);
        $TableMLine = $res->fetch_row();
        $content .= "\n\n" . $TableMLine[1] . ";\n\n";
        $TableMLine[1] = str_ireplace('CREATE TABLE `', 'CREATE TABLE IF NOT EXISTS `', $TableMLine[1]);
        for ($i = 0, $st_counter = 0; $i < $fields_amount; $i++, $st_counter = 0) {
            while ($row = $result->fetch_row()) { // when started (and every after 100 command cycle):
                if ($st_counter % 100 == 0 || $st_counter == 0) {
                    $content .= "\nINSERT INTO " . $table . " VALUES";
                }
                $content .= "\n(";
                for ($j = 0; $j < $fields_amount; $j++) {
                    $row[$j] = str_replace("\n", "\\n", addslashes($row[$j]));
                    if (isset($row[$j])) {
                        $content .= '"' . $row[$j] . '"';
                    } else {
                        $content .= '""';
                    }
                    if ($j < ($fields_amount - 1)) {
                        $content .= ',';
                    }
                }
                $content .= ")";
                // every after 100 command cycle [or at last line] ....p.s. but should be inserted 1 cycle eariler
                if ((($st_counter + 1) % 100 == 0 && $st_counter != 0) || $st_counter + 1 == $rows_num) {
                    $content .= ";";
                } else {
                    $content .= ",";
                }
                $st_counter = $st_counter + 1;
            }
        }
        $content .= "\n\n\n";
    }
    $content .= "\r\n\r\n/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;\r\n/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;\r\n/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;";
    $backup_name = $backup_name ? $backup_name : $name . '___(' . date('H-i-s') . '_' . date('d-m-Y') . ').sql';
    ob_get_clean();
    header('Content-Type: application/octet-stream');
    header("Content-Transfer-Encoding: Binary");
    header('Content-Length: ' . (function_exists('mb_strlen') ? mb_strlen($content, '8bit') : strlen($content)));
    header("Content-disposition: attachment; filename=\"" . $backup_name . "\"");
    echo $content;
    exit;
}

//금액을 한글로 바꿔주는 소스
function number2hangul($number){

    $num = array('', '일', '이', '삼', '사', '오', '육', '칠', '팔', '구');
    $unit4 = array('', '만', '억', '조', '경');
    $unit1 = array('', '십', '백', '천');

    $res = array();

    $number = str_replace(',','',$number);
    $split4 = str_split(strrev((string)$number),4);

    for($i=0;$i<count($split4);$i++){
        $temp = array();
        $split1 = str_split((string)$split4[$i], 1);
        for($j=0;$j<count($split1);$j++){
            $u = (int)$split1[$j];
            if($u > 0) $temp[] = $num[$u].$unit1[$j];
        }
        if(count($temp) > 0) $res[] = implode('', array_reverse($temp)).$unit4[$i];
    }
    return implode('', array_reverse($res));
}

// 환율 정보
function getExchangeRate($currency_code) {

    $str = file_get_contents('https://quotation-api-cdn.dunamu.com/v1/forex/recent?codes=FRX.KRWUSD,FRX.KRWCNY,FRX.KRWJPY,FRX.KRWEUR,FRX.KRWTWD');
    $json = json_decode($str, true);
    $currency['USD'] = $json[0]['basePrice'];
    $currency['CNY'] = $json[1]['basePrice'];
    $currency['JPY'] = number_format($json[2]['basePrice'] / 100, 2);
    $currency['EUR'] = $json[3]['basePrice'];
    $currency['TWD'] = $json[4]['basePrice'];

    return $currency[$currency_code];
}

// 메시지 띄우고 뒤로 가기
function error($message) {
    echo "
            <script>
                alert('${message}');
                history.go(-1);
            </script>
    ";

    exit;
}

function send_mail($to, $from, $from_name, $subject, $contents, $attach_file) {
    global $upload_root; // 업로드 폴더

    $headers = "From: $from_name"." <".$from.">";

    $semi_rand = md5(time());
    $mime_boundary = "==Multipart_Boundary_x{$semi_rand}x";

    $headers .= "\nMIME-Version: 1.0\n" . "Content-Type: multipart/mixed;\n" . " boundary=\"{$mime_boundary}\"";

    $message = "--{$mime_boundary}\n" . "Content-Type: text/html; charset=\"UTF-8\"\n" . "Content-Transfer-Encoding: 7bit\n\n" . $contents . "\n\n";

    foreach ($attach_file as $item) {
        $file = $upload_root . "/" . $item['file_tmp_name'];

        $file_name = $item['file_name'];

        $message .= "--{$mime_boundary}\n";
        $fp =    @fopen($file,"rb");
        $data =  @fread($fp,filesize($file));

        @fclose($fp);
        $data = chunk_split(base64_encode($data));
        $message .= "Content-Type: application/octet-stream; charset=utf-8; name=\"".$file_name."\"\n" .
            "Content-Description: ".basename($file)."\n" .
            "Content-Disposition: attachment;\n" . " filename=\"".$file_name."\"; size=".filesize($file).";\n" .
            "Content-Transfer-Encoding: base64\n\n" . $data . "\n\n";
    }

    $message .= "--{$mime_boundary}--";
    $returnpath = "-f" . $from;

    return mail($to, $subject, $message, $headers, $returnpath);
}
function createDateRangeArray($startDate, $endDate)
{
    $start = new DateTime($startDate);
    $end = new DateTime($endDate);
    $end->modify('+1 day'); // Include the end date in the range

    $dateRange = [];

    $num = 0;
    while ($start < $end) {
        $dateRange[$num]['day'] = $start->format('Y-m-d');
        $dateRange[$num]['count'] = 0;
        $start->modify('+1 day');
        $num++;
    }

    return $dateRange;
}
function createMonthRangeArray($startDate, $endDate)
{
    $start = new DateTime($startDate);
    $end = new DateTime($endDate);
    $end->modify('+1 Month'); // Include the end date in the range

    $dateRange = [];

    $num = 0;
    while ($start < $end) {
        $dateRange[$num]['day'] = $start->format('Y-m');
        $dateRange[$num]['count'] = 0;
        $start->modify('+1 Month');
        $num++;
    }

    return $dateRange;
}
function createYearRangeArray($startYear, $endYear) {
    $yearRange = array();

    $num = 0;
    for ($year = $startYear; $year <= $endYear; $year++) {
        $yearRange[$num]['day'] = $year;
        $yearRange[$num]['count'] = 0;
        $num++;
    }

    return $yearRange;
}

// 파일 업로드
function fileUpload($table, $idx, $type, $file, $sort) {
    global $db;
    global $upload_root; // 업로드 폴더
    global $upload_file_size; // 업로드 제한 용량

    // 허용 확장자
    switch ($type) {
        case "image" :
            $allow_extension = array('jpg', 'jpeg', 'png', 'gif'); // 허용 확장자
            break;

        case "file" :
        default :
            $allow_extension = array('jpg', 'jpeg', 'png', 'gif', 'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx', 'pdf', 'hwp', 'zip'); // 허용 확장자
            break;
    }

    // 파일 업로드 관련 변수
    $file_name = trim($file['name'][$sort]); // 파일명
    $file_name_array = explode('.', $file_name); // 확장자 추출
    $file_extension = strtolower( end( $file_name_array ) ); // 확장자
    $tmp_name = $file['tmp_name'][$sort]; // 임시 파일명
    $file_tmp_name = str_replace("/tmp/", "", $tmp_name) . '-' . $sort . '-' . date("YmdHis"); // 조작된 임시 파일명
    $file_size = $file['size'][$sort]; // 용량

    // 기타 설정
    $target =  $upload_root . "/" . $file_tmp_name; // 저장 대상
    $max_size = $upload_file_size; // 제한 용량 (메가)

    // 확장자 체크
    if (in_array($file_extension, $allow_extension)) {

        // 용량 체크
        if ($file_size) {

            $max_size = $max_size * 1024 * 1024; // 바이트로 계산 1MB = 1024KB = 1048576Byte

            if ($file_size > $max_size) {
                return array("status" => "error", "message" => "파일 용량 초과");
            }

        } else {
            return array("status" => "error", "message" => "파일 오류");
        }

        // 업로드
        if (!move_uploaded_file($tmp_name, $target)) {
            return array("status" => "error", "message" => "업로드 오류");
        }

    } else {
        return array("status" => "error", "message" => "파일 확장자 오류");
    }

    $sql = "
		            INSERT INTO attach_file
		            SET
		                    fk_table = '${table}',
		                    fk_idx = '${idx}',
		                    sort = '${sort}',

		                    file_extension = '${file_extension}',
		                    file_name = '${file_name}',
		                    file_tmp_name = '${file_tmp_name}',
		                    file_size = '${file_size}',

                            create_employee_code = '${_SESSION['employee_code']}'
    ";
    $result = $db->query($sql)->affectedRows();
    $lastIDX = $db->lastInsertID();

    // 과거 데이터 처리
    if ($result != -1) {

        // 과거 데이터 검색
        $sql = "
			            SELECT *
			            FROM attach_file
			            WHERE
				                    fk_table = '${table}'
				                    AND fk_idx = '${idx}'
				                    AND sort = '${sort}'
				                    AND idx < '${lastIDX}'
	    ";
        $list = $db->query($sql)->fetchAll();

        foreach ($list as $item) {

            // 과거 데이터 삭제
            $sql = "
				            DELETE FROM attach_file
				            WHERE idx = '${item['idx']}'
				            LIMIT 1
		    ";
            $db->query($sql);

            // 파일 삭제
            @unlink($upload_root . "/" . $item['file_tmp_name']);
        }
    }

    return $result;
}

// 업로드 파일 삭제 (DB 테이블을 이용한 삭제)
function fileRemove($table, $idx) {
    global $db;
    global $upload_root; // 업로드 폴더

    // 과거 데이터 검색
    $sql = "
		            SELECT *
		            FROM attach_file
		            WHERE
			                    fk_table = '${table}'
			                    AND fk_idx = '${idx}'
    ";
    $list = $db->query($sql)->fetchAll();
    foreach ($list as $item) {

        // 과거 데이터 삭제
        $sql = "
			            DELETE FROM attach_file
			            WHERE idx = '${item['idx']}'
			            LIMIT 1
	    ";
        $result =$db->query($sql);

        // 파일 삭제
        @unlink($upload_root . "/" . $item['file_tmp_name']);
    }

    return $result;
}

// 업로드 파일 삭제 (실제 파일명을 이용한 삭제)
function fileRemoveWithCode($code) {
    global $db;
    global $upload_root; // 업로드 폴더

    // 데이터 삭제
    $sql = "
		            DELETE FROM attach_file
		            WHERE file_tmp_name = '${code}'
		            LIMIT 1
	";
    $result =$db->query($sql)->affectedRows();

    // 파일 삭제
    @unlink($upload_root . "/" . $code);

    return $result;
}