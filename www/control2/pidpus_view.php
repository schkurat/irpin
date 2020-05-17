<?php
include_once "../function.php";
$vst_tbl = "";
if (isset($_GET['flag'])) {
    $flg = $_GET['flag'];
    $vi = '';
    if ($flg == "first") {
        $kr_fl = "AND YEAR(zamovlennya.D_PR)=" . date("Y");
        $vi = "view";
    }
    if ($flg == "nap") {
        $kr_fl = "AND zamovlennya.PS='0' AND zamovlennya.VUK!=''
	AND zamovlennya.KEY=taks.IDZM AND taks.DL='1'";
        /* 	AND
        (zamovlennya.DODOP!='0000-00-00' OR zamovlennya.TUP_ZAM=2 OR
        (zamovlennya.VUD_ROB=9 AND zamovlennya.DOKVUT!='0000-00-00'))   */
        $vst_tbl = ", taks ";
    }
    if ($flg == "pid") {
        $kr_fl = "AND zamovlennya.PS='1' AND zamovlennya.DATA_PS='" . date("Y-m-d") . "'";
        $vi = "view";
    }
    if ($flg == "zm") {
        $vi = "view";
        $sz = $_GET['szam'];
        $nz = $_GET['nzam'];
        $kr_fl = "AND zamovlennya.SZ='$sz' AND zamovlennya.NZ='$nz'"; //AND zamovlennya.VUK!='' AND zamovlennya.DOKVUT!='0000-00-00'
    }
    if ($flg == "vuk") {
        $vi = "view";
        $vukon = $_GET['vk'];
        $kr_fl = "AND zamovlennya.VUK='$vukon'"; //AND zamovlennya.DOKVUT!='0000-00-00'
    }
    if ($flg == "adres") {
        $vi = "view";
        $ns = $_GET['nsp'];
        $vl = $_GET['vyl'];
        if (isset($_GET['bud'])) $bd = $_GET['bud'];
        else $bd = "";
        if (isset($_GET['kvar'])) $kv = $_GET['kvar'];
        else $kv = "";
        $kr_fl = "AND zamovlennya.NS='$ns' AND zamovlennya.VL='$vl'"; //AND zamovlennya.VUK!='' AND zamovlennya.DOKVUT!='0000-00-00'
        if ($bd != "") {
            $kr_fl .= " AND zamovlennya.BUD=" . $bd;
        }
        if ($kv != "") {
            $kr_fl .= " AND zamovlennya.KVAR=" . $kv;
        }
    }
} else {
    $kr_fl = "AND zamovlennya.SZ='" . date("dmy") . "'";
    $vi = "view";
}

$frn = get_filter_for_rn($drn,'zamovlennya','RN');
?>

    <script type="text/javascript">
        $(document).ready(
            function () {
                $(".zmview tr").mouseover(function () {
                    $(this).addClass("over");
                });

                $(".zmview tr").mouseout(function () {
                    $(this).removeClass("over");
                });
                $(".zmview tr:even").addClass("alt");

                $(".zmview").on("click", ".status-link", changeStatus);
            }
        );
        function changeStatus() {
            let element = $(this);
            let zm_kl = $(this).data("kl");
            let status = $(this).data("status");
            $.ajax({
                type: "POST",
                url: "changeStatus.php",
                data: 'kl=' + zm_kl + '&status=' + status,
                dataType: "html",
                success: function (html) {
                    if (html === '1') {
                        element.parent().css("background-color","#ffd391");
                        element.parent().siblings().css("background-color","#ffd391");
                    }
                    if (html === '2') {
                        element.parent().css("background-color","#ff838e");
                        element.parent().siblings().css("background-color","#ff838e");
                    }
                },
                error: function (html) {
                    alert(html.error);
                }
            });
        }
    </script>
    <div style="background-color: #ffd391; display: inline-block; padding: 5px;">На перевірці</div>
    <div style="background-color: #ff838e; display: inline-block; padding: 5px;">На доопрацюванні</div>
    <div style="background-color: #7afd84; display: inline-block; padding: 5px;">На друк</div>
