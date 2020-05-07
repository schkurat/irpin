<?php
include "../function.php";
include "scriptu.php";
?>
<body>
<?php

if (!empty($_GET['adr_id'])) {
    $id = $_GET['adr_id'];
    $sql = "SELECT arhiv_dop_adr.rn, arhiv_dop_adr.ns, arhiv_dop_adr.vl, arhiv_dop_adr.bud, arhiv_dop_adr.kvar, arhiv_dop_adr.status,  rayonu.RAYON,  vulutsi.VUL,   nas_punktu.NSP,   tup_nsp.TIP_NSP,  tup_vul.TIP_VUL 
			FROM `arhiv_dop_adr`, `rayonu`,`vulutsi`,`nas_punktu` , `tup_nsp`, `tup_vul`
			WHERE arhiv_dop_adr.id = " . $id . "
			AND arhiv_dop_adr.rn = rayonu.ID_RAYONA
			AND arhiv_dop_adr.ns = nas_punktu.ID_NSP
			AND arhiv_dop_adr.vl = vulutsi.ID_VUL
			AND vulutsi.ID_TIP_VUL = tup_vul.ID_TIP_VUL
			AND nas_punktu.ID_TIP_NSP = tup_nsp.ID_TIP_NSP ";


    $atu1 = mysql_query($sql);
    while ($aut1 = mysql_fetch_array($atu1)) {
        $id_rn = $aut1["rn"];
        $rn = $aut1["RAYON"];
        $id_nsp = $aut1["ns"];
        $nsp = $aut1["NSP"];
        $id_vl = $aut1["vl"];
        $vl = $aut1["VUL"];
        $bd = $aut1["bud"];
        $kv = $aut1["kvar"];
        //var_dump($aut1);
    }

    $sql2 = "SELECT * FROM `arhiv` WHERE `RN`=$id_rn AND `NS` = $id_nsp AND `VL` = $id_vl AND `KV` = '$kv' AND `BD` = '$bd' AND DL = 1";
    //echo $sql2;
    $atu2 = mysql_query($sql2);
    $count = mysql_affected_rows();
    //echo $count;
    if ($count == 0) {

        $sql5 = "UPDATE `kpbti`.`arhiv_dop_adr` SET `status` = 1, `comment` = '" . $com . "' WHERE id = " . $id;
        $atu5 = mysql_query($sql5);
        $max = 0;
        $sql3 = "SELECT N_SPR FROM `arhiv` WHERE `RN`=$id_rn AND DL = 1";
        //echo $sql3;
        $atu3 = mysql_query($sql3);
        while ($aut3 = mysql_fetch_array($atu3)) {
            $temp = intval($aut3["N_SPR"]);
            if ($temp > $max) $max = $temp;
        }
        $nspr = str_pad($max + 1, 7, "0", STR_PAD_LEFT);
        $sql4 = "INSERT INTO  `kpbti`.`arhiv` (`N_SPR`,`RN`,`NS`,`VL`,`BD`,`KV`) VALUES (\"" . $nspr . "\",$id_rn,$id_nsp,$id_vl,\"" . $bd . "\",\"" . $kv . "\" )";
        //echo $sql4;
        $atu4 = mysql_query($sql4);
        $id = mysql_insert_id();

    } else {
        $sql5 = "UPDATE `kpbti`.`arhiv_dop_adr` SET `status` = 1, PV='1', PV_DATE=NOW(), `comment` = '" . $com . "' WHERE id = " . $id;
        $atu5 = mysql_query($sql5);
        $sql2 = "SELECT * FROM `arhiv` WHERE `RN`=$id_rn AND `NS` = $id_nsp AND `VL` = $id_vl AND `KV` = '$kv' AND `BD` = '$bd' AND DL = 1";
        $atu2 = mysql_query($sql2);
        while ($aut2 = mysql_fetch_array($atu2)) {
            //var_dump($aut2);
            $id = $aut2["ID"];

            $nspr = $aut2["N_SPR"];
            if ($nspr == '') {
                $max = 0;
                $sql3 = "SELECT N_SPR FROM `arhiv` WHERE `RN`=$id_rn AND DL = 1";
                //echo $sql3;
                $atu3 = mysql_query($sql3);
                while ($aut3 = mysql_fetch_array($atu3)) {
                    $temp = intval($aut3["N_SPR"]);
                    if ($temp > $max) $max = $temp;
                }
                $nspr = str_pad($max + 1, 7, "0", STR_PAD_LEFT);
            }


            $prim = htmlspecialchars($aut2["PRIM"], ENT_QUOTES);

            $name = htmlspecialchars($aut2["NAME"], ENT_QUOTES);
            $vlas = htmlspecialchars($aut2["VLASN"], ENT_QUOTES);
            $sklchast = htmlspecialchars($aut2["SKL_CHAST"], ENT_QUOTES);
            $kadnam = htmlspecialchars($aut2["KAD_NOM"], ENT_QUOTES);

            $plzm = $aut2["PL_ZEM"];
            $plzg = $aut2["PL_ZAG"];
            $pljt = $aut2["PL_JIT"];
            $pldp = $aut2["PL_DOP"];

            $fdi = $aut2["FIRST_DT_INV"];
            $fv = htmlspecialchars($aut2["FIRST_VUK"], ENT_QUOTES);
            $no = $aut2["NUMB_OBL"];
            $do = $aut2["DT_OBL"];
        }
        $sql5 = "UPDATE `arhiv` SET `N_SPR` = '$nspr' WHERE id = " . $id;
        $atu5 = mysql_query($sql5);
    }
} else {
    if (!empty($_GET['zap_id'])) {
        $id = $_GET['zap_id'];
        $sql = "SELECT `arhiv`.*, rayonu.RAYON,  vulutsi.VUL,   nas_punktu.NSP,   tup_nsp.TIP_NSP,  tup_vul.TIP_VUL  
		FROM `arhiv`, `rayonu`,`vulutsi`,`nas_punktu` , `tup_nsp`, `tup_vul` 
		WHERE id = $id AND DL = 1
		AND arhiv.rn = rayonu.ID_RAYONA
		AND arhiv.ns = nas_punktu.ID_NSP
		AND arhiv.vl = vulutsi.ID_VUL
		AND vulutsi.ID_TIP_VUL = tup_vul.ID_TIP_VUL
		AND nas_punktu.ID_TIP_NSP = tup_nsp.ID_TIP_NSP
		
		
		";
        //echo $sql;
        $atu = mysql_query($sql);
        while ($aut2 = mysql_fetch_array($atu)) {
            //var_dump($aut2);
            $id = $aut2["ID"];

            $id_rn = $aut2["rn"];
            $rn = $aut2["RAYON"];
            $id_nsp = $aut2["ns"];
            $nsp = $aut2["NSP"];
            $id_vl = $aut2["vl"];
            $vl = $aut2["VUL"];
            $bd = $aut2["BD"];
            $kv = $aut2["KV"];

            $nspr = $aut2["N_SPR"];
            $prim = htmlspecialchars($aut2["PRIM"], ENT_QUOTES);

            $name = htmlspecialchars($aut2["NAME"], ENT_QUOTES);
            $vlas = htmlspecialchars($aut2["VLASN"], ENT_QUOTES);
            $sklchast = htmlspecialchars($aut2["SKL_CHAST"], ENT_QUOTES);
            $kadnam = htmlspecialchars($aut2["KAD_NOM"], ENT_QUOTES);

            $plzm = $aut2["PL_ZEM"];
            $plzg = $aut2["PL_ZAG"];
            $pljt = $aut2["PL_JIT"];
            $pldp = $aut2["PL_DOP"];

            $fdi = $aut2["FIRST_DT_INV"];
            $fv = htmlspecialchars($aut2["FIRST_VUK"], ENT_QUOTES);
            $no = $aut2["NUMB_OBL"];
            $do = $aut2["DT_OBL"];
        }
    }


}

