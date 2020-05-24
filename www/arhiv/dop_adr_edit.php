<?php
include "../function.php";
include "scriptu.php";
$kl = $_GET['kl'];
?>
<style type="text/css">
    .povorot {
        -moz-transform: rotate(-90deg); /* Для Firefox */
        -ms-transform: rotate(-90deg); /* Для IE */
        -webkit-transform: rotate(-90deg); /* Для Safari, Chrome, iOS */
        -o-transform: rotate(-90deg); /* Для Opera */
        transform: rotate(-90deg);
    }

    .input_file {
        width: 24px;
        height: 24px;
        background: url('../images/plus_krug.png') no-repeat;
        cursor: pointer;
        overflow: hidden;
        padding: 0;
        float: right;

    }

    .input_style {
        -moz-opacity: 0;
        cursor: pointer;
        filter: alpha(opacity=0);
        opacity: 0;
        font-size: 24px;
        height: 24px;
    }
</style>
<script type="text/javascript">
    /*$(document).ready(function () {
        $('#bt1').click(ShowElement);
        $('#bt2').click(HideElement);
        $('input.bt').click(HideElement_cancel);
        $('#add_ns').click(add_nsp);
        $('#add_vl').click(add_vul);

    });

    function ShowElement() {
        $("#add_vul").fadeOut();
        $("#add_nas_punkt").fadeIn(3000);
    }

    function HideElement() {
        $("#add_nas_punkt").fadeOut();
        $("#add_vul").fadeIn(3000);
    }

    function HideElement_cancel() {
        $("#add_nas_punkt").fadeOut();
        $("#add_vul").fadeOut();
    }

    function add_nsp(eventObj) {
        $.ajax({
            type: "POST",
            url: "nspadd.php",
            data: 'rajon2=' + $("#rayon2").val() + '&nsp2=' + $("#nsp2").val() + '&tup2=' + $("#tup2").val(),
            dataType: "html",
            success: function (html) {
                var rp = html;
                if (rp == '1') {
                    $("#rayon :nth-child(1)").attr("selected", "selected");
                    $("#nas_punkt").empty();
                    $("#vulutsya").empty();
                    $("#nas_punkt").attr("disabled", "disabled");
                    $("#vulutsya").attr("disabled", "disabled");
                    HideElement_cancel();
                }
            },
            error: function (html) {
                alert(html.error);
            }
        });
    }

    function add_vul(eventObj) {
        $.ajax({
            type: "POST",
            url: "vladd.php",
            data: 'rajon3=' + $("#rayon3").val() + '&nsp3=' + $("#nas_punkt3").val() + '&vul3=' + $("#vul3").val() + '&tup3=' + $("#tup3").val(),
            dataType: "html",
            success: function (html) {
                var rp = html;
                if (rp == '1') {
                    $("#rayon :nth-child(1)").attr("selected", "selected");
                    $("#nas_punkt").empty();
                    $("#vulutsya").empty();
                    $("#nas_punkt").attr("disabled", "disabled");
                    $("#vulutsya").attr("disabled", "disabled");
                    HideElement_cancel();
                }
            },
            error: function (html) {
                alert(html.error);
            }
        });
    }*/
</script>

<body>
<div id="add_nas_punkt">
    <table>
        <tr>
            <th colspan="2">Додавання нового нас. пункту</th>
        </tr>
        <tr>
            <td colspan="2">
                Район<br>
                <select class="sel_ad" id="rayon2" name="rajon2">
                    <option value="0">Оберіть район</option>
                    <?php
                    $id_rn = '';
                    $rajn = '';
                    $sql = "SELECT rayonu.ID_RAYONA,rayonu.RAYON FROM rayonu ORDER BY rayonu.ID_RAYONA";
                    $atu = mysql_query($sql);
                    while ($aut = mysql_fetch_array($atu)) {
                        $dl_s = strlen($aut["RAYON"]) - 10;
                        $n_rjn = substr($aut["RAYON"], 0, $dl_s);
                        echo '<option ' . $sl[$aut["ID_RAYONA"]] . ' value="' . $aut["ID_RAYONA"] . '">' . $n_rjn . '</option>';
                    }
                    mysql_free_result($atu);
                    ?>
                </select></td>
        </tr>
        <tr>
            <td colspan="2">
                Назва населеного пункту<br><input type="text" id="nsp2" name="nsp2" value="" style="width:200px;"/><br>
                Тип населеного пункту<br>
                <select id="tup2" name="tup2" class="sel_ad">
                    <option value="0">Оберіть тип</option>
                    <?php
                    $sql = "SELECT tup_nsp.ID_TIP_NSP,tup_nsp.TIP_NSP FROM tup_nsp ORDER BY tup_nsp.ID_TIP_NSP";
                    $atu = mysql_query($sql);
                    while ($aut = mysql_fetch_array($atu)) {
                        echo '<option value="' . $aut["ID_TIP_NSP"] . '">' . $aut["TIP_NSP"] . '</option>';
                    }
                    mysql_free_result($atu);
                    ?>
                </select>
            </td>
        </tr>
        <tr>
            <td align="center">
                <input type="button" id="add_ns" name="ok" style="width:80px;margin-top:15px;" value="Ок">
            </td>
            <td align="center">
                <input type="button" class="bt" style="width:80px;margin-top:15px;" value="Вiдмiна">
            </td>
        </tr>
    </table>
</div>

