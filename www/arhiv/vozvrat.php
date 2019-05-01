<?php
session_start();
$lg=$_SESSION['LG'];
$pas=$_SESSION['PAS'];

include("../function.php");

$id_zak=$_GET['id_zak'];
$serial=$_GET['serial'];
$numb=$_GET['numb'];

$id_zp=$_GET['id_arh'];
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
 if($id_zp!=0){
    $ath1=mysql_query("UPDATE arhiv SET SERIAL='$serial',NUM='$numb',NS='$ns',VL='$vl',BD='$bd',KV='$kv',PRIM='$prim',
           FIRST_DT_INV='$dt_perv',FIRST_VUK='$vk_perv',NUMB_OBL='$numb_obl',DT_OBL='$dt_obl',NAME='$nameobj',
           VLASN='$vlasn',PL_ZEM='$plzem',PL_ZAG='$plzag',PL_JIT='$pljit',PL_DOP='$pldop',SKL_CHAST='$skl_chast',
           KAD_NOM='$kad_nom',N_SPR='$n_sp'  
           WHERE ID='$id_zp' AND DL='1'");
           if(!$ath1){
           echo "Запис не скоригований";} 
 }
 else{
     $ath1=mysql_query("INSERT INTO arhiv (SERIAL,NUM,N_SPR,NS,VL,BD,KV,PRIM,FIRST_DT_INV,FIRST_VUK,NUMB_OBL,"
             . "DT_OBL,NAME,VLASN,PL_ZEM,PL_ZAG,PL_JIT,PL_DOP,SKL_CHAST,KAD_NOM) VALUES('$serial','$numb','$n_sp',"
             . "'$ns','$vl','$bd','$kv','$prim','$dt_perv','$vk_perv','$numb_obl','$dt_obl','$nameobj','$vlasn','$plzem',"
             . "'$plzag','$pljit','$pldop','$skl_chast','$kad_nom');");
 }
if($dt_pot!='' and $vk_pot!=''){
 
mysql_query("UPDATE second_inv SET DT_INV='$dt_pot',ISP='$vk_pot' WHERE SPR='$id_zp' AND DL='1'");

$ryadov=mysql_affected_rows();

if($ryadov==0){
$ath2=mysql_query("INSERT INTO second_inv (SPR,DT_INV,ISP) VALUES('$id_zp','$dt_pot','$vk_pot');");	
}
}
mysql_query("UPDATE arhiv_zakaz SET DATA_POVER=NOW() WHERE arhiv_zakaz.KEY='$id_zak'");

header("location: arhiv.php?filter=vozvrat_view");
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