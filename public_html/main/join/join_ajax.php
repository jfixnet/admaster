<?php include_once $_SERVER['DOCUMENT_ROOT'] . "/include/config.php"; ?>

<?php

$process_mode = sanitize($_REQUEST['process_mode']);

if ($process_mode == "join") {

	// 변수 정리
	$code = sanitize($_REQUEST['code']);
	$password = sanitize($_REQUEST['password']);
	$re_password = sanitize($_REQUEST['re_password']);
	$reception_status_check = sanitize($_REQUEST['reception_status_check']);

	$sql = "
			SELECT code FROM jf_users WHERE code = '${code}'
	";

	$result = $db->query($sql)->fetchArray();

	if ($result) {
		$temp = array("status" => 0, "message" => "중복되는 아이디가 있습니다..", "redirect" => "",);
		echo json_encode($temp);
		exit;
	}

	if ($password != $re_password) {
		$temp = array("status" => 0, "message" => "비밀번호를 확인하세요.", "redirect" => "",);
		echo json_encode($temp);
		exit;
	}

	$name = sanitize($_REQUEST['name']);
	$phone = sanitize($_REQUEST['phone']);
	$email = sanitize($_REQUEST['email']);
	$reception_status_check = sanitize($_REQUEST['reception_status_check']);
	$password = enc($password);

	$reception_status = 'N';
	if ($reception_status_check == 'on') {
		$reception_status = 'Y';
	}

	$sql = "
				INSERT INTO jf_users
				SET 
					code = '${code}',
					password = '${password}',
					name ='${name}',
					phone ='${phone}',
					email ='${email}',
					status ='Y',
					reception_status = '${reception_status}'
	";

	$result = $db->query($sql);
	// print_r($result);

	$temp = array(
		"status" => 1,
		"message" => "시스템 로그인에 성공했습니다.",
		"redirect" => "/",
	);

	echo json_encode($temp);
}

else if ($process_mode == 'code_check') {

	$code = sanitize($_REQUEST['code']);
	$sql = "
			SELECT code FROM jf_users WHERE code = '${code}'
	";

	$result = $db->query($sql)->fetchArray();

	if (!$result) {
		$temp = array("status" => true);
		echo json_encode($temp);
		exit;
	}

	$temp = array("status" => false);
	echo json_encode($temp);
	exit;
}

?>
