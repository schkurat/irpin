<?php
session_start();
$lg=$_SESSION['LG'];
$pas=$_SESSION['PAS'];
header('Content-Type: text/html; charset=utf-8'); 
include_once "../function.php";

$db=mysql_connect("localhost",$lg,$pas);
if(!$db) echo "Не вiдбулося зєднання з базою даних";
  
 if(!@mysql_select_db(kpbti,$db))
  {
   echo("Не завантажена таблиця");
   exit(); 
   }
   
$sql = "SELECT zamovlennya.KEY FROM zamovlennya WHERE DL='1' AND VUK='' "; 
 $atu=mysql_query($sql);
  while($aut=mysql_fetch_array($atu))
  {
$vk="";  
$vuk="";
$idz=$aut["KEY"];
if(isset($_POST['a'.$idz])) $vuk=$_POST['a'.$idz];

$sql1 = "SELECT ROBS FROM robitnuku WHERE ID_ROB='$vuk'"; 
 $atu1=mysql_query($sql1);
  while($aut1=mysql_fetch_array($atu1))
  {		
$vk=$aut1['ROBS'];  
}
mysql_free_result($atu1);

$dt_vuh="";
if(isset($_POST['b'.$idz])) $dt_vuh=date_bd($_POST['b'.$idz]);
$skl="0";
if(isset($_POST['c'.$idz])) $skl="1";
$zv="0";
if(isset($_POST['zv'.$idz])) $zv="1";

$ath1=mysql_query("UPDATE zamovlennya SET VUK='$vk', DATA_VUH='$dt_vuh', SKL='$skl',ZVON='$zv' WHERE zamovlennya.KEY='$idz'");	
	
	if(!$ath1){
	echo "Замовлення не внесене до БД";} 
}
mysql_free_result($atu);

//Zakrutie bazu       
       if(mysql_close($db))
        {
        // echo("Закриття бази даних");
         }
         else
         {
          echo("Не можливо виконати закриття бази"); 
          }
header("location: index.php?filter=ros_view");
?>   
