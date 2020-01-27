<?php
session_start();
$lg=$_SESSION['LG'];
$pas=$_SESSION['PAS'];
header('Content-Type: text/html; charset=utf-8');
$db=mysql_connect("localhost",$lg,$pas);
if(!$db) echo "Не вiдбулося зєднання з базою даних";

 if(!@mysql_select_db(kpbti,$db))
  {
   echo("Не завантажена таблиця");
   exit();
   }

$vk="";
$vuk="";
$kl=$_POST['kl'];
$vuk=$_POST['vukon'];
$skl="0";
if(isset($_POST['skl'])) $skl="1";
$zv="0";
if(isset($_POST['zvon'])) $zv="1";

$sql1 = "SELECT ROBS FROM robitnuku WHERE ID_ROB='$vuk'";
 $atu1=mysql_query($sql1);
  while($aut1=mysql_fetch_array($atu1))
  {
$vk=$aut1['ROBS'];
}
mysql_free_result($atu1);

$ath1=mysql_query("UPDATE zamovlennya SET VUK='$vk', SKL='$skl', ZVON='$zv' WHERE zamovlennya.KEY='$kl'");
	if(!$ath1){
	echo "Виконавця не змінено"; }

//Zakrutie bazu
       if(mysql_close($db))
        {
        // echo("Закриття бази даних");
         }
         else
         {
          echo("Не можливо виконати закриття бази");
          }
header("location: index.php?filter=kontrol_view");
?>
