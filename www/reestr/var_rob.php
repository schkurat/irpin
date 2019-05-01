<?php
session_start();
$lg=$_SESSION['LG'];
$pas=$_SESSION['PAS'];
header('Content-Type: text/html; charset=utf-8');

include "../function.php";
$cena="";
$mito="";
$v_rob=$_POST['vr'];
$ter=$_POST['ter'];
$terrg=$_POST['terrg'];
$db=mysql_connect("localhost",$lg,$pas);
if(!$db) echo "Не вiдбулося зєднання з базою даних"; 
 if(!@mysql_select_db(kpbti,$db))
  {echo("Не завантажена таблиця");
   exit();}
if($v_rob!=""){
  $ath=mysql_query("SELECT VART FROM dlya_oformlennya WHERE id_oform='$v_rob';");
  if($ath)
  {
   while($aut=mysql_fetch_array($ath))
   {
   $cena=$aut['VART'];
   }
mysql_free_result($ath);}

$dat=date("Y-m-d",mktime(0,0,0,date("m"),date("d")+1,date("Y")));
if($v_rob==21 and $terrg=='1') {$mito=160.00; $dat_g=work_date($dat,5);}
if($v_rob==22) {$mito=40.00; $dat_g=work_date($dat,0);}
if($v_rob==23) {$mito=60.00; $dat_g=work_date($dat,0);}

/* if($v_rob==26) {
if($ter==1) $dat_g=work_date($dat,3);
else $dat_g=work_date($dat,1);
}
else
$dat_g=''; */
if($ter=='2') {
if($v_rob<21) $cena=$cena*2;
if($v_rob==21 and $terrg=='1') {$mito=160.00; $dat_g=work_date($dat,5);}
if($v_rob==21 and $terrg=='2') {$mito=640.00; $dat_g=work_date($dat,2);}
if($v_rob==21 and $terrg=='3') {$mito=1280.00; $dat_g=work_date($dat,1);}
if($v_rob==21 and $terrg=='4') {$mito=3200.00; $dat_g=work_date($dat,0);}
if($v_rob==22) {$mito=40.00; $dat_g=work_date($dat,0);}
if($v_rob==23) {$mito=60.00; $dat_g=work_date($dat,0);}
}
}
echo $cena.':'.$dat_g.':'.$mito;


 if(mysql_close($db))
{}
else
    {echo("Не можливо виконати закриття бази");}   
?>