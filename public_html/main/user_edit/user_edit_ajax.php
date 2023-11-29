<?php include_once $_SERVER['DOCUMENT_ROOT'] . "/include/config.php"; ?>
<?php include_once $_SERVER['DOCUMENT_ROOT'] . "/include/auth.php"; ?>
<?php

// 변수
$process_mode = sanitize($_REQUEST['process_mode']);

 if ($process_mode == 'view') {

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

 else if ($process_mode == 'update') {

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
