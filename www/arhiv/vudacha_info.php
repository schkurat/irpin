<?php
    include("../function.php");
    $idArhivZakaz = $_GET["kl"];
    $arh_Number = getArhNumber($idArhivZakaz);
    if($arh_Number == null){
        $serial = getSerial();
        $nexArhNum = nexArhNumber($serial);
        $invNumber = $serial.".".$nexArhNum;
    }
?>
<form action="vudacha.php" name="myform" method="post">
<table align="center" class="zmview">
<tr><th colspan="4" align="center">Видача справи</th></tr>
<tr>
<td>Інвентарний номер</td>
<td><input name="inv_number" type="text" size="20" value="<?php echo $invNumber; ?>" />
    <input type="hidden" name="kl" value="<?php echo $idArhivZakaz; ?>">
</td>
</tr>
<tr>
<td>Старий інвентарний номер</td>
<td><input name="old_inv_number" type="text" size="20" />
</td>
</tr>
<tr><td align="center" colspan="2">
<input name="Ok" type="submit" value="Видати" /></td>
</tr>
</table>
</form>