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
        3 => 'create_date',
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
        "data" => $list
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