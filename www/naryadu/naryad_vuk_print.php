<?php
session_start();
$lg=$_SESSION['LG'];
$pas=$_SESSION['PAS'];

include "../function.php";
$p='';
$bdat=date_bd($_POST['bdate']);
$edat=date_bd($_POST['edate']);
$vuk=$_POST['vukon'];
if($vuk!='') $filter=" robitnuku.ROBS='".$vuk."' AND ";
else $filter="";


$db=mysql_connect("localhost",$lg,$pas);
if(!$db) echo "Не вiдбулося зєднання з базою даних";
  
 if(!@mysql_select_db(kpbti,$db))
  {
   echo("Не завантажена таблиця");
   exit(); 
   }
//robitnuku.ROBS='".$vuk."' AND
$sql = "SELECT `ID_ROB`,`ROBS`,`POSADA`,`1`,`2`,`3`,`4`,`5`,`6`,`7`,`8`,`9`,`10`,`11`,`12` FROM robitnuku,posadu 
	WHERE ".$filter." robitnuku.PS=posadu.ID"; 
 $atu=mysql_query($sql);
  while($aut=mysql_fetch_array($atu))
  {	
	$kod_rob=$aut["ID_ROB"];
	$robs=$aut["ROBS"];
	$posada=$aut["POSADA"];
	$pr1=$aut["1"]; $pr2=$aut["2"]; $pr3=$aut["3"]; $pr4=$aut["4"]; $pr5=$aut["5"]; $pr6=$aut["6"];
	$pr7=$aut["7"]; $pr8=$aut["8"]; $pr9=$aut["9"]; $pr10=$aut["10"]; $pr11=$aut["11"]; $pr12=$aut["12"];


$p.='<table style="font-size: 9pt;" border="0" cellpadding="0" cellspacing="0">
<tr><th align="left">
Відомість закриття нарядів та заробітна плата за відрядними розцінками за період з '.german_date($bdat).' по '.german_date($edat).'
</br>Виконавець робіт: '.$robs.' '.$posada.'</th></tr>
</table></br><table style="font-size: 9pt;" border="1" cellpadding="0" cellspacing="0">
<tr>
<th align="center">Замовлення</th>
<th align="center">Адреса</th>
<th align="center" style="width:40px;">1</th>
<th align="center" style="width:40px;">2</th>
<th align="center" style="width:40px;">3</th>
<th align="center" style="width:40px;">4</th>
<th align="center" style="width:40px;">5</th>
<th align="center" style="width:40px;">6</th>
<th align="center" style="width:40px;">7</th>
<th align="center" style="width:40px;">8</th>
<th align="center" style="width:40px;">9</th>
<th align="center" style="width:40px;">10</th>
<th align="center" style="width:40px;">11</th>
<th align="center" style="width:40px;">12</th>
<th align="center">Всього</th>
</tr>';

$sv1=0; $sv2=0; $sv3=0; $sv4=0; $sv5=0; $sv6=0; $sv7=0; $sv8=0; $sv9=0; $sv10=0; $sv11=0; $sv12=0;
$svsogo=0;
$sql1="SELECT zakruttya.*,spr_nr.KOD_ZM,zamovlennya.VIDSOTOK FROM zakruttya,spr_nr,zamovlennya  
	WHERE zakruttya.DT_ZAK>='$bdat' AND zakruttya.DT_ZAK<='$edat' AND zakruttya.DL='1' 
	AND zakruttya.VK='$kod_rob' AND zakruttya.KODP=spr_nr.KODP AND zamovlennya.KEY=zakruttya.ID_ZAK 
	ORDER BY KODP,SZ,SZU,NZ";			
//echo $sql1;
 $atu1=mysql_query($sql1);  
  while($aut1=mysql_fetch_array($atu1))
 {
	$tip=0;
	$sz=$aut1["SZ"];
	$szu=$aut1["SZU"];
	$nz=$aut1["NZ"];
	$kod_zm=$aut1["KOD_ZM"];
	if($szu=='') $zakaz=$sz.'*'.$nz.'-'.$kod_zm;
	else $zakaz=$sz.'*'.$szu.'/'.$nz;
	$adresa=$aut1["ADRES"];
	$v1=round((($aut1["1"]*$aut1["VIDSOTOK"])/100),2);
	$v2=round((($aut1["2"]*$aut1["VIDSOTOK"])/100),2);
	$v3=round((($aut1["3"]*$aut1["VIDSOTOK"])/100),2);
	$v4=round((($aut1["4"]*$aut1["VIDSOTOK"])/100),2);
	$v5=round((($aut1["5"]*$aut1["VIDSOTOK"])/100),2);
	$v6=round((($aut1["6"]*$aut1["VIDSOTOK"])/100),2);
	$v7=round((($aut1["7"]*$aut1["VIDSOTOK"])/100),2);
	$v8=round((($aut1["8"]*$aut1["VIDSOTOK"])/100),2);
	$v9=round((($aut1["9"]*$aut1["VIDSOTOK"])/100),2);
	$v10=round((($aut1["10"]*$aut1["VIDSOTOK"])/100),2);
	$v11=round((($aut1["11"]*$aut1["VIDSOTOK"])/100),2);
	$v12=round((($aut1["12"]*$aut1["VIDSOTOK"])/100),2);
	$vsogo=$v1+$v2+$v3+$v4+$v5+$v6+$v7+$v8+$v9+$v10+$v11+$v12;
	$svsogo=$svsogo+$vsogo;
$sv1=$sv1+$v1; $sv2=$sv2+$v2; $sv3=$sv3+$v3; $sv4=$sv4+$v4; $sv5=$sv5+$v5; $sv6=$sv6+$v6; 
$sv7=$sv7+$v7; $sv8=$sv8+$v8; $sv9=$sv9+$v9; $sv10=$sv10+$v10; $sv11=$sv11+$v11; $sv12=$sv12+$v12;
	
$p.='<tr><td align="center">'.$zakaz.'</td><td>'.$adresa.'</td>
<td align="center">'.procherk($v1).'</td>
<td align="center">'.procherk($v2).'</td>
<td align="center">'.procherk($v3).'</td>
<td align="center">'.procherk($v4).'</td>
<td align="center">'.procherk($v5).'</td>
<td align="center">'.procherk($v6).'</td>
<td align="center">'.procherk($v7).'</td>
<td align="center">'.procherk($v8).'</td>
<td align="center">'.procherk($v9).'</td>
<td align="center">'.procherk($v10).'</td>
<td align="center">'.procherk($v11).'</td>
<td align="center">'.procherk($v12).'</td>
<td align="center">'.procherk($vsogo).'</td>
</tr>';

 } 
 mysql_free_result($atu1);  

$p.='<tr><td colspan="2">Всього:</td>
<td align="center">'.procherk($sv1).'</td>
<td align="center">'.procherk($sv2).'</td>
<td align="center">'.procherk($sv3).'</td>
<td align="center">'.procherk($sv4).'</td>
<td align="center">'.procherk($sv5).'</td>
<td align="center">'.procherk($sv6).'</td>
<td align="center">'.procherk($sv7).'</td>
<td align="center">'.procherk($sv8).'</td>
<td align="center">'.procherk($sv9).'</td>
<td align="center">'.procherk($sv10).'</td>
<td align="center">'.procherk($sv11).'</td>
<td align="center">'.procherk($sv12).'</td>
<td align="center">'.procherk($svsogo).'</td>
</tr>';
$p.='</table></br>';
$p.='<table style="font-size: 9pt;" border="1" cellpadding="0" cellspacing="0">
<tr><th align="center">Вид</th>
<th align="center">Назва</th>
<th align="center">Вал(сума)</th>
<th align="center">К.ф.</th>
<th align="center">Зарплата</th>
</tr>';
$zp1=round((($sv1*$pr1)/100),2);
$zp2=round((($sv2*$pr2)/100),2);
$zp3=round((($sv3*$pr3)/100),2);
$zp4=round((($sv4*$pr4)/100),2);
$zp5=round((($sv5*$pr5)/100),2);
$zp6=round((($sv6*$pr6)/100),2);
$zp7=round((($sv7*$pr7)/100),2);
$zp8=round((($sv8*$pr8)/100),2);
$zp9=round((($sv9*$pr9)/100),2);
$zp10=round((($sv10*$pr10)/100),2);
$zp11=round((($sv11*$pr11)/100),2);
$zp12=round((($sv12*$pr12)/100),2);
$zp_sum=$zp1+$zp2+$zp3+$zp4+$zp5+$zp6+$zp7+$zp8+$zp9+$zp10+$zp11+$zp12;
$p.='<tr><td align="center">1</td>
<td>Прийом замовлень в інших населених пунктах</td>
<td align="right">'.procherk($sv1).'</td>
<td align="right">'.$pr1.'</td>
<td align="right">'.procherk($zp1).'</td></tr>
<tr><td align="center">2</td>
<td>Ведення архіву в інших населених пунктах</td>
<td align="right">'.procherk($sv2).'</td>
<td align="right">'.$pr2.'</td>
<td align="right">'.procherk($zp2).'</td></tr>
<tr><td align="center">3</td>
<td>Первинна інвентаризація в місті</td>
<td align="right">'.procherk($sv3).'</td>
<td align="right">'.$pr3.'</td>
<td align="right">'.procherk($zp3).'</td></tr>
<tr><td align="center">4</td>
<td>Первинна інвентаризація в інших населених пунктах</td>
<td align="right">'.procherk($sv4).'</td>
<td align="right">'.$pr4.'</td>
<td align="right">'.procherk($zp4).'</td></tr>
<tr><td align="center">5</td>
<td>Поточна інвентаризація в місті</td>
<td align="right">'.procherk($sv5).'</td>
<td align="right">'.$pr5.'</td>
<td align="right">'.procherk($zp5).'</td></tr>
<tr><td align="center">6</td>
<td>Поточна інвентаризація в інших населених пунктах</td>
<td align="right">'.procherk($sv6).'</td>
<td align="right">'.$pr6.'</td>
<td align="right">'.procherk($zp6).'</td></tr>
<tr><td align="center">7</td>
<td>Роботи, що не потребують виходу на об`єкт в місті</td>
<td align="right">'.procherk($sv7).'</td>
<td align="right">'.$pr7.'</td>
<td align="right">'.procherk($zp7).'</td></tr>
<tr><td align="center">8</td>
<td>Роботи, що не потребують виходу на об`єкт в інших населених пунктах</td>
<td align="right">'.procherk($sv8).'</td>
<td align="right">'.$pr8.'</td>
<td align="right">'.procherk($zp8).'</td></tr>
<tr><td align="center">9</td>
<td>Прийом замовлень в місці проживання працівника</td>
<td align="right">'.procherk($sv9).'</td>
<td align="right">'.$pr9.'</td>
<td align="right">'.procherk($zp9).'</td></tr>
<tr><td align="center">10</td>
<td>Ведення архіву в місці проживання працівника</td>
<td align="right">'.procherk($sv10).'</td>
<td align="right">'.$pr10.'</td>
<td align="right">'.procherk($zp10).'</td></tr>
<tr><td align="center">11</td>
<td>Виготовлення довідки</td>
<td align="right">'.procherk($sv11).'</td>
<td align="right">'.$pr11.'</td>
<td align="right">'.procherk($zp11).'</td></tr>
<tr><td align="center">12</td>
<td>Таксування робіт</td>
<td align="right">'.procherk($sv12).'</td>
<td align="right">'.$pr12.'</td>
<td align="right">'.procherk($zp12).'</td></tr>';
$p.='<tr><td colspan="2">Всього:</td>
<td align="right">'.$svsogo.'</td>
<td align="center">-</td>
<td align="right">'.$zp_sum.'</td></tr></table>';
$p.='<br>
<table style="font-size: 9pt;" border="0" cellpadding="0" cellspacing="0">
<tr><td align="right">Виконавець&nbsp</td><td>___________________&nbsp</td><td>'.$robs.'</td></tr>
<tr><td></br>Провідний інженер з якості&nbsp</td><td></br>___________________&nbsp</td><td></br>Рєзнік Є.О.</td></table><br><br>';

}
mysql_free_result($atu);

echo $p;
if(mysql_close($db))
        {
        // echo("Закриття бази даних");
         }
         else
         {
          echo("Не можливо виконати закриття бази"); 
          }		  
?>