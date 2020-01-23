<?php
session_start();
$lg=$_SESSION['LG'];
$pas=$_SESSION['PAS'];
header('Content-Type: text/html; charset=utf-8');
//$kodp=$_SESSION['KODP'];

include "../function.php";

$bdat=date_bd($_POST['date1']);
$edat=date_bd($_POST['date2']);
$flg=$_POST['flag'];

$db=mysql_connect("localhost",$lg,$pas);
if(!$db) echo "Не вiдбулося зєднання з базою даних";

 if(!@mysql_select_db(kpbti,$db))
  {
   echo("Не завантажена таблиця");
   exit();
   }

$p='<b>Період: з  '.german_date($bdat).' по '.german_date($edat).'</b>
	<table border="1" cellpadding="0" cellspacing="0"><tr>
	<th align="center"><font size="2">Замов лення</font></th>
	<th align="center"><font size="2">Адреса</font></th>
	<th align="center"><font size="2">Вид робіт</font></th>
	<th align="center"><font size="2">ПІБ (назва)</font></th>
	<th align="center"><font size="2">Дата прийому</font></th>
	<th align="center"><font size="2">Дата готовності</font></th>
	<!--<th align="center"><font size="2">Дата таксування</font></th>-->
	<th align="center"><font size="2">Виконавець</font></th>
	<th align="center"><font size="2">Прийом замовлення</font></th>
	<th align="center"><font size="2">Телефон</font></th>
	<th align="center"><font size="2">Дзвінок</font></th>
	<th align="center"><font size="2">Підпис</font></th>
	</tr>
	';

if($flg=="got"){
$kr_fl="AND zamovlennya.DATA_GOT>='$bdat' AND zamovlennya.DATA_GOT<='$edat'";
}
if($flg=="nevuk"){
$kr_fl="AND zamovlennya.DATA_GOT>='$bdat' AND zamovlennya.DATA_GOT<='$edat' AND zamovlennya.PS='0' AND zamovlennya.VD='0'";
}
if($flg=="nevuk_vuk"){
$vukonavets=$_POST['isp'];
$kr_fl="AND zamovlennya.DATA_GOT>='$bdat' AND zamovlennya.DATA_GOT<='$edat' AND zamovlennya.PS='0' AND zamovlennya.VD='0'
 AND zamovlennya.VUK='$vukonavets'";
}
if($flg=="pr_period"){
$kr_fl="AND zamovlennya.D_PR>='$bdat' AND zamovlennya.D_PR<='$edat'";
}
if($flg=="vk_date_g"){
$vukonavets=$_POST['isp'];
$kr_fl="AND zamovlennya.DATA_GOT>='$bdat' AND zamovlennya.DATA_GOT<='$edat' AND zamovlennya.VUK='$vukonavets'";
}

$sql1="SELECT zamovlennya.SZ,zamovlennya.NZ,zamovlennya.TUP_ZAM,zamovlennya.ZVON,
		zamovlennya.PR,zamovlennya.IM,zamovlennya.PB,zamovlennya.PS,nas_punktu.NSP,
		vulutsi.VUL,tup_nsp.TIP_NSP,tup_vul.TIP_VUL,zamovlennya.KEY,zamovlennya.BUD,zamovlennya.KVAR,
		dlya_oformlennya.document,zamovlennya.D_PR,zamovlennya.DATA_GOT,zamovlennya.PR_OS,zamovlennya.VUK,
		zamovlennya.TEL
		FROM zamovlennya, nas_punktu, vulutsi, tup_nsp, tup_vul, dlya_oformlennya
		WHERE
		zamovlennya.DL='1'
		".$kr_fl."
		AND nas_punktu.ID_NSP=zamovlennya.NS
		AND vulutsi.ID_VUL=zamovlennya.VL
		AND tup_nsp.ID_TIP_NSP=nas_punktu.ID_TIP_NSP
		AND tup_vul.ID_TIP_VUL=vulutsi.ID_TIP_VUL
		AND dlya_oformlennya.id_oform=zamovlennya.VUD_ROB
		ORDER BY zamovlennya.KEY";

 $atu1=mysql_query($sql1);
  while($aut1=mysql_fetch_array($atu1))
 {
if($aut1["BUD"]!="") $bud="буд.".$aut1["BUD"]; else $bud="";
if($aut1["KVAR"]!="") $kvar="кв.".$aut1["KVAR"]; else $kvar="";

$zakaz=$aut1["SZ"].'/'.$aut1["NZ"];

	$pr=$aut1["PR"];
	$im=$aut1["IM"];
    $pb=$aut1["PB"];
	$ns=$aut1["NSP"];
	$tns=$aut1["TIP_NSP"];
	$vl=$aut1["VUL"];
	$tvl=$aut1["TIP_VUL"];
	$vud_rob=$aut1["document"];
	if($aut1["ZVON"]=='1') $zv='так';
	else $zv='ні';

$adres=$tns.' '.$ns.' '.$tvl.' '.$vl.' '.$bud.' '.$kvar;
$fio=$pr.' '.$im.' '.$pb;
$tel=$aut1["TEL"];
$vukon=$aut1["VUK"];
if($vukon=="") $vukon="-";
if($tel=="") $tel="-";
if($aut1["PS"]=='1') $pidpus='так';
else $pidpus='ні';
	$p.='<tr>
	<td align="center"><font size="2">'.$zakaz.'</font></td>
	<td><font size="2">'.$adres.'</td>
	<td align="center"><font size="2">'.$vud_rob.'</font></td>
	<td align="center"><font size="2">'.$fio.'</font></td>
	<td align="center"><font size="2">'.german_date($aut1["D_PR"]).'</font></td>
	<td align="center"><font size="2">'.german_date($aut1["DATA_GOT"]).'</font></td>
	<!--<td align="center"><font size="2">'.$d_taks.'</font></td>-->
	<td align="center"><font size="2">'.$vukon.'</font></td>
	<td align="center"><font size="2">'.$aut1["PR_OS"].'</font></td>
	<td align="center"><font size="2">'.$tel.'</font></td>
	<td align="center"><font size="2">'.$zv.'</font></td>
	<td align="center"><font size="2">'.$pidpus.'</font></td>
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
