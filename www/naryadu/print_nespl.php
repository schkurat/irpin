<?php
session_start();
$lg = $_SESSION['LG'];
$pas = $_SESSION['PAS'];

include "../function.php";

$bdat = date_bd($_POST['date1']);
$edat = date_bd($_POST['date2']);
//$flg=$_POST['flag'];
if (!empty($_POST['rayon'])) {
    $rayon = intval($_POST['rayon']);
    if ($rayon > 0) {
        $ray = " AND zamovlennya.RN = " . $rayon;
    } else {
        $ray = '';
    }
} else {
    $ray = '';
}


$db = mysql_connect("localhost", $lg, $pas);
if (!$db) echo "Не вiдбулося зєднання з базою даних";

if (!@mysql_select_db(kpbti, $db)) {
    echo("Не завантажена таблиця");
    exit();
}

$p = '<b>Період: з  ' . german_date($bdat) . ' по ' . german_date($edat) . '</b>
	<table border="1" cellpadding="0" cellspacing="0"><tr>
	<th align="center"><font size="2">Замов лення</font></th>
	<th align="center"><font size="2">Дата прийому</font></th>
	<th align="center"><font size="2">Адреса</font></th>
	<th align="center"><font size="2">ПІБ (назва)</font></th>
	<th align="center"><font size="2">Вид робіт</font></th>
	<th align="center"><font size="2">Прийом замовлення</font></th>
	<th align="center"><font size="2">Дата готовності</font></th>
	<th align="center"><font size="2">Виконавець</font></th>
	<th align="center"><font size="2">Телефон</font></th>
	<th align="center"><font size="2">Сума аванс+доплата</font></th>
	<th align="center"><font size="2">Підпис</font></th>
	</tr>
	';

$num_rows = 0;
$sql1 = "SELECT zamovlennya.SZ,zamovlennya.NZ,zamovlennya.PR,zamovlennya.IM,zamovlennya.PB,zamovlennya.PS,
		nas_punktu.NSP,vulutsi.VUL,tup_nsp.TIP_NSP,tup_vul.TIP_VUL,zamovlennya.KEY,zamovlennya.TUP_ZAM,
		zamovlennya.BUD,zamovlennya.KVAR,dlya_oformlennya.document,zamovlennya.D_PR,zamovlennya.SUM_D,
		zamovlennya.EDRPOU,zamovlennya.IPN,zamovlennya.SVID,zamovlennya.SUM,
		zamovlennya.DATA_GOT,zamovlennya.PR_OS,zamovlennya.VUK,zamovlennya.TEL  
	FROM zamovlennya,nas_punktu,vulutsi,tup_nsp,tup_vul,dlya_oformlennya 
				WHERE
					zamovlennya.DL='1' AND zamovlennya.D_PR>='$bdat' AND zamovlennya.D_PR<='$edat' 
					" . $ray . "
					AND ((zamovlennya.DOKVUT='0000-00-00' AND zamovlennya.SUM!=0) 
					OR (zamovlennya.DODOP='0000-00-00' AND zamovlennya.SUM_D!=0))  
					AND nas_punktu.ID_NSP=zamovlennya.NS
					AND vulutsi.ID_VUL=zamovlennya.VL
					AND tup_nsp.ID_TIP_NSP=nas_punktu.ID_TIP_NSP
					AND tup_vul.ID_TIP_VUL=vulutsi.ID_TIP_VUL
					AND dlya_oformlennya.id_oform=zamovlennya.VUD_ROB
					ORDER BY SZ, NZ";
$atu1 = mysql_query($sql1);
while ($aut1 = mysql_fetch_array($atu1)) {
    if ($aut1["BUD"] != "") $bud = "буд. " . $aut1["BUD"]; else $bud = "";
    if ($aut1["KVAR"] != "") $kvar = "кв. " . $aut1["KVAR"]; else $kvar = "";

    $ser = $aut1['SZ'];
    $nom = $aut1['NZ'];
    $tup_zam = $aut1['TUP_ZAM'];

    $pr = $aut1["PR"];
    $im = $aut1["IM"];
    $pb = $aut1["PB"];
    $edrpou = $aut1["EDRPOU"];
    $ipn = $aut1["IPN"];
    $svid = $aut1["SVID"];
    $ns = $aut1["NSP"];
    $tns = $aut1["TIP_NSP"];
    $vl = $aut1["VUL"];
    $tvl = $aut1["TIP_VUL"];
    $vud_rob = $aut1["document"];

    $sql = "SELECT kasa.NZ FROM kasa WHERE kasa.DL='1' AND kasa.SZ='$ser' AND kasa.NZ='$nom'";
    $atu = mysql_query($sql);
    $aut = mysql_num_rows($atu);
    If ($aut == 0) {
        $zakaz = '';

        $zakaz = $ser . '/' . $nom;

        $adres = $rn . ' ' . $tns . ' ' . $ns . ' ' . $tvl . ' ' . $vl . ' ' . $bud . ' ' . $kvar;
        $fio = $pr . ' ' . $im . ' ' . $pb;
        $tel = $aut1["TEL"];
        $sum = $aut1["SUM"] + $aut1["SUM_D"];
        $vukon = $aut1["VUK"];
        if ($vukon == "") $vukon = "-";
        if ($tel == "") $tel = "-";
        if ($aut1["PS"] == '1') $pidpus = 'так';
        else $pidpus = 'ні';
//if($kod_zm!="") $kod_zm='-'.$kod_zm; 
        $p .= '<tr>
	<td align="center"><font size="2">' . $zakaz . '</font></td>
	<td><font size="2">' . german_date($aut1["D_PR"]) . '</td>
	<td><font size="2">' . $adres . '</td>
	<td align="center"><font size="2">' . $fio . '</font></td>
	<td align="center"><font size="2">' . $vud_rob . '</font></td>
	<td align="center"><font size="2">' . $aut1["PR_OS"] . '</font></td>
	<td align="center"><font size="2">' . german_date($aut1["DATA_GOT"]) . '</font></td>
	<td align="center"><font size="2">' . $vukon . '</font></td>
	<td align="center"><font size="2">' . $tel . '</font></td>
	<td align="center"><font size="2">' . $sum . '</font></td>
	<td align="center"><font size="2">' . $pidpus . '</font></td>
	</tr>';
        $num_rows++;
    }
    mysql_free_result($atu);
}
mysql_free_result($atu1);
$p .= '</table>';
echo $p;
echo '<br>Всього замовлень: ' . $num_rows;
if (mysql_close($db)) {
    // echo("Закриття бази даних");
} else {
    echo("Не можливо виконати закриття бази");
}
