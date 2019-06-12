<?php

// Required if your environment does not handle autoloading
require __DIR__. '/helper.php';


if($_SERVER['REQUEST_METHOD'] == "GET") {
    header("Location: /");
    exit;
}


$messageBody = $_REQUEST['sms_message'];
list($header, $records) = readSheet($_FILES["excel_file"]['tmp_name']);

include(__DIR__. "/views/sms_final_list.php");