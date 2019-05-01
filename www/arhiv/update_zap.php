<?php
session_start();
$lg=$_SESSION['LG'];
$pas=$_SESSION['PAS'];

include("../function.php");

$id_zp=$_GET['id_zps'];
$n_sp=str_pad($_GET['n_spr'], 6, "0", STR_PAD_LEFT);
$ns=$_GET['nsp'];
$vl=$_GET['vyl'];
$bd=$_GET['bud'];
$kv=$_GET['kv'];
$prim=$_GET['prum'];
$nameobj=$_GET['nameobj'];
$vlasn=$_GET['vlasn'];
$skl_chast=$_GET['skl_chast'];
$kad_nom=$_GET['kad_nom'];
$plzem=str_replace(",",".",$_GET['plzem']);
$plzag=str_replace(",",".",$_GET['plzag']);
$pljit=str_replace(",",".",$_GET['pljit']);
$pldop=str_replace(",",".",$_GET['pldop']);
$dt_perv=date_bd($_GET['dt_perv']);
$vk_perv=addslashes($_GET['vk_perv']);
$numb_obl=$_GET['numb_obl'];
$dt_obl=date_bd($_GET['dt_obl']);
if(isset($_GET['dt_pot'])) $dt_pot=date_bd($_GET['dt_pot']); else $dt_pot='';
if(isset($_GET['vk_pot'])) $vk_pot=$_GET['vk_pot']; else $vk_pot='';

$db=mysql_connect("localhost",$lg,$pas);
if(!$db) echo "Не вiдбулося зєднання з базою даних";
  
 if(!@mysql_select_db(kpbti,$db))
  {
   echo("Не завантажена таблиця");
   exit(); 
   }

if($ns!="" and $vl!=""){
 
 $ath1=mysql_query("UPDATE arhiv SET NS='$ns',VL='$vl',BD='$bd',KV='$kv',PRIM='$prim',
	FIRST_DT_INV='$dt_perv',FIRST_VUK='$vk_perv',NUMB_OBL='$numb_obl',DT_OBL='$dt_obl',NAME='$nameobj',
	VLASN='$vlasn',PL_ZEM='$plzem',PL_ZAG='$plzag',PL_JIT='$pljit',PL_DOP='$pldop',SKL_CHAST='$skl_chast',
	KAD_NOM='$kad_nom',N_SPR='$n_sp'  
	WHERE ID='$id_zp' AND DL='1'");
	if(!$ath1){
	echo "Запис не скоригований";} 

if($dt_pot!='' and $vk_pot!=''){
 
mysql_query("UPDATE second_inv SET DT_INV='$dt_pot',ISP='$vk_pot' WHERE SPR='$id_zp' AND DL='1'");

$ryadov=mysql_affected_rows();

if($ryadov==0){
$ath2=mysql_query("INSERT INTO second_inv (SPR,DT_INV,ISP) VALUES('$id_zp','$dt_pot','$vk_pot');");	
}
}

header("location: arhiv.php?filter=arh_view&rejum=view&srt=NUMB_OBL");
}
else
{
if($ns=="") echo "Не заповнено поле Населений пункт<br>";
if($vl=="") echo "Не заповнено поле Вулиця<br>";
}

//header('Content-Type: text/html; charset=utf-8'); 

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