<?php include "../include/config.php"; ?>

<?php

// 변수
$process_mode = sanitize($_REQUEST['process_mode']);

// 저장
if ($process_mode == "login") {

    $code = sanitize($_REQUEST['code']);
    $password = sanitize($_REQUEST['password']);
    $password = enc($password);

    $sql = "
				SELECT *
				FROM jf_users
				WHERE
						code = ?
                    AND password = ?
				LIMIT 1
	";
    $result = $db->query($sql, $code, $password)->fetchArray();

    if ($result) {
        if ($result['status'] == 'N') {

            $temp = array(
                "status" => 0,
                "message" => '비활성화된 계정입니다. 관리자에게 문의해주세요.',
                "redirect" => "",
            );

            echo json_encode($temp);
            exit;
        }
        if ($result['is_admin'] == 'N') {

            $temp = array(
                "status" => 0,
                "message" => '비활성화된 계정입니다. 관리자에게 문의해주세요.',
                "redirect" => "",
            );

            echo json_encode($temp);
            exit;
        }

        session_start();

        $_SESSION['user_idx'] = $result['idx'];
        $_SESSION['user_code'] = $result['code'];
        $_SESSION['user_name'] = $result['name'];
        $_SESSION['is_admin'] = $result['is_admin'];

        $redirect = "index.php";

        $sql = "
					INSERT INTO jf_login_history
					SET user_code = '${result['code']}'
		";
        $result = $db->query($sql);

        $temp = array(
            "status" => 1,
            "message" => "시스템 로그인에 성공했습니다.",
            "redirect" => $redirect,
        );

    } else {
        $temp = array("status" => 0, "message" => "아이디와 비밀번호를 확인하세요.", "redirect" => "");
    }

    echo json_encode($temp);

}