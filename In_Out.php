<?php
session_start();
// if(!isset($_SESSION['user_id'])){
//    $_SESSION['user_name']=$_POST['user_name'];
//    $_SESSION['user_id']=$_POST['user_id'];
// }

if(isset($_GET['user_id'])){
   $_SESSION['user_id']=$_GET['user_id'];
   $_SESSION['user_name']=$_GET['user_name'];
}
if(!isset($_SESSION['in'])){
   $_SESSION['in']=$_POST['in'];
}else if(isset($_SESSION['in'])){
   unset($_POST['in']);
}

if(!isset($_SESSION['out'])){
   $_SESSION['out']=$_POST['out'];
}else if(isset($_SESSION['out'])){
   unset($_POST['out']);
}
require_once 'function.php';
$date_memory=date_memory($date,$_SESSION['performanceDB']);//出退勤時間の計算関数
$dt = new DateTime();
$date=$dt->format('Y-m-d H:'.$date_memory);//出退勤時間の分秒を15分計算して代入
require_once 'AttendanceDB.php';

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
<input type="button" onclick="location.href='http://localhost/Attendance_System/UserMenuList.php'" value="利用者一覧" style="float:right" >
<input type="button" onclick="location.href='http://localhost/Attendance_System/Index.php'" value="TOP" style="float:right" >
</header>
IN,OUT
<br>

<h1>利用者氏名:<?php print $_GET['user_name']; ?></h1>
<section>
    <p>現在時刻: <span id="RealtimeClock"></span></p>
</section>
<p>現在
<?php 
if(count($performanceDB)==1){
	print '通所';
}else if(count($performanceDB)==2 || count($performanceDB)==0){
	print '退所';
}
?>
されております。</p>

<?php
if(count($performanceDB)==0){
?>
<form action="#" method="post">
<input type="hidden" name="in" value="0">
<input type="submit" value="IN">
</form>
<?php
}

if(count($performanceDB)==1){
   ?>
   <form action="#" method="post">
   <input type="hidden" name="out" value="1">
   <input type="submit" value="OUT">
   </form>
<?php
}

?>

<footer>
</footer>

<script>
   let nowIn = new Date();
   let InYear = realtime( nowIn.getFullYear() );
   let InMonth = realtime( nowIn.getMonth()+1 );
   let InDate = realtime( nowIn.getDate() );

function realtime(num) {
   // 桁数が1桁だったら先頭に0を加えて2桁に調整する
   let ret;
   if( num < 10 ) { ret = "0" + num; }
   else { ret = num; }
   return ret;
}

function showClock2() {
   let now = new Date();
   let nowYear = realtime( now.getFullYear() );
   let nowMonth = realtime( now.getMonth()+1 );
   let nowDate = realtime( now.getDate() );
   let nowHour = realtime( now.getHours() );
   let nowMin  = realtime( now.getMinutes() );
   let nowSec  = realtime( now.getSeconds() );
   let msg = nowYear + "年" + nowMonth + "月" + nowDate + "日 " + nowHour + ":" + nowMin + ":" + nowSec + " です。";
   document.getElementById("RealtimeClock").innerHTML = msg;
}
setInterval('showClock2()',1000);
</script>

</body>
</html>