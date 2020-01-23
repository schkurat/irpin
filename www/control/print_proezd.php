<?php
session_start();
$lg=$_SESSION['LG'];
$pas=$_SESSION['PAS'];
header('Content-Type: text/html; charset=utf-8');
//$kodp=$_SESSION['KODP'];

include "../function.php";

$bdat=date_bd($_POST['date1']);
$edat=date_bd($_POST['date2']);
$temp_vuk='';

$db=mysql_connect("localhost",$lg,$pas);
if(!$db) echo "Не вiдбулося зєднання з базою даних";

 if(!@mysql_select_db(kpbti,$db))
  {
   echo("Не завантажена таблиця");
   exit();
   }
$p='<table border="1" cellpadding="0" cellspacing="0">';

$sql1="SELECT zamovlennya.SZ,zamovlennya.NZ,zamovlennya.TUP_ZAM,
		nas_punktu.NSP,vulutsi.VUL,tup_nsp.TIP_NSP,tup_vul.TIP_VUL,zamovlennya.KEY,
		zamovlennya.BUD,zamovlennya.KVAR,zamovlennya.D_PR,zamovlennya.DATA_GOT,zamovlennya.VUK
	FROM zamovlennya,nas_punktu,vulutsi,tup_nsp,tup_vul
	WHERE
		zamovlennya.DL='1' AND zamovlennya.DATA_PS>='$bdat' AND zamovlennya.DATA_PS<='$edat'
		AND zamovlennya.VUK!='' AND zamovlennya.VUK!='Бюро'
		AND nas_punktu.ID_NSP=zamovlennya.NS
		AND vulutsi.ID_VUL=zamovlennya.VL
		AND tup_nsp.ID_TIP_NSP=nas_punktu.ID_TIP_NSP
		AND tup_vul.ID_TIP_VUL=vulutsi.ID_TIP_VUL
	ORDER BY zamovlennya.VUK,zamovlennya.SZ,zamovlennya.NZ";

 $atu1=mysql_query($sql1);
  while($aut1=mysql_fetch_array($atu1))
 {
if($aut1["BUD"]!="") $bud="буд. ".$aut1["BUD"]; else $bud="";
if($aut1["KVAR"]!="") $kvar="кв. ".$aut1["KVAR"]; else $kvar="";

$ser=$aut1['SZ'];
$nom=$aut1['NZ'];
$tup_zam=$aut1['TUP_ZAM'];

$zakaz=$ser.'/'.$nom;

	$ns=$aut1["NSP"];
	$tns=$aut1["TIP_NSP"];
	$vl=$aut1["VUL"];
	$tvl=$aut1["TIP_VUL"];

$adres=$tns.' '.$ns.' '.$tvl.' '.$vl.' '.$bud.' '.$kvar;
$vukon=$aut1["VUK"];
if($temp_vuk!=$vukon){
if($temp_vuk!='') $p.='<tr><td colspan="4"><font size="3">&nbsp</font></td></tr>';
$temp_vuk=$vukon;

$p.='<tr><td colspan="4"><font size="3"><b>'.$temp_vuk.'
період: з  '.german_date($bdat).' по '.german_date($edat).'</b></font></td></tr>
<tr>
	<th align="center"><font size="2">Замов лення</font></th>
	<th align="center"><font size="2">Адреса</font></th>
	<th align="center"><font size="2">Дата прийому</font></th>
	<th align="center"><font size="2">Дата готовності</font></th>
	</tr>';
}


	$p.='<tr>
	<td align="center"><font size="1">'.$zakaz.'</font></td>
	<td><font size="1">'.$adres.'</td>
	<td align="center"><font size="1">'.german_date($aut1["D_PR"]).'</font></td>
	<td align="center"><font size="1">'.german_date($aut1["DATA_GOT"]).'</font></td>
	</tr>';

 }
 mysql_free_result($atu1);
 $p.='</table>';
 echo $p;
if(mysql_close($db))
        {
        // echo("Закриття бази даних");
         }
         else
         {
          echo("Не можливо виконати закриття бази");
          }
?>
