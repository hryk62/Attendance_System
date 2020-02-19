<?php
session_start();
require_once 'function.php';

var_dump($_GET);

$dt = new DateTime();
$year=$dt->format('Y');
$month=$dt->format('m');//現在の月にタブ固定する
$ym=$dt->format('Y-n');//現在の年月
$i=1;
while($i<=12){

	$y_array[$i]=$dt->format('Y');
	$m_array[$i]=$dt->format('n');
	//print $i.'::'.$y_array[$i].':'.$m_array[$i].'<br>';
	$i++;
	$dt->modify('-1 months')->format('n');

}

$m_array=array_reverse($m_array);
$y_array=array_reverse($y_array);

if(isset($_GET['user_id'])){
	$_SESSION['user_id']=$_GET['user_id'];
	$_SESSION['user_name']=$_GET['user_name'];
}
$delete_id=$_GET['delete_id'];

require_once 'AttendanceDB.php';
if(isset($_GET['delete_id'])){
   	delete($_GET['delete_id']);
}

if($_GET['set_hour_minute']!=$_SESSION['set_hour_minute']){
	edit_date_time($_GET['set_id'],$_GET['set_date'],$_GET['set_hour_minute'],$_GET['judge'],$_SESSION['user_id']);
	$_SESSION['set_hour_minute']=$_GET['set_hour_minute'];
}

if($user_edit_DB['name']!=$_GET['edit_name'] || $user_edit_DB['name_kana']!=$_GET['edit_kana'] || $user_edit_DB['area']!=$_GET['edit_area']){
	edit_user($_GET['edit_name'],$_GET['edit_kana'],$_GET['edit_area'],$_SESSION['user_id'],$_SESSION['admin_id']);
}
$user_edit_DB=user_edit_memory($_SESSION['user_id']);

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

<p>利用者編集画面</p>
<p><?php print $user_edit_DB['name'];?></p>
<p id="tabcontrol">
	<?php $i=1;
	$num=0;
	while($i<=12){
	
	?>
    <a href="#tabpage<?php print $i;?>"><?php print $y_array[$num].'年<br>'.$m_array[$num];?>月</a>
    <?php
	$i++;
	$num++;
    }
    ?>
   	<a href="#tabpage13">利用者情報</a>
</p>

<div id="tabbody">
    <?php
	$i=1;
	$num=0;
    while($i<=12){
    ?>
    <div id="tabpage<?php print $i;?>">
		<?php
			days($y_array[$num],$m_array[$num],$_SESSION['user_id']);
		?>
    </div>
<?php
	$i++;
	$num++;
}
?>

    <div id="tabpage13">
		<form action="#" method="get">
			<p>利用者氏名</p>
			<input type="text" name="edit_name" value="<?php print $user_edit_DB['name']; ?>">
			<br>
			<p>利用者かな</p>
			<input type="text" name="edit_kana" value="<?php print $user_edit_DB['name_kana']; ?>">
			<br><br>
			<select name="edit_area">
				<option value="0" <?php if($user_edit_DB['area']==0){print 'selected'; }?>>本校</option>
				<option value="1" <?php if($user_edit_DB['area']==1){print 'selected'; }?>>2校</option>
			</select>
			<input type="submit" value="利用者情報変更">
		</form>

		<form name="myform" action="http://localhost/Attendance_System/AdminUserList.php" method="get"　>
			<input type="hidden" name="delete_user_id" value="<?php print $user_edit_DB['id'];?>">
			<input type="submit" value="利用者削除" onclick="return Check()">
		</form>
	</div>
</div>


<form method="get" id="id" action="http://localhost/Attendance_System/AdminUserList.php">
	<input type="hidden" name="delete" value="delete">
    <input type="submit" value="削除" onClick="return Check()">
</form>

<!------------------------------------------------>
<script type="text/javascript">

function Check(){
	var checked = confirm("削除します");
	if (checked == true) {
		return true;
	} else {
		return false;
	}
}

// ---------------------------
// ▼A：対象要素を得る
// ---------------------------
var tabs = document.getElementById('tabcontrol').getElementsByTagName('a');
var pages = document.getElementById('tabbody').getElementsByTagName('div');

// ---------------------------
// ▼B：タブの切り替え処理
// ---------------------------
function changeTab() {
	// ▼B-1. href属性値から対象のid名を抜き出す
	var targetid = this.href.substring(this.href.indexOf('#')+1,this.href.length);

	// ▼B-2. 指定のタブページだけを表示する
	for(var i=0; i<pages.length; i++) {
		if( pages[i].id != targetid ) {
			pages[i].style.display = "none";
		}
		else {
			pages[i].style.display = "block";
		}
   }

	// ▼B-3. クリックされたタブを前面に表示する
	for(var i=0; i<tabs.length; i++) {
		tabs[i].style.zIndex = "0";
	}
	this.style.zIndex = "10";

	// ▼B-4. ページ遷移しないようにfalseを返す
	return false;
}

// ---------------------------
// ▼C：すべてのタブに対して、クリック時にchangeTab関数が実行されるよう指定する
// ---------------------------
for(var i=0; i<tabs.length; i++) {
  	 tabs[i].onclick = changeTab;
}

// ---------------------------
// ▼D：最初は先頭のタブを選択しておく
// ---------------------------
tabs[11].onclick();
    var tabs = document.getElementById('tabcontrol').getElementsByTagName('a');
    var pages = document.getElementById('tabbody').getElementsByTagName('div');
   
</script>
</body>
</html>
