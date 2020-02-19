<?php //IN OUT 時間の打刻時間を計算する
function date_memory($date,$pfmDB){
    if(isset($_POST['in'])||isset($_POST['out'])){
        $dt = new DateTime();
        $now_hour_minute=$dt->format('i:s');

        if(strtotime("now") < strtotime('9:30:00')){
            $in_date=date("Y/m/d 9:30:00");
            return $in_date;

        }else if(strtotime("now") < strtotime('16:00:00')){
            if(!empty($pfmDB)){
                
                switch(strtotime($now_hour_minute)){
                    case strtotime("00:00")<strtotime("14:59"):
                        return $within_punch_out="00:00";
                        break;
                    case strtotime("15:00")<strtotime("29:59"):
                        return $within_punch_out="15:00";
                        break;
                    case strtotime("30:00")<strtotime("44:59"):
                        return $within_punch_out="30:00";
                        break;
                    case strtotime("45:00")<strtotime("59:59"):
                        return $within_punch_out="45:00";
                        break;
                }
            }
            else{
                switch(strtotime($now_hour_minute)){
                    case strtotime("00:00")<strtotime("14:59"):
                        return $within_punch_in="15:00";
                        break;
                    case strtotime("15:00")<strtotime("29:59"):
                        return $within_punch_in="30:00";
                        break;
                    case strtotime("30:00")<strtotime("44:59"):
                        return $within_punch_in="45:00";
                        break;
                    case strtotime("45:00")<strtotime("59:59"):
                        return $within_punch_in="00:00";
                        break;
                }
            }
        }else if(strtotime("now") > strtotime('16:00:00')){
            $out_date=date("Y/m/d 16:00:00");
            return $out_date;
        }
    }
}

function set_date($year,$month,$day_or_last){
    $dt = new Datetime();
    if($day_or_last==0){
        $dt->setDate($year,$month,1);
        return $last_day=$dt->format('t'); 
        //月日数を計算を返す
    }else if($day_or_last>=1){
        $dt->setDate($year,$month,$day_or_last);
        return $dt->format('Y-m-d');
        //年月日を返す
    }
}

function days($year,$month,$user_id){
    ?>
    <p><?php print $year.'年'; ?></p>
    <table>
    <tr>
    <th>日</th>
    <th>I N編集</th>
    <th>I N削除</th>
    <th>OUT編集</th>
    <th>OUT削除</th>
    </tr>
    <?php
    $last_day=set_date($year,$month,0);//月日数を取得する
    $performance_in=performance($year,$month,$user_id,0);//ユーザーの月のINを取得する
    $performance_out=performance($year,$month,$user_id,1);//ユーザーの月のOUTを取得する
    $i=1;
    //var_dump($performance_in);
    ?>
    <?php
    while($i<=$last_day){
        $month_day=set_date($year,$month,$i);//年月日
        $in_date=performance_in($performance_in,$month_day);
        $out_date=performance_out($performance_out,$month_day); 
        //var_dump($in_date);
        //var_dump($out_date);
        ?>
        <tr>
        <td>
        <?php
        print $i;//日を出力する
        ?>
        </td>
        <td>
        <?php
        date_list($in_date[0],$in_date[1],$month_day,0);//記録されたIN時間を出力する
        ?>
        </td>
        <td>
        <form action="#" method="get">
        <input type="submit" value="削除"><!--IN時間をDELETEする-->
        <input type="hidden" name="delete_id" value="<?php print $in_date[1];?>">
        </form>
        </td>
        <td>
        <?php
        date_list($out_date[0],$out_date[1],$month_day,1);//記録されたOUT時間を出力する
        ?>
        </td>
        <td>
        <form action="#" method="get">
        <input type="submit" value="削除"><!--OUT時間をDELETEする-->
        <input type="hidden" name="delete_id" value="<?php print $out_date[1];?>">
        </form>
        </td>
        </tr>
        <?php
        $i++;
    }
    ?>
    </table>
    <?php
}

function performance_in($performance_in,$month_day){
  // var_dump($performance_in);
    foreach($performance_in as $pfm){
        //var_dump($pfm);
        $dt = new DateTime($pfm['date']);
        $date=$dt->format('Y-m-d');
        if($date==$month_day){
            $in_date[0]=$dt->format('H:i');
            $in_date[1]=$pfm['id'];
            break;
            
        }else if($date!=$month_day){
            $in_date[0]=0;
            $in_date[1]=0;
            
        }
    }
    return $in_date;
}

function performance_out($performance_out,$month_day){ 
    foreach($performance_out as $pfm){
        $dt = new DateTime($pfm['date']);
        $date=$dt->format('Y-m-d');//記録済みのデータを年月日に変換する
        if($date==$month_day){
            $out_date[0]=$dt->format('H:i');
            $out_date[1]=$pfm['id'];
            break;
        }
        else if($date!=$month_day){
            $out_date[0]=0;
            $out_date[1]=0;
            
        }
    }
    return $out_date;
}

function date_list($hour_minute,$id,$date,$judge){ //編集画面の時間プルダウン
?>
    <form action="#" method="get">
    <input type="hidden" name="judge" value="<?php print $judge;?>">
    <input type="hidden" name="set_id" value="<?php print $id;?>">
    <input type="hidden" name="set_date" value="<?php print $date;?>">
    <select name="set_hour_minute"　value="">
    <?php
        if($hour_minute!=0){
    ?>
    <option selected><?php print $hour_minute;?></option>
    <?php
    }else if($hour_minute==0){
        ?>
    <option selected>--:--</option>
        <?php
    }
    $h=9;
    while($h<=16){
        if($h==9 && $judge==0){
        ?>
        <option value="<?php print $h;?>:30"><?php print $h;?>:30</option>
        <option value="<?php print $h;?>:45"><?php print $h;?>:45</option>
        <?php
        }
        if($h!=9 && $h!=16){
        ?>
        <option value="<?php print $h;?>:00"><?php print $h;?>:00</option>
        <option value="<?php print $h;?>:15"><?php print $h;?>:15</option>
        <option value="<?php print $h;?>:30"><?php print $h;?>:30</option>
        <option value="<?php print $h;?>:45"><?php print $h;?>:45</option>
        <?php
        }
        if($h==16 && $judge==1){
        ?>
        <option value="<?php print $h;?>:00"><?php print $h;?>:00</option>
        <?php
        }
        $h++;
    }
    ?>
</select>
<input type="submit" value="変更">
</form>
<?php
}

?>