<?php
session_start();
unset($_SESSION['out']);
unset($_SESSION['in']);

if(!isset($_SESSION['area'])){
	$_SESSION['area']=$_GET['area'];
}
require_once 'AttendanceDB.php';
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
<input type="button" onclick="location.href='http://localhost/Attendance_System/Index.php'" value="TOPへ"style="float:right">
<input type="button" onclick="location.href='http://localhost/Attendance_System/In_Out.php'" value="IN OUT" style="float:right" >
</header>
利用者メニュー
<br>

<div>
<?php
foreach($_SESSION['usersDB'] as $users_list){
?>
<form action="http://localhost/Attendance_System/In_Out.php" method="get"  >
<input type="hidden" name="user_id" value="<?php print $users_list['id']; ?>">
<input type="hidden" name="user_name" value="<?php print $users_list['name']; ?>">
<input type="submit" value="<?php print 'ID:No.'.$users_list['id'].':'.$users_list['name']; ?>">

</form>
<br><br>
<?php
}
?>
</div>

<footer>
</footer>
<script src="tab.js"></script>
</body>
</html>

<!--
<div class="tab_wrap" style="float:left">
	<input id="tab1" type="radio" name="tab_btn" checked>
	<input id="tab2" type="radio" name="tab_btn">
    <input id="tab3" type="radio" name="tab_btn">
	<input id="tab4" type="radio" name="tab_btn">
	<input id="tab5" type="radio" name="tab_btn">
	<input id="tab6" type="radio" name="tab_btn">
	<input id="tab7" type="radio" name="tab_btn">
	<input id="tab8" type="radio" name="tab_btn">
	<input id="tab9" type="radio" name="tab_btn">
	<input id="tab10" type="radio" name="tab_btn">
    
 
	<div class="tab_area" style="float:left">
		<label class="tab1_label" for="tab1">あ</label><br>
		<label class="tab2_label" for="tab2">か</label><br>
        <label class="tab3_label" for="tab3">さ</label><br>
        <label class="tab4_label" for="tab4">た</label><br>
		<label class="tab5_label" for="tab5">な</label><br>
        <label class="tab6_label" for="tab6">は</label><br>
        <label class="tab7_label" for="tab7">ま</label><br>
		<label class="tab8_label" for="tab8">や</label><br>
        <label class="tab9_label" for="tab9">ら</label><br>
        <label class="tab10_label" for="tab10">わ</label>
	</div>
	<div class="panel_area">
		<div id="panel1" class="tab_panel">
			<p>
			
			</p>
		</div>
		<div id="panel2" class="tab_panel">
			<p>panel2</p>
		</div>
		<div id="panel3" class="tab_panel">
			<p>panel3</p>
        </div>
        <div id="panel4" class="tab_panel">
			<p>panel4</p>
		</div>
		<div id="panel5" class="tab_panel">
			<p>panel5</p>
		</div>
		<div id="panel6" class="tab_panel">
			<p>panel6</p>
        </div>
        <div id="panel7" class="tab_panel">
			<p>panel1</p>
		</div>
		<div id="panel8" class="tab_panel">
			<p>panel2</p>
		</div>
		<div id="panel9" class="tab_panel">
			<p>panel3</p>
        </div>
        <div id="panel10" class="tab_panel">
			<p>panel3</p>
        </div>
	</div>
</div>
-->