<?php
include "./scriptu.php";
?>
<form action="arhiv.php" name="myform" method="get">
    <table align="center" class="zmview">
        <tr>
            <th colspan="4" align="center">Історія по суб'єкту за період</th>
        </tr>
        <tr>
            <td>Період</td>
            <td>
                <input name="npr" class="datepicker" type="text" size="10" maxlength="10"
                       value="<?php echo date("d.m.Y"); ?>"/>
                -
                <input name="kpr" class="datepicker" type="text" size="10" maxlength="10"
                       value="<?php echo date("d.m.Y"); ?>"/>
                <input name="filter" type="hidden" value="history"/>
            </td>
        </tr>
        <tr>
            <td>
                Суб'єкт
            </td>
            <td>
                <select name="subj">
                    <option value=""></option>
                    <?php
                    $p = '';
                    $sql = "SELECT `NAME`,`EDRPOU` FROM `yur_kl` WHERE DL='1' ORDER BY name";
                    $atu = mysql_query($sql);
                    while ($aut = mysql_fetch_array($atu)) {
                        $p .= '<option value="' . $aut["EDRPOU"] . '">' . $aut["NAME"] . '</option>';
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
        </tr>
    </table>
</form>