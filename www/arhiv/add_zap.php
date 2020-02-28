<?php
session_start();
//var_dump($_POST);
$lg=$_SESSION['LG'];
$pas=$_SESSION['PAS'];
include("../function.php");
$id = $_POST['id'];
$inv_n=$_POST['inv_number'];
$ns=$_POST['nsp'];
$vl=$_POST['vyl'];
$bd=$_POST['bud'];
if(isset($_POST['kv'])) $kv=$_POST['kv'];
else $kv="";
$prim=$_POST['prum'];
$pr_dt="";
$nameobj=$_POST['nameobj'];
$vlasn=$_POST['vlasn'];
$skl_chast=$_POST['skl_chast'];
$kad_nom=$_POST['kad_nom'];
$plzem=str_replace(",",".",$_POST['plzem']);
$plzag=str_replace(",",".",$_POST['plzag']);
$pljit=str_replace(",",".",$_POST['pljit']);
$pldop=str_replace(",",".",$_POST['pldop']);
$dt_perv=date_bd($_POST['dt_perv']);
$vk_perv=$_POST['vk_perv'];
$numb_obl=$_POST['numb_obl'];
$dt_obl=date_bd($_POST['dt_obl']);


if($kv!="") $flag=" AND KV='".$kv."'";
else $flag="";
$db=mysql_connect("localhost",$lg,$pas);
if(!$db) echo "Не вiдбулося зєднання з базою даних";
  
 if(!@mysql_select_db(kpbti,$db))
  {
   echo("Не завантажена таблиця");
   exit(); 
   }

/*$sql = "SELECT ID FROM arhiv WHERE DL='1' AND ((NS='".$ns."' AND VL='".$vl."' AND BD='".$bd."'".$flag.") OR (N_SPR='".$inv_n."'))";
$atu=mysql_query($sql);
$num_rows = mysql_num_rows($atu);
mysql_free_result($atu);
if($num_rows==0){*/

//if($ns!="" and $vl!=""){
/* $n_spr='1';
$sql = "SELECT N_SPR FROM arhiv WHERE DL='1' ORDER BY N_SPR DESC LIMIT 1"; 
 $atu=mysql_query($sql);
  while($aut=mysql_fetch_array($atu))
 {
	$n_spr=$aut["N_SPR"]+1;    
 }
 mysql_free_result($atu);  */

/*$ath1=mysql_query("INSERT INTO arhiv (NS,VL,BD,KV,PRIM,N_SPR,FIRST_DT_INV,FIRST_VUK,
 NUMB_OBL,DT_OBL,NAME,VLASN,PL_ZEM,PL_ZAG,PL_JIT,PL_DOP,SKL_CHAST,KAD_NOM)
	VALUES('$ns','$vl','$bd','$kv','$prim','$inv_n','$dt_perv','$vk_perv','$numb_obl','$dt_obl',
	'$nameobj','$vlasn','$plzem','$plzag','$pljit','$pldop','$skl_chast','$kad_nom');");*/
$sql = "UPDATE arhiv SET 
PRIM = '$prim',N_SPR = '$inv_n',FIRST_DT_INV = '$dt_perv',FIRST_VUK = '$vk_perv',NUMB_OBL = '$numb_obl', DT_OBL = '$dt_obl',NAME = '$nameobj',
VLASN = '$vlasn',PL_ZEM = '$plzem',PL_ZAG = '$plzag',PL_JIT = '$pljit', PL_DOP = '$pldop', SKL_CHAST = '$skl_chast', KAD_NOM = '$kad_nom' 
WHERE id = $id";
//echo $sql;
//exit();
$ath1=mysql_query($sql);

	if(!$ath1){
	echo "Запис не внесений до БД";} 

	echo "<br>";
	echo mysql_affected_rows();
	echo "<br>";
	echo "Номер помилки ".mysql_errno();
	echo "<br>";
	echo "Пормилка ".mysql_error();

	$nr = mysql_errno();
	if ($nr == 0) header("location: arhiv.php?filter=arh_view&rejum=view&srt=N_SPR");
/*}
else
{
header('Content-Type: text/html; charset=utf-8');
if($ns=="") echo "Не заповнено поле Населений пункт<br>";
if($vl=="") echo "Не заповнено поле Вулиця<br>";
}*/
//}
//else 
//echo "Справа вже існує в базі!";

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