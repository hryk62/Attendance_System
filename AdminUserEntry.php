<?php
session_start();
//ユーザーエントリーstart
if($_SESSION['entry_name']!=$_POST['entry_name']){
    $_SESSION['entry_name']=$_POST['entry_name'];
    $_SESSION['entry_kana']=$_POST['entry_kana'];
    $_SESSION['entry_area']=$_POST['entry_area'];
}else if($_SESSION['entry_name']==$_POST['entry_name']){
    unset($_POST['entry_name']);
    unset($_POST['entry_kana']);    
}
//ユーザーエントリーend
require_once 'AttendanceDB.php';
entry();
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
<input type="button" onclick="location.href='http://localhost/Attendance_System/AdminUserList.php'" value="利用者一覧" style="float:right">
</header>

<h1>利用者登録</h1>
<br>
<div class="entry_user">
<form action="#" method="post">
<p>利用者氏名</p>
<input type="text" name="entry_name" value="" required>
<br>
<br>

<p>利用者ふりがな</p>
<input type="text" name="entry_kana" value="" pertern="^[ぁ-ん]+$,[\u3041-\u309F]*" required>
<select name="entry_area">
<option value="0">本校</option>
<option value="1">2校</option>
</select>
<br>
<input type="submit" value="登録">
</form>
</div>

</body>
</html>