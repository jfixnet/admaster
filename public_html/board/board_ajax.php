<?php include_once $_SERVER['DOCUMENT_ROOT'] . "/include/default.php"; ?>

<?php

// 변수
$process_mode = sanitize($_REQUEST['process_mode']);

if ($process_mode == "list") {
    $table_name = sanitize($_REQUEST['table_name']);
    $srch_key = sanitize($_REQUEST['srch_key']);
    $srch_keyword = sanitize($_REQUEST['srch_keyword']);

    // DataTables 요청 처리
    $draw = $_GET['draw'];
    $start = $_GET['start'];
    $length = $_GET['length'];
    $search = $_GET['search']['value'];
    $order = $_GET['order'];
    $column = $order[0]['column'];
    if (!$column) {
        $column = 0;
    }
    $dir = $order[0]['dir'];
    if (!$dir) {
        $dir = 'desc';
    }

    $sql_where = '';
    if ($srch_keyword) {
        $sql_where .= " AND $srch_key LIKE '%{$srch_keyword}%' ";
    }

    $columns = array(
        0 => 'idx',
        1 => 'title',
        2 => 'user_name',
        3 => 'view_count',
        4 => 'create_date',
    );

    $orderColumn = $columns[$column];
    $orderDirection = $dir;

    // 총 개수
    $sql = "
                    SELECT count(*) as count
                    
                    FROM ${table_name}
                    
                    WHERE
                        1 = 1
                    
                    ORDER BY idx
    ";

    $total_count = $db->query($sql)->fetchArray();

    // 검색 조건 총 개수
    $sql = "
                    SELECT count(*) as count
                    
                    FROM ${table_name}
                    
                    WHERE
                        1 = 1
                    
                        ${sql_where}
                    
                    ORDER BY idx
    ";

    $filter_count = $db->query($sql)->fetchArray();

    // 데이터 쿼리
    $sql = "
                    SELECT *, (select count(*) from ${table_name}) as total_count
                    
                    FROM ${table_name}
                    
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
        $item['no'] = count($result) - $no;
        $no = $no + 1;

        $list[] = $item;
    }

    $data = array(
        "draw" => $draw,
        "recordsTotal" => $total_count['count'],
        "recordsFiltered" => $filter_count['count'],
        "data" => $list,
    );

    echo json_encode($data);
}

else if ($process_mode == 'create') {

    $table_name = sanitize($_REQUEST['form_table_name']);
    $title = sanitize($_REQUEST['title']);
    $content = $_REQUEST['content'];
    $user_name = $_REQUEST['user_name'];
    $write_password = $_REQUEST['write_password'];
    $write_password = enc($write_password);

    if ($_SESSION['user_name']) {
        $user_name = $_SESSION['user_name'];
    }

    $sql = "
                    INSERT INTO ${table_name}
                    
                    SET 
                        title = '${title}',
                        content = '${content}',
                        user_name = '${user_name}',
                        write_password = '${write_password}',
                        create_user_code = '${_SESSION['user_code']}'
    ";

    $result = $db->query($sql)->affectedRows();
    $lastIDX = $db->lastInsertID();

    // 첨부파일 처리
    for ($i = 0; $i < count($_FILES['file']['name']); $i++) {
        if ($_FILES['file']['name'][$i]) {
            $result_temp = fileUpload($table_name, $lastIDX, "file", $_FILES['file'], $i);

            if ($result_temp['status'] == "error") { // 업로드 오류
                $message_add =  " [주의 : " . $result_temp['message'] . "]";
            }
        }
    }

    // 분기
    if ($result != -1) {
        $temp = array(
            "status" => 1,
            "message" => "저장되었습니다.",
        );
    } else {
        $temp = array(
            "status" => 0,
            "message" => "저장 오류",
        );
    }

    echo json_encode($temp);
}

