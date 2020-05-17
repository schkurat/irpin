<?php
include "../scriptu.php";
include_once "../function.php";
$frn = get_filter_for_rn($drn, 'rayonu', 'ID_RAYONA');
?>
<form action="index.php" name="myform" method="get">
    <table align="center" class="zmview">
        <tr>
            <th colspan="4" align="center">Пошук по за адресою</th>
        </tr>
        <tr>
            <td>Район:</td>
            <td colspan="3">
                <div class="border">
                    <select class="sel_ad" id="rayon" name="rajon">
                        <option value="">Оберіть район</option>
                        <?php
                        $id_rn = '';
                        $rajn = '';
                        $sql = "SELECT rayonu.ID_RAYONA,rayonu.RAYON FROM rayonu WHERE " . $frn . " ORDER BY rayonu.ID_RAYONA";
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
            <td>Будинок:</td>
            <td><input type="text" size="10" maxlength="10" name="bud" value=""/></td>
            <td>Квартира:</td>
            <td><input type="text" size="3" maxlength="3" name="kvar" value=""/>
                <input name="filter" type="hidden" value="zm_view"/>
            </td>
        </tr>
        <tr>
            <td colspan="2" align="center">
                <input name="Ok" type="submit" value="Пошук"/></td>
</form>
<form action="index.php" name="myform" method="post">
    <td colspan="2" align="center">
        <input name="Cancel" type="submit" value="Відміна"/>
</form>
</td>
</tr>
</table>