<?php
include_once "../function.php";

$dt_vd = date("Y-m-d");
$for_client = (isset($_GET["fl"])) ? $_GET["fl"] : '';
if (isset($_GET["npr"])) $npr = date_bd($_GET["npr"]); else $npr = '';
if (isset($_GET["kpr"])) $kpr = date_bd($_GET["kpr"]); else $kpr = '';
$flag = (isset($_GET["flag"])) ? $_GET["flag"] : '';
$filter2 = "";
if ($flag == 'zm') {
    $s = (isset($_GET["n_zam"])) ? trim($_GET["n_zam"]) : '';
    $sz = mb_substr($s, 2, 6);
    $nz = mb_substr($s, 8, 2);
    if (strlen($s) == 10) {
        $filter2 = " AND zamovlennya.SZ='$sz' AND zamovlennya.nz='$nz' ";
    } else {
        $filter2 = "";
        echo " Невірний номер замовлення";
    }
} elseif ($flag == 'adres') {
    $s_rn = (isset($_GET["rajon"])) ? $_GET["rajon"] : '';
    $s_nsp = (isset($_GET["nsp"])) ? $_GET["nsp"] : '';
    $s_vl = (isset($_GET["vyl"])) ? $_GET["vyl"] : '';
    $s_bd = (isset($_GET["bud"])) ? $_GET["bud"] : '';
    $s_kv = (isset($_GET["kvar"])) ? $_GET["kvar"] : '';
    $filter2 = " AND zamovlennya.RN='$s_rn' AND zamovlennya.NS='$s_nsp' AND zamovlennya.VL='$s_vl' AND zamovlennya.BUD='$s_bd' AND zamovlennya.KVAR='$s_kv' ";
}

$vud_zam = $_GET["vud_zam"];
if ($npr != '' and $kpr != '') {
    if ($vud_zam == '3') {
        $filter = " AND zamovlennya.DATA_VD>='$npr' AND zamovlennya.DATA_VD<='$kpr' AND zamovlennya.VD='1'";
    } else {
        $filter = " AND zamovlennya.DATA_VD>='$npr' AND zamovlennya.DATA_VD<='$kpr' AND zamovlennya.TUP_ZAM='$vud_zam' AND zamovlennya.VD='1'";
    }
} elseif (!empty($filter2)) {
    $filter = "";
} else {
    $filter = " AND zamovlennya.DATA_VD='$dt_vd' AND zamovlennya.VD='1'";
}
if (!empty($for_client)) {
    $filter = " AND zamovlennya.PS='1' AND zamovlennya.VD='0'";
}

$frn = get_filter_for_rn($drn,'zamovlennya','RN');

$p = '<table align="center" class="zmview">
<tr bgcolor="#B5B5B5">
<th colspan="2">#</th>
<th>Замовлення</th>
<th>Вид робіт</th>
<th>ІДН</th>
<th>ПІБ</th>
<th>Прим.</th>
<th>Дата нар.</th>
<th>Адреса зам.</th>
<th>Сума допл.</th>
<th>Дата гот.</th>
</tr>';
$lich = 0;
$sql = "SELECT zamovlennya.SZ,zamovlennya.NZ,zamovlennya.TUP_ZAM,zamovlennya.PRIM,rayonu.ID_RAYONA,zamovlennya.VD,
	zamovlennya.DOKVUT,zamovlennya.IDN,zamovlennya.PR,zamovlennya.IM,zamovlennya.PB,zamovlennya.D_NAR,
	zamovlennya.BUD,zamovlennya.KVAR,zamovlennya.SUM_D,zamovlennya.DATA_GOT,zamovlennya.DOKVUT,dlya_oformlennya.document,
	nas_punktu.NSP,tup_nsp.TIP_NSP,vulutsi.VUL,tup_vul.TIP_VUL,zamovlennya.KEY,zamovlennya.SUM_KOR,zamovlennya.SUM  
	FROM zamovlennya, rayonu, nas_punktu, vulutsi, tup_nsp, tup_vul, dlya_oformlennya
	WHERE
		zamovlennya.DL='1' " . $filter . $filter2 . " AND (" . $frn . ") 
		AND dlya_oformlennya.id_oform=zamovlennya.VUD_ROB
		AND rayonu.ID_RAYONA=zamovlennya.RN
		AND nas_punktu.ID_NSP=zamovlennya.NS
		AND vulutsi.ID_VUL=zamovlennya.VL
		AND tup_nsp.ID_TIP_NSP=nas_punktu.ID_TIP_NSP
		AND tup_vul.ID_TIP_VUL=vulutsi.ID_TIP_VUL
		ORDER BY zamovlennya.KEY DESC";
