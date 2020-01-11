<?php
include "../function.php";

$inv_spr = $_GET["inv_spr"];
$fl = 0;
$sql = "SELECT nas_punktu.NSP,tup_nsp.TIP_NSP,vulutsi.VUL,tup_vul.TIP_VUL,arhiv.BD,arhiv.KV  
	FROM arhiv,nas_punktu,vulutsi,tup_nsp,tup_vul 
	WHERE arhiv.N_SPR='$inv_spr' AND nas_punktu.ID_NSP=arhiv.NS 
	AND vulutsi.ID_VUL=arhiv.VL 
	AND tup_nsp.ID_TIP_NSP=nas_punktu.ID_TIP_NSP 
	AND tup_vul.ID_TIP_VUL=vulutsi.ID_TIP_VUL 
	AND arhiv.DL='1'";
//echo $sql;
$atu = mysql_query($sql);
while ($aut = mysql_fetch_array($atu)) {
    $fl++;
    $obj_ner = objekt_ner(0, $aut["BD"], $aut["KV"]);
    $adr = $aut["TIP_NSP"] . $aut["NSP"] . " " . $aut["TIP_VUL"] . $aut["VUL"] . " " . $obj_ner;
}
mysql_free_result($atu);
if ($fl != 0) {
//    function open_sprava($kat, $adr)
//    {
//        if ($dh = opendir($kat)) {
//            while (false !== ($file = readdir($dh))) {
//                if ($file != "." && $file != "..") {
//                    switch ($file) {
//                        case 'TITLE':
//                            $z1 = '<tr><td id="zal"><a href="earhiv.php?filter=file_view&kat=' . $kat . '/' . $file . '&name=Обкладинка&adr=' . $adr . '">Обкладинка</a></td></tr>';
//                            break;
//                        case 'OPIS':
//                            $z2 = '<tr><td id="zal"><a href="earhiv.php?filter=file_view&kat=' . $kat . '/' . $file . '&name=Опис інвентарної справи&adr=' . $adr . '">Опис інвентарної справи</a></td></tr>';
//                            break;
//                        case 'PLANZEM':
//                            $z4 = '<tr><td id="zal"><a href="earhiv.php?filter=file_view&kat=' . $kat . '/' . $file . '&name=План земельної ділянки&adr=' . $adr . '">План земельної ділянки</a></td></tr>';
//                            break;
//                        case 'PLANBUD':
//                            $z5 = '<tr><td id="zal"><a href="earhiv.php?filter=file_view&kat=' . $kat . '/' . $file . '&name=План будинку&adr=' . $adr . '">План будинку</a></td></tr>';
//                            break;
//                        case 'JURCOST':
//                            $z6 = '<tr><td id="zal"><a href="earhiv.php?filter=file_view&kat=' . $kat . '/' . $file . '&name=Журнали обмірів та площ. Оцінка об`єкту&adr=' . $adr . '">Журнали обмірів та площ. Оцінка об`єкту</a></td></tr>';
//                            break;
//                        case 'ESKIZ':
//                            $z12 = '<tr><td id="zal"><a href="earhiv.php?filter=file_view&kat=' . $kat . '/' . $file . '&name=Ескіз планів поверхів будинку&adr=' . $adr . '">Ескіз планів поверхів будинку</a></td></tr>';
//                            break;
//                        case 'ABRIS':
//                            $z13 = '<tr><td id="zal"><a href="earhiv.php?filter=file_view&kat=' . $kat . '/' . $file . '&name=Абрис земельної ділянки&adr=' . $adr . '">Абрис земельної ділянки</a></td></tr>';
//                            break;
//                        case 'KAMER':
//                            $z14 = '<tr><td id="zal"><a href="earhiv.php?filter=file_view&kat=' . $kat . '/' . $file . '&name=Акт польової і камеральної перевірки&adr=' . $adr . '">Акт польової і камеральної перевірки</a></td></tr>';
//                            break;
//                        case 'ZAMOVL':
//                            $z15 = '<tr><td id="zal"><a href="earhiv.php?filter=file_view&kat=' . $kat . '/' . $file . '&name=Заява (замовлення)&adr=' . $adr . '">Заява (замовлення)</a></td></tr>';
//                            break;
//                        case 'INSHI':
//                            $z16 = '<tr><td id="zal"><a href="earhiv.php?filter=file_view&kat=' . $kat . '/' . $file . '&name=Інші документи&adr=' . $adr . '">Інші документи</a></td></tr>';
//                            break;
//                    }
//                }
//            }
//            closedir($dh);
//        }
//        $z = $z1 . $z2 . $z3 . $z4 . $z5 . $z6 . $z7 . $z8 . $z9 . $z10 . $z11 . $z12 . $z13 . $z14 . $z15 . $z16;
//        return $z;
//    }

//    $p = '
//<script type="text/javascript">
//$(document).ready(
//  function()
//  {
//  	$(".zmview tr").mouseover(function() {
//  		$(this).addClass("over");
//  	});
//
//  	$(".zmview tr").mouseout(function() {
//  		$(this).removeClass("over");
//  	});
//	$(".zmview tr:even").addClass("alt");
//  }
//);
//</script>
//<table align="center" class="zmview">
//<tr>
//<th>' . $adr . '</th>
//</tr>';
    $dir = 'ea/' . $inv_spr;
    if(!is_dir($dir)){
        mkdir($dir, 0777);
        $ath1 = mysql_query("INSERT INTO arh_sec(N_SPR) VALUES ('$inv_spr');");
    }

    $sf = 0;
    $old_file = '';
    $kat = $dir;
    ?>
    <form action="add_file.php" name="myform" method="post" enctype="multipart/form-data">
        <table align="center" class="zmview">
            <tr>
                <th colspan="2"><?= $adr ?></th>
            </tr>
            <?php
            if ($dh = opendir($kat)) {
                while (false !== ($file = readdir($dh))) {
                    if ($file != "." && $file != "..") {
                        $sf++;
                        ?>
                        <tr>
                            <td align="center">
                                <a href="earhiv.php?filter=delete_file&url=<?= $kat ?>/<?= $file ?>&inv=<?= $inv_spr ?>">
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
                    <input name="inv" type="hidden" value="<?= $inv_spr ?>"/>
                </td>
            </tr>

        </table>
    </form>
<?php

//    if (is_dir($dir)) {
//        $p .= open_sprava($dir, $adr);
//    } else {
//        mkdir($dir, 0777);
//        mkdir($dir . '/TITLE', 0777);
//        mkdir($dir . '/OPIS', 0777);
//        mkdir($dir . '/PLANZEM', 0777);
//        mkdir($dir . '/PLANBUD', 0777);
//        mkdir($dir . '/JURCOST', 0777);
//        mkdir($dir . '/ESKIZ', 0777);
//        mkdir($dir . '/ABRIS', 0777);
//        mkdir($dir . '/KAMER', 0777);
//        mkdir($dir . '/ZAMOVL', 0777);
//        mkdir($dir . '/INSHI', 0777);

//        $ath1 = mysql_query("INSERT INTO arh_sec(N_SPR) VALUES ('$inv_spr');");

       // $p .= open_sprava($dir, $adr);

//    }


//    $p .= '</table>';
//    echo $p;
} else echo 'За вказаним номером інвентарної справи не знайдено!';
