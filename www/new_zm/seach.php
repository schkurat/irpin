<?php
include "../scriptu.php";
$krit = (isset($_GET['krit'])) ? $_GET['krit'] : '';

?>
<form action="index.php" name="myform" method="get">
    <table align="center" class="zmview">
        <?php
        if ($krit == "zm") {
            ?>
            <tr>
                <th colspan="4" align="center">Пошук по номеру замовлення</th>
            </tr>
            <tr>
                <td>
                    Номер замовлення
                    <input name="filter" type="hidden" value="vudacha_view"/>
                    <input name="flag" type="hidden" value="zm"/>
                </td>
                <td><input name="n_zam" type="text" value=""/></td>
            </tr>
            <tr>
                <td align="center" colspan="2">
                    <input name="Ok" type="submit" value="Пошук"/></td>
            </tr>
            <?php
        }
        if ($krit == "adr") {
            ?>
            <tr>
                <th colspan="4" align="center">Пошук по за адресою</th>
            </tr>
            <tr>
                <td>Район:</td>
                <td colspan="3">
                    <div class="border">
                        <select class="sel_ad" id="rayon" name="rajon">
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
                    </div>
                </td>
            </tr>
            <tr>
                <td>Населений пункт:</td>
                <td colspan="3">
                    <div class="border">
                        <select class="sel_ad" id="nas_punkt" name="nsp" disabled="disabled"></select>
                    </div>
                </td>
            </tr>
            <tr>
                <td>Вулиця:</td>
                <td colspan="3">
                    <div class="border">
                        <select class="sel_ad" id="vulutsya" name="vyl" disabled="disabled"></select>
                    </div>
                </td>
            </tr>
            <tr>
                <td>Будинок:
                    <input name="flag" type="hidden" value="adres"/>
                    <input name="filter" type="hidden" value="vudacha_view"/>
                </td>
                <td><input type="text" size="10" maxlength="10" name="bud" value=""/></td>
                <td>Квартира:</td>
                <td><input type="text" size="3" maxlength="3" name="kvar" value=""/>
                </td>
            </tr>

            <tr>
                <td colspan="4" align="center">
                    <input name="Ok" type="submit" value="Пошук"/></td>
            </tr>
            <?php
        }
        ?>
    </table>
</form>