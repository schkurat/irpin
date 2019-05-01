<?php
session_start();
$lg=$_SESSION['LG'];
$pas=$_SESSION['PAS'];

include("../function.php");

$id_zp=$_GET['id_zps'];
$npp=$_GET['npp'];
$ns=$_GET['nsp'];
$vl=$_GET['vyl'];
$bd=$_GET['bud'];
$kv=$_GET['kv'];
$dt=date_bd($_GET['dt']);
$inv=$_GET['inv'];

$por=addslashes($_GET['por']);
$prim=addslashes($_GET['prum']);
$pr=addslashes($_GET['priz']);
$im=addslashes($_GET['imya']);
$pb=addslashes($_GET['pbat']);

$db=mysql_connect("localhost",$lg,$pas);
if(!$db) echo "Не вiдбулося зєднання з базою даних";
  
 if(!@mysql_select_db(kpbti,$db))
  {
   echo("Не завантажена таблиця");
   exit(); 
   }

if($ns!="" and $vl!=""){
 
 $ath1=mysql_query("UPDATE samovol SET DT='$dt',NS='$ns',VL='$vl',
	BD='$bd',KV='$kv',POR='$por',PR='$pr',IM='$im',PB='$pb',PRIM='$prim',IN_N='$inv' 
	WHERE ID='$id_zp' AND DL='1'");
	if(!$ath1){
	echo "Запис не скоригований";} 
	
header("location: samovol.php?filter=samovol_view&rejum=view&srt=NPP");
}
else
{
if($ns=="") echo "Не заповнено поле Населений пункт<br>";
if($vl=="") echo "Не заповнено поле Вулиця<br>";
}

//Zakrutie bazu       
       if(mysql_close($db))
        {
        // echo("Закриття бази даних");
         }
         else
         {
          echo("Не можливо виконати закриття бази"); 
          }
?>