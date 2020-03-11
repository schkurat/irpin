<?php
include_once "../function.php";

$d2 = date("Y-m-d");
$zam_den = "arhiv_zakaz.D_PR='" . $d2 . "'";
$flag = $zam_den;
$szak = $_GET['sz'];
$nzak = $_GET['nz'];

$ns = $_GET['nsp'];
$vl = $_GET['vyl'];
$bd = $_GET['bud'];
$kv = $_GET['kvar'];
//$idn=$_GET['idn'];
//$rah=$_GET['rah'];
//$pr=$_GET['priz'];
if (isset($_GET['npr'])) {
    $npr = date_bd($_GET['npr']);
    $npr1 = $_GET['npr'];
    if (isset($_GET['kpr'])) {
        $kpr = date_bd($_GET['kpr']);
        $kpr1 = $_GET['kpr'];
//$kr_zak=$_GET['vud_zam'];
        $posluga = $_GET['posluga'];
//if($kr_zak==3) $fl_vst='';
//else $fl_vst=" AND arhiv_zakaz.TUP_ZAM='".$kr_zak."'";
        if ($posluga == "") $fl2_vst = '';
        else $fl2_vst = " AND arhiv_zakaz.VUD_ROB='" . $posluga . "'";
    }
}
if ($npr != "" and $kpr != "") {
    $flag = "arhiv_zakaz.D_PR>='" . $npr . "' AND arhiv_zakaz.D_PR<='" . $kpr . "'" . $fl_vst . $fl2_vst;
}
if ($szak != "" and $nzak != "") {
    $flag = "arhiv_zakaz.SZ=" . $szak . " AND arhiv_zakaz.NZ=" . $nzak;
}

if ($ns != "" and $vl != "") {
    $flag = "arhiv_zakaz.NS=" . $ns . " AND arhiv_zakaz.VL=" . $vl;
    if ($bd != "") {
        $flag .= " AND arhiv_zakaz.BUD=" . $bd;
    }
    if ($kv != "") {
        $flag .= " AND arhiv_zakaz.KVAR=" . $kv;
    }
}
//if($idn!=""){$flag="zamovlennya.IDN=".$idn;}
if (isset($_GET['search'])) $search = $_GET['search']; else $search = '';
if ($search != '') {
    $flag = "(LOCATE('$search',arhiv_zakaz.SUBJ)!=0 OR LOCATE('$search',arhiv_zakaz.EDRPOU)!=0 OR "
        . "LOCATE('$search',rayonu.RAYON)!=0 OR LOCATE('$search',nas_punktu.NSP)!=0 OR "
        . "LOCATE('$search',vulutsi.VUL)!=0 OR LOCATE('$search',arhiv_zakaz.PR)!=0)";

}

if ($ddl == '1') {
    $cssp = '4';
} else {
    $cssp = '3';
}
$kly = 0;
$p = '<table class="zmview">
<tr>
<th colspan="' . $cssp . '">#</th>
<th>Замовлення</th>
<th>Замовник</th>
<th>Тип справи</th>
<th>Сертифікована особа</th>
<th>Прим.</th>
<th>Телефон<br>Email</th>
<th colspan="2" style="min-width: 300px;">Адреса зам.</th>
<th>Сума</th>
<th>Дата пр.</th>
</tr>';

$sql = "SELECT arhiv_zakaz.*,arhiv_jobs.name,arhiv_jobs.type/*,rayonu.RAYON,nas_punktu.NSP,tup_nsp.TIP_NSP,
				vulutsi.VUL,tup_vul.TIP_VUL*/
			 FROM arhiv_zakaz,/* rayonu, nas_punktu, vulutsi, tup_nsp, tup_vul,*/ arhiv_jobs
				WHERE 
					" . $flag . "
					AND arhiv_zakaz.DL='1'  
					AND arhiv_jobs.id=VUD_ROB
					/*AND rayonu.ID_RAYONA=RN
					AND nas_punktu.ID_NSP=NS
					AND vulutsi.ID_VUL=VL
					AND tup_nsp.ID_TIP_NSP=nas_punktu.ID_TIP_NSP
					AND tup_vul.ID_TIP_VUL=vulutsi.ID_TIP_VUL*/
					ORDER BY arhiv_zakaz.KEY DESC";
