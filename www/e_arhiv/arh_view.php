<?php
include_once "../function.php";

$flag = "";

$rej = (isset($_GET['rejum'])) ? $_GET['rejum'] : '';

if ($rej == "seach") {
    if (isset($_GET['info'])) {
        $info = $_GET['info'];
        $flag = "(LOCATE('" . $info . "',nas_punktu.NSP)!=0 OR LOCATE('" . $info . "',vulutsi.VUL)!=0 
		OR LOCATE('" . $info . "',arhiv.N_SPR)!=0) AND";
    }
}

$rayon = (isset($_GET['rayon']))? $_GET['rayon'] : '0';
$flag_rn = "";
if($rayon != 0){
    $flag_rn = " AND arhiv.RN = " . $rayon;
}

$frn = get_filter_for_rn($drn,'arhiv','RN');

$sql = "SELECT arhiv.ID,arhiv.N_SPR,arhiv.RN,rayonu.RAYON,nas_punktu.NSP,tup_nsp.TIP_NSP,vulutsi.VUL,tup_vul.TIP_VUL,arhiv.BD,arhiv.KV 
	FROM arhiv,rayonu,nas_punktu,vulutsi,tup_nsp,tup_vul 
	WHERE " . $flag . " arhiv.DL='1' " . $flag_rn . " AND (" . $frn . ") 
	AND rayonu.ID_RAYONA=arhiv.RN
	AND nas_punktu.ID_NSP=arhiv.NS 
	AND vulutsi.ID_VUL=arhiv.VL 
	AND tup_nsp.ID_TIP_NSP=nas_punktu.ID_TIP_NSP 
	AND tup_vul.ID_TIP_VUL=vulutsi.ID_TIP_VUL ORDER BY rayonu.RAYON,nas_punktu.NSP,vulutsi.VUL COLLATE utf8_unicode_ci";
//            echo $sql;
$atu = $db->db_link->query($sql);
$spr_number = $atu->num_rows;
if ($spr_number > 0){
?>
<style>
    .fal {
        padding: 5px 5px;
    }
    .fa-trash-alt {
        color: #ff0000;
    }
    .fa-pen-alt {
        color: #00e;
    }
</style>
<h3>Кількість справ: <?= $spr_number ?></h3>
<table align="center" class="zmview">
    <tr>
        <?php
        if ($ddl == '1') {
            ?>
            <th colspan="2">Дія</th>
            <?php
        }
        ?>
        <th>Номер справи</th>
        <th>Адреса</th>
    </tr>
    <?php
    while ($aut = $atu->fetch_array(MYSQLI_ASSOC)) {
        $obj_ner = objekt_ner(0, $aut["BD"], $aut["KV"]);
        $adr = $aut["RAYON"]. " " . $aut["TIP_NSP"] . $aut["NSP"] . " " . $aut["TIP_VUL"] . $aut["VUL"] . " " . $obj_ner;
        $inventory = (!empty($aut["N_SPR"])) ? str_pad($aut["RN"], 2, 0, STR_PAD_LEFT) . $aut["N_SPR"] : '';
        ?>
        <tr>
            <?php
            if ($ddl == '1') {
                ?>
                <td><a href="delete.php?kl=<?= $aut["ID"] ?>&rn=<?= $rayon ?>" onclick="return confirm('Ви дісно бажаєте видалити?') ? true : false;" title="Видалення"><i class="fal fa-trash-alt"></i></a></td>
                <td><a href="earhiv.php?filter=adr_edit&kl=<?= $aut["ID"] ?>&rn=<?= $rayon ?>" title="Редагувати адресу"><i class="fal fa-pen-alt"></i></a></td>
                <?php
            }
            ?>
            <td align="center"><?= $inventory ?></td>
            <td><a class="text-link" href="earhiv.php?filter=spr_view&id_storage=<?= $aut["ID"] ?>"><?= $adr ?></a></td>
        </tr>
        <?php
    }
    }
    $atu->free_result();
    ?>
</table>

