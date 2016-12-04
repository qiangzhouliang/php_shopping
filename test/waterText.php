<?php

$filename="../images/logo.jpg";
/**
 * 添加文字水印
 */
waterText($filename);
/**
 * 添加文字水印
 * @param string $filename
 * @param string $text
 * @param string $fontfile
 */
function waterText($filename,$text="imooc.com",$fontfile="MSYH.TTC"){
    $fileInfo=getimagesize($filename);
    $mime=$fileInfo['mime'];
    $createFun=str_replace("/", "createfrom", $mime);
    $outFun=str_replace("/", null, $mime);
    $image=$createFun($filename);
    $color=imagecolorallocatealpha($image, 255,0,0,50);
    $fontfile="../fonts/{$fontfile}";
    imagettftext($image, 14, 0, 0, 14, $color, $fontfile, $text);
    header("content-type:".$mime);
    $outFun($image,$filename);
    imagedestroy($image);
}