<?php include_once $_SERVER['DOCUMENT_ROOT'] . "/include/config.php"; ?>

<?php

// 변수
$process_mode = sanitize($_REQUEST['process_mode']);

if ($process_mode == "list") {
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

else if ($process_mode == "list2") {
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

else if ($process_mode == "list3") {
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

else if ($process_mode == "list4") {
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

else if ($process_mode == "list5") {
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

else if ($process_mode == "list6") {
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

else if ($process_mode == "list7") {
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

else if ($process_mode == "list8") {
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

else if ($process_mode == "list9") {
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

else if ($process_mode == "list10") {
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

