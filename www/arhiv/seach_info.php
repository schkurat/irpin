<?php
include "../function.php";
include "../scriptu.php";
?>

<script type="text/javascript">
    $(document).ready(function () {
        $("input[ name='rj_saech']").change(radio_click)
    });

    function radio_click() {
        if ($("input[name='rj_saech']:checked").val() == "n_spr") {
            $("#id_spr").attr("disabled", false);
            $("#id_bd").attr("disabled", "disabled");
            $("#id_kv").attr("disabled", "disabled");
            $("#id_prim").attr("disabled", "disabled");
            $("#id_vlasn").attr("disabled", "disabled");
            $("#id_kadn").attr("disabled", "disabled");
            $("#id_obln").attr("disabled", "disabled");
        }
        if ($("input[name='rj_saech']:checked").val() == "adr") {
            $("#id_spr").attr("disabled", "disabled");
            $("#id_bd").attr("disabled", false);
            $("#id_kv").attr("disabled", false);
            $("#id_prim").attr("disabled", "disabled");
            $("#id_vlasn").attr("disabled", "disabled");
            $("#id_kadn").attr("disabled", "disabled");
            $("#id_obln").attr("disabled", "disabled");
        }
        if ($("input[name='rj_saech']:checked").val() == "prim") {
            $("#id_spr").attr("disabled", "disabled");
            $("#id_bd").attr("disabled", "disabled");
            $("#id_kv").attr("disabled", "disabled");
            $("#id_prim").attr("disabled", false);
            $("#id_vlasn").attr("disabled", "disabled");
            $("#id_kadn").attr("disabled", "disabled");
            $("#id_obln").attr("disabled", "disabled");
        }
        if ($("input[name='rj_saech']:checked").val() == "vlasn") {
            $("#id_spr").attr("disabled", "disabled");
            $("#id_bd").attr("disabled", "disabled");
            $("#id_kv").attr("disabled", "disabled");
            $("#id_prim").attr("disabled", "disabled");
            $("#id_vlasn").attr("disabled", false);
            $("#id_kadn").attr("disabled", "disabled");
            $("#id_obln").attr("disabled", "disabled");
        }
        if ($("input[name='rj_saech']:checked").val() == "kadn") {
            $("#id_spr").attr("disabled", "disabled");
            $("#id_bd").attr("disabled", "disabled");
            $("#id_kv").attr("disabled", "disabled");
            $("#id_prim").attr("disabled", "disabled");
            $("#id_vlasn").attr("disabled", "disabled");
            $("#id_kadn").attr("disabled", false);
            $("#id_obln").attr("disabled", "disabled");
        }
        if ($("input[name='rj_saech']:checked").val() == "obln") {
            $("#id_spr").attr("disabled", "disabled");
            $("#id_bd").attr("disabled", "disabled");
            $("#id_kv").attr("disabled", "disabled");
            $("#id_prim").attr("disabled", "disabled");
            $("#id_vlasn").attr("disabled", "disabled");
            $("#id_kadn").attr("disabled", "disabled");
            $("#id_obln").attr("disabled", false);
        }
    }
</script>

<body>
<form action="arhiv.php" name="myform" method="get">
    <input type="hidden" size="10" name="rejum" value="seach"/>
    <input type="hidden" size="10" name="filter" value="arh_view"/>
    <table align="center" class="zmview">
        <tr>
            <th colspan="3"><b>Пошук справи в журналі</b></th>
        </tr>
        <tr>
            <td><input id="r1" type="radio" name="rj_saech" value="n_spr"/><label for="r1">Номер справи</label></td>
            <td colspan="2"><input type="text" id="id_spr" name="n_spravu" value="" disabled/></td>
        </tr>
        <tr>
            <td rowspan="6"><input id="r2" type="radio" name="rj_saech" value="adr" checked/><label
                        for="r2">Адреса</label></td>
        </tr>
        <tr>
            <td colspan="2">
                <div class="border">
                    <select class="sel_ad" id="rayon" name="rajon">
                        <option value="">Оберіть район</option>
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
                </div>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <div class="border">
                    <select class="sel_ad" id="nas_punkt" name="nsp"></select>
                </div>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <div class="border">
                    <select class="sel_ad" id="vulutsya" name="vyl" disabled="disabled"></select>
                </div>
            </td>
        </tr>
        <tr>
            <td>Будинок</td>
            <td><input type="text" id="id_bd" size="20" maxlength="20" name="bud" value=""/></td>
        </tr>
        <tr>
            <td>Квартира</td>
            <td><input type="text" id="id_kv" size="4" maxlength="4" name="kv" value=""/></td>
        </tr>
        <tr>
            <td><input id="r3" type="radio" name="rj_saech" value="prim"/><label for="r3">Примітка</label></td>
            <td colspan="2"><input type="text" id="id_prim" size="40" maxlength="40" name="prum" value="" disabled/>
            </td>
        </tr>


        <tr>
            <td><input id="r4" type="radio" name="rj_saech" value="vlasn"/><label for="r4">Власник</label></td>
            <td colspan="2"><input type="text" id="id_vlasn" size="40" name="vlasnuk" value="" disabled/></td>
        </tr>
        <tr>
            <td><input id="r5" type="radio" name="rj_saech" value="kadn"/><label for="r5">Кадастровий номер</label></td>
            <td colspan="2"><input type="text" id="id_kadn" size="40" name="kad_n" value="" disabled/></td>
        </tr>
        <tr>
            <td><input id="r6" type="radio" name="rj_saech" value="obln"/><label for="r6">Обліковий номер</label></td>
            <td colspan="2"><input type="text" id="id_obln" size="40" name="obl_n" value="" disabled/></td>
        </tr>


        <tr>
            <td colspan="2" align="center"><input type="submit" id="submit" value="Пошук"></td>
            <td align="center"><input name="reset" type="reset" id="reset" value="Очистити"></td>
        </tr>
    </table>
</form>