<?php
session_start();
$lg=$_SESSION['LG'];
$pas=$_SESSION['PAS'];

include "../function.php";

$bdat=date_bd($_POST['bdate']);
$edat=date_bd($_POST['edate']);
$vuk=$_POST['vukon'];

$db=mysql_connect("localhost",$lg,$pas);
if(!$db) echo "Не вiдбулося зєднання з базою даних";
  
 if(!@mysql_select_db(kpbti,$db))
  {
   echo("Не завантажена таблиця");
   exit(); 
   }
$sql = "SELECT `ID_ROB`,`POSADA`,`1` FROM robitnuku,posadu 
	WHERE robitnuku.ROBS='".$vuk."' AND robitnuku.PS=posadu.ID"; 
 $atu=mysql_query($sql);
  while($aut=mysql_fetch_array($atu))
  {	
	$kod_rob=$aut["ID_ROB"];
	$posada=$aut["POSADA"];
	$pr=$aut["1"];
}
mysql_free_result($atu);

$p='<table style="font-size: 9pt;" border="0" cellpadding="0" cellspacing="0">
<tr><th align="left">
Відомість закриття нарядів та заробітна плата за відрядними розцінками за період з '.german_date($bdat).' по '.german_date($edat).'
</br>Виконавець робіт: '.$vuk.' '.$posada.'</th></tr>
</table></br><table style="font-size: 9pt;" border="1" cellpadding="0" cellspacing="0">
<tr>
<th align="center">Замовлення</th>
<th align="center">Адреса</th>
<th align="center" style="width:40px;">Сума всього</th>
<th align="center" style="width:40px;">Сума в наряд</th>
</tr>';
$tip=0;
$vsogo=0;
$svsogo=0;
$idzm2=0;
$sql1="SELECT zakruttya.*,taks.SUM,taks.SUM_OKR,spr_nr.KOD_ZM,zamovlennya.VIDSOTOK   
	FROM zakruttya,taks,spr_nr,zamovlennya   
	WHERE zakruttya.DT_ZAK>='$bdat' AND zakruttya.DT_ZAK<='$edat' AND zakruttya.DL='1' 
	AND zakruttya.ID_ZAK=taks.IDZM AND taks.DL='1' AND zakruttya.KODP=spr_nr.KODP 
	AND zamovlennya.KEY=zakruttya.ID_ZAK 
	ORDER BY KODP,SZ,SZU,NZ";			
//echo $sql1;
 $atu1=mysql_query($sql1);  
  while($aut1=mysql_fetch_array($atu1))
 {
	$idzm=$aut1["ID_ZAK"];
	if($idzm2!=$idzm && $idzm2!=0){
	if($tip==1) $naryad=$svsogo;
	else $naryad=0;
	$s_zak=round($sum+$sum_okr,2);
	$p.='<tr><td align="center">'.$zakaz.'</td><td>'.$adresa.'</td>
	<td align="center">'.procherk($s_zak).'</td>
	<td align="center">'.procherk($naryad).'</td>
	</tr>';
	$itog=$itog+$s_zak;
	$itog_nr=$itog_nr+$naryad;
	$tip=0;
	$svsogo=0;
	}
	$sz=$aut1["SZ"];
	$szu=$aut1["SZU"];
	$nz=$aut1["NZ"];
	$kod_zm=$aut1["KOD_ZM"];
	if($szu=='') $zakaz=$sz.'*'.$nz.'-'.$kod_zm;
	else $zakaz=$sz.'*'.$szu.'/'.$nz;
	$adresa=$aut1["ADRES"];
	$vk=$aut1["VK"];
	$v3=round((($aut1["3"]*$aut1["VIDSOTOK"])/100),2);
	$v4=round((($aut1["4"]*$aut1["VIDSOTOK"])/100),2);
	$v5=round((($aut1["5"]*$aut1["VIDSOTOK"])/100),2);
	$v6=round((($aut1["6"]*$aut1["VIDSOTOK"])/100),2);
	$v7=round((($aut1["7"]*$aut1["VIDSOTOK"])/100),2);
	$v8=round((($aut1["8"]*$aut1["VIDSOTOK"])/100),2);
	$sum=$aut1["SUM"];
	$sum_okr=$aut1["SUM_OKR"];
	$vsogo=$v3+$v4+$v5+$v6+$v7+$v8;
	$svsogo=$svsogo+$vsogo;
	if($vk==$kod_rob) $tip=1; //3 
	$idzm2=$idzm;

 } 
 mysql_free_result($atu1);  
if($tip==1) $naryad=$svsogo;
	else $naryad=0;
	$s_zak=round($sum+$sum_okr,2);
	$p.='<tr><td align="center">'.$zakaz.'</td><td>'.$adresa.'</td>
	<td align="center">'.procherk($s_zak).'</td>
	<td align="center">'.procherk($naryad).'</td>
	</tr>';
	$itog=$itog+$s_zak;
	$itog_nr=$itog_nr+$naryad;
$p.='<tr><td colspan="2">Всього</td>
	<td align="center">'.procherk($itog).'</td>
	<td align="center">'.procherk($itog_nr).'</td>
	</tr>';
$p.='</table></br>';

$p.='<table style="font-size: 9pt;" border="1" cellpadding="0" cellspacing="0">
<tr><th align="center">Вид робіт</th>
<th align="center">Вал(сума)</th>
<th align="center">Зарплата</th>
</tr>';
$zp=round((($itog_nr*$pr)/100),2);
$p.='<tr><td align="center">Відрядно виконані роботи КФ='.$pr.'</td>
<td align="right">'.procherk($itog_nr).'</td>
<td align="right">'.procherk($zp).'</td></tr>';
$p.='<tr><td>Всього:</td>
<td align="right">'.$itog_nr.'</td>
<td align="right">'.$zp.'</td></tr></table>';
$p.='<br>
<table style="font-size: 9pt;" border="0" cellpadding="0" cellspacing="0">
<tr><td></br>Провідний інженер з якості&nbsp</td><td></br>___________________&nbsp</td><td></br>Рєзнік Є.О.</td></table>';
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