<?php
$p = '<form action="otmetka.php" name="myform" method="get">
<table align="center" class="zmview">
<tr>
<th colspan="2">Статус</th>
<th colspan="3">Документи</th>
<th>Підписано</th>
<th>Дата пр.</th>
<th>С. ном.з.</th>
<th>Адреса</th>
<th>ПІБ (назва) замовника</th>
<th>ПІБ виконавця</th>
<th>Вартість</th>
<th>#</th>
</tr>';

$sql = "SELECT zamovlennya.SZ,zamovlennya.EA,zamovlennya.NZ,zamovlennya.TUP_ZAM,zamovlennya.STATUS,rayonu.*,
		zamovlennya.PS,zamovlennya.PR,zamovlennya.IM,zamovlennya.PB,nas_punktu.NSP,
		vulutsi.VUL,tup_nsp.TIP_NSP,tup_vul.TIP_VUL,zamovlennya.KEY,zamovlennya.BUD,zamovlennya.KVAR,
		zamovlennya.D_PR,zamovlennya.VUK,zamovlennya.DATA_GOT,zamovlennya.SUM,zamovlennya.SUM_KOR
				FROM zamovlennya, rayonu, nas_punktu, vulutsi, tup_nsp, tup_vul" . $vst_tbl . "
				WHERE
					zamovlennya.DL='1' " . $kr_fl . " AND (" . $frn . ") 
					AND rayonu.ID_RAYONA=zamovlennya.RN
					AND nas_punktu.ID_NSP=zamovlennya.NS
					AND vulutsi.ID_VUL=zamovlennya.VL
					AND tup_nsp.ID_TIP_NSP=nas_punktu.ID_TIP_NSP
					AND tup_vul.ID_TIP_VUL=vulutsi.ID_TIP_VUL
					ORDER BY SZ, NZ DESC";