else if ($process_mode == 'update') {

    $idx = $_REQUEST['idx'];
    $table_name = sanitize($_REQUEST['form_table_name']);
    $title = sanitize($_REQUEST['title']);
    $content = $_REQUEST['content'];
    $user_name = $_REQUEST['user_name'];
    $write_password = $_REQUEST['write_password'];

    $set_write_password = '';
    if ($write_password) {
        $write_password = enc($write_password);
        $set_write_password = ", write_password = '${write_password}'";
    }

    if ($_SESSION['user_name']) {
        $user_name = $_SESSION['user_name'];
    }

    $sql = "
                    UPDATE ${table_name}
                    SET
                            title = '${title}',
                            content = '${content}',
                            user_name = '${user_name}'
                            
                            ${set_write_password}
                    
                    WHERE idx = '${idx}' 
                    LIMIT 1
    ";

    $result = $db->query($sql)->affectedRows();

    // 첨부파일 처리
    for ($i = 0; $i < count($_FILES['file']['name']); $i++) {
        if ($_FILES['file']['name'][$i]) {
            $result_temp = fileUpload($table_name, $idx, "file", $_FILES['file'], $i);
            if ($result_temp['status'] == "error") { // 업로드 오류
                $message_add =  " [주의 : " . $result_temp['message'] . "]";
            }
        }
    }

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
else if ($process_mode == 'delete') {

    $table_name = sanitize($_REQUEST['table_name']);
    $idx = $_REQUEST['idx'];

    $sql = "
                    DELETE FROM ${table_name}
                    WHERE idx = '${idx}' 
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

else if ($process_mode == 'view') {

    $table_name = sanitize($_REQUEST['table_name']);
    $idx = sanitize($_REQUEST['idx']);

    $sql = "
                    SELECT *
                    
                    FROM ${table_name}
                    
                    WHERE
                        1 = 1
                    
                    AND idx = '${idx}'
    ";

    $result = $db->query($sql)->fetchArray();

    // 첨부파일 표시
    $sql = "
                    SELECT *
                    FROM attach_file
                    WHERE
                                fk_table = '${table_name}'
                                AND fk_idx = '${idx}'
                    ORDER BY sort ASC
    ";
    // echo $sql;
    $files = $db->query($sql)->fetchAll();
    $result['files'] = $files;

    $view_count = $result['view_count'] + 1;

    $sql = "
                    UPDATE ${table_name}
                    
                    SET view_count = '${view_count}'
                        
                    WHERE idx = '${idx}'
    ";

    $db->query($sql)->affectedRows();

    echo json_encode($result);
}

else if ($process_mode == 'password_check') {

    $table_name = sanitize($_REQUEST['table_name']);
    $idx = sanitize($_REQUEST['idx']);
    $password = sanitize($_REQUEST['write_password']);

    if (!$password) {
        $temp = array(
            "status" => 0,
            "check" => '',
            "message" => "비밀번호를 입력해주세요.",
        );

        echo json_encode($temp);
        exit;
    }

    $password = enc($password);

    $sql = "
                    SELECT *
                    
                    FROM ${table_name}
                    
                    WHERE
                        1 = 1
                    
                    AND idx = '${idx}'
    ";

    $result = $db->query($sql)->fetchArray();

    if ($result['write_password'] != $password) {
        $temp = array(
            "status" => 0,
            "check" => '',
            "message" => "비밀번호를 확인해주세요.",
        );
        echo json_encode($temp);
        exit;
    }

    $temp = array(
        "status" => 1,
        "check" => enc($result['write_password']),
        "message" => "확인되었습니다.",
    );

    echo json_encode($temp);
}

// 첨부파일 삭제
else if ($process_mode == "delete_file") {

    // 변수 정리
    $code = sanitize($_REQUEST['code']);

    // 업로드 파일 삭제
    $result = fileRemoveWithCode($code);

    // 분기
    if ($result != -1) {
        $temp = array(
            "status" => 1,
            "message" => "삭제되었습니다.",
        );
    } else {
        $temp = array(
            "status" => 0,
            "message" => "삭제 오류",
        );
    }

    echo json_encode($temp);
}

else if ($process_mode == "page_setting") {

    $table_name = sanitize($_REQUEST['table_name']);

    // 테이블 설정 정보
    $sql = "
                    SELECT *
                    
                    FROM board_management 
                    
                    WHERE
                        table_name = '${table_name}'
                    
                    ORDER BY idx
    ";

    $table_setting_data = $db->query($sql)->fetchArray();

    echo json_encode($table_setting_data);
}

else if ($process_mode == "comment_create") {

    $table_name = sanitize($_REQUEST['table_name']);
    $idx = sanitize($_REQUEST['idx']);
    $parent_comment_idx = sanitize($_REQUEST['parent_comment_idx']);
    $user_name = sanitize($_REQUEST['user_name']);
    $comment = $_REQUEST['comment'];
    $comment_password = enc($_REQUEST['comment_password']);
    $is_secret = $_REQUEST['is_secret'];

    if (!$user_name) {
        $sql = "
                    SELECT *
                    FROM users
                    WHERE code = '${_SESSION['user_code']}'
        ";
        $result = $db->query($sql)->fetchArray();

        $user_name = $result['name'];
    }

    $sql = "
                    INSERT INTO comment
                    
                    SET 
                        table_name = '${table_name}',
                        fk_table_idx = '${idx}',
                        parent_comment_idx = '${parent_comment_idx}',
                        comment = '${comment}',
                        user_name = '${user_name}',
                        comment_password = '${comment_password}',
                        create_user_code = '${_SESSION['user_code']}'
    ";

    $result = $db->query($sql)->affectedRows();

    // 분기
    if ($result != -1) {
        $temp = array(
            "status" => 1,
            "message" => "등록 되었습니다.",
        );
    } else {
        $temp = array(
            "status" => 0,
            "message" => "저장 오류",
        );
    }

    echo json_encode($temp);
}

else if ($process_mode == "comment_list") {

    $table_name = sanitize($_REQUEST['table_name']);
    $idx = sanitize($_REQUEST['idx']);

    $sql = "
                    SELECT *
                    FROM comment
                    WHERE 
                            table_name = '${table_name}'
                    AND fk_table_idx = '${idx}'
    ";

    $result = $db->query($sql)->fetchAll();

    if (count($result) == 0) {
        $result = '';
        echo json_encode($result);
        exit;
    }

    $list = [];
    foreach ($result as $item) {

        $list[] = $item;
    }

    $result = $list;

    echo json_encode($result);
}

else if ($process_mode == "comment_delete") {

    $idx = sanitize($_REQUEST['idx']);

    $sql = "
                    DELETE FROM comment
                    WHERE 
                            idx = '${idx}'
                    LIMIT 1
    ";

    $result = $db->query($sql)->affectedRows();

    if ($result != -1) {
        $temp = array(
            "status" => 1,
            "message" => "삭제 되었습니다.",
        );
    } else {
        $temp = array(
            "status" => 0,
            "message" => "삭제 오류",
        );
    }

    echo json_encode($temp);
}