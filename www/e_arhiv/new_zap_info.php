<?php
//include "../function.php";
include "../scriptu.php";
?>
<form action="earhiv.php" name="myform" method="get">
    <table align="center" class="zmview">
        <tr>
            <th colspan="2"><b>Електронна справа</b></th>
        </tr>
        <tr>
            <td>Серія замовлення</td>
            <td>
                <input type="text" name="sz" value="<?= date("dmy") ?>" maxlength="6" required/>
            </td>
        </tr>
        <tr>
            <td>Номер замовлення</td>
            <td>
                <input type="text" size="20" name="nz" value="" required/>
                <input type="hidden" size="20" name="filter" value="spr_view" required/>
            </td>
        </tr>
        <tr>
            <td align="center"><input type="submit" id="submit" value="Ок" style="width:79px"></td>
            <td align="center"><input name="reset" type="reset" id="reset" value="Очистити"></td>
        </tr>
    </table>
</form>