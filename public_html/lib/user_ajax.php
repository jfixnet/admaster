<?php include "config.php"; ?>

<?php include "../lib/auth.php"; ?>

<?php

// 변수
$process_mode = sanitize($_REQUEST['process_mode']);

if ($process_mode == "visitor_count") {

    //    접속자 IP
    $ip = $_SERVER['REMOTE_ADDR'];

    if (!$ip) {
        $result = [];
        echo json_encode($result);
        exit;
    }

    $sql = "
                    SELECT *
                    
                    FROM jf_visitor_count
                    
                    WHERE
                        1 = 1
                    
                    AND ip = '${ip}'
    ";

    $result = $db->query($sql)->fetchArray();

    $addedTime = strtotime($result['create_date']) + 600;
    $newTime = date("Y-m-d H:i:s", $addedTime);

    if (date('Y-m-d H:i:s') <= $newTime) {
        $result = [];
        echo json_encode($result);
        exit;
    }

    $referrer = $_REQUEST['referrer'];
    if (!$referrer) {
        $referrer = '/';
    }

    $agent = getBrowserInfo();
    $os = getOsInfo();
    $device = getDeviceInfo();

    $sql = "
                    INSERT INTO jf_visitor_count
                    
                    SET 
                        ip = '${ip}',
                        route = '${referrer}',
                        browser = '${agent}',
                        os = '${os}',
                        device = '${device}'
    ";

    $result = $db->query($sql)->affectedRows();

    echo json_encode($result);
    exit;
}

else if ($process_mode == "join") {

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
        "redirect" => "index.php",
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

else if ($process_mode == "login") {

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

        $redirect = "index.php";

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

        $temp = array("status" => 0, "message" => "dkdlel와 비밀번호를 확인하세요.", "redirect" => "",);

    }
    echo json_encode($temp);
}

else if ($process_mode == 'user_info_view') {

    $sql = "
                    SELECT code, name, phone, email
                    
                    FROM jf_users
                    
                    WHERE
                        1 = 1
                    
                    AND code = '${_SESSION['user_code']}'
    ";

    $result = $db->query($sql)->fetchArray();

    echo json_encode($result);
}

else if ($process_mode == 'user_info_update') {

    $name = sanitize($_REQUEST['name']);
    $email = sanitize($_REQUEST['email']);
    $phone = sanitize($_REQUEST['phone']);
    $password = sanitize($_REQUEST['password']);
    $user_code = $_SESSION['user_code'];

    if (!$name) {
        $name = $_SESSION['user_name'];
    }

    $sql = "
                    SELECT code, name, phone, email
                    
                    FROM jf_users
                    
                    WHERE
                        1 = 1
                    
                    AND code = '${_SESSION['user_code']}'
    ";

    $result = $db->query($sql)->fetchArray();
    $password = enc($password);
    if ($result['password'] != $password) {
        $temp = array(
            "status" => 0,
            "message" => "비밀번호가 다릅니다.",
        );
        echo json_encode($temp);
        exit;
    }

    $new_password = sanitize($_REQUEST['new_password']);
    $password = enc($new_password);

    $sql = "
                    UPDATE jf_users
                    SET
                            name = '${name}',
                            email = '${email}',
                            phone = '${phone}',
                            password = '${password}'
                    WHERE code = '${user_code}'
                    LIMIT 1
    ";

    $result = $db->query($sql)->affectedRows();

    // 분기
    if ($result != -1) {
        $temp = array(
            "status" => 1,
            "message" => "수정되었습니다.",
        );
    } else {
        $temp = array(
            "status" => 0,
            "message" => "저장 오류",
        );
    }

    echo json_encode($temp);
}

function getBrowserInfo()
{
    $userAgent = $_SERVER["HTTP_USER_AGENT"];
    if(preg_match('/MSIE/i',$userAgent) && !preg_match('/Opera/i',$u_agent)){
        $browser = 'Internet Explorer';
    }
    else if(preg_match('/Firefox/i',$userAgent)){
        $browser = 'Mozilla Firefox';
    }
    else if (preg_match('/Chrome/i',$userAgent)){
        $browser = 'Google Chrome';
    }
    else if(preg_match('/Safari/i',$userAgent)){
        $browser = 'Apple Safari';
    }
    else if(preg_match('/Opera/i',$userAgent)){
        $browser = 'Opera';
    }
    else if(preg_match('/Netscape/i',$userAgent)){
        $browser = 'Netscape';
    }
    else{
        $browser = "Other";
    }

    return $browser;
}
function getOsInfo()
{
    $userAgent = $_SERVER["HTTP_USER_AGENT"];

    if (preg_match('/linux/i', $userAgent)){
        $os = 'linux';}
    else if(preg_match('/macintosh|mac os x/i', $userAgent)){
        $os = 'mac';}
    else if (preg_match('/windows|win32/i', $userAgent)){
        $os = 'windows';}
    else {
        $os = 'Other';
    }

    return $os;
}
function getDeviceInfo()
{
    $userAgent = $_SERVER["HTTP_USER_AGENT"];

    if (preg_match('/iPhone/i', $userAgent)){
        $os = 'iPhone';
    } else if(preg_match('/iPad/i', $userAgent)){
        $os = 'iPad';
    } else if (preg_match('/Android/i', $userAgent)){
        $os = 'Android';
    } else if (preg_match('/Windows Phone/i', $userAgent)){
        $os = 'window phone';
    } else {
        $os = 'Other';
    }

    return $os;
}
