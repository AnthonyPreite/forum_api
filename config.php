<?php
    define('DB_USER', 'root');
    define('DB_PASS', '');
    define('DB_HOST', 'localhost:8888');
    define('DB_NAME', 'forumticket');

    define('MODE', 'dev'); // dev or prod

    $connect = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    if($connect->connect_error) :
        die('Connection failed: ' . $connect->connect_error);
    else :
        $connect->set_charset('utf8');
    endif;

require_once 'functions.php';