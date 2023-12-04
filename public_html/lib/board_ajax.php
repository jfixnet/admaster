<?php include "config.php"; ?>

<?php include "auth.php"; ?>

<?php
// 변수
$process_mode = sanitize($_REQUEST['process_mode']);

$img_extension = array('jpg', 'jpeg', 'png', 'gif');

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
        $sql_where .= " AND a.$srch_key LIKE '%{$srch_keyword}%' ";
    }

    $columns = array(
        0 => 'a.idx',
        1 => 'a.title',
        2 => 'a.user_name',
        3 => 'a.view_count',
        4 => 'a.create_date',
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
                    
                    FROM ${table_name} as a
                    
                    WHERE
                        1 = 1
                    
                        ${sql_where}
                    
                    ORDER BY a.idx
    ";

    $filter_count = $db->query($sql)->fetchArray();

    // 데이터 쿼리
    $sql = "
                    SELECT a.*, 
                           (select count(*) from ${table_name}) as total_count, 
                           (select count(*) from jf_comment where table_name = '${table_name}' and fk_table_idx = a.idx  ) as comment_count
                    
                    FROM ${table_name} as a
                    
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

else if ($process_mode == "gallery_list") {
    global $upload_url;
    $table_name = sanitize($_REQUEST['table_name']);

    $per_page = 12;
    $page = $_REQUEST["page"];
    $page = ($page == "" ? 1 : $page);
    $from_record = ($page - 1) * $per_page;

    // 총 개수
    $sql = "
                    SELECT *
                    
                    FROM ${table_name}
                    
                    WHERE
                        1 = 1
                    
                    ORDER BY idx DESC
    ";

    $total_count = $db->query($sql)->numRows();
    $total_page  = @ceil($total_count / $per_page);
    $counter = $list_cnt = $total_count - (($page - 1) * $per_page);

    $result['paging']['total_count'] = $total_count;
    $result['paging']['total_page'] = $total_page;
    $result['paging']['from_record'] = $from_record;
    $result['paging']['counter'] = $counter;

    // 데이터 쿼리
    $sql = "
                    SELECT a.*, 
                           (select count(*) from ${table_name}) as total_count, 
                           (select count(*) from jf_comment where table_name = '${table_name}' and fk_table_idx = a.idx  ) as comment_count
                    
                    FROM ${table_name} as a
                    
                    WHERE
                        1 = 1
                    
                    ORDER BY idx DESC
                    
                    LIMIT ${from_record}, ${per_page}
    ";

    $result['data'] = $db->query($sql)->fetchAll();

    $list = [];
    $no = 0;
    foreach ($result['data'] as $item) {
        $sql = "
                    SELECT *
                    
                    FROM jf_attach_file
                    
                    WHERE
                        fk_table = '${table_name}' 
                    AND fk_idx = '${item['idx']}'
                    
                    ORDER BY idx DESC
        ";

        $attach_file_data = $db->query($sql)->fetchAll();

        // 첨부파일 이미지 표시
        $item['attach_file'] = '';
        $item['attach_file_url'] = 'img/noImage.jpg';
        if ($attach_file_data) {
            foreach ($attach_file_data as $file) {
                if (in_array($file['file_extension'], $img_extension)) {
                    $item['attach_file'] = $attach_file_data;
                    $item['attach_file_url'] = "../data/".$file['file_tmp_name'];
                }
            }
        }

        // summernote 업로드 이미지 표시
        $pattern = '/<img.*?src=["\'](.*?)["\'].*?>/i';

        preg_match($pattern, $item['content'], $matches);

        if (isset($matches[1])) {
            $image_src = $matches[1];
            $item['attach_file_url'] = $image_src;
        }

        $list[] = $item;
    }

    $result['data'] = $list;

    echo json_encode($result);
}

else if ($process_mode == 'create') {

    $table_name = sanitize($_REQUEST['form_table_name']);
    $title = sanitize($_REQUEST['title']);
    $content = $_REQUEST['content'];
    $user_name = $_REQUEST['user_name'];
    $write_password = $_REQUEST['write_password'];
    $write_password = enc($write_password);
    $is_secret_val = $_REQUEST['is_secret'];

    if ($_SESSION['user_name']) {
        $user_name = $_SESSION['user_name'];
    }

    $is_secret = 'N';
    if ($is_secret_val == 'on') {
        $is_secret = 'Y';
    }

    $sql = "
                    SELECT contents
                    
                    FROM jf_board_setting
                    
                    WHERE
                            type = 'filtering'
    ";

    $blacklist_data = $db->query($sql)->fetchArray();

    $blacklist = explode(",", $blacklist_data['contents']);
    foreach ($blacklist as $word) {
        if (stripos($content, $word) !== false) {
            $temp = array(
                "status" => 0,
                "message" => "비속어가 포함되어있습니다.",
            );
            echo json_encode($temp);
            exit;

            //$content = str_ireplace($word, "****", $content);
        }
    }

    $sql = "
                    INSERT INTO ${table_name}
                    
                    SET 
                        title = '${title}',
                        content = '${content}',
                        user_name = '${user_name}',
                        write_password = '${write_password}',
                        is_secret = '${is_secret}',
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

            $temp = array(
                "status" => 0,
                "message" => $result_temp['message'],
            );

            echo json_encode($temp);
            exit;
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
    $is_secret_val = $_REQUEST['is_secret'];

    $set_write_password = '';
    if ($write_password) {
        $write_password = enc($write_password);
        $set_write_password = ", write_password = '${write_password}'";
    }

    if ($_SESSION['user_name']) {
        $user_name = $_SESSION['user_name'];
    }

    $is_secret = 'N';
    if ($is_secret_val == 'on') {
        $is_secret = 'Y';
    }

    $sql = "
                    UPDATE ${table_name}
                    SET
                            title = '${title}',
                            content = '${content}',
                            user_name = '${user_name}',
                            is_secret = '${is_secret}'
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

                $temp = array(
                    "status" => 0,
                    "message" => $result_temp['message'],
                );

                echo json_encode($temp);
                exit;
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
                    FROM jf_attach_file
                    WHERE
                                fk_table = '${table_name}'
                                AND fk_idx = '${idx}'
                    ORDER BY sort ASC
    ";
    // echo $sql;
    $files = $db->query($sql)->fetchAll();
    $result['files'] = $files;
    $result['img_url'] = [];
    foreach ($files as $file) {
        if (in_array($file['file_extension'], $img_extension)) {
            $result['img_url'][] = "../data/".$file['file_tmp_name'];
        }
    }

    $view_count = $result['view_count'] + 1;

    $sql = "
                    UPDATE ${table_name}
                    
                    SET view_count = '${view_count}'
                        
                    WHERE idx = '${idx}'
    ";

    $db->query($sql)->affectedRows();

    echo json_encode($result);
}

else if ($process_mode == 'board_password_check') {

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
                    
                    FROM jf_board_management 
                    
                    WHERE
                        table_name = '${table_name}'
                    
                    ORDER BY idx
    ";

    $table_setting_data = $db->query($sql)->fetchArray();

    if (!$table_setting_data) {
        $data = array(
            "status" => false,
            "data" => '',
            "message" => '게시판이 없습니다. 관리자에게 문의해주세요.',
            "redirect" => "/",
        );

        echo json_encode($data);
        exit;
    }

    $data = array(
        "status" => true,
        "data" => $table_setting_data,
        "message" => '',
        "redirect" => "",
    );

    echo json_encode($data);
}

else if ($process_mode == "comment_create") {

    $table_name = sanitize($_REQUEST['table_name']);
    $idx = sanitize($_REQUEST['idx']);
    $parent_comment_idx = sanitize($_REQUEST['parent_comment_idx']);
    if (!$parent_comment_idx) {
        $parent_comment_idx = 0;
    }
    $user_name = sanitize($_REQUEST['user_name']);
    $comment = $_REQUEST['comment'];
    $comment_password = enc($_REQUEST['comment_password']);
    $is_secret = $_REQUEST['is_secret'];

    if (!$user_name) {
        $sql = "
                    SELECT *
                    FROM jf_users
                    WHERE code = '${_SESSION['user_code']}'
        ";
        $result = $db->query($sql)->fetchArray();

        $user_name = $result['name'];
    }

    $sql = "
                    INSERT INTO jf_comment
                    
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
                    FROM jf_comment
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

        $item['delete_auth'] = 'N';
        if ($item['is_admin'] == 'Y' || $item['create_user_code'] == $_SESSION['user_code']) {
            $item['delete_auth'] = 'Y';
        }

        $list[] = $item;
    }

    $result = $list;

    echo json_encode($result);
}

