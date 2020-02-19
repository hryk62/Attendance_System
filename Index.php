<?php
session_start();
session_destroy();

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link rel="stylesheet" href="reset.css">
<link rel="stylesheet" href="Attendance.css">
<title>打刻システム</title>
</head>
<body>
<header>
<input type="button" onclick="location.href='http://localhost/Attendance_System/AdminLogin.php'" value="管理メニュー">
</header>
<!---->
<h1>管理システム</h1>

<form action="http://localhost/Attendance_System/UserMenuList.php" method="get">
<input type="submit" value="本校">
<input type="hidden" name="area" value="0">
</form><br><br>

<form action="http://localhost/Attendance_System/UserMenuList.php" method="get">
<input type="submit" value="2校">
<input type="hidden" name="area" value="1">
</form>
<br><br>



<footer>
</footer>

</body>
</html>