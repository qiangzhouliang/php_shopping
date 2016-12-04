<?php
header("content-type:text/html;charset=utf-8");
require_once '../lib/string.func.php';
//print_r($_FILES);
$filename = $_FILES['myFile']['name'];
$type = $_FILES['myFile']['type'];
$tmp_name = $_FILES['myFile']['tmp_name'];
$error = $_FILES['myFile']['error'];
$size = $_FILES['myFile']['size'];
$allowExt = array("gif","jpeg","jpg","png","wbmp");
$maxSize = 1048576;//限制文件大小 2M
$imgFlag = true;
//判断下错误信息
if ($error == UPLOAD_ERR_OK){
    $ext = getExt($filename);
    $path = "uploads";
    if (!file_exists($path)){
        mkdir($path,0777,true);
    }
    $filename = getUniName().".".$ext;
    //限制文件上传类型
    if (!in_array($ext, $allowExt)){
        exit("非法文件类型");
    }
    //限制文件大小
    if ($size > $maxSize){
        exit("文件过大");
    }
    if ($imgFlag){
        //如何验证图片是否是一个真正的图片类型
        //getimagesize($filename)：验证文件是否是图片类型
        $info = getimagesize($tmp_name);
        if (!$info){
            exit("不是真正的图片类型");
        }
    }
    //判断文件是否是通过HTTP POST上传上来的
    //is_uploaded_file($tmp_name)

    $destination = $path."/".$filename;
    if (is_uploaded_file($tmp_name)){
        if (move_uploaded_file($tmp_name, $destination)){
            $mes = "文件上传成功";
        }else {
            $mes = "文件移动失败";
        }
    }else {
        $mes = "文件不是通过HTTP　POST方式上传上来的";
    }
}else {
    switch ($error){
        case 1:
            $mes = "超过了配置文件上传文件的大小";
            break;
        case 2:
            $mes = "超过了表单设置的上传文件的大小";
            break;
        case 3:
            $mes = "文件部分被上传";
            break;
        case 4:
            $mes = "没有文件被上传";
            break;
        case 6:
            $mes = "没有找到临时目录";
            break;
        case 7:
            $mes = "文件不可写";
            break;
        case 8:
            $mes = "由于PHP的扩展程序中断了文件上传";
            break;
    }
}
echo $mes;
?>