<?php
include_once "../function.php";

$dtkas = date_bd($_GET['dt_obr']);
$p = '<table class="zmview" align="center">
<tr>
<th colspan="2">#</th>
<th>№</th>
<th>Дата</th>
<th>ПІБ</th>
<th>Адреса</th>
<th>Сума</th>
<th>Тип суми</th>
</tr>';

$sql = "SELECT kasa.*,zamovlennya.PR,zamovlennya.IM,zamovlennya.PB,zamovlennya.BUD,zamovlennya.KVAR,zamovlennya.RN,
			zamovlennya.SUM AS SM_A,zamovlennya.SUM_D AS SM_D,
			rayonu.RAYON,nas_punktu.NSP,tup_nsp.TIP_NSP,vulutsi.VUL,tup_vul.TIP_VUL 
		FROM kasa,zamovlennya,rayonu,nas_punktu,vulutsi,tup_nsp,tup_vul 
		WHERE 
		zamovlennya.DL='1' AND kasa.DT='$dtkas' AND kasa.DL='1' 
		AND kasa.SZ=zamovlennya.SZ AND kasa.NZ=zamovlennya.NZ 
		AND rayonu.ID_RAYONA=zamovlennya.RN 
		AND nas_punktu.ID_NSP=NS AND vulutsi.ID_VUL=VL
		AND tup_nsp.ID_TIP_NSP=nas_punktu.ID_TIP_NSP
		AND tup_vul.ID_TIP_VUL=vulutsi.ID_TIP_VUL";

$atu = mysql_query($sql);
while ($aut = mysql_fetch_array($atu)) {
    $obj_ner = objekt_ner(0, $aut["BUD"], $aut["KVAR"]);
    $adres = $aut["RAYON"] . ' ' . $aut["TIP_NSP"] . $aut["NSP"] . " " . $aut["TIP_VUL"] . $aut["VUL"] . " " . $obj_ner;
    $tsum = '';
    if ($aut["SM"] == $aut["SM_A"]) $tsum = 'аванс';
    if ($aut["SM"] == $aut["SM_D"]) $tsum = 'доплата';
    $zm = get_num_order($aut["RN"], $aut["SZ"], $aut["NZ"]);
    $p .= '<tr>    
    <td align="center">
        <a href="naryadu.php?filter=edit_k&kl=' . $aut["ID"] . '&tsum=' . $tsum . '"><img src="../images/b_edit.png" border="0"></a>
    </td>
    <td align="center">
        <img class="drop-line" data-kl="' . $aut["ID"] . '" src="../images/b_drop.png" border="0">
    </td>
	<td align="center">' . $zm . '</td>
      <td align="center">' . german_date($aut["DT"]) . '</td>
      <td align="center">' . $aut["PR"] . ' ' . $aut["IM"] . ' ' . $aut["PB"] . '</td>
	  <td>' . $adres . '</td>
      <td align="center">' . $aut["SM"] . '</td>
	  <td align="center">' . $tsum . '</td>
      </tr>';
}
mysql_free_result($atu);
$p .= '</table>';
echo $p;
?>

<script type="text/javascript">
    $(document).ready(
        function()
        {
            $(".zmview tr").mouseover(function() {
                $(this).addClass("over");
            });

            $(".zmview tr").mouseout(function() {
                $(this).removeClass("over");
            });
            $(".zmview tr:even").addClass("alt");
            $("table").stickyTableHeaders();

            $(".drop-line").mouseover(function () {
                $(this).css("cursor","pointer");
            });
            $(".drop-line").click(function () {
                let isDelete = confirm("Ви дійсно бажаєте видалити запис?");
                if(isDelete == true){
                    let current_element = $(this);
                    $.ajax({
                        type: "POST",
                        url: "delete_kasa.php",
                        data: 'kl=' + current_element.data("kl"),
                        dataType: "html",
                        success: function (html) {
                            if(html == 'Success'){
                                current_element.parent().parent().remove();
                            }
                        },
                        error: function (html) {
                            alert(html.error);
                        }
                    });
                }
            });
        }
    );
</script>
