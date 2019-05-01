<?php
session_start();
$lg=$_SESSION['LG'];
$pas=$_SESSION['PAS'];
header('Content-Type: text/html; charset=utf-8');

include "../function.php";
$db=mysql_connect("localhost",$lg,$pas);
if(!$db) echo "Не вiдбулося зєднання з базою даних"; 
 if(!@mysql_select_db(kpbti,$db))
  {echo("Не завантажена таблиця");
   exit();}
   
$vud=$_POST['vud'];
$ter=$_POST['ter'];
$terrg=$_POST['terrg'];
$vr=$_POST['vr'];
$dat=date("Y-m-d",mktime(0,0,0,date("m"),date("d")+1,date("Y")));
if($ter=='2'){
if($vud=='1'){
if($vr==26) $dat_g=work_date($dat,1);
else $dat_g=work_date($dat,3);
if($vr==21 and $terrg=='1') $dat_g=work_date($dat,5);
if($vr==21 and $terrg=='2') $dat_g=work_date($dat,2);
if($vr==21 and $terrg=='3') $dat_g=work_date($dat,1);
if($vr==21 and $terrg=='4') $dat_g=work_date($dat,0);
}
else{
if($vr==26) $dat_g=work_date($dat,1);
else $dat_g=work_date($dat,10);
if($vr==21 and $terrg=='1') $dat_g=work_date($dat,5);
if($vr==21 and $terrg=='2') $dat_g=work_date($dat,2);
if($vr==21 and $terrg=='3') $dat_g=work_date($dat,1);
if($vr==21 and $terrg=='4') $dat_g=work_date($dat,0);
}
}
else{
$dat_g=mis_term($dat,1);
if($vr==21 and $terrg=='1') $dat_g=work_date($dat,5);
if($vr==21 and $terrg=='2') $dat_g=work_date($dat,2);
if($vr==21 and $terrg=='3') $dat_g=work_date($dat,1);
if($vr==21 and $terrg=='4') $dat_g=work_date($dat,0);
}

echo $dat_g;
 
if(mysql_close($db))
{}
else
{echo("Не можливо виконати закриття бази");}   
?>