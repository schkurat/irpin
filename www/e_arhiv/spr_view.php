<?php
include "../function.php";

$frn = get_filter_for_rn($drn,'arhiv','RN');
?>
    <style>
        .ea_card {
            display: block;
            float: left;
            width: 30%;
            padding: 5px;
            height: 280px;
            overflow-y: scroll;
        }
    </style>
<?php
$id_storage = (isset($_GET['id_storage'])) ? $_GET['id_storage'] : 0;
if ($id_storage == 0) {
    $sz = $_GET["sz"];
    $nz = (int)$_GET["nz"];
    $add_table = ',zamovlennya';
    $filter = "zamovlennya.SZ='$sz' AND zamovlennya.NZ='$nz' AND zamovlennya.DL='1' AND zamovlennya.EA=arhiv.ID ";
} else {
    $filter = "arhiv.ID='$id_storage' ";
    $add_table = '';
}

if ($ddl == '1') {
    $cssp = '2';
} else {
    $cssp = '1';
}

$fl = 0;
$dir = 0;
$sql = "SELECT arhiv.ID,nas_punktu.NSP,tup_nsp.TIP_NSP,vulutsi.VUL,tup_vul.TIP_VUL,arhiv.BD,arhiv.KV  
	FROM arhiv,nas_punktu,vulutsi,tup_nsp,tup_vul" . $add_table . " 
	WHERE " . $filter . " AND (" . $frn . ") 
	AND nas_punktu.ID_NSP=arhiv.NS 
	AND vulutsi.ID_VUL=arhiv.VL 
	AND tup_nsp.ID_TIP_NSP=nas_punktu.ID_TIP_NSP 
	AND tup_vul.ID_TIP_VUL=vulutsi.ID_TIP_VUL 
	AND arhiv.DL='1'";
//echo $sql;
$atu = $db->db_link->query($sql);
while ($aut = $atu->fetch_array(MYSQLI_ASSOC)) {
    $fl++;
    $obj_ner = objekt_ner(0, $aut["BD"], $aut["KV"]);
    $adr = $aut["TIP_NSP"] . $aut["NSP"] . " " . $aut["TIP_VUL"] . $aut["VUL"] . " " . $obj_ner;
    $dir = $aut["ID"];
}
$atu->free_result();
$id_storage = ($id_storage == 0)? $dir: $id_storage;
if ($fl != 0) {
    ?>
    <h2 style="text-align: center"><?= $adr ?></h2>
    <?php
    $main_dir = 'ea/' . $id_storage;
    if (is_dir($main_dir)) {
        check_or_create_folder($main_dir);
        if ($mdh = opendir($main_dir)) {
            while (false !== ($item = readdir($mdh))) {
                if ($item != "." && $item != "..") {
                    $sf = 0;
                    $old_file = '';

                    $kat = 'ea/' . $id_storage . '/' . $item;
                    if (is_dir($kat)) {
                        switch ($item) {
                            case "document":
                                $title = "Прийом документів";
                                break;
                            case "keeper":
                                $title = "Зберігач";
                                break;
                            case "technical":
                                $title = "Технічні документи";
                                break;
                            case "correspondence":
                                $title = "Кореспонденція";
                                break;
                            case "inventory":
                                $title = "Інвентарна справа";
                                break;
                        }
                        ?>
                        <div class="ea_card">
                            <form action="add_file.php" name="myform" method="post" enctype="multipart/form-data">
                                <table align="center" class="zmview">
                                    <tr>
                                        <th colspan="2"><?= $title ?></th>
                                    </tr>
                                    <?php
                                    if ($dh = opendir($kat)) {
                                        while (false !== ($file = readdir($dh))) {
                                            if ($file != "." && $file != "..") {
                                                $sf++;
                                                ?>
                                                <tr>
                                                    <?php
                                                    if($ddl == '1'){
                                                        ?>
                                                        <td align="center">
                                                            <a href="earhiv.php?filter=delete_file&url=<?= $kat ?>/<?= $file ?>&sz=<?= $sz ?>&nz=<?= $nz ?>&id_storage=<?= $id_storage ?>">
                                                                <img src="../images/b_drop.png" border="0">
                                                            </a>
                                                        </td>
                                                        <?php
                                                    }
                                                    ?>
                                                    <td id="zal"><a
                                                                href="download_file.php?url=<?= $kat ?>/<?= $file ?>"><?= $file ?></a>
                                                    </td>
                                                </tr>
                                                <?php
                                                $old_file = $file;
                                            }
                                        }
                                        closedir($dh);
                                    }
                                    ?>
                                    <tr>
                                        <td colspan="2">
                                            <?php
                                            if ($sf == 1) {
                                                $info = new SplFileInfo($old_file);
                                                if ($info->getExtension() == 'pdf' or $info->getExtension() == 'PDF') {
                                                    ?>
                                                    Замінити сторінку
                                                    <input name="page" type="text" size="3" value=""/>
                                                    <input name="old_file" type="hidden" value="<?= $old_file ?>"/>
                                                    <?php
                                                }
                                            }
                                            ?>
                                            <input type="file" name="file[]"><input type="submit" id="submit"
                                                                                    value="Завантажити">
                                            <input name="id_kat" type="hidden" value="<?= $kat ?>"/>
                                            <input name="sz" type="hidden" value="<?= $sz ?>"/>
                                            <input name="nz" type="hidden" value="<?= $nz ?>"/>
                                            <input name="id_storage" type="hidden" value="<?= $id_storage ?>"/>
                                        </td>
                                    </tr>
                                </table>
                            </form>
                        </div>
                        <?php
                    }
                }
            }
            closedir($mdh);
        }
    }
} else echo 'За вказаним номером інвентарної справи не знайдено!';
