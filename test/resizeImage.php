<?php
$filename = "des_big.jpg";
$src_image = imagecreatefromjpeg($filename);
//取得图片的宽和高
list($src_w,$src_h)=getimagesize($filename);
$scale = 0.5;//缩放比例
//目标图片的宽和高
$dst_w = ceil($src_w*$scale);
$dst_h = ceil($src_h*$scale);
$dst_image = imagecreatetruecolor($dst_w, $dst_h);
imagecopyresampled($dst_image, $src_image, 0, 0, 0, 0, $dst_w, $dst_h, $src_w, $src_h);
header('content-type:image/jpeg');
//保存图片
imagejpeg($dst_image,'uploads/'.$filename);
imagedestroy($src_image);
imagedestroy($dst_image);