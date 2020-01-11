<?php
//include_once "../function.php";
$kat = $_GET['kat'];
$name = $_GET['name'];
$adr = $_GET['adr'];
$sf = 0;
$old_file = '';
?>

<form action="add_file.php" name="myform" method="post" enctype="multipart/form-data">
    <table align="center" class="zmview">
        <tr>
            <th colspan="2"><?= $name ?></br><?= $adr ?></th>
        </tr>
        <?php
        if ($dh = opendir($kat)) {
            while (false !== ($file = readdir($dh))) {
                if ($file != "." && $file != "..") {
                    $sf++;
                    ?>
                    <tr>
                        <td align="center">
                            <a href="earhiv.php?filter=delete_file&url=<?= $kat ?>/<?= $file ?>&kat=<?= $kat ?>&name=<?= $name ?>&adr=<?= $adr ?>">
                                <img src="../images/b_drop.png" border="0">
                            </a>
                        </td>
                        <td id="zal"><a href="download_file.php?url=<?= $kat ?>/<?= $file ?>"><?= $file ?></a></td>
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
                if ($sf > 0) {
                    ?>
                    Замінити сторінку
                    <input name="page" type="text" size="3" value=""/>
                    <input name="old_file" type="hidden" value="<?= $old_file ?>"/>
                    <?php
                }
                ?>
                <input type="file" name="file[]"><input type="submit" id="submit" value="Завантажити">
                <input name="id_kat" type="hidden" value="<?= $kat ?>"/>
                <input name="nazv" type="hidden" value="<?= $name ?>"/>
                <input name="adres" type="hidden" value="<?= $adr ?>"/>
            </td>
        </tr>

    </table>
</form>

