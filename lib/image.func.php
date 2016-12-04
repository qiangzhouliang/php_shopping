<?php
require_once 'string.func.php';
function verifyImage($type = 1,$length = 4,$pixel = 0,$line = 0,$sess_name = "verify"){
    //通过GD库做验证码
    //创建画布
    $width = 80;
    $height = 28;
    $image = imagecreatetruecolor($width, $height);
    //创建颜色
    $white = imagecolorallocate($image, 255, 255, 255);
    $black = imagecolorallocate($image, 0, 0, 0);
    //用填充矩形填充画布
    imagefilledrectangle($image, 1, 1, $width-2, $height-2, $white);
    $chars = buildRandomString($type,$length);
    $_SESSION[$sess_name] = $chars;
    //存放字体我文件
    $fontfiles = array("MSYH.TTC","SIMYOU.TTF");
    for ($i = 0; $i < $length; $i++){
        $size = mt_rand(14, 18);
        $angle = mt_rand(-15, 15);
        $x = 5 + $i*$size;
        $y = mt_rand(20, 26);
        $fontfile = "../fonts/".$fontfiles[mt_rand(0, count($fontfiles)-1)];
        $color = imagecolorallocate($image, mt_rand(50, 90), mt_rand(80, 200), mt_rand(90, 180));
        $text = substr($chars, $i, 1);
        imagettftext($image, $size, $angle, $x, $y, $color, $fontfile, $text);
    }
    if ($pixel){
        for ($i = 0; $i < $pixel; $i++){
            imagesetpixel($image, mt_rand(0, $width-1), mt_rand(0, $height-1), $black);
        }
    }
    if ($line){
        for ($i = 0; $i < $line; $i++){
            $color = imagecolorallocate($image, mt_rand(100, 200), mt_rand(80, 200), mt_rand(100, 180));
            imageline($image, mt_rand(0, $width-1), mt_rand(0, $height-1), mt_rand(0, $width-1), mt_rand(0, $height-1), $color);
        }
    }
    header("content-type: image/gif");
    //显示画布
    imagegif($image);
    //销毁资源
    imagedestroy($image);
}
//verifyImage(2,4,10,5);

/**
 *生成不同大小的缩放图
 * @param string $filename
 * @param string $destination
 * @param real $scale
 * @param string $dst_w
 * @param string $dst_h
 * @param string $isReservedSource
 * @return string
 */
function thumb($filename,$destination=null,$dst_w=null,$dst_h=null,$isReservedSource = true,$scale = 0.5){
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
        mkdir(dirname($destination),0777,true);
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
    $outFun($image,$filename);
    imagedestroy($image);
}

/**
 * 添加图片水印
 * @param string $dstFile 目标文件
 * @param string $srcFile 源文件
 * @param number $pct     透明度
 */
function waterPic($dstFile,$srcFile="../images/logo.jpg",$pct=30){
    //获得原图片图片信息
    $srcFileInfo=getimagesize($srcFile);
    $src_w=$srcFileInfo[0];
    $src_h=$srcFileInfo[1];
    //获得目标图片的信息
    $dstFileInfo=getimagesize($dstFile);
    //获取图片类型
    $srcMime=$srcFileInfo['mime'];
    $dstMime=$dstFileInfo['mime'];
    //替换生成创建函数
    $createSrcFun=str_replace("/", "createfrom", $srcMime);
    $createDstFun=str_replace("/", "createfrom", $dstMime);
    $outDstFun=str_replace("/", null, $dstMime);
    //创建两个画布
    $dst_im=$createDstFun($dstFile);
    $src_im=$createSrcFun($srcFile);
    //合并图片
    imagecopymerge($dst_im, $src_im, 0,0,0,0, $src_w, $src_h,$pct);
    $outDstFun($dst_im,$dstFile);
    //销毁图片
    imagedestroy($src_im);
    imagedestroy($dst_im);
}
