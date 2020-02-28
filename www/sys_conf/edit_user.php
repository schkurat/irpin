<?php
$name=$_GET['name'];
$sql = "SELECT PR,IM,PB,PRD,DPS,DTL FROM security WHERE LOG='$name' AND DL='1'"; 
$atu=mysql_query($sql);
while($aut=mysql_fetch_array($atu))
{	
$pr=$aut['PR'];
$im=$aut['IM'];
$pb=$aut['PB'];
$prd=$aut['PRD'];
$dps=$aut['DPS'];
$dtl=$aut['DTL'];
$pidpus='';
}
mysql_free_result($atu);
$mas1=array();
$mas2=array();

for($i=0; $i<=15; $i++){
if($prd{$i}=="1"){$mas1[$i]="checked";}
} 
for($i=0; $i<=43; $i++){
if($dzm{$i}=="1"){$mas2[$i]="checked";}
} 
if($dtl=="1") $ch_dtl="checked";
else $ch_dtl="";
//$pos=strpos($dps,'1');
if($dps=="1"){
$pidpus="checked";
}
?>
<form action="update_user.php" name="myform" method="post">
<table align="center" class="zmview">
<tr><th colspan="4" align="center">Редагування користувача</th></tr>
<tr><td colspan="4">Прізвище <input name="priz" type="text" value="<?php echo $pr; ?>"/>
Ім`я<input name="imya" type="text" value="<?php echo $im; ?>"/>
По батькові<input name="pobat" type="text" value="<?php echo $pb; ?>"/></td></tr>
<tr><th colspan="4">Права доступу</th></tr>
<tr><td>
<input name="1" type="checkbox" value="pr1" <?php echo $mas1[0]; ?>/>Прийом замовлення
</td><td>
<input name="2" type="checkbox" value="pr2" <?php echo $mas1[1]; ?>/>Розподіл/контроль замовл.
</td><td>
<input name="3" type="checkbox" value="pr3" <?php echo $mas1[2]; ?>/>Адміністратор
</td><td>
<input name="4" type="checkbox" value="pr4" <?php echo $mas1[3]; ?>/>Таксування
</td></tr>
<tr><td>
<input name="5" type="checkbox" value="pr5" <?php echo $mas1[4]; ?>/>Ще не існуючий блок
</td><td>
<input name="6" type="checkbox" value="pr6" <?php echo $mas1[5]; ?>/>Ще не існуючий блок
</td><td>
<input name="7" type="checkbox" value="pr7" <?php echo $mas1[6]; ?>/>Зведення нарядів
</td><td>
<input name="8" type="checkbox" value="pr8" <?php echo $mas1[7]; ?>/>Електронний архів
</td></tr>
<tr><td>
<input name="9" type="checkbox" value="pr9" <?php echo $mas1[8]; ?>/>Книга оліку самоч. буд.
</td><td>
<input name="10" type="checkbox" value="pr10" <?php echo $mas1[9]; ?>/>Архів
</td><td>
<input name="11" type="checkbox" value="pr11" <?php echo $mas1[10]; ?>/>Канцелярія
</td><td>
<input name="12" type="checkbox" value="pr12" <?php echo $mas1[11]; ?>/>Реєстрація
</td></tr>
<tr><td>
<input name="13" type="checkbox" value="pr13" <?php echo $mas1[12]; ?>/>Аналітика
</td><td>
<input name="14" type="checkbox" value="pr14" <?php echo $mas1[13]; ?>/>Ще не існуючий блок
</td>
<td colspan="2" align="center">
<input name="15" type="checkbox" value="pr15" <?php echo $mas1[14]; ?>/>Ще не існуючий блок
</td>
</tr>
<!--<tr><th colspan="4">Доступ до філій</th></tr>-->
<?php
/* $kk=0;
$sql = "SELECT spr_nr.ID,spr_nr.NAS FROM spr_nr ORDER BY ID";
 $atu=mysql_query($sql);
  while($aut=mysql_fetch_array($atu))
 {$kk++;
 if($kk==4){
 $ss.='<td><input name="d'.$aut["ID"].'" type="checkbox" value="pz'.$aut["ID"].'" '.$mas2[$aut["ID"]-1].'/>'.$aut["NAS"].'</td></tr>';
 $kk=0;
 }
 if($kk==1){
 $ss.='<tr><td><input name="d'.$aut["ID"].'" type="checkbox" value="pz'.$aut["ID"].'" '.$mas2[$aut["ID"]-1].'/>'.$aut["NAS"].'</td>';
 }
 if($kk!=1 and $kk!=4 and $kk!=0){
 $ss.='<td><input name="d'.$aut["ID"].'" type="checkbox" value="pz'.$aut["ID"].'" '.$mas2[$aut["ID"]-1].'/>'.$aut["NAS"].'</td>';
 }
 }
mysql_free_result($atu);
if($kk<=4){$ss.='<td>-</td></tr>';}
echo $ss; */
?>
<tr><th colspan="4">Розширені права доступу</th></tr>
<tr><td>
<input name="21" type="checkbox" value="pr21" <?php echo $ch_dtl; ?>/>Видалення замовлення
</td>
<td colspan="3">
<input name="25" type="checkbox" value="pr25" <?php echo $pidpus; ?>/>Підпис справ
<input name="id_us" type="hidden" value="<?php echo $name; ?>"/>
</td>
</tr>
<tr><td colspan="2" align="center">
<input name="Ok" type="submit" value="Змінити" /></td>
<td colspan="2" align="center">
<input name="reset" type="reset" value="Очистити" />
</td>
</tr>
</table>
</form>