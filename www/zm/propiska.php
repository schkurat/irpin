<?php
session_start();
$lg=$_SESSION['LG'];
$pas=$_SESSION['PAS'];
header('Content-Type: text/html; charset=utf-8');

include "../function.php";
$rn=$_POST['rn'];
$np=$_POST['np'];
$vl=$_POST['vlu'];

$db=mysql_connect("localhost",$lg,$pas);
if(!$db) echo "Не вiдбулося зєднання з базою даних"; 
 if(!@mysql_select_db(kpbti,$db))
  {echo("Не завантажена таблиця");
   exit();}

  $ath=mysql_query("SELECT rayonu.RAYON,nas_punktu.NSP, tup_nsp.TIP_NSP,vulutsi.VUL,tup_vul.TIP_VUL
			      FROM rayonu, nas_punktu, vulutsi, tup_nsp, tup_vul
				WHERE 
					rayonu.ID_RAYONA='$rn'
					AND nas_punktu.ID_NSP='$np'
					AND vulutsi.ID_VUL='$vl'
					AND rayonu.ID_RAYONA=nas_punktu.ID_RN AND rayonu.ID_RAYONA=vulutsi.ID_RN
					AND nas_punktu.ID_NSP=vulutsi.ID_NSP
					AND tup_nsp.ID_TIP_NSP=nas_punktu.ID_TIP_NSP
					AND tup_vul.ID_TIP_VUL=vulutsi.ID_TIP_VUL;");
  if($ath)
  {
   while($aut=mysql_fetch_array($ath))
   {
   $r=$aut['RAYON'];
   $n=$aut['NSP'];
   $tn=$aut['TIP_NSP'];
   $v=($aut['VUL']);
   $tv=($aut['TIP_VUL']);
   }
mysql_free_result($ath);}

echo $r.':'.$n.':'.$tn.':'.$v.':'.$tv;

 if(mysql_close($db))
{}
else
    {echo("Не можливо виконати закриття бази");}   

//header("location: nove_zamovlennya.php");		
?>