<?php
require_once '../include.php';
$act = $_REQUEST['act'];
$id = @$_REQUEST['id'];
if ($act == "logout"){
    logout();
}elseif ($act == "addAdmin"){
    //添加管理员的操作
    $mes = addAdmin();
}elseif ($act == "editAdmin"){
    //修改管理员
    $mes = editAdmin($id);
}elseif ($act == "delAdmin"){
    $mes = delAdmin($id);
}elseif ($act == "addCate"){
    $mes = addCate();
}elseif ($act == "editCate"){
    $where = "id={$id}";
    $mes = editCate($where);
}elseif ($act == "delCate"){
    $mes = delCate($id);
}elseif ($act == "addPro"){
    $mes = addPro();
}elseif ($act == 'editPro'){
    $mes = editPro($id);
}elseif ($act == "delPro"){
    $mes = delPro($id);
}elseif ($act == "addUser"){
    $mes = addUser();
}elseif ($act == "delUser"){
    $mes = delUser($id);
}elseif ($act == "editUser"){
    $mes = editUser($id);
}elseif ($act == "waterText"){
    $mes = doWaterText($id);
}elseif ($act == "waterPic"){
    $mes = doWaterPic($id);
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
	<title>Document</title>
</head>
<body>
	<?php
	   if ($mes){
	       echo $mes;
	   }
	?>
</body>
</html>