$i = 1;
//echo $sql;
$atu = mysql_query($sql);
while ($aut = mysql_fetch_array($atu)) {
    if ($aut["BUD"] != "") $bud = "буд." . $aut["BUD"]; else $bud = "";
    if ($aut["KVAR"] != "") $kvar = "кв." . $aut["KVAR"]; else $kvar = "";

    $obj_ner = objekt_ner(0, $aut["BUD"], $aut["KVAR"]);
    $address = $aut["TIP_NSP"] . $aut["NSP"] . " " . $aut["TIP_VUL"] . $aut["VUL"] . " " . $obj_ner;
    $adr_storage = urlencode(serialize($address));

    $zakaz = get_num_order($aut["ID_RAYONA"], $aut["SZ"], $aut["NZ"]);
    $aut['SZ'] . '/' . $aut['NZ'];

    $key_zm = $aut['KEY'];
    $dt_got = $aut['DATA_GOT'];
    $sum_kor = $aut['SUM_KOR'];
    $vartist = 0;
    $sum_taks = 0;
    if($aut['STATUS'] == 1){
        $status_css = 'style="background-color: #ffd391;"';
    }elseif ($aut['STATUS'] == 2){
        $status_css = 'style="background-color: #ff838e;"';
    }elseif ($aut['PS'] == 1) {
        $status_css = 'style="background-color: #7afd84;"';
    }else{
        $status_css = '';
    }
    if($aut['PS'] == 1){
        $html_status = '<td colspan="2" align="center">-</td>';
    }else{
        $html_status = '<td ' . $status_css . ' align="center"><img class="status-link" data-kl="' . $key_zm . '" data-status="1" src="../images/b_select.png" alt="На перевірці"></td>
                    <td ' . $status_css . ' align="center"><img class="status-link" data-kl="' . $key_zm . '" data-status="2" src="../images/s_process.png" alt="На доопрацюванні"></td>';
    }

    $sql1 = "SELECT * FROM taks WHERE taks.IDZM='$key_zm' AND DL='1'";
    $atu1 = mysql_query($sql1);
    while ($aut1 = mysql_fetch_array($atu1)) {
        $sum_taks = round((($aut1["SUM"] + $aut1["SUM_OKR"]) * (($aut1["NDS"] / 100) + 1)), 2);
    }
    mysql_free_result($atu1);

    if ($sum_kor != 0) $vartist = $sum_kor;
    else $vartist = $sum_taks;


    $sql2 = "SELECT PS FROM zamovlennya WHERE zamovlennya.KEY='$key_zm' AND DL='1'";
    $atu2 = mysql_query($sql2);
    while ($aut2 = mysql_fetch_array($atu2)) {
        $ps = $aut2["PS"];
    }
    mysql_free_result($atu2);
    if ($ps == '1') $ch = "checked";
    else $ch = "";

    $gal = '<input name="' . $i . '" type="checkbox" value="g' . $i . '" ' . $ch . '>';
    if ($vi == "view") {
        if ($ch == "checked") $res = "підписано";
        else $res = "не підписано";
    } else $res = $gal;
    $p .= '<tr>' . $html_status . '
<td ' . $status_css . ' align="center"><a class="text-link" href="index.php?filter=storage&url=' . $aut["EA"] . '/document&parent_link=&adr=' . $adr_storage . '">Вхідні</a></td>
<td ' . $status_css . ' align="center"><a class="text-link" href="index.php?filter=storage&url=' . $aut["EA"] . '/technical&parent_link=&adr=' . $adr_storage . '">Техніка</a></td>
<td ' . $status_css . ' align="center"><a class="text-link" href="index.php?filter=storage&url=' . $aut["EA"] . '/inventory&parent_link=&adr=' . $adr_storage . '">Справа</a></td>
<td ' . $status_css . ' align="center">
' . $res . '
</td>
	<td ' . $status_css . ' align="center">' . german_date($aut["D_PR"]) . '</td>
      <td ' . $status_css . ' align="center">' . $zakaz . '
	  <input type="hidden" name="z' . $i . '" size="9" value="' . $key_zm . '"/>
	  <!--<input type="hidden" name="dt' . $i . '" size="9" value="' . $dt_got . '"/>-->
	  <input type="hidden" name="spr' . $i . '" size="9" value="' . $aut["SUM"] . '"/>
	  </td>
	  <td ' . $status_css . '>' . $aut["TIP_NSP"] . $aut["NSP"] . " " . $aut["TIP_VUL"] . $aut["VUL"] . " " . $bud . " " . $kvar . '</td>
	  <td ' . $status_css . '>' . $aut["PR"] . " " . $aut["IM"] . " " . $aut["PB"] . '</td>
      <td ' . $status_css . '>' . $aut["VUK"] . '</td>
	  <td ' . $status_css . ' align="right">' . $vartist . ' грн.</td>
	  <td ' . $status_css . '><a href="index.php?filter=edit_sum&idzak=' . $key_zm . '&smt=' . $sum_taks . '&smk=' . $sum_kor . '"><img src="../images/b_edit.png"></a></td>
      </tr>';
    $i++;
}
mysql_free_result($atu);
if ($flg == "nap") {
    $p .= '<tr bgcolor="#B5B5B5"><td colspan="13" align="center"><input name="ok" type="submit" value="Зберегти відмітки" /></td></tr>
		</table><input name="i" type="hidden" value="' . $i . '" /></form>';
} else {
    $p .= '</table></form>';
}
if ($i > 1) {
    echo $p;
} else {
    echo "Помилка!!!<br>";
    echo "Дану помилку ви бачите в таких випадках:<br>";
    echo "1 - Такого номера замовлення не існує<br>";
    echo "2 - Замовленню не призначений виконавець<br>";
    echo "3 - Замовлення не оплачене<br>";
}

