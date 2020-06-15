<?php
session_start();
$lg = $_SESSION['LG'];
$pas = $_SESSION['PAS'];

include "../function.php";
?>
<style>
    .report{
        border: 1px solid black;
        border-collapse: collapse;
        font-size: 0.75em;
    }
    .report th,.report td{
        border: 1px solid black;
        padding: 2px 3px;
    }
    .pidpus p{
        margin-left: 20%;
    }
</style>
<?php

$bdat = date_bd($_POST['date1']);
$edat = date_bd($_POST['date2']);
$flg = $_POST['flag'];
if (!empty($_POST['rayon'])) {
    $rayon = intval($_POST['rayon']);
    if ($rayon > 0) {
        $ray = " AND arhiv_dop_adr.rn = " . $rayon;
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
	<table class="report"><tr>
	<th align="center" rowspan="2">Замов лення</th>
	<th align="center" rowspan="2">Адреса</th>
	<th align="center" rowspan="2">Вид робіт</th>
	<th align="center" rowspan="2">ПІБ (назва)</th>
	<th align="center" rowspan="2">Дата прийому</th>
	<!--<th align="center" rowspan="2">Сума на ЗП</th> -->
	<th align="center" colspan="2">Сплачено</th>
<!--	<th align="center" rowspan="2">Виконавець</th> -->
	</tr>
	<tr><th>Сума</th><th>Дата</th></tr>
	';

//if ($flg == "got") {
//    $kr_fl = "AND zamovlennya.DATA_GOT>='$bdat' AND zamovlennya.DATA_GOT<='$edat'";
//}
//if ($flg == "nevuk") {
//    $kr_fl = "AND zamovlennya.DATA_GOT>='$bdat' AND zamovlennya.DATA_GOT<='$edat' AND zamovlennya.PS='0' AND zamovlennya.VD='0'";
//}
//if ($flg == "nevuk_vuk") {
//    $vukonavets = $_POST['isp'];
//    $kr_fl = "AND zamovlennya.DATA_GOT>='$bdat' AND zamovlennya.DATA_GOT<='$edat' AND zamovlennya.PS='0' AND zamovlennya.VD='0'
// AND zamovlennya.VUK='$vukonavets'";
//}
//if ($flg == "got_vuk") {
//    $vukonavets = $_POST['isp'];
//    $kr_fl = "AND zamovlennya.DATA_PS>='$bdat' AND zamovlennya.DATA_PS<='$edat' AND zamovlennya.PS='1' AND zamovlennya.VUK='$vukonavets'";
//}
if ($flg == "pr_period") {
    $kr_fl = "AND arhiv_zakaz.D_PR>='$bdat' AND arhiv_zakaz.D_PR<='$edat'";
}
//if ($flg == "vk_date_g") {
//    $vukonavets = $_POST['isp'];
//    $kr_fl = "AND zamovlennya.DATA_GOT>='$bdat' AND zamovlennya.DATA_GOT<='$edat' AND zamovlennya.VUK='$vukonavets'";
//}

$s_sm_opl = 0;
$s_sm_taks = 0;
$s_taks_not_pdv = 0;
$s_sm_zp = 0;
$sql1 = "SELECT arhiv_zakaz.*,arhiv_jobs.name,arhiv_jobs.type,arhiv_jobs.id 
            FROM arhiv_zakaz,arhiv_jobs 
            WHERE
			arhiv_zakaz.DL='1' 
			" . $kr_fl . "			
			AND arhiv_jobs.id=arhiv_zakaz.VUD_ROB AND arhiv_jobs.dl='1' 
			ORDER BY arhiv_zakaz.KEY DESC";

$atu1 = mysql_query($sql1);
//$num_rows = mysql_num_rows($atu1);
while ($aut1 = mysql_fetch_array($atu1)) {
    $ser = $aut1['SZ'];
    $nom = $aut1['NZ'];
    $tup_zam = $aut1['TUP_ZAM'];
    $zakaz = get_num_order($rayon, $ser, $nom);

    $pr = $aut1["PR"];
    $im = $aut1["IM"];
    $pb = $aut1["PB"];

    $ns = $aut1["NSP"];
    $tns = $aut1["TIP_NSP"];
    $vl = $aut1["VUL"];
    $tvl = $aut1["TIP_VUL"];
    $vud_rob = $aut1["name"];

    $fio = $pr . ' ' . $im . ' ' . $pb;
    $tel = $aut1["TEL"];
    if ($tel == "") $tel = "-";

    $id_zm = $aut1["KEY"];

    $sm_opl = 0;
    $pay_sm_insert = '';
    $pay_dt_insert = '';
    $address_insert = '';
//    $pay_insert_one = '';
//    $pay_insert_more = '';
    $sql3 = "SELECT SM,DT FROM arhiv_kasa WHERE SZ='$ser' AND NZ='$nom' AND DL='1'";
//    echo $sql3;
    $atu3 = mysql_query($sql3);
    $cunt_pay = mysql_num_rows($atu3);
//    $i=0;
    while ($aut3 = mysql_fetch_array($atu3)) {
//        $i++;
        $sm_opl = (float)round($aut3["SM"], 2);
        $s_sm_opl += $sm_opl;
//        if($cunt_pay == 1){
//            $pay_insert_one = '<td align="right">' . number_format($sm_opl,2) . '</td><td align="center">' . german_date($aut3["DT"]) . '</td>';
//        }else{
//            if($i == 1){
//                $pay_insert_one = '<td align="right">' . number_format($sm_opl,2) . '</td><td align="center">' . german_date($aut3["DT"]) . '</td>';
//            }else{
//                $pay_insert_more .= '<tr><td align="right">' . number_format($sm_opl,2) . '</td><td align="center">' . german_date($aut3["DT"]) . '</td></tr>';
//            }
//        }
        $pay_sm_insert .= '<div> ' . number_format($sm_opl,2) . ' </div>';
        $pay_dt_insert .= '<div> ' . german_date($aut3["DT"]) . ' </div>';
    }
    mysql_free_result($atu2);


    $zm_id = $aut1["KEY"];
    $sql2 = "SELECT arhiv_dop_adr.*, arhiv_dop_adr.id AS ID, rayonu.RAYON,nas_punktu.NSP,tup_nsp.TIP_NSP,
			vulutsi.VUL,tup_vul.TIP_VUL
			 FROM arhiv_dop_adr, rayonu, nas_punktu, vulutsi, tup_nsp, tup_vul
				WHERE 
					arhiv_dop_adr.id_zm='$zm_id' 
				  " . $ray . "
					AND rayonu.ID_RAYONA=arhiv_dop_adr.rn
					AND nas_punktu.ID_NSP=arhiv_dop_adr.ns
					AND vulutsi.ID_VUL=arhiv_dop_adr.vl
					AND tup_nsp.ID_TIP_NSP=nas_punktu.ID_TIP_NSP
					AND tup_vul.ID_TIP_VUL=vulutsi.ID_TIP_VUL
					ORDER BY arhiv_dop_adr.id DESC";
//    echo $sql2;
    $atu2 = mysql_query($sql2);
    $count_adr = mysql_num_rows($atu2);
    while ($aut2 = mysql_fetch_array($atu2)) {
        $rayon = $aut2["rn"];
        $ns = $aut2["ns"];
        $vl = $aut2["vl"];
        $bd = trim($aut2["bud"]);
        $kv = trim($aut2["kvar"]);

        $obj_ner_dop = objekt_ner(0, $bd, $kv);
        $address = $aut2["TIP_NSP"] . $aut2["NSP"] . " " . $aut2["TIP_VUL"] . $aut2["VUL"] . " " . $obj_ner_dop;

        $n_spr = '';
        $sql3 = "SELECT N_SPR FROM arhiv WHERE RN='" . $rayon . "' AND NS = '" . $ns . "' AND VL = '" . $vl . "' 
                    AND BD = '" . $bd . "' AND KV = '" . $kv . "'";
        //echo $sql2;
        $atu3 = mysql_query($sql3);
        $is_archive = mysql_num_rows($atu3);
        while ($aut3 = mysql_fetch_array($atu3)) {
            $n_spr = $aut3["N_SPR"];
        }
        mysql_free_result($atu3);
        $col_hidden = '';

        $address_insert .= '<div class="adr-more"> ' . $address .  ' </div>';

    }
    mysql_free_result($atu2);

//    if($count_adr == 0){
//        $adr_insert_one = '<td>-</td>';
//        $count_adr = 1;
//    }

    $p .= '<tr>
	<td>' . $zakaz . '</td>
	<td>'. $address_insert .' </td>
	<td>' . $vud_rob . '</td>
	<td>' . $fio . '</td>
	<td align="center">' . german_date($aut1["D_PR"]) . '</td>
	<td>'. $pay_sm_insert .'</td>
	<td>' . $pay_dt_insert . '</td>
	</tr>';
}
mysql_free_result($atu1);
$p .= '<tr>
    <th colspan="5" align="left">Всього: </th>
    <th>' . number_format($s_sm_opl,2) . '</th>
    <th></th>
    </tr></table>';

echo $p;
//echo '<br>Всього замовлень: ' . $num_rows;
if ($flg == "got_vuk" and  !empty($vukonavets)){
    ?>
    <div class="pidpus">
        <p>Виконавець __________________________ <?= $vukonavets ?></p>
    </div>
    <?php
}
if (mysql_close($db)) {
    // echo("Закриття бази даних");
} else {
    echo("Не можливо виконати закриття бази");
}
