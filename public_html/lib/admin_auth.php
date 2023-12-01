<?php

//ini_set('memory_limit','-1');

session_start();

if (basename($_SERVER['PHP_SELF']) != 'admin_ajax.php') {

    if ($_SESSION['is_admin'] == 'N') {
        Header("Location:../adm/login.php");
        exit;
    }

    if (!$_SESSION['user_code']) {
        Header("Location:../adm/login.php");
        exit;
    }
}

?>
