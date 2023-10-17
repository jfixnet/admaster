<?php include_once $_SERVER['DOCUMENT_ROOT'] . "/include/default.php"; ?>

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
                    
                    FROM visitor_count
                    
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

    $route = $_SERVER['HTTP_REFERER'];
    $agent = getBrowserInfo();
    $os = getOsInfo();
    $device = getDeviceInfo();

    $sql = "
                    INSERT INTO visitor_count
                    
                    SET 
                        ip = '${ip}',
                        route = '${route}',
                        browser = '${agent}',
                        os = '${os}',
                        device = '${device}'
    ";

    $result = $db->query($sql)->affectedRows();

    echo json_encode($result);
    exit;
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
