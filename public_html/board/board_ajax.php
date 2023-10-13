<?php include_once $_SERVER['DOCUMENT_ROOT'] . "/include/default.php"; ?>

<?php

// 변수
$process_mode = sanitize($_REQUEST['process_mode']);

if ($process_mode == "list") {
    $table_name = sanitize($_REQUEST['table_name']);
    $srch_key = sanitize($_REQUEST['srch_key']);
    $srch_keyword = sanitize($_REQUEST['srch_keyword']);

    $sql_where = '';
    if ($srch_keyword) {
        $sql_where .= " AND $srch_key LIKE '%{$srch_keyword}%' ";
    }

    $sql = "
                    SELECT *, (select count(*) from ${table_name}) as total_count
                    
                    FROM ${table_name}
                    
                    WHERE
                        1 = 1
                                        
                        ${sql_where}
                                        
                    ORDER BY idx desc
    ";

    $result = $db->query($sql)->fetchAll();

    $list = [];
    $no = 0;
    foreach ($result as $item) {
        $item['no'] = $item['total_count'] - $no;
        $no = $no + 1;

        $list[] = $item;
    }

    $result = $list;

    echo json_encode($result);

}

else if ($process_mode == 'create') {

    $table_name = sanitize($_REQUEST['form_table_name']);
    $title = sanitize($_REQUEST['title']);
    $content = $_REQUEST['content'];

    $sql = "
                    INSERT INTO ${table_name}
                    
                    SET 
                        title = '${title}',
                        content = '${content}',
                        user_name = '${_SESSION['user_name']}',
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

    $table_name = sanitize($_REQUEST['form_table_name']);
    $title = sanitize($_REQUEST['title']);
    $content = $_REQUEST['content'];
    $idx = $_REQUEST['idx'];

    $sql = "
                    UPDATE ${table_name}
                    SET
                            title = '${title}',
                            content = '${content}'
                    WHERE idx = '${idx}' 
                    LIMIT 1
    ";

    $result = $db->query($sql)->affectedRows();

    // 분기
    if ($rsult != -1) {
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