<?php
header("content-type:text/html;charset=utf-8");
require_once 'upload.func.php';
require_once '../lib/string.func.php';
//echo '<pre>';
//print_r($_FILES);
foreach ($_FILES as $val){
    $mes = uploadFile($val);
    echo $mes;
}