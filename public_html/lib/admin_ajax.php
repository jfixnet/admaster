<?php include "config.php"; ?>

<?php include "../lib/admin_auth.php"; ?>

<?php

// 변수
$process_mode = sanitize($_REQUEST['process_mode']);

// 저장
if ($process_mode == "list") {


}

else if ($process_mode == "login") {

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

        $redirect = "../adm/index.php";

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

else if ($process_mode == "board_list") {

    $sql = "
                    SELECT *
                    
                    FROM jf_board_management
                    
                    WHERE
                        1 = 1
                                        
                    ORDER BY idx desc
    ";

    $result = $db->query($sql)->fetchAll();

    echo json_encode($result);

}

else if ($process_mode == 'board_create') {

    $table_name = sanitize($_REQUEST['table_name']);
    $table_title = sanitize($_REQUEST['table_title']);
    $secret_mode = sanitize($_REQUEST['secret_mode']);
    $admin_only = sanitize($_REQUEST['admin_only']);
    $comment_mode = sanitize($_REQUEST['comment_mode']);
    $memo = sanitize($_REQUEST['memo']);
    $skin = sanitize($_REQUEST['skin']);
    $attach_file_num = sanitize($_REQUEST['attach_file_num']);

    $sql = "
                    SELECT *
                    
                    FROM jf_board_management
                    
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
              `content` longtext DEFAULT NULL COMMENT '내용',
              `user_name` varchar(25) NOT NULL COMMENT '작성자명',
              `write_password` varchar(255) DEFAULT NULL COMMENT '글 비밀번호',
              `view_count` int(10) DEFAULT 0 COMMENT '조회수',
              
              `create_date` datetime DEFAULT current_timestamp(),
              `create_user_code` varchar(25) DEFAULT NULL,
              `update_date` datetime DEFAULT NULL ON UPDATE current_timestamp(),
              `update_user_code` varchar(25) DEFAULT NULL,
              PRIMARY KEY (`idx`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='${memo}';
    ";

    $board_create = $db->query($sql)->affectedRows();

    $sql = "
                    INSERT INTO jf_board_management
                    SET
                            table_name = '${table_name}',
                            table_title = '${table_title}',
                            secret_mode = '${secret_mode}',
                            admin_only = '${admin_only}',
                            comment_mode = '${comment_mode}',
                            skin = '${skin}',
                            attach_file_num = '${attach_file_num}',
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
}

else if ($process_mode == 'board_update') {

    $table_name = sanitize($_REQUEST['table_name']);
    $table_title = sanitize($_REQUEST['table_title']);
    $memo = sanitize($_REQUEST['memo']);
    $secret_mode = sanitize($_REQUEST['secret_mode']);
    $admin_only = sanitize($_REQUEST['admin_only']);
    $comment_mode = sanitize($_REQUEST['comment_mode']);
    $skin = sanitize($_REQUEST['skin']);
    $attach_file_num = sanitize($_REQUEST['attach_file_num']);

    $sql = "
                    UPDATE jf_board_management
                    SET
                            table_title = '${table_title}',
                            secret_mode = '${secret_mode}',
                            admin_only = '${admin_only}',
                            comment_mode = '${comment_mode}',
                            skin = '${skin}',
                            attach_file_num = '${attach_file_num}',
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

}

else if ($process_mode == 'board_view') {

    $table_name = sanitize($_REQUEST['table_name']);

    $sql = "
                    SELECT *
                    
                    FROM jf_board_management
                    
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

else if ($process_mode == "stat_list") {
    $srch_start_date = sanitize($_REQUEST['srch_start_date']);
    $srch_end_date = sanitize($_REQUEST['srch_end_date']);

    // DataTables 요청 처리
    $draw = $_GET['draw'];
    $start = $_GET['start'];
    $length = $_GET['length'];
    $search = $_GET['search']['value'];
    $order = $_GET['order'];
    $column = $order[0]['column'];

    // 기본 정렬
    if (!$column) {
        $column = 0;
    }

    $dir = $order[0]['dir'];
    if (!$dir) {
        $dir = 'desc';
    }

    $sql_where = " AND create_date BETWEEN  '${srch_start_date} 00:00:00' AND '${srch_end_date} 23:59:59'";

    $columns = array(
        0 => 'idx',
        1 => 'title',
        2 => 'user_name',
        3 => 'create_date',
    );

    $orderColumn = $columns[$column];
    $orderDirection = $dir;

    // 총 개수
    $sql = "
                    SELECT count(*) as count
                    
                    FROM jf_visitor_count
                    
                    WHERE
                        1 = 1
                    
                    ORDER BY idx
    ";

    $total_count = $db->query($sql)->fetchArray();

    // 검색 조건 총 개수
    $sql = "
                    SELECT count(*) as count
                    
                    FROM jf_visitor_count
                    
                    WHERE
                        1 = 1
                    
                        ${sql_where}
                    
                    ORDER BY idx
    ";

    $filter_count = $db->query($sql)->fetchArray();

    // 데이터 쿼리
    $sql = "
                    SELECT *
                    
                    FROM jf_visitor_count
                    
                    WHERE
                        1 = 1
                                        
                        ${sql_where}
                    
                    ORDER BY ${orderColumn} ${orderDirection}
                    
                    LIMIT ${start}, ${length}
    ";

    $result = $db->query($sql)->fetchAll();

    $list = [];
    $no = 0;
    foreach ($result as $item) {
        $list[] = $item;
    }

    $data = array(
        "draw" => $draw,
        "recordsTotal" => $total_count['count'],
        "recordsFiltered" => $filter_count['count'],
        "data" => $list
    );

    echo json_encode($data);
}

else if ($process_mode == "stat_list2") {
    $srch_start_date = sanitize($_REQUEST['srch_start_date']);
    $srch_end_date = sanitize($_REQUEST['srch_end_date']);

    $sql_where = " AND create_date BETWEEN  '${srch_start_date} 00:00:00' AND '${srch_end_date} 23:59:59'";


    $sql = "
                    SELECT count(*) as total_count
                    
                    FROM jf_visitor_count
                    
                    WHERE
                        1 = 1
                                        
                        ${sql_where}
                    
    ";

    $total_count_data = $db->query($sql)->fetchArray();

    // 데이터 쿼리
    $sql = "
                    SELECT *, count(*) as count
                    
                    FROM jf_visitor_count
                    
                    WHERE
                        1 = 1
                                        
                        ${sql_where}
                    
                    GROUP BY route
                    
                    ORDER BY count DESC
                    
    ";

    $result = $db->query($sql)->fetchAll();

    $list = [];
    $rank = 1;
    foreach ($result as $item) {

        $item['rank'] = $rank++;
        $item['per'] = number_format($item['count'] / $total_count_data['total_count'] * 100,1);

        $list[] = $item;
    }

    $result = $list;

    echo json_encode($result);
}

else if ($process_mode == "stat_list3") {
    $srch_start_date = sanitize($_REQUEST['srch_start_date']);
    $srch_end_date = sanitize($_REQUEST['srch_end_date']);

    $sql_where = " AND create_date BETWEEN  '${srch_start_date} 00:00:00' AND '${srch_end_date} 23:59:59'";


    $sql = "
                    SELECT count(*) as total_count
                    
                    FROM jf_visitor_count
                    
                    WHERE
                        1 = 1
                                        
                        ${sql_where}
                    
    ";

    $total_count_data = $db->query($sql)->fetchArray();

    // 데이터 쿼리
    $sql = "
                    SELECT *, count(*) as count
                    
                    FROM jf_visitor_count
                    
                    WHERE
                        1 = 1
                                        
                        ${sql_where}
                    
                    GROUP BY browser
                    
                    ORDER BY count DESC
                    
    ";

    $result = $db->query($sql)->fetchAll();

    $list = [];
    $rank = 1;
    foreach ($result as $item) {

        $item['rank'] = $rank++;
        $item['per'] = number_format($item['count'] / $total_count_data['total_count'] * 100,1);

        $list[] = $item;
    }

    $result = $list;

    echo json_encode($result);
}

else if ($process_mode == "stat_list4") {
    $srch_start_date = sanitize($_REQUEST['srch_start_date']);
    $srch_end_date = sanitize($_REQUEST['srch_end_date']);

    $sql_where = " AND create_date BETWEEN  '${srch_start_date} 00:00:00' AND '${srch_end_date} 23:59:59'";


    $sql = "
                    SELECT count(*) as total_count
                    
                    FROM jf_visitor_count
                    
                    WHERE
                        1 = 1
                                        
                        ${sql_where}
                    
    ";

    $total_count_data = $db->query($sql)->fetchArray();

    // 데이터 쿼리
    $sql = "
                    SELECT *, count(*) as count
                    
                    FROM jf_visitor_count
                    
                    WHERE
                        1 = 1
                                        
                        ${sql_where}
                    
                    GROUP BY os
                    
                    ORDER BY count DESC
                    
    ";

    $result = $db->query($sql)->fetchAll();

    $list = [];
    $rank = 1;
    foreach ($result as $item) {

        $item['rank'] = $rank++;
        $item['per'] = number_format($item['count'] / $total_count_data['total_count'] * 100,1);

        $list[] = $item;
    }

    $result = $list;

    echo json_encode($result);
}

else if ($process_mode == "stat_list5") {
    $srch_start_date = sanitize($_REQUEST['srch_start_date']);
    $srch_end_date = sanitize($_REQUEST['srch_end_date']);

    $sql_where = " AND create_date BETWEEN  '${srch_start_date} 00:00:00' AND '${srch_end_date} 23:59:59'";


    $sql = "
                    SELECT count(*) as total_count
                    
                    FROM jf_visitor_count
                    
                    WHERE
                        1 = 1
                                        
                        ${sql_where}
                    
    ";

    $total_count_data = $db->query($sql)->fetchArray();

    // 데이터 쿼리
    $sql = "
                    SELECT *, count(*) as count
                    
                    FROM jf_visitor_count
                    
                    WHERE
                        1 = 1
                                        
                        ${sql_where}
                    
                    GROUP BY device
                    
                    ORDER BY count DESC
                    
    ";

    $result = $db->query($sql)->fetchAll();

    $list = [];
    $rank = 1;
    foreach ($result as $item) {

        $item['rank'] = $rank++;
        $item['per'] = number_format($item['count'] / $total_count_data['total_count'] * 100,1);

        $list[] = $item;
    }

    $result = $list;

    echo json_encode($result);
}

else if ($process_mode == "stat_list6") {
    $srch_start_date = sanitize($_REQUEST['srch_start_date']);
    $srch_end_date = sanitize($_REQUEST['srch_end_date']);

    $sql_where = " AND create_date BETWEEN  '${srch_start_date} 00:00:00' AND '${srch_end_date} 23:59:59'";


    $sql = "
                    SELECT count(*) as total_count
                    
                    FROM jf_visitor_count
                    
                    WHERE
                        1 = 1
                                        
                        ${sql_where}
                    
    ";

    $total_count_data = $db->query($sql)->fetchArray();

    $time_arr = [
        ['hour'=>'00:00', 'count'=> 0],
        ['hour'=>'01:00', 'count'=> 0],
        ['hour'=>'02:00', 'count'=> 0],
        ['hour'=>'03:00', 'count'=> 0],
        ['hour'=>'04:00', 'count'=> 0],
        ['hour'=>'05:00', 'count'=> 0],
        ['hour'=>'06:00', 'count'=> 0],
        ['hour'=>'07:00', 'count'=> 0],
        ['hour'=>'08:00', 'count'=> 0],
        ['hour'=>'09:00', 'count'=> 0],
        ['hour'=>'10:00', 'count'=> 0],
        ['hour'=>'11:00', 'count'=> 0],
        ['hour'=>'12:00', 'count'=> 0],
        ['hour'=>'13:00', 'count'=> 0],
        ['hour'=>'14:00', 'count'=> 0],
        ['hour'=>'15:00', 'count'=> 0],
        ['hour'=>'16:00', 'count'=> 0],
        ['hour'=>'17:00', 'count'=> 0],
        ['hour'=>'18:00', 'count'=> 0],
        ['hour'=>'19:00', 'count'=> 0],
        ['hour'=>'20:00', 'count'=> 0],
        ['hour'=>'21:00', 'count'=> 0],
        ['hour'=>'22:00', 'count'=> 0],
        ['hour'=>'23:00', 'count'=> 0]
    ];

    // 데이터 쿼리
    $sql = "
                    SELECT DATE_FORMAT(create_date, '%H:00') AS hour, count(*) as count
                    
                    FROM jf_visitor_count
                    
                    WHERE
                        1 = 1
                                        
                        ${sql_where}
                    
                    GROUP BY hour
                    
                    ORDER BY hour

    ";

    $result = $db->query($sql)->fetchAll();

    foreach ($time_arr as $item) {

        foreach ($result as $date_item) {

            $count = 0;
            if ($item['hour'] == $date_item['hour']) {
                $item['count'] = $date_item['count'];
                break;
            }
        }

        $item['per'] = number_format($item['count'] / $total_count_data['total_count'] * 100,1);

        $list[] = $item;
    }

    $result = $list;

    echo json_encode($result);
}

else if ($process_mode == "stat_list7") {
    $srch_start_date = sanitize($_REQUEST['srch_start_date']);
    $srch_end_date = sanitize($_REQUEST['srch_end_date']);

    $sql_where = " AND create_date BETWEEN  '${srch_start_date} 00:00:00' AND '${srch_end_date} 23:59:59'";


    $sql = "
                    SELECT count(*) as total_count
                    
                    FROM jf_visitor_count
                    
                    WHERE
                        1 = 1
                                        
                        ${sql_where}
                    
    ";

    $total_count_data = $db->query($sql)->fetchArray();

    $time_arr = [
        ['day'=>'Mon', 'day_ko'=>'월', 'count'=> 0],
        ['day'=>'Tue', 'day_ko'=>'화', 'count'=> 0],
        ['day'=>'Wed', 'day_ko'=>'수', 'count'=> 0],
        ['day'=>'Thu', 'day_ko'=>'목', 'count'=> 0],
        ['day'=>'Fri', 'day_ko'=>'금', 'count'=> 0],
        ['day'=>'Sat', 'day_ko'=>'토', 'count'=> 0],
        ['day'=>'Sun', 'day_ko'=>'일', 'count'=> 0]
    ];

    // 데이터 쿼리
    $sql = "
                    SELECT DATE_FORMAT(create_date, '%a') AS day, count(*) as count
                    
                    FROM jf_visitor_count
                    
                    WHERE
                        1 = 1
                                        
                        ${sql_where}
                    
                    GROUP BY day
                    
                    ORDER BY day

    ";

    $result = $db->query($sql)->fetchAll();

    foreach ($time_arr as $item) {

        foreach ($result as $date_item) {

            $count = 0;
            if ($item['day'] == $date_item['day']) {
                $item['count'] = $date_item['count'];
                break;
            }
        }

        $item['per'] = number_format($item['count'] / $total_count_data['total_count'] * 100,1);

        $list[] = $item;
    }

    $result = $list;

    echo json_encode($result);
}

else if ($process_mode == "stat_list8") {
    $srch_start_date = sanitize($_REQUEST['srch_start_date']);
    $srch_end_date = sanitize($_REQUEST['srch_end_date']);

    $sql_where = " AND create_date BETWEEN  '${srch_start_date} 00:00:00' AND '${srch_end_date} 23:59:59'";


    $sql = "
                    SELECT count(*) as total_count
                    
                    FROM jf_visitor_count
                    
                    WHERE
                        1 = 1
                                        
                        ${sql_where}
                    
    ";

    $total_count_data = $db->query($sql)->fetchArray();

    $dateArray = array_reverse(createDateRangeArray($srch_start_date, $srch_end_date));

    // 데이터 쿼리
    $sql = "
                    SELECT DATE_FORMAT(create_date, '%Y-%m-%d') AS day, count(*) as count
                    
                    FROM jf_visitor_count
                    
                    WHERE
                        1 = 1
                                        
                        ${sql_where}
                    
                    GROUP BY day
                    
                    ORDER BY day

    ";

    $result = $db->query($sql)->fetchAll();

    foreach ($dateArray as $item) {

        foreach ($result as $date_item) {

            $count = 0;
            if ($item['day'] == $date_item['day']) {
                $item['count'] = $date_item['count'];
                break;
            }
        }

        $item['per'] = number_format($item['count'] / $total_count_data['total_count'] * 100,1);

        $list[] = $item;
    }

    $result = $list;

    echo json_encode($result);
}

else if ($process_mode == "stat_list9") {
    $srch_start_date = date('Y-m',strtotime(sanitize($_REQUEST['srch_start_date'])));
    $srch_end_date = date('Y-m',strtotime(sanitize($_REQUEST['srch_end_date'])));

    $sql_where = " AND create_date BETWEEN  '${srch_start_date}-01 00:00:00' AND '${srch_end_date}-31 23:59:59'";

    $sql = "
                    SELECT count(*) as total_count
                    
                    FROM jf_visitor_count
                    
                    WHERE
                        1 = 1
                                        
                        ${sql_where}
                    
    ";

    $total_count_data = $db->query($sql)->fetchArray();

    $dateArray = array_reverse(createMonthRangeArray($srch_start_date, $srch_end_date));

    // 데이터 쿼리
    $sql = "
                    SELECT DATE_FORMAT(create_date, '%Y-%m') AS day, count(*) as count
                    
                    FROM jf_visitor_count
                    
                    WHERE
                        1 = 1
                                        
                        ${sql_where}
                    
                    GROUP BY day
                    
                    ORDER BY day

    ";

    $result = $db->query($sql)->fetchAll();

    foreach ($dateArray as $item) {

        foreach ($result as $date_item) {

            $count = 0;
            if ($item['day'] == $date_item['day']) {
                $item['count'] = $date_item['count'];
                break;
            }
        }

        $item['per'] = number_format($item['count'] / $total_count_data['total_count'] * 100,1);

        $list[] = $item;
    }

    $result = $list;

    echo json_encode($result);
}

else if ($process_mode == "stat_list10") {
    $srch_start_date = date('Y',strtotime(sanitize($_REQUEST['srch_start_date'])));
    $srch_end_date = date('Y',strtotime(sanitize($_REQUEST['srch_end_date'])));

    $sql_where = " AND create_date BETWEEN  '${srch_start_date}-01-01 00:00:00' AND '${srch_end_date}-12-31 23:59:59'";

    $sql = "
                    SELECT count(*) as total_count
                    
                    FROM jf_visitor_count
                    
                    WHERE
                        1 = 1
                                        
                        ${sql_where}
                    
    ";

    $total_count_data = $db->query($sql)->fetchArray();

    $dateArray = array_reverse(createYearRangeArray($srch_start_date, $srch_end_date));

    // 데이터 쿼리
    $sql = "
                    SELECT DATE_FORMAT(create_date, '%Y') AS day, count(*) as count
                    
                    FROM jf_visitor_count
                    
                    WHERE
                        1 = 1
                                        
                        ${sql_where}
                    
                    GROUP BY day
                    
                    ORDER BY day
    ";

    $result = $db->query($sql)->fetchAll();

    foreach ($dateArray as $item) {

        foreach ($result as $date_item) {

            $count = 0;
            if ($item['day'] == $date_item['day']) {
                $item['count'] = $date_item['count'];
                break;
            }
        }

        $item['per'] = number_format($item['count'] / $total_count_data['total_count'] * 100,1);

        $list[] = $item;
    }

    $result = $list;

    echo json_encode($result);
}

else if ($process_mode == 'board_setting_view') {

    $sql = "
                    SELECT contents
                    
                    FROM jf_board_setting
                    
                    WHERE type = 'extension'
                                        
                    ORDER BY idx desc
    ";

    $extension_data = $db->query($sql)->fetchArray();

    $result['data']['extension'] = $extension_data['contents']; // 리턴값 초기화

    $sql = "
                    SELECT contents
                    
                    FROM jf_board_setting
                    
                    WHERE type = 'filtering'
                                        
                    ORDER BY idx desc
    ";

    $filtering_data = $db->query($sql)->fetchArray();

    $result['data']['filtering'] = $filtering_data['contents']; // 리턴값 초기화

    $sql = "
                    SELECT contents
                    
                    FROM jf_board_setting
                    
                    WHERE type = 'phone_check'
                                        
                    ORDER BY idx desc
    ";

    $filtering_data = $db->query($sql)->fetchArray();

    $result['data']['phone_check'] = $filtering_data['contents']; // 리턴값 초기화

    $sql = "
                    SELECT contents
                    
                    FROM jf_board_setting
                    
                    WHERE type = 'email_check'
                                        
                    ORDER BY idx desc
    ";

    $filtering_data = $db->query($sql)->fetchArray();

    $result['data']['email_check'] = $filtering_data['contents']; // 리턴값 초기화

    $sql = "
                    SELECT contents
                    
                    FROM jf_board_setting
                    
                    WHERE type = 'address_check'
                                        
                    ORDER BY idx desc
    ";

    $filtering_data = $db->query($sql)->fetchArray();

    $result['data']['address_check'] = $filtering_data['contents']; // 리턴값 초기화

    echo json_encode($result);
}

else if ($process_mode == 'board_setting_update') {

    $extension = $_REQUEST['extension'];
    $filtering = $_REQUEST['filtering'];
    $phone_check = $_REQUEST['phone_check'];
    $email_check = $_REQUEST['email_check'];
    $address_check = $_REQUEST['address_check'];

    $sql = "
                    DELETE FROM jf_board_setting
                    WHERE type = 'extension' 
                    LIMIT 1
    ";

    $result = $db->query($sql)->affectedRows();

    $sql = "
					INSERT INTO jf_board_setting
					SET 
					    type = 'extension',
					    contents = '${extension}'
					
					
		";
    $result = $db->query($sql);

    $sql = "
                    DELETE FROM jf_board_setting
                    WHERE type = 'filtering' 
                    LIMIT 1
    ";

    $result = $db->query($sql)->affectedRows();

    $sql = "
					INSERT INTO jf_board_setting
					SET 
					    type = 'filtering',
					    contents = '${filtering}'
					
					
		";
    $result = $db->query($sql);

    $sql = "
                    DELETE FROM jf_board_setting
                    WHERE type = 'phone_check' 
                    LIMIT 1
    ";

    $result = $db->query($sql)->affectedRows();

    $sql = "
					INSERT INTO jf_board_setting
					SET 
					    type = 'phone_check',
					    contents = '${phone_check}'
					
					
		";
    $result = $db->query($sql);

    $sql = "
                    DELETE FROM jf_board_setting
                    WHERE type = 'email_check' 
                    LIMIT 1
    ";

    $result = $db->query($sql)->affectedRows();

    $sql = "
					INSERT INTO jf_board_setting
					SET 
					    type = 'email_check',
					    contents = '${email_check}'
					
					
		";
    $result = $db->query($sql);

    $sql = "
                    DELETE FROM jf_board_setting
                    WHERE type = 'address_check' 
                    LIMIT 1
    ";

    $result = $db->query($sql)->affectedRows();

    $sql = "
					INSERT INTO jf_board_setting
					SET 
					    type = 'address_check',
					    contents = '${address_check}'
					
					
		";
    $result = $db->query($sql);

    // 분기
    if ($result != -1) {
        $temp = array(
            "status" => 1,
            "message" => "저장 되었습니다.",
        );
    } else {
        $temp = array(
            "status" => 0,
            "message" => "저장 오류",
        );
    }

    echo json_encode($temp);
}