<?php
// *** Logout the current user.
$logoutGoTo = "logoutSuccess.php";
if (!isset($_SESSION)) {
  session_start();
}
$_SESSION['MM_Username'] = NULL;
$_SESSION['MM_UserGroup'] = NULL;
$_SESSION['MM_UserType'] = NULL;
$_SESSION['MM_Uid'] = NULL;
$_SESSION['MM_Status'] = NULL;
$_SESSION['MM_UserId'] = NULL;//add by coway 2016.9.13
unset($_SESSION['MM_Username']);
unset($_SESSION['MM_UserGroup']);
unset($_SESSION['MM_UserType']);
unset($_SESSION['MM_Uid']);
unset($_SESSION['MM_Status']);
unset($_SESSION['MM_UserId']);//add by coway 2016.9.13
if ($logoutGoTo != "") {header("Location: $logoutGoTo");
exit;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>無標題文件</title>
</head>

<body>
</body>
</html>