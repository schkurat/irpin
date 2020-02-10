<?php
session_start();
$lg = $_SESSION['LG'];
$pas = $_SESSION['PAS'];
//$kodp=$_SESSION['KODP'];

include "../function.php";

$bdat = date_bd($_POST['date1']);
$edat = date_bd($_POST['date2']);
$flg = $_POST['flag'];

$db = mysql_connect("localhost", $lg, $pas);
if (!$db) echo "Не вiдбулося зєднання з базою даних";

if (!@mysql_select_db(kpbti, $db)) {
    echo("Не завантажена таблиця");
    exit();
}
?>
<html>
    <head>
        <title>
            Автоматизована система інвентаризації об'єктів нерухомості
        </title>
        <link rel="stylesheet" type="text/css" href="../my.css"/>
    </head>
    <body>
<?php
$p = '<b>Період: з  ' . german_date($bdat) . ' по ' . german_date($edat) . '</b>
	<table class="statistic"><tr>
	<th align="center">Замов лення</th>
	<th align="center">Адреса</th>
	<th align="center">Вид робіт</th>
	<th align="center">ПІБ (назва)</th>
	<th align="center">Телефон</th>
	<th align="center">Дата прийому</th>
	<th align="center">Прийом замовлення</th>
	<th align="center">Дата готовності</th>
	<th align="center">Дзвінок</th>
	<th align="center">Сума авансу</th>
	<th align="center">Дата авансу</th>
	<th align="center">Дата виходу</th>
	<th align="center">Сума доплати</th>
	<th align="center">Дата доплати</th>
	<th align="center">Таксування</th>
	<th align="center">Сплачено</th>
	<th align="center">Виконавець</th>
	<th align="center">Дата виконання</th>
	<th align="center">Видача</th>
	</tr>
	';

if ($flg == "got") {
    $kr_fl = "AND zamovlennya.DATA_GOT>='$bdat' AND zamovlennya.DATA_GOT<='$edat'";
}
if ($flg == "nevuk") {
    $kr_fl = "AND zamovlennya.DATA_GOT>='$bdat' AND zamovlennya.DATA_GOT<='$edat' AND zamovlennya.PS='0' AND zamovlennya.VD='0'";
}
if ($flg == "nevuk_vuk") {
    $vukonavets = $_POST['isp'];
    $kr_fl = "AND zamovlennya.DATA_GOT>='$bdat' AND zamovlennya.DATA_GOT<='$edat' AND zamovlennya.PS='0' AND zamovlennya.VD='0'
 AND zamovlennya.VUK='$vukonavets'";
}
if ($flg == "pr_period") {
    $kr_fl = "AND zamovlennya.D_PR>='$bdat' AND zamovlennya.D_PR<='$edat'";
}
if ($flg == "vk_date_g") {
    $vukonavets = $_POST['isp'];
    $kr_fl = "AND zamovlennya.DATA_GOT>='$bdat' AND zamovlennya.DATA_GOT<='$edat' AND zamovlennya.VUK='$vukonavets'";
}

$sql1 = "SELECT zamovlennya.SZ,zamovlennya.NZ,zamovlennya.TUP_ZAM,zamovlennya.ZVON,zamovlennya.DOKVUT,zamovlennya.DODOP,zamovlennya.SUM,zamovlennya.DATA_VUH,zamovlennya.SUM_D,zamovlennya.DATA_PS,zamovlennya.VD,
		zamovlennya.PR,zamovlennya.IM,zamovlennya.PB,zamovlennya.PS,nas_punktu.NSP,rayonu.*,
		vulutsi.VUL,tup_nsp.TIP_NSP,tup_vul.TIP_VUL,zamovlennya.KEY,zamovlennya.BUD,zamovlennya.KVAR,
		dlya_oformlennya.document,zamovlennya.D_PR,zamovlennya.DATA_GOT,zamovlennya.PR_OS,zamovlennya.VUK,
		zamovlennya.TEL
		FROM zamovlennya,rayonu, nas_punktu, vulutsi, tup_nsp, tup_vul, dlya_oformlennya
		WHERE
		zamovlennya.DL='1'  
		" . $kr_fl . " 
		AND rayonu.ID_RAYONA=zamovlennya.RN
		AND nas_punktu.ID_NSP=zamovlennya.NS
		AND vulutsi.ID_VUL=zamovlennya.VL
		AND tup_nsp.ID_TIP_NSP=nas_punktu.ID_TIP_NSP
		AND tup_vul.ID_TIP_VUL=vulutsi.ID_TIP_VUL
		AND dlya_oformlennya.id_oform=zamovlennya.VUD_ROB
		ORDER BY zamovlennya.KEY";

