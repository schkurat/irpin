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
            <td>Оберіть район</td>
            <td>
                <select class="sel_ad" id="rayon" name="rayon">
                    <option value="0">Всі райони</option>
                    <?php
                    $sql = "SELECT rayonu.ID_RAYONA,rayonu.RAYON FROM rayonu ORDER BY rayonu.ID_RAYONA";
                    $atu = $db->db_link->query($sql);
                    while ($aut = $atu->fetch_array(MYSQLI_ASSOC)) {
                        $dl_s = strlen($aut["RAYON"]) - 10;
                        $n_rjn = substr($aut["RAYON"], 0, $dl_s);
                        echo '<option value="' . $aut["ID_RAYONA"] . '">' . $n_rjn . '</option>';
                    }
                    $atu->free_result();
                    ?>
                </select>
                <input type="hidden" size="20" name="filter" value="arh_view" required/>
            </td>
        </tr>
        <tr>
            <td align="center" colspan="2"><input type="submit" id="submit" value="Ок" style="width:79px"></td>
        </tr>
    </table>
</form>