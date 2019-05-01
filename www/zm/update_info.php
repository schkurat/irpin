<?php
session_start();
$lg=$_SESSION['LG'];
$pas=$_SESSION['PAS'];
//$n_zm=$_POST['nzam'];
$v_zm=$_POST['vud_zam'];
$idn=$_POST['kod'];
$id_vr=$_POST['vud_rob'];
//$pr=htmlspecialchars($_POST['priz'],ENT_QUOTES);
$pr=$_POST['priz'];
$im=$_POST['imya'];
$pb=$_POST['pobat'];
$prim=$_POST['prim'];
$dn=$_POST['dnar'];
$pasport=$_POST['pasport'];
$tl=$_POST['tel'];
$email=$_POST['email'];
//$rn=$_POST['rajon'];
$ns=$_POST['nsp'];
$vl=$_POST['vyl'];
$bd=$_POST['bud'];
$kv=$_POST['kvar'];
$sm=$_POST['sum'];
$d_vh=$_POST['datav'];
$dg=$_POST['datag'];
$kl=$_POST['kll'];

include("../function.php");

$db=mysql_connect("localhost",$lg,$pas);
if(!$db) echo "Не вiдбулося зєднання з базою даних";
  
 if(!@mysql_select_db(kpbti,$db))
  {
   echo("Не завантажена таблиця");
   exit(); 
   }   

 $dn=date_bd($dn);
 $d_vh=date_bd($d_vh);
 $dg=date_bd($dg);
 $d_pr=date("Y-m-d");

$ath1=mysql_query("UPDATE zamovlennya SET TUP_ZAM='$v_zm',VUD_ROB='$id_vr',IDN='$idn',
		PR='$pr',IM='$im',PB='$pb',PRIM='$prim',D_NAR='$dn',PASPORT='$pasport',TEL='$tl',EMAIL='$email',
		NS='$ns',VL='$vl',BUD='$bd',KVAR='$kv',SUM='$sm',DATA_VUH='$d_vh',
		DATA_GOT='$dg' WHERE zamovlennya.KEY='$kl'");
	
	
	if(!$ath1){
	echo "Замовлення не внесене до БД";} 

//Zakrutie bazu       
       if(mysql_close($db))
        {
        // echo("Закриття бази даних");
         }
         else
         {
          echo("Не можливо виконати закриття бази"); 
          }	
	
header("location: zamovlennya.php?filter=zm_view");
?>