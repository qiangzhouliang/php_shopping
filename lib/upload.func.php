<?php
/**
 * 构建上传文件信息
 * @return array
 */
function buildInfo(){
    if (!$_FILES){
        return ;
    }
    $i = 0;
    foreach ($_FILES as $v) {
        if (is_string($v['name'])) {
            // 单文件
            $files[$i] = $v;
            $i ++;
        } else {
            // 多文件
            foreach ($v['name'] as $key => $val) {
                $files[$i]['name'] = $val;
                $files[$i]['type'] = $v['type'][$key];
                $files[$i]['tmp_name'] = $v['tmp_name'][$key];
                $files[$i]['size'] = $v['size'][$key];
                $files[$i]['error'] = $v['error'][$key];
                $i ++;
            }
        }
    }
    return $files;
}

function uploadFile($path = "uploads", $allowExt = array("gif","jpeg","jpg","png","wbmp"), $maxSize = 2097152, $imgFlag = true){
    if (! file_exists($path)) {
        mkdir($path, 0777, true);
    }
    $files = buildInfo();
    if (!($files && is_array($files))){
        return ;
    }
    $i = 0;
    foreach ($files as $file) {
        if ($file['error'] === UPLOAD_ERR_OK) {
           $ext = getExt($file['name']);
           //检查文件的扩展名
           if (!in_array($ext, $allowExt)){
               exit($file['name']."非法文件类型");
           }
           //校验是否是一个真正的图片类型
           if ($imgFlag){
               if (!getimagesize($file['tmp_name'])){
                   exit($file['name']."不是真正的图片类型");
               }
           }
           //检查上传文件的大小
           if ($file['size'] > $maxSize){
               exit($file['name']."上传文件过大");
           }
           //是否是通过http post上传上来的
           if (!is_uploaded_file($file['tmp_name'])){
               exit($file['name']."不是通过HTTP POST方式上传上来的");
           }
           $filename = getUniName().".".$ext;
           $destination = $path."/".$filename;
           if (move_uploaded_file($file['tmp_name'], $destination)){
                $file['name'] = $filename;
                unset($file['error'],$file['tmp_name'],$file['size'],$file['type']);
                $uploadedFiles[$i] = $file;
                $i++;
           }
        } else {
            switch ($file['error']) {
                case 1:
                    $mes = $file['name']."超过了配置文件上传文件的大小";
                    break;
                case 2:
                    $mes = $file['name']."超过了表单设置的上传文件的大小";
                    break;
                case 3:
                    $mes = $file['name']."文件部分被上传";
                    break;
                case 4:
                    $mes = $file['name']."没有文件被上传";
                    break;
                case 6:
                    $mes = $file['name']."没有找到临时目录";
                    break;
                case 7:
                    $mes = $file['name']."文件不可写";
                    break;
                case 8:
                    $mes = $file['name']."由于PHP的扩展程序中断了文件上传";
                    break;
            }
            echo $mes;
        }
    }
    return $uploadedFiles;
}
