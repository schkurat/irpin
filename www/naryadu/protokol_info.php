<?php
include "../scriptu.php";
?>
<form action="print_protokol.php" name="myform" method="get">
    <table align="center" class="zmview">
        <tr>
            <th colspan="2" align="center">Протокол обробки каси</th>
        </tr>
<!--        <tr>-->
<!--            <td>Дата обробки</td>-->
<!--            <td><input name="dt_obr" type="text" size="10" maxlength="10" value="--><?php //echo date("d.m.Y"); ?><!--"/></td>-->
<!--        </tr>-->

        <tr>
            <td>Період з
                <input name="date_start" type="text" class="datepicker" size="10" maxlength="10"
                       value="<?php echo date("d.m.Y"); ?>"/></td>
            <td>по <input name="date_end" type="text" class="datepicker" size="10" maxlength="10"
                          value="<?php echo date("d.m.Y"); ?>"/>
            </td>
        </tr>
        <tr>
            <td align="center">
                <input name="Ok" type="submit" style="width:80px" value="Формувати"/></td>
</form>
<form action="naryadu.php" name="myform" method="post">
    <td align="center">
        <input name="Cancel" type="submit" style="width:80px" value="Відміна"/>
</form>
</td>
</tr>
</table>
