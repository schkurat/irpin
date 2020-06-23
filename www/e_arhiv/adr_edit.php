<?php
include "../function.php";
include "scriptu.php";
$kl = (int)$_GET['kl'];
?>
<body>
<?php
$sql1 = "SELECT * FROM `arhiv` WHERE ID = " . $kl;
// echo $sql1;
$atu = $db->db_link->query($sql1);
while ($aut1 = $atu->fetch_array(MYSQLI_ASSOC)) {
    $n_spr = $aut1["N_SPR"];
    $rn = $aut1["RN"];
    $nsp = $aut1["NS"];
    $vl = $aut1["VL"];
    $bd = $aut1["BD"];
    $kv = $aut1["KV"];
}
$atu->free_result();
$inv = (!empty($n_spr))? str_pad($rn,2,'0', 0) . $n_spr : '';
echo '
	<input id="id_rn" name="id_rn" type="hidden" value="' . $rn . '">
	<input id="id_nsp" name="id_nsp" type="hidden" value="' . $nsp . '">
	<input id="id_vl" name="id_vl" type="hidden" value="' . $vl . '">';
?>
<form action="update_adr.php" name="myform" method="post">
    <table align="" class="zmview">
        <tr>
            <th colspan="4" style="font-size: 35px;"><b>Редагування запису</b></th>
        </tr>
        <td>Інвентарний номер</td>
        <td colspan="3"><input type="text" name="inv" value="<?= $inv ?>"></td>
        <tr>
            <td>Район:</td>
            <td colspan="3">
                <div class="border">
                    <select class="sel_ad" id="rayon" name="rajon" required>
                        <option value="">Оберіть район</option>
                        <?php
                        $id_rn = '';
                        $rajn = '';
                        $sql = "SELECT rayonu.ID_RAYONA,rayonu.RAYON FROM rayonu ORDER BY rayonu.ID_RAYONA";
                        $atu = $db->db_link->query($sql);
                        while ($aut = $atu->fetch_array(MYSQLI_ASSOC)) {
                            $dl_s = strlen($aut["RAYON"]) - 10;
                            $n_rjn = substr($aut["RAYON"], 0, $dl_s);
                            if ($rn == $aut["ID_RAYONA"]) $s = 'selected="selected"'; else $s = '';
                            echo '<option value="' . $aut["ID_RAYONA"] . '" ' . $s . ' >' . $n_rjn . '</option>';
                        }
                        $atu->free_result();
                        ?>
                    </select>
                </div>
            </td>
        </tr>
        <tr>
            <td>Населений пункт:</td>
            <td colspan="3">
                <div class="border">
                    <select class="sel_ad" id="nas_punkt" name="nsp" required></select>
                </div>
            </td>
        </tr>
        <tr>
            <td>Вулиця:</td>
            <td colspan="3">
                <div class="border">
                    <select class="sel_ad" id="vulutsya" name="vyl" disabled="disabled" required></select>
                </div>
            </td>
        </tr>
        <tr>
            <td>Будинок:</td>
            <td>
                <input type="text" id="bd" size="10" name="bud" value="<?php echo $bd; ?>" required/>
                <input type="hidden" name="kl" value="<?= $kl ?>">
            </td>
            <td>Квартира:</td>
            <td><input type="text" id="kv" size="3" maxlength="3" name="kvar" value="<?php echo $kv; ?>"/></td>
        </tr>
        <tr>
            <td colspan="4" align="center">
                <div id="fizpl"><input type="submit" id="submit" value="Змінити"></div>
            </td>
        </tr>
    </table>
</form>