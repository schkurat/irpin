<?php
$tp = $_GET['tip'];
$kl = $_GET['kl'];

$sql = "SELECT SZ,NZ FROM arhiv_zakaz WHERE arhiv_zakaz.KEY='$kl'";
$atu = mysql_query($sql);
while ($aut = mysql_fetch_array($atu)) {
    $sz = $aut["SZ"];
    $nz = $aut["NZ"];
}
mysql_free_result($atu);

$sm = 0;
$sql = "SELECT SUM(SM) AS SM FROM arhiv_kasa WHERE arhiv_kasa.SZ='$sz' AND arhiv_kasa.NZ='$nz' AND arhiv_kasa.DL='1'";
$atu = mysql_query($sql);
while ($aut = mysql_fetch_array($atu)) {
    $sm = $aut["SM"];
}
mysql_free_result($atu);
?>
<table class="zmview">
    <tr>
        <th>Видалення замовлення</th>
    </tr>
    <?php
    if ($sm > 0) {
        ?>
        <tr>
            <td>Замовлення <?= $sz . '/' . $nz ?> неможливо видалити!</td>
        </tr>
        <tr>
            <td align="center">
                <a href="index.php?filter=zm_view"><input name="cancel" type="button" value="OK"></a></td>
        </tr>
        <?php
    } else {
        ?>
        <tr>
            <td>Ви дійсно бажаєте видалити замовлення <?= $sz . '/' . $nz ?> </td>
        </tr>
        <tr>
            <td align="center">
                <a href="delete_zm.php?tip=<?= $tp . '&kl=' . $kl ?>"><input name="cancel" type="button"
                                                                              value="Ок"></a>
                <a href="arhiv.php?filter=zm_view"><input name="cancel" type="button" value="Відміна"></a>
            </td>
        </tr>
        <?php
    }
    ?>
</table>
