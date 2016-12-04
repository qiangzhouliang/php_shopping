<?php
$srcFile="../images/logo.jpg";
$dstFile="des_big.jpg";
waterPic($dstFile);
/**
 * 添加图片水印
 * @param string $dstFile
 * @param string $srcFile
 * @param number $pct
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
    header("content-type:".$dstMime);
    $outDstFun($dst_im,$dstFile);
    //销毁图片
    imagedestroy($src_im);
    imagedestroy($dst_im);
}