//echo $sql;
$atu = mysql_query($sql);
while ($aut = mysql_fetch_array($atu)) {
    $kly++;
    $d_pr = german_date($aut["D_PR"]);
//    $seriya = $aut["SZ"];
//    $zam = $aut["NZ"];
    $zm_id = $aut["KEY"];
    $job_type = $aut["type"];

    $obj_ner = objekt_ner(0, $aut["BUD"], $aut["KVAR"]);

    if ($ddl == '1') {
        if ($aut["PS"] == '0') {
            $vst_bl = '<td align="center"><a href="arhiv.php?filter=delete_info&tip=zakaz&kl=' . $aut["KEY"] . '"><img src="../images/b_drop.png" border="0"></a></td>';
        } else {
            $vst_bl = '<td align="center">-</td>';
        }
    } else {
        $vst_bl = '';
    }

    $vst_print = '<a href="print_dog.php?kl=' . $aut["KEY"] . '"><img src="../images/print.png" border="0"></a>';

    $vst_bl2 = '<td align="center"><a href="print_akt_transfer.php?kl=' . $aut["KEY"] . '"><img src="../images/akt.png" border="0"></a></td>';

    $kvut = '<a href="print_kvut.php?kl=' . $aut["KEY"] . '"><img src="../images/kvut.png" border="0"></a>';

    $rayon = 0;
    $dop_adr = '';
    $sql1 = "SELECT arhiv_dop_adr.*, arhiv_dop_adr.id AS ID, rayonu.RAYON,nas_punktu.NSP,tup_nsp.TIP_NSP,
			vulutsi.VUL,tup_vul.TIP_VUL
			 FROM arhiv_dop_adr, rayonu, nas_punktu, vulutsi, tup_nsp, tup_vul
				WHERE 
					arhiv_dop_adr.id_zm='$zm_id' 
					AND rayonu.ID_RAYONA=arhiv_dop_adr.rn
					AND nas_punktu.ID_NSP=arhiv_dop_adr.ns
					AND vulutsi.ID_VUL=arhiv_dop_adr.vl
					AND tup_nsp.ID_TIP_NSP=nas_punktu.ID_TIP_NSP
					AND tup_vul.ID_TIP_VUL=vulutsi.ID_TIP_VUL
					ORDER BY arhiv_dop_adr.id DESC";
    //echo $sql1;
    $atu1 = mysql_query($sql1);
    while ($aut1 = mysql_fetch_array($atu1)) {
        $rayon = $aut1["rn"];
        $obj_ner_dop = objekt_ner(0, $aut1["bud"], $aut1["kvar"]);
        //var_dump($aut1);
        if ($aut1["status"] == "0") {
            $dop_adr .= '
					<a href ="http://ibti.pp.ua/arhiv/arhiv.php?filter=edit_zap_info&adr_id=' . $aut1["id"] . '" class="add_to_arh" alt="текст">
					</a>
					<a href ="http://ibti.pp.ua/arhiv/arhiv.php?filter=edit_status&adr_id=' . $aut1["id"] . '&npr=' . $npr1 . '&kpr=' . $kpr1 . '&posluga=' . $pos . '" class="back_zm" alt="текст">
					</a>
		<div><a href="arhiv.php?filter=dop_adr_edit&kl=' . $aut1["id"] . '">' . $aut1["TIP_NSP"] . $aut1["NSP"] . " " . $aut1["TIP_VUL"] . $aut1["VUL"] . " " . $obj_ner_dop . '</a></div><div style="clear: both"></div>';
        } else {
            $dop_adr .= '<div style="color:gray;">' . $aut1["TIP_NSP"] . $aut1["NSP"] . " " . $aut1["TIP_VUL"] . $aut1["VUL"] . " " . $obj_ner_dop . '</div><div style="clear: both"></div>';
        }
    }
    mysql_free_result($atu1);
    $address = $dop_adr;

    $order = get_num_order($rayon,$aut["SZ"],$aut["NZ"]);

    $customer = ($job_type != 2) ? $aut["SUBJ"] : $aut["PR"] . " " . $aut["IM"] . " " . $aut["PB"];
    $srt_worker = ($job_type != 2) ? $aut["PR"] . " " . $aut["IM"] . " " . $aut["PB"] : '';

    $p .= '<tr bgcolor="#FFFAF0">
' . $vst_bl . $vst_bl2 . '
<td align="center">' . $vst_print . '</td>	
<td align="center">' . $kvut . '</td>	
      <td align="center">' . $order . '</td>
      <td align="center" id="zal"><a href="arhiv.php?filter=zmina_info&fl=subj&kl=' . $aut["KEY"] . '">' . $customer . '</a></td>    
      <td align="center" id="zal"><a href="arhiv.php?filter=zmina_info&fl=tup_spr&kl=' . $aut["KEY"] . '">' . $aut["name"] . '</a></td>
      <td align="center" id="zal"><a href="arhiv.php?filter=zmina_info&fl=prizv&kl=' . $aut["KEY"] . '">' . $srt_worker . '</a></td>
	<td align="center" id="zal"><a href="arhiv.php?filter=zmina_info&fl=prim&kl=' . $aut["KEY"] . '">' . $aut["PRIM"] . '</a></td>
        <td align="center" id="zal"><a href="arhiv.php?filter=zmina_info&fl=telefon&kl=' . $aut["KEY"] . '">' . $aut["TEL"] . '<br>' . $aut["EMAIL"] . '</a></td>
	  <!--<td align="center" id="zal"><a href="arhiv.php?filter=zmina_info&fl=email&kl=' . $aut["KEY"] . '">' . $mulo . '</a></td>-->
      <td id="zal" style="font-size: 12px;">' . $address . '</td>
	  <td align="center"><a href="arhiv.php?filter=dop_adr_info&kl=' . $aut["KEY"] . '"><img src="../images/plus.png"></a></td>
	  <td align="center" id="zal"><a href="arhiv.php?filter=zmina_info&fl=vartist&kl=' . $aut["KEY"] . '">' . $aut["SUM"] . '</a></td>
	  <td align="center">' . $d_pr . '</td>
      </tr>';

}
mysql_free_result($atu);
$p .= '</table>';
if ($kly > 0) echo $p;
else echo '<table class="zmview" align="center"><tr><th style="font-size: 35px;"><b>Замовлень не знайдено</b></th></tr></table>';
