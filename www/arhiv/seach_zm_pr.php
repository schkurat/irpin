<?php
include "./scriptu.php";
?>
<form action="arhiv.php" name="myform" method="get">
    <table align="center" class="zmview">
        <tr>
            <th colspan="4" align="center">Замовлення за період</th>
        </tr>
        <tr>
            <td>Період</td>
            <td>
                <input name="npr" class="datepicker" type="text" size="10" maxlength="10" value="<?php echo date("d.m.Y"); ?>"/>
                -
                <input name="kpr" class="datepicker" type="text" size="10" maxlength="10" value="<?php echo date("d.m.Y"); ?>"/>
                <input name="filter" type="hidden" value="zm_view"/>
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
                    $sql = "SELECT * FROM arhiv_jobs ORDER BY name";
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
            <td align="center">
                <input name="Ok" type="submit" value="Пошук"/></td>
</form>
<form action="arhiv.php?filter=logo" name="myform" method="post">
    <td align="center">
        <input name="Cancel" type="submit" value="Відміна"/>
</form>
</td>
</tr>
</table>