//echo $sql;
$atu = mysql_query($sql);
while ($aut = mysql_fetch_array($atu)) {
    if ($aut["BUD"] != "") $bud = "буд." . $aut["BUD"]; else $bud = "";
    if ($aut["KVAR"] != "") $kvar = "кв." . $aut["KVAR"]; else $kvar = "";

    if ($aut["DOKVUT"] == "0000-00-00") {
        $prop = "dollar_s.png";
        $stat = "n";
    } else {
        $prop = "dollar_z.png";
        $stat = "a";
    }
    $zakaz = get_num_order($aut["ID_RAYONA"], $aut["SZ"], $aut["NZ"]);
    if ($aut["VD"] == '1') {
        $first_insert = '<a href="print_kvut_vudacha.php?kl=' . $aut["KEY"] . '&tz=' . $aut["TUP_ZAM"] . '"><img src="/images/print.png"></a>';
        $second_insert = '<a href="print_akt_vudacha.php?kl=' . $aut["KEY"] . '"><img src="/images/akt.png"></a>';
    } else {
        $first_insert = '<a href="index.php?filter=doplata_info&kl=' . $aut["KEY"] . '"><img src="/images/plus.png"></a>';
        $second_insert = '-';
    }

    $kl = $aut["KEY"];

    if($aut["SUM_D"] == 0){
        $sum_kor=$aut["SUM_KOR"];
        $sum=$aut["SUM"];
        $dokvut=$aut["DOKVUT"];
        if($dokvut=='0000-00-00') $sum=0;
        $taks=0;
        $nds=0;
        $sql2 = "SELECT taks.SUM,taks.SUM_OKR,taks.NDS FROM taks WHERE taks.IDZM='$kl' AND DL='1'";
        $atu2=mysql_query($sql2);
        while($aut2=mysql_fetch_array($atu2))
        {
            $taks=$aut2["SUM"]+$aut2["SUM_OKR"];
            $nds=$aut2["NDS"];
        }
        mysql_free_result($atu2);
        if($taks!=0){
            if($sum_kor!=0) $dopl=round($sum_kor,2);
            else $dopl=round(((($nds+100)*$taks)/100)-$sum,2);
        }
        else {$dopl='0';}
    }else{
        $dopl = $aut["SUM_D"];
    }
    $dopl = number_format($dopl,2);


    $p .= '<tr bgcolor="#FFFAF0">
<td align="center">' . $first_insert . '</td>
<td align="center">' . $second_insert . '</td>
	<td align="center">' . $zakaz . '</td>
      <td align="center">' . $aut["document"] . '</td>
	  <td align="center">' . $aut["IDN"] . '</td>
      <td align="center">' . $aut["PR"] . " " . $aut["IM"] . " " . $aut["PB"] . '</td>
	  <td align="center">' . $aut["PRIM"] . '</td>
	  <td align="center">' . german_date($aut["D_NAR"]) . '</td>
      <td align="center">' . $aut["TIP_NSP"] . $aut["NSP"] . " " . $aut["TIP_VUL"] . $aut["VUL"] . " " . $bud . " " . $kvar . '</td>
	  <td align="center" id="zal"><a href="index.php?filter=zmina_dop_info&kl=' . $aut["KEY"] . '">' . $dopl . '</a></td>
	  <td align="center">' . german_date($aut["DATA_GOT"]) . '</td>
      </tr>';
    $lich++;
}
mysql_free_result($atu);
$p .= '</table>';

if ($lich > 0) echo $p;
else echo '<table class="zmview" align="center"><tr><th style="font-size: 35px;"><b>Замовлень не знайдено.</b></th></tr></table>';
