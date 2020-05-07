<?php
include_once "../function.php";

$url = $_GET['url'];
$parent_link = json_decode($_GET['parent_link']);
$adr = unserialize($_GET['adr']);
$adr = get_adr($url, $lg, $pas);
$back_link = 'arhiv.php?filter=zm_view';

$dir = 'ea/' . $url;
$rows = open_dir($dir, $adr);

//$pl = urlencode($_GET['parent_link']);
$ad = urlencode($adr);
?>
<script type="text/javascript">
    $(document).ready(function () {
        $('#e_arhiv').on('click','.del-file', delFile).on('mouseover','.del-file', function () {
            $(this).css('cursor', 'pointer');
        });
    });
</script>

<form action="add_storage.php" name="myform" method="post" enctype="multipart/form-data">
    <table class="zmview" id="e_arhiv">
        <tr>
            <th colspan="2">Архів</th>
        </tr>
        <tr>
            <td>
                <a class="text-link" href="<?= $back_link ?>">< Назад</a>
                <input type="hidden" name="parent_link" value="">
                <input type="hidden" name="adr" value="<?= $ad ?>">
                <input type="hidden" name="url" value="<?= $url ?>">
            </td>
            <td>
                <input type="file" name="file[]" size="40" multiple>
                <input type="submit" id="submit" value="Додати">
            </td>
        </tr>
        <?= $rows ?>
    </table>
</form>
