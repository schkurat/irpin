<?php
include_once "../function.php";
$tp = $_GET['tip'];
$kl = $_GET['kl'];
$taks = 0;

$sql = "SELECT SZ,NZ,RN FROM zamovlennya WHERE zamovlennya.KEY='$kl'";
$atu = mysql_query($sql);
while ($aut = mysql_fetch_array($atu)) {
    $sz = $aut["SZ"];
    $nz = $aut["NZ"];
    $rn = $aut["RN"];
}
mysql_free_result($atu);
$order = get_num_order($rn, $sz, $nz);

//$sql = "SELECT * FROM taks WHERE taks.IDZM='$kl' AND taks.DL='1'";
//$atu = mysql_query($sql);
//$taks = mysql_num_rows($atu);
//mysql_free_result($atu);

$sql = "SELECT SUM(SM) AS SM FROM kasa WHERE kasa.SZ='$sz' AND kasa.NZ='$nz' AND kasa.DL='1'";
$atu = mysql_query($sql);
while ($aut = mysql_fetch_array($atu)) {
    $sm = $aut["SM"];
}
mysql_free_result($atu);
//var_dump($sm);
?>
<table class="zmview">
    <tr>
        <th>Видалення замовлення</th>
    </tr>
    <?php
    if ($sm > 0) {
        ?>
        <tr>
            <td>Замовлення <?= $order ?> неможливо видалити!</td>
        </tr>
        <tr>
            <td align="center">
                <a href="index.php?filter=zm_view"><input name="cancel" type="button" value="OK"></a></td>
        </tr>
        <?php
    } else {
        ?>
        <tr>
            <td>Ви дійсно бажаєте видалити замовлення <?= $order ?></td>
        </tr>
        <tr>
            <td align="center">
                <a href="delete_zm.php?tip=<?= $tp ?>&kl=<?= $kl ?>"><input name="cancel" type="button"
                                                                              value="Ок"></a>
                <a href="index.php?filter=zm_view"><input name="cancel" type="button" value="Відміна"></a>
            </td>
        </tr>
        <?php
    }
    ?>
</table>