?>
<form action="add_zap.php" name="myform" method="post">
    <input id="id" name="id" type="hidden" value="<?php echo $id; ?>">
    <table align="center" class="zmview">
        <tr>
            <th colspan="2"><b>Реєстрація нової справи</b></th>
        </tr>
        <tr>
            <td>Інвентареий номер</td>
            <td><input type="text" size="20" maxlength="6" name="inv_number" value="<?php echo $nspr; ?>" readonly/>
            </td>
        </tr>
        <tr>
            <td>Район:</td>
            <td colspan="3">
                <div class="border">
                    <input type="text" size="20" maxlength="20" name="rayon" value="<?php echo $rn; ?>" readonly/>
                </div>
            </td>
        </tr>
        <tr>
            <td>Населений пункт</td>
            <td>
                <div class="border">
                    <!--<select class="sel_ad" id="nas_punkt" name="nsp" required>
<option value="">Оберіть населений пункт</option>
<?php
                    $sql = "SELECT nas_punktu.ID_NSP,nas_punktu.NSP,tup_nsp.TIP_NSP 
		FROM nas_punktu,tup_nsp 
		WHERE nas_punktu.ID_TIP_NSP=tup_nsp.ID_TIP_NSP 
		ORDER BY nas_punktu.ID_NSP";
                    $atu = mysql_query($sql);
                    while ($aut = mysql_fetch_array($atu)) {
                        echo '<option value="' . $aut["ID_NSP"] . '">' . $aut["NSP"] . ' ' . $aut["TIP_NSP"] . '</option>';
                    }
                    mysql_free_result($atu);
                    ?>
