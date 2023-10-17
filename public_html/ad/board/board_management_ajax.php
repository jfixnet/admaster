<?php include_once $_SERVER['DOCUMENT_ROOT'] . "/include/default.php"; ?>

<?php

// 변수
$process_mode = sanitize($_REQUEST['process_mode']);

if ($process_mode == "list") {

    $sql = "
                    SELECT *
                    
                    FROM board_management
                    
                    WHERE
                        1 = 1
                                        
                    ORDER BY idx desc
    ";

    $result = $db->query($sql)->fetchAll();

    echo json_encode($result);

} else if ($process_mode == 'create') {

    $table_name = sanitize($_REQUEST['table_name']);
    $memo = sanitize($_REQUEST['memo']);

    $sql = "
                    SELECT *
                    
                    FROM board_management
                    
                    WHERE
                        1 = 1
                    
                    and table_name = '${table_name}'
                                        
                    ORDER BY idx desc
    ";

    $board_check = $db->query($sql)->fetchArray();

    if ($board_check) {
        $temp = array(
            "status" => 0,
            "message" => '테이블명이 존재합니다.',
            "redirect" => "",
        );

        echo json_encode($temp);
        exit;
    }

    $sql = "
                CREATE TABLE `${table_name}` (
              `idx` int(10) unsigned NOT NULL AUTO_INCREMENT,
              `title` varchar(255) NOT NULL COMMENT '제목',
              `content` longtext NOT NULL COMMENT '내용',
              `user_name` varchar(25) NOT NULL COMMENT '작성자명',
              `write_password` varchar(255) NOT NULL COMMENT '게시글 비밀번호',
              
              `create_date` datetime DEFAULT current_timestamp(),
              `create_user_code` varchar(25) DEFAULT NULL,
              `update_date` datetime DEFAULT NULL ON UPDATE current_timestamp(),
              `update_user_code` varchar(25) DEFAULT NULL,
              PRIMARY KEY (`idx`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='${memo}';
    ";

    $board_create = $db->query($sql);


    $sql = "
                    INSERT INTO board_management
                    SET
                            table_name = '${table_name}',
                            memo = '${memo}'
    ";

    $board_management_result = $db->query($sql)->affectedRows();

    // 분기
    if ($board_management_result != -1) {
        $temp = array(
            "status" => 1,
            "message" => "생성 되었습니다.",
        );
    } else {
        $temp = array(
            "status" => 0,
            "message" => "저장 오류",
        );
    }

    echo json_encode($temp);
} else if ($process_mode == 'update') {

    $table_name = sanitize($_REQUEST['table_name']);
    $memo = sanitize($_REQUEST['memo']);

    $sql = "
                    UPDATE board_management
                    SET
                            memo = '${memo}'
                    WHERE table_name = '${table_name}' 
                    LIMIT 1
    ";

    $board_management_result = $db->query($sql)->affectedRows();

    // 분기
    if ($board_management_result != -1) {
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
} else if ($process_mode == 'view') {

    $table_name = sanitize($_REQUEST['table_name']);

    $sql = "
                    SELECT *
                    
                    FROM board_management
                    
                    WHERE
                        1 = 1
                    
                    and table_name = '${table_name}'
                                        
                    ORDER BY idx desc
    ";

    //$board_check = $db->query($sql)->fetchArray();

    $list = $db->query($sql)->fetchAll();

    $result['data'] = []; // 리턴값 초기화
    foreach ($list as $item) {

        $result['data'] = $item;
    }

    echo json_encode($result);
}