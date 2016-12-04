<?php
require_once '../lib/string.func.php';
//生成缩放图
$filename = "des_big.jpg";
//thumb($filename);
thumb($filename,"image_50/".$filename,50,50,true);
/**
 *生成不同大小的缩放图
 * @param unknown $filename
 * @param string $destination
 * @param real $scale
 * @param string $dst_w
 * @param string $dst_h
 * @param string $isReservedSource
 * @return string
 */
function thumb($filename,$destination=null,$dst_w=null,$dst_h=null,$isReservedSource = false,$scale = 0.5){
    //得到文件类型、宽和高
    list($src_w,$src_h,$imagetype)=getimagesize($filename);
    if (is_null($dst_w)||is_null($dst_h)){
        $dst_w = ceil($src_w*$scale);
        $dst_h = ceil($src_h*$scale);
    }
    //得到图片类型
    $mime = image_type_to_mime_type($imagetype);
    $createFun = str_replace("/", "createfrom", $mime);
    //imagejpeg
    $outFun = str_replace("/", null, $mime);
    $src_image = $createFun($filename);
    $dst_image = imagecreatetruecolor($dst_w, $dst_h);
    imagecopyresampled($dst_image, $src_image, 0, 0, 0, 0, $dst_w, $dst_h, $src_w, $src_h);
    //保存在指定路径下
    //image_50/auhuahi.jpg
    if ($destination && !file_exists(dirname($destination))){
        mkdir($destination,0777,true);
    }
    $dstFilename = $destination == null?getUniName().".".getExt($filename):$destination;
    //保存到本地
    @$outFun($dst_image,$dstFilename);
    //销毁
    imagedestroy($src_image);
    imagedestroy($dst_image);
    if (!$isReservedSource){
        unlink($filename);//删掉源文件
    }
    return $dstFilename;
}