<div id="add_vul">
    <table>
        <tr>
            <th colspan="2">Додавання нової вулиці</th>
        </tr>
        <tr>
            <td colspan="2">
                Район<br>
                <select class="sel_ad" id="rayon3" name="rajon3">
                    <option value="0">Оберіть район</option>
                    <?php
                    $id_rn = '';
                    $rajn = '';
                    $sql = "SELECT rayonu.ID_RAYONA,rayonu.RAYON FROM rayonu ORDER BY rayonu.ID_RAYONA";
                    $atu = mysql_query($sql);
                    while ($aut = mysql_fetch_array($atu)) {
                        $dl_s = strlen($aut["RAYON"]) - 10;
                        $n_rjn = substr($aut["RAYON"], 0, $dl_s);
                        echo '<option ' . $sl[$aut["ID_RAYONA"]] . ' value="' . $aut["ID_RAYONA"] . '">' . $n_rjn . '</option>';
                    }
                    mysql_free_result($atu);
                    ?>
                </select>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                Населений пункт: <br><select class="sel_ad" id="nas_punkt3" name="nsp3" disabled="disabled"></select>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                Назва<br><input type="text" size="25" id="vul3" name="vul3" value="" style="width:200px"/>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                Тип<br>
                <select id="tup3" name="tup3" class="sel_ad">
                    <option value="0">Оберіть тип</option>
                    <?php
                    $sql = "SELECT tup_vul.ID_TIP_VUL,tup_vul.TIP_VUL FROM tup_vul ORDER BY tup_vul.ID_TIP_VUL";
                    $atu = mysql_query($sql);
                    while ($aut = mysql_fetch_array($atu)) {
                        echo '<option value="' . $aut["ID_TIP_VUL"] . '">' . $aut["TIP_VUL"] . '</option>';
                    }
                    mysql_free_result($atu);
                    ?>
                </select>
            </td>
        </tr>
        <tr>
            <td align="center">
                <input type="button" id="add_vl" name="ok" style="width:80px;margin-top:15px;" value="Ок">
            </td>
            <td align="center">
                <input type="button" class="bt" style="width:80px;margin-top:15px;" value="Вiдмiна">
            </td>
        </tr>
    </table>
</div>

<?php
	$sql1 = "SELECT * FROM `arhiv_dop_adr` WHERE ID = ".$kl;
    // echo $sql1;
    $atu1 = mysql_query($sql1);
    while ($aut1 = mysql_fetch_array($atu1)) {
        $rn = $aut1["rn"];
		$nsp =  $aut1["ns"];
		$vl = $aut1["vl"];
		$bd = $aut1["bud"];
		$kv = $aut1["kvar"];
		//var_dump($aut1);		
	}
	echo '
	<input id="id_rn" name="id_rn" type="hidden" value="'.$rn.'">
	<input id="id_nsp" name="id_nsp" type="hidden" value="'.$nsp.'">
	<input id="id_vl" name="id_vl" type="hidden" value="'.$vl.'">';
?>


<form action="update_dop_adr.php" name="myform" method="post">
    <table align="" class="zmview">
        <tr>
            <th colspan="4" style="font-size: 35px;"><b>Редагувати адрес</b></th>
        </tr>
        <tr>
            <td>Район:</td>
            <td colspan="3">
                <div class="border">
                    <select class="sel_ad" id="rayon" name="rajon" required>
                        <option value="">Оберіть район</option>
                        <?php
                        $id_rn = '';
                        $rajn = '';
                        $sql = "SELECT rayonu.ID_RAYONA,rayonu.RAYON FROM rayonu ORDER BY rayonu.ID_RAYONA";
                        $atu = mysql_query($sql);
                        while ($aut = mysql_fetch_array($atu)) {
                            $dl_s = strlen($aut["RAYON"]) - 10;
                            $n_rjn = substr($aut["RAYON"], 0, $dl_s);
							if ($rn == $aut["ID_RAYONA"] ) $s='selected="selected"'; else $s='';
                            echo '<option ' . $sl[$aut["ID_RAYONA"]] . ' value="' . $aut["ID_RAYONA"] . '" '.$s.' >' . $n_rjn . '</option>';
                        }
                        mysql_free_result($atu);
                        ?>
                    </select>
                </div>
            </td>
        </tr>
        <tr>
            <td>Населений пункт:</td>
            <td colspan="3">
                <div class="border">
                    <select class="sel_ad" id="nas_punkt" name="nsp" required>
					</select>
                    <input type="button" id="bt1" value="Додати нас. пункт" style="width:125px;"/>
                </div>
            </td>
        </tr>
        <tr>
            <td>Вулиця:</td>
            <td colspan="3">
                <div class="border">
                    <select class="sel_ad" id="vulutsya" name="vyl" disabled="disabled" required></select>
                    <input type="button" id="bt2" value="Додати вулицю" style="width:125px;"/>
                </div>
            </td>
        </tr>
        <tr>
            <td>Будинок:</td>
            <td>
                <input type="text" id="bd" size="10" name="bud" value="<?php echo $bd;?>" required/>
                <input type="hidden" name="kl" value="<?= $kl ?>">
            </td>
            <td>Квартира:</td>
            <td><input type="text" id="kv" size="3" maxlength="3" name="kvar" value="<?php echo $kv;?>"/></td>
        </tr>
        <tr>
            <td colspan="4" align="center">
                <div id="fizpl"><input type="submit" id="submit" value="Додати"></div>
            </td>
        </tr>
    </table>
</form>