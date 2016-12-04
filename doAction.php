<?php
require_once 'include.php';
$act = $_REQUEST['act'];
if ($act == "reg"){
    $mes = reg();
}elseif ($act == "login"){
    $mes = login();
}elseif ($act = "userOut"){
    $mes = userOut();
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