<?php
require_once 'DBConnection.php';
$db_connection = new DBsettion();
$db_connection->__construct();

function entry(){
    if(isset($_POST['entry_name'])){ //利用者エントリー
        $db_connection = new DBsettion();

        $sql='INSERT users(name, name_kana, area, update_admin_id, insert_date)VALUES(?, ?, ?, ?, now())';
        $user_entry[]=$_POST['entry_name'];
        $user_entry[]=$_POST['entry_kana'];
        $user_entry[]=$_POST['entry_area'];
        $user_entry[]=$_SESSION['admin_id'];
        $stmt=$db_connection->setSql($sql, $user_entry);
        $entry_alert = "<script type='text/javascript'>alert('利用者の登録を完了しました。');</script>";
        print $entry_alert;
    }
}

if(isset($_POST['in'])){//IN時間を記録する
    $sql='INSERT user_performance(user_id, judge_fg, date, insert_date)VALUES(?, ?, ?, now())';
    $punch_in[]=$_GET['user_id'];
    $punch_in[]=0;
    $punch_in[]=$date;
    $stmt=$db_connection->setSql($sql, $punch_in);
}

if(isset($_POST['out'])){//OUT時間を記録する
    $sql='INSERT user_performance(user_id, judge_fg, date, insert_date)VALUES(?, ?, ?, now())';
    $punch_out[]=$_GET['user_id'];
    $punch_out[]=1;
    $punch_out[]=$date;
    $stmt=$db_connection->setSql($sql, $punch_out);
}

//areaのユーザー一覧
function users($area){

    $db_connection = new DBsettion();
    $sql='SELECT * FROM users WHERE area=? AND delete_fg=0 ORDER BY name_kana';
    $users_table[]=$_SESSION['area'];
    $stmt=$db_connection->setSql($sql, $users_table);
    $_SESSION['usersDB']=$stmt->fetchAll(PDO::FETCH_ASSOC);
}

//管理者ログイン時間をupdate
$sql='UPDATE admin SET update_date=now() WHERE name=? AND password=?';
$admin_insert[]=$_SESSION['login'];
$admin_insert[]=$_SESSION['pass'];
$stmt=$db_connection->setSql($sql, $admin_insert);

$sql='SELECT * FROM admin WHERE name=? AND password=?';
$admin_table[]=$_SESSION['login'];
$admin_table[]=$_SESSION['pass'];
$stmt=$db_connection->setSql($sql, $admin_table);
$adminDB=$stmt->fetch(PDO::FETCH_ASSOC);

//当日の利用者実績データを取得
$sql='SELECT * FROM user_performance WHERE user_id=? AND delete_fg=0 AND CAST(date AS date)=CURRENT_DATE()';
$performance_table[]=$_GET['user_id'];
$stmt=$db_connection->setSql($sql, $performance_table);
$performanceDB=$stmt->fetchAll(PDO::FETCH_ASSOC);
$_SESSION['performanceDB']=$performanceDB;

//各月日ごとに時間を取得する。
function performance($year, $month, $user_id, $judge){
    $date1 = new DateTime($year.'-'.$month.'-1');
    $first_day=$date1->format('Y-m-d 00:00:00');
    $date2 = new DateTime($year.'-'.$month.'-1');
    $last_day=$date2->modify('+1 months')->format('Y-m-d 00:00:00');
    $db_connection = new DBsettion();

    $sql='SELECT * FROM user_performance WHERE user_id=? AND delete_fg=0 AND judge_fg=? AND date BETWEEN ? AND ?';
    $performance_m[]=$user_id;
    $performance_m[]=$judge;
    $performance_m[]=$first_day;
    $performance_m[]=$last_day;
    $stmt=$db_connection->setSql($sql, $performance_m);
    return $performance_monthDB=$stmt->fetchAll(PDO::FETCH_ASSOC);
}

function edit_date_time($id, $date, $time=0, $judge, $user_id){
    if($time!=0 && $time!='--:--'){
        $dt=new DateTime();
        $set_date=$dt->format($date.' '.$time.':00');
        $db_connection = new DBsettion();
        
        if($id!=0){
            $sql='UPDATE user_performance SET date=?, update_date=now(), update_admin_id=? WHERE id=? ';
            $performance_edit[]=$set_date;
            $performance_edit[]=$_SESSION['admin_id'];
            $performance_edit[]=$id;
            $stmt=$db_connection->setSql($sql, $performance_edit);
            $edit_alert = "<script type='text/javascript'>alert('利用者の打刻時間を編集しました。');</script>";
            print $edit_alert;

        }else if($id==0){
            $sql='INSERT user_performance (date, update_date, update_admin_id, judge_fg, user_id)VALUES(?, now(), ?, ?, ?) ';
            $performance_edit_new[]=$set_date;
            $performance_edit_new[]=$_SESSION['admin_id'];
            $performance_edit_new[]=$judge;
            $performance_edit_new[]=$user_id;
            $stmt=$db_connection->setSql($sql, $performance_edit_new);
            $new_edit_alert = "<script type='text/javascript'>alert('利用者の打刻時間を追加しました。');</script>";
            print $new_edit_alert;
        }
    }
}

function delete($delete_id){

    $db_connection = new DBsettion();
    $sql='UPDATE user_performance SET delete_fg=1, update_admin_id=?, update_date=now() WHERE id=?';
    $delete_fg[]=$_SESSION['admin_id'];
    $delete_fg[]=$delete_id;
    $stmt=$db_connection->setSql($sql, $delete_fg);

}

function user_edit_memory($user_id){

    $db_connection = new DBsettion();
    $sql='SELECT * FROM users WHERE id=?';
    $user_memory[]=$user_id;
    $stmt=$db_connection->setSql($sql, $user_memory);
    return $user_date=$stmt->fetch(PDO::FETCH_ASSOC);

}

function edit_user($name, $kana, $area, $id, $admin_id){

    $db_connection = new DBsettion();
    $sql='UPDATE users SET name=?, name_kana=?, area=?, update_admin_id=?, update_date=now() WHERE id=?';
    $edit_user[]=$name;
    $edit_user[]=$kana;
    $edit_user[]=$area;
    $edit_user[]=$admin_id;
    $edit_user[]=$id;
    $stmt=$db_connection->setSql($sql, $edit_user);

}

function user_delete($user_id, $admin_id){
    $db_connection = new DBsettion();
    $sql='UPDATE users SET update_date=now(), update_admin_id=?, delete_fg=1 WHERE id=?';
    $delete_user[]=$admin_id;
    $delete_user[]=$user_id;
    $stmt=$db_connection->setSql($sql, $delete_user);
    
}

?>