<?php include_once $_SERVER['DOCUMENT_ROOT'] . "/include/default.php"; ?>

<?php

// 변수
$process_mode = sanitize($_REQUEST['process_mode']);

// 저장

if ($process_mode == 'create') {

	$table_name = 'sign';
	$lastIDX = '1';

    // 첨부파일 처리
    for ($i = 0; $i < count($_FILES['sign']['name']); $i++) {

        if ($_FILES['sign']['name'][$i]) {
            $result_temp = fileUpload($table_name, $lastIDX, "file", $_FILES['sign'], $i);

            if ($result_temp['status'] == "error") { // 업로드 오류
                $message_add =  " [주의 : " . $result_temp['message'] . "]";
            }
        }
    }

    // 분기
    if ($result_temp['status'] == "error") {
		$temp = array(
			"status" => 0,
			"message" => "저장 오류",
            "tmp_name" => ""
		);
    } else {
		$temp = array(
			"status" => 1,
			"message" => "저장되었습니다.",
			"tmp_name" => $result_temp['tmp_name']
		);
    }

    echo json_encode($temp);
}

?>
