<?php
include_once "../function.php";
?>
<style>
    a.text-link {
        display: flex;
        padding-top: 6px;
    }

    a.text-link:hover {
        display: flex;
        padding-top: 6px;
    }

    .fal {
        padding: 5px 2px;
    }

    .spr-icon{
        display: block;
    }

    .fa-paperclip, .fa-inbox-out, .fa-file-user, .fa-file-spreadsheet, .fa-file-excel {
        color: #009aff;
    }

    .fa-file-contract, .fa-plus, .fa-list-ol, .fa-inbox-in {
        color: #11cc06;
    }

    .fa-receipt {
        color: #ff8400;
    }

    .action-adr {
        float: left;
    }

    .fal {
        font-size: 18px;
    }

    .fa-trash {
        color: #ff0000;
    }

    .fa-inbox-out, .fa-paperclip, .fa-inbox-in {
        float: left;
    }
</style>
<?php
$d2 = date("Y-m-d");
$zam_den = "arhiv_zakaz.D_PR='" . $d2 . "'";
$flag = $zam_den;
$szak = $_GET['sz'];
$nzak = $_GET['nz'];

$ns = $_GET['nsp'];
$vl = $_GET['vyl'];
$bd = $_GET['bud'];
$kv = $_GET['kvar'];
if (isset($_GET['npr'])) {
    $npr = date_bd($_GET['npr']);
    $npr1 = $_GET['npr'];
    if (isset($_GET['kpr'])) {
        $kpr = date_bd($_GET['kpr']);
        $kpr1 = $_GET['kpr'];
        $posluga = $_GET['posluga'];
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
if (isset($_GET['search'])) $search = $_GET['search']; else $search = '';
if ($search != '') {
    $flag = "((arhiv_zakaz.SZ='" . substr($search, 2, 6) . "' AND arhiv_zakaz.NZ='" . (int)substr($search, 8, 2) . "') "
        . " OR ((LOCATE('$search',arhiv_zakaz.SUBJ)!=0 OR LOCATE('$search',arhiv_zakaz.EDRPOU)!=0 OR "
        . "LOCATE('$search',arhiv_zakaz.PR)!=0)))";

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
<th>Прим.</th>
<th colspan="2" style="min-width: 350px;">Адреса зам.</th>
<th>Сума</th>
<th>Дата пр.</th>
</tr>';

$sql = "SELECT arhiv_zakaz.*,arhiv_jobs.name,arhiv_jobs.type,arhiv_jobs.id 
			 FROM arhiv_zakaz, arhiv_jobs
				WHERE 
					" . $flag . "
					AND arhiv_zakaz.DL='1'  
					AND arhiv_jobs.id=arhiv_zakaz.VUD_ROB AND arhiv_jobs.dl='1' 
					ORDER BY arhiv_zakaz.KEY DESC";
//echo $sql;
$atu = mysql_query($sql);
while ($aut = mysql_fetch_array($atu)) {
    $kly++;
    $d_pr = german_date($aut["D_PR"]);
    $zm_id = $aut["KEY"];
    $job_type = $aut["type"];
    $code_job = $aut["id"];

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

    $vst_print = '<a href="print_dog.php?kl=' . $aut["KEY"] . '" title="Договір"><i class="fal fa-file-contract"></i></a>';
    $vst_bl2 = '';
    if ($code_job <= 5) {
        if ($job_type == 3) {
            $vst_bl2 .= '<a href="print_dod.php?kl=' . $aut["KEY"] . '&dod=1" class="text-link" title="Додаток 1 до договору"><i class="fal fa-paperclip">1</i></a>
        <a href="print_dod.php?kl=' . $aut["KEY"] . '&dod=2" class="text-link" title="Додаток 2 до договору"><i class="fal fa-paperclip">2</i></a>
        <a href="print_dod.php?kl=' . $aut["KEY"] . '&dod=3" class="text-link" title="Додаток 3 до договору"><i class="fal fa-paperclip">3</i></a>';
        } elseif ($job_type == 1) {
            $vst_bl2 .= '<a href="print_dod.php?kl=' . $aut["KEY"] . '&dod=4" class="text-link" title="Додаток 4 до договору"><i class="fal fa-paperclip">4</i></a>
        <a href="print_dod.php?kl=' . $aut["KEY"] . '&dod=5" class="text-link" title="Додаток 5 до договору"><i class="fal fa-paperclip">5</i></a>';
        }
    }elseif ($code_job == 6){
        $vst_bl2 .= '<a href="print_spr.php?kl=' . $aut["KEY"] . '&sp=1" class="spr-icon" title="Додаток звичайна"><i class="fal fa-file-user"></i></a>
        <a href="print_spr.php?kl=' . $aut["KEY"] . '&sp=2" class="spr-icon" title="Довідка з технічними показниками"><i class="fal fa-file-spreadsheet"></i></a>
        <a href="print_spr.php?kl=' . $aut["KEY"] . '&sp=3" class="spr-icon" title="Довідка про відсутність"><i class="fal fa-file-excel"></i></a>';
    }
//    $vst_bl2 = '<td align="center"><a href="print_akt_transfer.php?kl=' . $aut["KEY"] . '" title="Акт виконаних робіт"><i class="fal fa-file-certificate"></i></a></td>';

    $kvut = '<a href="print_kvut.php?kl=' . $aut["KEY"] . '" title="Квитанція на оплату"><i class="fal fa-receipt"></i></a>';

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
        $ns = $aut1["ns"];
        $vl = $aut1["vl"];
        $bd = trim($aut1["bud"]);
        $kv = trim($aut1["kvar"]);

        $obj_ner_dop = objekt_ner(0, $bd, $kv);

        $sql2 = "SELECT N_SPR FROM arhiv WHERE RN='" . $rayon . "' AND NS = '" . $ns . "' AND VL = '" . $vl . "' 
                    AND BD = '" . $bd . "' AND KV = '" . $kv . "'";
        //echo $sql2;
        $atu2 = mysql_query($sql2);
        $is_archive = mysql_num_rows($atu2);
        $col_hidden = '';

        if ($job_type == 3) {
            if ($aut1["status"] == "0") {
                if ($is_archive > 0) {
                    $paste_action = ($aut1["PV"] == '0') ? '<a href="http://ibti.pp.ua/arhiv/arhiv.php?filter=edit_zap_info&adr_id=' . $aut1["id"] . '" class="action-adr" title="Відмітка про внесеня матеріалів до справи">
                            <i class="fal fa-inbox-in"></i></a>' : '';
                } else {
                    $paste_action = '<a href="http://ibti.pp.ua/arhiv/arhiv.php?filter=edit_zap_info&adr_id=' . $aut1["id"] . '" class="action-adr" title="Присвоїти інвентарний номер">
					    <i class="fal fa-list-ol"></i>
					</a>';
                }
                $dop_adr .= '
            <div class="ard-row">
					' . $paste_action . '
					<a href="http://ibti.pp.ua/arhiv/arhiv.php?filter=edit_status&adr_id=' . $aut1["id"] . '&npr=' . $npr1 . '&kpr=' . $kpr1 . '&posluga=' . $pos . '" class="action-adr">
					<i class="fal fa-trash"></i>
					</a>
		<a href="arhiv.php?filter=dop_adr_edit&kl=' . $aut1["id"] . '" class="text-link" title="Редагування адреси">' . $aut1["TIP_NSP"] . $aut1["NSP"] . " " . $aut1["TIP_VUL"] . $aut1["VUL"] . " " . $obj_ner_dop . '</a>
		
		</div><div style="clear: both"></div>';
            } else {
                $dop_adr .= '<div style="color:gray;">' . $aut1["TIP_NSP"] . $aut1["NSP"] . " " . $aut1["TIP_VUL"] . $aut1["VUL"] . " " . $obj_ner_dop . '</div><div style="clear: both"></div>';
            }
        } elseif ($job_type == 1) {
            if ($aut1["status"] != 2) {
                $v_insert = ($aut1["VD"] == '0') ? '<i class="fal fa-inbox-out" data-kl="' . $aut1["id"] . '" title="Відмітка про видачу"></i>' : '';
                $dop_adr .= '
            <div class="ard-row">
				' . $v_insert . '
				<a href="print_dod.php?kl=' . $aut["KEY"] . '&dod=6&kl_adr=' . $aut1["id"] . '" title="Додаток 6 до договору"><i class="fal fa-paperclip">6</i></a>
		        <a href="arhiv.php?filter=dop_adr_edit&kl=' . $aut1["id"] . '" class="text-link" title="Редагування адреси">' . $aut1["TIP_NSP"] . $aut1["NSP"] . " " . $aut1["TIP_VUL"] . $aut1["VUL"] . " " . $obj_ner_dop . '</a>
		    </div>
		    <div style="clear: both"></div>';
            } else {
                $dop_adr .= '<div style="color:red;">' . $aut1["TIP_NSP"] . $aut1["NSP"] . " " . $aut1["TIP_VUL"] . $aut1["VUL"] . " " . $obj_ner_dop . '</div><div style="clear: both"></div>';
            }
        } elseif ($job_type == 2) {
            $dop_adr .= '<div>' . $aut1["TIP_NSP"] . $aut1["NSP"] . " " . $aut1["TIP_VUL"] . $aut1["VUL"] . " " . $obj_ner_dop . '</div><div style="clear: both"></div>';
            $col_hidden = 'style="display:none;"';
        }

    }
    mysql_free_result($atu1);
    $address = $dop_adr;

    $order = get_num_order($rayon, $aut["SZ"], $aut["NZ"]);

    $customer = ($job_type != 2) ? $aut["SUBJ"] : $aut["PR"] . " " . $aut["IM"] . " " . $aut["PB"];
    $srt_worker = ($job_type != 2) ? $aut["PR"] . " " . $aut["IM"] . " " . $aut["PB"] : '';
    $phone = (!empty($aut["TEL"])) ? 'Тел. ' . $aut["TEL"] : '';
    $email = (!empty($aut["EMAIL"])) ? $aut["EMAIL"] : '';

    $p .= '<tr bgcolor="#FFFAF0">
' . $vst_bl . '	
<td align="center">' . $vst_print . '</td>	
<td align="center">' . $kvut . '</td>	
<td align="center">' . $vst_bl2 . '</td>
      <td align="center">' . $order . '</td>
      <td align="center" id="zal"><a href="arhiv.php?filter=zmina_info&fl=subj&kl=' . $aut["KEY"] . '">' . $customer . '</a><br>' . $phone . '<br>' . $email . '<br><a href="arhiv.php?filter=zmina_info&fl=prizv&kl=' . $aut["KEY"] . '">' . $srt_worker . '</a></td>    
      <td align="center" id="zal"><a href="arhiv.php?filter=zmina_info&fl=tup_spr&kl=' . $aut["KEY"] . '">' . $aut["name"] . '</a></td>
	  <td align="center" id="zal"><a href="arhiv.php?filter=zmina_info&fl=prim&kl=' . $aut["KEY"] . '">' . $aut["PRIM"] . '</a></td>
      <td style="font-size: 12px;">' . $address . '</td>
	  <td align="center"><a href="arhiv.php?filter=dop_adr_info&kl=' . $aut["KEY"] . '" title="Додати адресу"><i class="fal fa-plus"></i></td>
	  <td align="center" id="zal"><a href="arhiv.php?filter=zmina_info&fl=vartist&kl=' . $aut["KEY"] . '">' . $aut["SUM"] . '</a></td>
	  <td align="center">' . $d_pr . '</td>
      </tr>';

}
mysql_free_result($atu);
$p .= '</table>';
if ($kly > 0) echo $p;
else echo '<table class="zmview" align="center"><tr><th style="font-size: 35px;"><b>Замовлень не знайдено</b></th></tr></table>';
?>
<script language="JavaScript">
    $(document).ready(function () {
        $('.zmview').on('mouseover', '.fa-inbox-out', function () {
            $(this).css('cursor', 'pointer');
        }).on('click', '.fa-inbox-out', function () {
            let element = $(this);
            let kl = element.data("kl");
            $.ajax({
                type: "GET",
                url: "vudacha.php",
                data: "kl=" + kl,
                dataType: "html",
                success: function (html) {
                    if (html == '1') {
                        element.remove();
                    }
                },
                error: function (html) {
                    alert(html.error);
                }
            });
        });
    });
</script>