</select>-->
                    <input type="text" size="20" maxlength="20" name="nsp" value="<?php echo $nsp; ?>" readonly/>
                </div>
            </td>
        </tr>
        <tr>
            <td>Вулиця</td>
            <td>
                <div class="border">
                    <!--<select class="sel_ad" id="vulutsya" name="vyl" disabled="disabled"></select>-->
                    <input type="text" size="20" maxlength="20" name="vul" value="<?php echo $vl; ?>" readonly/>
                </div>
            </td>
        </tr>
        <tr>
            <td>Будинок</td>
            <td><input type="text" size="20" maxlength="20" name="bud" value="<?php echo $bd; ?>" readonly/></td>
        </tr>
        <tr>
            <td>Квартира</td>
            <td><input type="text" size="4" maxlength="4" name="kv" value="<?php echo $kv; ?>" readonly/></td>
        </tr>
        <tr>
            <td>Примітка</td>
            <td><input type="text" size="50" maxlength="100" name="prum" value="<?php echo $prim; ?>"/></td>
        </tr>
        <tr>
            <th colspan="2"><b>Об'єкт</b></th>
        </tr>
        <tr>
            <td>Назва</td>
            <td><input type="text" size="50" name="nameobj" value="<?php echo $name; ?>"/></td>
        </tr>
        <tr>
            <td>Власники</td>
            <td><input type="text" size="50" name="vlasn" value="<?php echo $vlas; ?>"/></td>
        </tr>
        <tr>
            <td>Складові частини</td>
            <td><input type="text" size="50" name="skl_chast" value="<?php echo $sklchast; ?>"/></td>
        </tr>
        <tr>
            <td>Кадастровий номер</br>земельної ділянки</td>
            <td><input type="text" size="50" name="kad_nom" value="<?php echo $kadnam; ?>"/></td>
        </tr>
        <tr>
            <th colspan="2"><b>Площа</b></th>
        </tr>
        <tr>
            <td>Земельної ділянки</td>
            <td><input type="text" name="plzem" value="<?php echo $plzm; ?>"/></td>
        </tr>
        <tr>
            <td>Загальна</td>
            <td><input type="text" name="plzag" value="<?php echo $plzg; ?>"/></td>
        </tr>
        <tr>
            <td>Житлова</td>
            <td><input type="text" name="pljit" value="<?php echo $pljt; ?>"/></td>
        </tr>
        <tr>
            <td>Допоміжна</td>
            <td><input type="text" name="pldop" value="<?php echo $pldp; ?>"/></td>
        </tr>
        <tr>
            <th colspan="2"><b>Первинна інвентаризація</b></th>
        </tr>
        <tr>
            <td>Дата</td>
            <td><input type="text" size="10" maxlength="10" name="dt_perv" value="<?php echo german_date($fdi); ?>"/>
            </td>
        </tr>
        <tr>
            <td>Виконавець</td>
            <td><input type="text" size="50" name="vk_perv" value="<?php echo $fv; ?>"/></td>
        </tr>
        <tr>
            <th colspan="2"><b>Прийняття на облік</b></th>
        </tr>
        <tr>
            <td>Номер</td>
            <td><input type="text" name="numb_obl" value="<?php echo $no; ?>"/></td>
        </tr>
        <tr>
            <td>Дата</td>
            <td><input type="text" size="10" maxlength="10" name="dt_obl" value="<?php echo german_date($do); ?>"/></td>
        </tr>
        <tr>
            <td colspan="2" align="center">
                <input type="submit" id="submit" value="Зберегти" style="margin-right:50px;">
                <input name="reset" type="reset" id="reset" value="Очистити">
            </td>
        </tr>
    </table>
</form>