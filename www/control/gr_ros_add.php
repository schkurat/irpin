<?php
session_start();
$lg=$_SESSION['LG'];
$pas=$_SESSION['PAS'];
header('Content-Type: text/html; charset=utf-8');

$pr[1]=0;
$pr[2]=0;
$pr[3]=0;
$pr[4]=0;
$pr[5]=0;
$kl=$_GET['kl'];
if(isset($_GET['vukon1'])) {$vuk[1]=$_GET['vukon1'];
if(isset($_GET['pr1']) and $vuk[1]!='') $pr[1]=$_GET['pr1'];}
if(isset($_GET['vukon2'])) {$vuk[2]=$_GET['vukon2'];
if(isset($_GET['pr2']) and $vuk[2]!='') $pr[2]=$_GET['pr2'];}
if(isset($_GET['vukon3'])) {$vuk[3]=$_GET['vukon3'];
if(isset($_GET['pr3']) and $vuk[3]!='') $pr[3]=$_GET['pr3'];}
if(isset($_GET['vukon4'])) {$vuk[4]=$_GET['vukon4'];
if(isset($_GET['pr4']) and $vuk[4]!='') $pr[4]=$_GET['pr4'];}
if(isset($_GET['vukon5'])) {$vuk[5]=$_GET['vukon5'];
if(isset($_GET['pr5']) and $vuk[5]!='') $pr[5]=$_GET['pr5'];}
$s_pr=$pr[1]+$pr[2]+$pr[3]+$pr[4]+$pr[5];

if($s_pr==100){
$ath1=mysql_query("UPDATE zamovlennya SET VUK='$vuk[1]', VIDSOTOK='$pr[1]' WHERE zamovlennya.KEY='$kl'");
if(!$ath1){echo "Помилка оновлення БД";}

for($i=2;$i<=5;$i++){

if($vuk[$i]!=''){
$ath1=mysql_query("INSERT INTO dod_vuk (ID_ZAK,VUKD,VIDS) VALUES ('$kl','$vuk[$i]','$pr[$i]')");
if(!$ath1){echo "Помилка внесення до БД";}
}
}
//echo "Все вірно";
//echo $kl;
header("location: index.php?filter=ros_view");
}
else
{
echo "Помилково внесені дані! Перевірте ще раз!";
}
?>
