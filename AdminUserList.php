<?php
session_start();
if(!isset($_SESSION['pass'])){
$_SESSION['pass']=$_POST['pass'];
$_SESSION['login']=$_POST['login'];
$_SESSION['area']=$_POST['area'];
}


//unset($_SESSION['admin_entry']);
unset($_SESSION['user_entry']);
unset($_SESSION['user_revice']);

require_once 'AttendanceDB.php';
$_SESSION['admin_id']=$adminDB['id'];

if(isset($_GET['delete_user_id'])){
	var_dump($_GET);
	user_delete($_GET['delete_user_id'], $_SESSION['admin_id']);
}
users($_SESSION['area']);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link rel="stylesheet" href="reset.css">
<link rel="stylesheet" href="Attendance.css">
<link rel="stylesheet" href="tab.css">
<title>打刻システム</title>
</head>
<body>

<header>
<input type="button" method="post" onclick="location.href='http://localhost/Attendance_System/Index.php'" value="TOP" style="float:right" >
<?php
try{
if(empty($adminDB)){
	throw new Exception();
}
?>
<input type="button" onclick="location.href='http://localhost/Attendance_System/AdminUserEntry.php'" value="利用者登録" style="float:right" >
<!--<input type="button" onclick="location.href='http://localhost/Attendance_System/AdminEntry.php?admin_entry=admin'" value="管理者登録" style="float:right" >-->
</header>
<h1>ログインしました。</h1>
<div>

<?php
foreach($_SESSION['usersDB'] as $users_list){
?>

<form action="http://localhost/Attendance_System/AdminUserEdit.php" method="get"  >
<input type="hidden" name="user_id" value="<?php print $users_list['id']; ?>">
<input type="hidden" name="user_name" value="<?php print $users_list['name']; ?>">
<input type="submit" value="<?php print 'ID:No.'.$users_list['id'].':'.$users_list['name']; ?>">

</form>
<br><br>
<?php
}
?>
</div>


<?php
}catch(Exception $e){
?>
</header>
<h1>ログインできていません。</h1>
<?php

}
?>
<footer>
</footer>
<script>
</script>
</body>
</html>