else if ($process_mode == "comment_delete") {

    $idx = sanitize($_REQUEST['idx']);

    $sql = "
                    DELETE FROM jf_comment
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

else if ($process_mode == "summernote_img_upload") {
    // 용량 체크
    if ($_FILES['file']['size'] > 10240000) { // 10메가
        $temp = array(
            "status" => 0,
            "message" => "파일 용량이 초과했습니다.",
        );

        echo json_encode($temp);
        exit;
    }

    // 확장자 체크
    $ext = substr(strrchr($_FILES['file']['name'],"."), 1);
    $ext = strtolower($ext);
    if ($ext != "jpg" and $ext != "png" and $ext != "jpeg" and $ext != "gif") {
        $temp = array(
            "status" => 0,
            "message" => "업로드 오류",
        );

        echo json_encode($temp);
        exit;
    }

    // 저장
    $name = date("YmdHis") . "_" . substr(rand(), 0, 4);
    $filename = $name . '.' . $ext;
    $upload_root = __DIR__."/../data/editor";
    $target = $upload_root . "/" . $filename;
    $location =  $_FILES['file']['tmp_name'];

    if (!move_uploaded_file($location, $target)) {
        $temp = array(
            "status" => 0,
            "message" => "업로드 오류",
        );

        echo json_encode($temp);
        exit;
    }

    //echo "../data/summernote/".$filename; // TODO :: 경로명 처리


    $temp = array(
        "status" => 1,
        "data" => '../data/editor/'.$filename,
        "message" => "업로드 되었습니다.",
    );
    echo json_encode($temp);
}