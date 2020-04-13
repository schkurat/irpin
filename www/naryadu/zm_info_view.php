<?php
include_once "../function.php";
$zm = $_GET['zm'];
$flag = zm_for_bd($zm);
?>
<style>
    table td{
        padding: 5px;
    }
</style>
<table class="zmview" align="center">
    <tr>
        <th>Замовлення</th>
        <th>Замовник</th>
        <th>Адреса</th>
        <th>Дата замовлення</th>
        <th style="width: 155px;">Таксування</th>
        <th style="width: 155px;">Проплати</th>
        <th>Видача</th>
    </tr>
    <?php

    $sz = '';
    $nz = '';

    $sql = "SELECT zamovlennya.SZ,zamovlennya.NZ,zamovlennya.PR,zamovlennya.IM,zamovlennya.PB,zamovlennya.BUD,zamovlennya.KVAR,
                dlya_oformlennya.document,rayonu.RAYON,nas_punktu.NSP,vulutsi.VUL,tup_nsp.TIP_NSP,tup_vul.TIP_VUL,zamovlennya.D_PR,
                zamovlennya.VD,zamovlennya.DATA_VD,zamovlennya.KEY   
        FROM zamovlennya,rayonu,nas_punktu,vulutsi,dlya_oformlennya,tup_nsp,tup_vul 
			WHERE zamovlennya.DL='1' " . $flag . " 
			AND dlya_oformlennya.id_oform=zamovlennya.VUD_ROB
			AND rayonu.ID_RAYONA=zamovlennya.RN
			AND nas_punktu.ID_NSP=zamovlennya.NS 
			AND vulutsi.ID_VUL=zamovlennya.VL
			AND tup_nsp.ID_TIP_NSP=nas_punktu.ID_TIP_NSP
			AND tup_vul.ID_TIP_VUL=vulutsi.ID_TIP_VUL";
    //echo $sql;
    $atu = mysql_query($sql);
    while ($aut = mysql_fetch_array($atu)) {

        $client = $aut["PR"] . ' ' . $aut["IM"] . ' ' . $aut["PB"];
        $address = $aut["RAYON"] . ' ' . $aut["TIP_NSP"] . $aut["NSP"] . ' ' . $aut["TIP_VUL"] . $aut["VUL"] . objekt_ner(0, $aut["BUD"], $aut["KVAR"]);
        $dt_zm = german_date($aut["D_PR"]);
        $kl_zm = $aut["KEY"];
        $dt_vd = ($aut["VD"] == '1') ? german_date($aut["DATA_VD"]) : '-';
        $sz = $aut["SZ"];
        $nz = $aut["NZ"];
    }
    mysql_free_result($atu);


    $sql = "SELECT kasa.SM, kasa.SM_KM,kasa.DT FROM kasa WHERE kasa.DL='1' AND kasa.SZ='$sz' AND kasa.NZ='$nz'";
//    echo $sql;
    $atu = mysql_query($sql);
    while ($aut = mysql_fetch_array($atu)) {
        $sm = $aut["SM"] + $aut["SM_KM"];
        $dt = german_date($aut["DT"]);
        $kasa_str .= number_format($sm, 2) . ' - ' . $dt . '<br>';
    }
    mysql_free_result($atu);

    $sql = "SELECT taks.SUM, taks.SUM_OKR, taks.DATE_T, taks.NDS  FROM taks WHERE taks.DL='1' AND taks.IDZM='$kl_zm'";
//    echo $sql;
    $atu = mysql_query($sql);
    while ($aut = mysql_fetch_array($atu)) {
        $taks_sm = ($aut["SUM"] + $aut["SUM_OKR"]) * ($aut["NDS"] / 100 + 1);
        $dt_taks = german_date($aut["DATE_T"]);
        $taks_str = number_format($taks_sm, 2) . ' - ' . $dt_taks;
    }
    mysql_free_result($atu);
    ?>

    <tr>
        <td align="center"><?= $zm ?></td>
        <td align="center"><?= $client ?></td>
        <td align="center"><?= $address ?></td>
        <td align="center"><?= $dt_zm ?></td>
        <td align="center"><?= $taks_str ?></td>
        <td align="center"><?= $kasa_str ?></td>
        <td align="center"><?= $dt_vd ?></td>
    </tr>
</table>
