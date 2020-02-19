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
<input type="button" onclick="location.href='http://localhost/Attendance_System/Index.php'" value="TOP" style="float:right" >
</header>
AdminLogin

<form action="http://localhost/Attendance_System/AdminUserList.php" method="post">
<h1>ログイン ID</h1>
<input type="text" name="login" value="katachi">
<br><br>

<h1>パスワード</h1>
<input type="text" value="1111" name="pass">1111</input>
<br><br>

<input type="radio" value="0" name="area" checked="checked">本校</input>
<input type="radio" value="1" name="area">2校</input>
<input type="submit">

</form>


</body>
</html>