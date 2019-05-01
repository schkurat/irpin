<?php
session_start();
$lg=$_SESSION['LG'];
$pas=$_SESSION['PAS'];

$ns=$_POST['nsp'];
$vl=$_POST['vyl'];
$bd=$_POST['bud'];
if(isset($_POST['kv'])) $kv=$_POST['kv'];
else $kv="";
$por=addslashes($_POST['por']);
$prim=addslashes($_POST['prum']);
$pr=addslashes($_POST['priz']);
$im=addslashes($_POST['imya']);
$pb=addslashes($_POST['pbat']);

$inv=$_POST['inv'];

include("../function.php");
$dt=date_bd($_POST['dt']);

$db=mysql_connect("localhost",$lg,$pas);
if(!$db) echo "Не вiдбулося зєднання з базою даних";
  
 if(!@mysql_select_db(kpbti,$db))
  {
   echo("Не завантажена таблиця");
   exit(); 
   }

if($ns!="" and $vl!=""){
$npp='1';
$sql = "SELECT NPP FROM samovol WHERE DL='1' ORDER BY NPP DESC LIMIT 1"; 
 $atu=mysql_query($sql);
  while($aut=mysql_fetch_array($atu))
 {
	$npp=$aut["NPP"]+1;    
 }
 mysql_free_result($atu); 

$ath1=mysql_query("INSERT INTO samovol (NPP,DT,NS,VL,BD,KV,POR,PR,IM,PB,PRIM,IN_N)
		VALUES('$npp','$dt','$ns','$vl','$bd','$kv','$por','$pr','$im','$pb',
		'$prim','$inv');");
	if(!$ath1){
	echo "Запис не внесений до БД";} 
		
header("location: samovol.php?filter=new_zap_info");
}
else
{
header('Content-Type: text/html; charset=utf-8');
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