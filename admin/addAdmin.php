<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
	<title>添加管理员</title>
</head>
<body>
    <h3>添加管理员</h3>
	<form action="doAdminAction.php?act=addAdmin" method="post">
	   <table width="70%" border="1" cellpadding="5" cellspacing="0" bgcolor="#cccccc">
            <tr>
                <td align="right">管理员名称</td>
                <td><input type="text" name="username" placeholder="请输入管理员名称" /></td>
            </tr>
            <tr>
                <td align="right">管理员密码</td>
                <td><input type="password" name="password"/></td>
            </tr>
            <tr>
                <td align="right">管理员邮箱</td>
                <td><input type="text" name="email" placeholder="请输入管理员邮箱" /></td>
            </tr>
            <tr>
                <td colspan="2" align="right"><input type="submit" value="添加管理员" /></td>
            </tr>
	   </table>
	</form>
</body>
</html>
