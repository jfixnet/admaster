<?php include_once $_SERVER['DOCUMENT_ROOT'] . "/include/config.php"; ?>

<?php

// 변수
$process_mode = sanitize($_REQUEST['process_mode']);

// 저장
if ($process_mode == "login") {

	// 변수 정리
	$code = sanitize($_REQUEST['code']);
	$password = sanitize($_REQUEST['password']);
	$password = enc($password);

	$end_point = sanitize($_REQUEST['end_point']); // 접속지 체크용

	$sql = "
				SELECT *
				FROM jf_users
				WHERE
							code = ?
							AND password = ?
							AND status = 'Y'
				LIMIT 1
	";
	$result = $db->query($sql, $code, $password)->fetchArray();
	// print_r($result);

	// 분기
	if ($result) {

		session_start();

		// 세션 저장
		$_SESSION['user_idx'] = $result['idx'];
		$_SESSION['user_code'] = $result['code'];
		$_SESSION['user_name'] = $result['name'];
		$_SESSION['is_admin'] = $result['is_admin'];

		$redirect = "/";

		$temp = array(
			"status" => 1,
			"message" => "시스템 로그인에 성공했습니다.",
			"redirect" => $redirect,
		);

		$sql = "
						INSERT INTO jf_login_history
						SET user_code = '${result['code']}'
		";
		$result = $db->query($sql);

	} else {

		$temp = array("status" => 0, "message" => "사원번호와 비밀번호를 확인하세요.", "redirect" => "",);

	}
	echo json_encode($temp);
}

?>
