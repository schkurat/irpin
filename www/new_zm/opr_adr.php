<?php
session_start();
$lg=$_SESSION['LG'];
$pas=$_SESSION['PAS'];
$kodp=$_SESSION['KODP'];
header('Content-Type: text/html; charset=utf-8');

if($kodp==9) $flag="zamovlennya.RN=8 AND zamovlennya.NS=48";
else $flag="zamovlennya.RN=".$kodp;
//include "function.php";
$sz=$_POST['sz'];
$nz=$_POST['nz'];
//echo $sz;
$db=mysql_connect("localhost",$lg,$pas);
if(!$db) echo "Не вiдбулося зєднання з базою даних"; 
 if(!@mysql_select_db(kpbti,$db))
  {echo("Не завантажена таблиця");
   exit();}

$ath=mysql_query("SELECT  dlya_oformlennya.document,zamovlennya.BUD,zamovlennya.KVAR,rayonu.RAYON,nas_punktu.NSP, 
								tup_nsp.TIP_NSP,vulutsi.VUL,tup_vul.TIP_VUL,zamovlennya.VUK, robitnuku.BRUGADA,zamovlennya.KEY
			 FROM zamovlennya,dlya_oformlennya, rayonu, nas_punktu, vulutsi, tup_nsp, tup_vul, robitnuku
				WHERE 
					".$flag." AND
					zamovlennya.SZ='$sz' AND zamovlennya.NZ='$nz' AND zamovlennya.DL='1' 
					AND dlya_oformlennya.id_oform=VUD_ROB AND VUD_ROB!=19
					AND zamovlennya.VUK=robitnuku.ROBS AND robitnuku.DL='1' 
					AND rayonu.ID_RAYONA=RN
					AND nas_punktu.ID_NSP=NS
					AND vulutsi.ID_VUL=VL
					AND tup_nsp.ID_TIP_NSP=nas_punktu.ID_TIP_NSP
					AND tup_vul.ID_TIP_VUL=vulutsi.ID_TIP_VUL;");
  if($ath)
  {
   while($aut=mysql_fetch_array($ath))
   {
   $rn=$aut['RAYON'];
   $tns=$aut['TIP_NSP'];
   $ns=$aut['NSP'];
   $tvl=$aut['TIP_VUL'];
   $vl=$aut['VUL'];
   $bd=$aut['BUD'];
   $kv=$aut['KVAR'];
   $vrob=$aut['document'];
   $vkon=$aut['VUK'];
   $brug=$aut['BRUGADA'];
   $id_zm=$aut['KEY'];
   }
mysql_free_result($ath);}

if($bd!="") $bud="буд. ".$bd; else $bud="";
if($kv!="") $kva="кв. ".$kv; else $kva="";

 echo $rn.':'.$tns.':'.$ns.':'.$tvl.':'.$vl.':'.$bud.':'.$kva.':'.$vrob.':'.$vkon.':'.$brug.':'.$id_zm;

 if(mysql_close($db))
{}
else
    {echo("Не можливо виконати закриття бази");}   

//header("location: nove_index.php");		
?>