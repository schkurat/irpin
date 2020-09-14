<?php
include "./scriptu.php";
include "../function.php";
$frn = get_filter_for_rn($drn,'rayonu','ID_RAYONA');
?>
<form action="arhiv.php" name="myform" method="get">
    <table align="center" class="zmview">
        <tr>
            <th colspan="4" align="center">Замовлення за період</th>
        </tr>
        <tr>
            <td>Період</td>
            <td>
                <input name="npr" class="datepicker" type="text" size="10" maxlength="10"
                       value="<?php echo date("d.m.Y"); ?>"/>
                -
                <input name="kpr" class="datepicker" type="text" size="10" maxlength="10"
                       value="<?php echo date("d.m.Y"); ?>"/>
                <input name="filter" type="hidden" value="zm_view"/>
            </td>
        </tr>
        <tr>
            <td>
                Тип замовлення
            </td>
            <td>
                <input id="r1" type="radio" name="vud_zam" value="1" /><label for="r1">Фізичне</label>
                <input id="r2" type="radio" name="vud_zam" value="2" /><label for="r2">Юридичне</label>
                <input id="r3" type="radio" name="vud_zam" value="3" checked/><label for="r3">Всі</label>
            </td>
        </tr>
        <tr>
            <td>
                Тип справи
            </td>
            <td>
                <select name="posluga">
                    <option value=""></option>
                    <?php
                    $p = '';
                    $sql = "SELECT * FROM arhiv_jobs WHERE DL='1' ORDER BY name";
                    $atu = mysql_query($sql);
                    while ($aut = mysql_fetch_array($atu)) {
                        $p .= '<option value="' . $aut["id"] . '">' . $aut["name"] . '</option>';
                    }
                    mysql_free_result($atu);
                    $p .= '</select>';
                    echo $p;
                    ?>
            </td>
        </tr>
        <tr>
            <td>Район</td>
            <td>
                <select name="rayon">
                    <option value=""></option>
                    <?php
                    $p = '';
                    $sql = "SELECT * FROM rayonu WHERE " . $frn . " ORDER BY RAYON";
                    $atu = mysql_query($sql);
                    while ($aut = mysql_fetch_array($atu)) {
                        $dl_s = strlen($aut["RAYON"]) - 10;
                        $n_rjn = substr($aut["RAYON"], 0, $dl_s);
                        $p .= '<option value="' . $aut["ID_RAYONA"] . '">' . $n_rjn . '</option>';
                    }
                    mysql_free_result($atu);
                    $p .= '</select>';
                    echo $p;
                    ?>
            </td>
        </tr>
        <tr>
            <td align="center" colspan="2">
                <input name="Ok" type="submit" value="Пошук"/></td>
            </td>
        </tr>
    </table>
</form>