$atu1 = mysql_query($sql1);
while ($aut1 = mysql_fetch_array($atu1)) {
    if ($aut1["BUD"] != "") $bud = "буд." . $aut1["BUD"]; else $bud = "";
    if ($aut1["KVAR"] != "") $kvar = "кв." . $aut1["KVAR"]; else $kvar = "";

    $ser = $aut1['SZ'];
    $nom = $aut1['NZ'];

    $zakaz = get_num_order($aut1["ID_RAYONA"], $ser, $nom);

    $pr = $aut1["PR"];
    $im = $aut1["IM"];
    $pb = $aut1["PB"];
    $ns = $aut1["NSP"];
    $tns = $aut1["TIP_NSP"];
    $vl = $aut1["VUL"];
    $tvl = $aut1["TIP_VUL"];
    $vud_rob = $aut1["document"];
    if ($aut1["ZVON"] == '1') $zv = 'так';
    else $zv = 'ні';

    $adres = $tns . ' ' . $ns . ' ' . $tvl . ' ' . $vl . ' ' . $bud . ' ' . $kvar;
    $fio = $pr . ' ' . $im . ' ' . $pb;
    $tel = $aut1["TEL"];
    $vukon = $aut1["VUK"];
    if ($vukon == "") $vukon = "-";
    if ($tel == "") $tel = "-";
    if ($aut1["PS"] == '1') $vudacha = 'так';
    else $vudacha = 'ні';

    $id_zm = $aut1["KEY"];
    $sm_taks = 0;
    $sql2 = "SELECT taks.* FROM taks WHERE IDZM='$id_zm' AND DL='1'";
    $atu2 = mysql_query($sql2);
    while ($aut2 = mysql_fetch_array($atu2)) {
        $sm_taks = round((($aut2["SUM"] + $aut2["SUM_OKR"]) * (($aut2["NDS"] / 100) + 1)), 2);
    }
    mysql_free_result($atu2);

    $sm_opl = 0;
    $sql2 = "SELECT SUM(SM) AS SM FROM kasa WHERE SZ='$ser' AND NZ='$nom' AND DL='1'";
    $atu2 = mysql_query($sql2);
    while ($aut2 = mysql_fetch_array($atu2)) {
        $sm_opl = round($aut2["SM"], 2);
    }
    mysql_free_result($atu2);

    $p .= '<tr>
	<td align="center">' . $zakaz . '</td>
	<td>' . $adres . '</td>
	<td align="center">' . $vud_rob . '</td>
	<td align="center">' . $fio . '</td>
	<td align="center">' . $tel . '</td>
	<td align="center">' . german_date($aut1["D_PR"]) . '</td>
	<td align="center">' . $aut1["PR_OS"] . '</td>
	<td align="center">' . german_date($aut1["DATA_GOT"]) . '</td>
	<td align="center">' . $zv . '</td>
	<td align="center">' . $aut1["SUM"] . '</td>
	<td align="center">' . german_date($aut1["DOKVUT"]) . '</td>
	<td align="center">' . german_date($aut1["DATA_VUH"]) . '</td>
	<td align="center">' . $aut1["SUM_D"] . '</td>
	<td align="center">' . german_date($aut1["DODOP"]) . '</td>
	<td align="center">' . $sm_taks . '</td>
	<td align="center">' . $sm_opl . '</td>
	<td align="center">' . $vukon . '</td>
	<td align="center">' . german_date($aut1["DATA_PS"]) . '</td>
	<td align="center">' . $vudacha . '</td>
	</tr>';
}
mysql_free_result($atu1);
$p .= '</table>';
echo $p;
if (mysql_close($db)) {
    // echo("Закриття бази даних");
} else {
    echo("Не можливо виконати закриття бази");
}
?>
    </body>
</html>
