<?php
session_start();
$lg=$_SESSION['LG'];
$pas=$_SESSION['PAS'];

header('Content-Type: text/html; charset=utf-8');

$vud=$_POST['vud'];
//if($vud==1){
$sz=$_POST['sz'];
$nz=$_POST['nz'];
/* $szu='';
$nzu=0;
}
else{
$sz=$_POST['sz'];
$nz=0;
$szu=$_POST['szu'];
$nzu=$_POST['nz'];
} */

$db=mysql_connect("localhost",$lg,$pas);
if(!$db) echo "Не вiдбулося зєднання з базою даних"; 
 if(!@mysql_select_db(kpbti,$db))
  {echo("Не завантажена таблиця");
   exit();}

$ath=mysql_query("SELECT  dlya_oformlennya.document,zamovlennya.BUD,zamovlennya.KVAR,
	nas_punktu.NSP,tup_nsp.TIP_NSP,vulutsi.VUL,tup_vul.TIP_VUL,zamovlennya.VUK,zamovlennya.KEY,
	zamovlennya.PR_OS,zamovlennya.TERM,zamovlennya.SKL 
	FROM zamovlennya,dlya_oformlennya, nas_punktu, vulutsi, tup_nsp, tup_vul
	WHERE 
		zamovlennya.SZ='$sz' AND zamovlennya.NZ='$nz'  
		AND zamovlennya.DL='1' 
		AND dlya_oformlennya.id_oform=zamovlennya.VUD_ROB 
		AND nas_punktu.ID_NSP=zamovlennya.NS
		AND vulutsi.ID_VUL=zamovlennya.VL
		AND tup_nsp.ID_TIP_NSP=nas_punktu.ID_TIP_NSP
		AND tup_vul.ID_TIP_VUL=vulutsi.ID_TIP_VUL;");
  if($ath)
  {
   while($aut=mysql_fetch_array($ath))
   {
   $tns=$aut['TIP_NSP'];
   $ns=$aut['NSP'];
   $tvl=$aut['TIP_VUL'];
   $vl=$aut['VUL'];
   $bd=$aut['BUD'];
   $kv=$aut['KVAR'];
   $vrob=$aut['document'];
   $vkon=$aut['VUK'];
   $pr_os=$aut['PR_OS'];
   $term=$aut['TERM'];
   $id_zm=$aut['KEY'];
   $skl=$aut['SKL'];
   }
mysql_free_result($ath);}

if($bd!="") $bud="буд. ".$bd; else $bud="";
if($kv!="") $kva="кв. ".$kv; else $kva="";

 echo $tns.':'.$ns.':'.$tvl.':'.$vl.':'.$bud.':'.$kva.':'.$vrob.':'.$vkon.':'.$pr_os.':'.$id_zm.':'.$term.':'.$skl;

 if(mysql_close($db))
{}
else
    {echo("Не можливо виконати закриття бази");}   

//header("location: nove_zamovlennya.php");		
?>