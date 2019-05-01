<?php
session_start();
header('Content-Type: text/html; charset=utf-8');
?>
<html>
<title>
Автоматизована система інвентаризації об'єктів нерухомості
</title>
<link rel="stylesheet" type="text/css" href="my.css" />
 <style>
#dr{
    font-family: "Monotype Corsiva";
   } 
hr {
	background: url(images/hr.png) no-repeat center;
	background-color: #ededed;
	height: 28px;
	border:none !important;
   -moz-background-size: 100%; /* Firefox 3.6+ */
   -webkit-background-size: 100%; /* Safari 3.1+ и Chrome 4.0+ */
   -o-background-size: 100%; /* Opera 9.6+ */
   background-size: 100%; /* Современные браузеры */
}
  </style>
  
<body>
<?php
$lg=$_SESSION['LG'];
$pas=$_SESSION['PAS'];
$pr=$_SESSION['PR'];
$im=$_SESSION['IM'];
$pb=$_SESSION['PB'];
$pd=$_SESSION['PD'];

if($pr!=""){
$privet='<tr style="height: 50px;"><td colspan="7"><font size="5"> Доброго дня '.$pr.' '.$im.' '.$pb.'</font><br></td></tr>'; 
$filter=array("disabled","disabled","disabled","disabled","disabled","disabled","disabled",
"disabled","disabled","disabled","disabled","disabled","disabled","disabled");
for($i=0; $i<15; $i++){ 
if($pd{$i}==1) {$filter[$i]="enabled";}
 }

$pb='<table align="center" border="0" cellspacing="0" style="width:900px;"><tr>';
$p[0]='<td align="center"><A href="zm/zamovlennya.php">
<img src="images/new_zm.png" style="width:100px;height:100px" title="Нове замовлення" alt="Нове замовлення" border="0">
</A></td>';
$p[1]='<td align="center"><A href="kans/kanselyariya.php">
<img src="images/kans.png" style="width:100px;height:100px" title="Канцелярія" alt="Канцелярія" border="0">
</A></td>';
$p[2]='<td align="center"><A href="sys_conf/admin.php">
<img src="images/admin.png" style="width:100px;height:100px" title="Адміністратор" alt="Адміністратор" border="0">
</A></td>';
$p[3]='<td align="center"><A href="kontrol/kontrol.php">
<img src="images/kontrol.png" style="width:100px;height:100px" title="Контроль замовлень" alt="Контроль замовлень" border="0">
</A></td>';
$p[4]='<td align="center"><A href="vudacha/vudacha.php">
<img src="images/vudacha.png" style="width:100px;height:100px" title="Видача замовлення" alt="Видача замовлення" border="0">
</A></td>';
$str='</tr><tr>';
$p[5]='<td align="center"><A href="pidpus/pidpus.php?filter=pidpus_view&flag=nap">
<img src="images/pidpus.png" style="width:100px;height:100px" title="Підпис" alt="Підпис" border="0">
</A></td>';
$p[6]='<td align="center"><A href="naryadu/naryadu.php">
<img src="images/naryad.png" style="width:100px;height:100px" title="Зведення нарядів" alt="Зведення нарядів" border="0">
</A></td>';
$p[7]='<td align="center"><A href="arhiv/arhiv.php">
<img src="images/arh.png" style="width:100px;height:100px" title="Архів" alt="Архів" border="0">
</A></td>';
$p[8]='<td align="center"><A href="samovol/samovol.php">
<img src="images/kniga.png" style="width:100px;height:100px" title="Книга обліку самоч. буд." alt="Книга обліку самов. буд." border="0">
</A></td>';
$p[9]='<td align="center"><A href="e_arhiv/earhiv.php">
<img src="images/earh.png" style="width:100px;height:100px" title="Електронний архів" alt="Електронний архів" border="0">
</A></td>';
$p[10]='<td align="center"><A href="taks/taks.php">
<img src="images/taks.png" title="Таксування" alt="Таксування" border="0">
</A></td>';
$p[11]='<td align="center"><A href="reestr/reestr.php">
<img src="images/reestr.png" style="width:100px;height:100px" title="Реєстрація" alt="Реєстрація" border="0">
</A></td>';
$p[12]='<td align="center"><A href="analytics/analytics.php">
<img src="images/graf_menu.png" style="width:100px;height:100px" title="Аналітичний блок" alt="Аналітични блок" border="0">
</A></td>';
$p[13]='<td align="center"><A href="tehnik/select_zm.php">
<img src="images/pencil.png" title="АРМ техніка" alt="АРМ техніка" border="0">
</A></td>';

$pe='</tr></table>';
echo $pb;
echo $privet;
//echo $logo;

//----pozdravlyalka----------------
$db=mysql_connect("localhost",$lg,$pas);
if(!$db) echo "Не вiдбулося зєднання з базою даних";
  
 if(!@mysql_select_db(kpbti,$db))
  {
   echo("Не завантажена таблиця");
   exit(); 
   }
$dt_seg=date("m-d");
$dt_1d=date("m-d",mktime(0,0,0,date("m"),date("d")+1,0));
$dt_2d=date("m-d",mktime(0,0,0,date("m"),date("d")+2,0));

$sql = "SELECT ROBITNUK,DATE_FORMAT(DN,'%m-%d') AS DN,FILE FROM robitnuku WHERE DATE_FORMAT(DN,'%m-%d')>='$dt_seg' AND DATE_FORMAT(DN,'%m-%d')<='$dt_2d' AND DL='1'";
$atu=mysql_query($sql);
while($aut=mysql_fetch_array($atu))
{
$pr_dn_2d='';
$pr_dn_1d='';
$pr_dn_seg='';
if($aut['DN']==$dt_2d) $pr_dn_2d='<font size="4">Через 2 дні свій День народження святкуватиме '.$aut['ROBITNUK'].'</font>';
if($aut['DN']==$dt_1d) $pr_dn_1d='<font size="4">Через 1 день свій День народження святкуватиме '.$aut['ROBITNUK'].'</font>';
if($aut['DN']==$dt_seg) $pr_dn_seg='<font size="6">'.$aut['ROBITNUK'].'</font>';
if($pr_dn_2d!='') echo '<tr><td colspan="7">'.$pr_dn_2d.'</td></tr>';
if($pr_dn_1d!='') echo '<tr><td colspan="7">'.$pr_dn_1d.'</td></tr>';
if($pr_dn_seg!='') {
$file=$aut['FILE'];
if(!copy('/home/common/hb/'.$file,'/var/www/html/images/'.$file)) echo "Не удалось скопировать";
echo '<tr bgcolor="">
<td colspan="7" align="center">
<img src="images/'.$file.'" title="С днем народження" alt="С днем народження" border="0"/></td>
</tr>
<!--<tr bgcolor=""><td colspan="3" align="center" id="dr">'.$pr_dn_seg.'</td></tr>-->
';}
}
mysql_free_result($atu);

if(mysql_close($db))
    {
    // echo("Закриття бази даних");
        }
    else
    {
        echo("Не можливо виконати закриття бази"); 
        }
//---------------------------------

$z=0;
for($k=0;$k<14;$k++){
If($filter[$k]=='enabled'){
echo $p[$k];
$z++;}
if($z==7){
echo $str;
$z=0;
}
}

$power='<tr><td colspan="7" align="center">
<A href="close_ses.php">
<img src="images/power.png" style="width:100px;height:100px" title="Вихід із програми" alt="Вихід із програми" border="0">
</A>
</td></tr>';
echo $power;
echo $pe;
//-----------------------------------------------
/* $text="В програму увійшов ".$pr." ".$im."!";
$tempfile="/var/spool/sms/outgoing/send_menu";
$SMSFILE = fopen($tempfile, "w");
$ucs2text=mb_convert_encoding($text, "UCS-2BE", "UTF-8");
fwrite($SMSFILE, "To: 380974949515\nAlphabet: UCS2\nUDH: false");
fwrite($SMSFILE, "\n\n$ucs2text");
fclose($SMSFILE); */
//--------------------------------------------
}
else
{echo "Логин або пароль ввели невірно";
echo '<br><A href="index.php">
Спробувати ще!
</A>';}
?>
</body>
</html>