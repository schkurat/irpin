<?php
include "../function.php";
$sz = $_POST['szam'];
$nz = $_POST['nzam'];
$vud_zam = $_POST['vud_zam'];
/* if($vud_zam==1) $szu='';
else $szu=$_POST['szu']; */
$teh = $_POST['teh'];
$pri = $_POST['priem'];
$arhi = $_POST['arhiv'];
$vum = $_POST['vum'];
$tks = $_POST['taks'];
$brug = $_POST['brug'];
$idzm = $_POST['idzm'];
$term = $_POST['term'];
$skl = $_POST['skl'];
$okr = $_POST['okr'];
$zmi_yur = $_POST['zmi_yur'];
$vid_rob = $_POST['vrob'];
if ($vid_rob == 'інвентаризація житла, що приватизується' and $vud_zam == 2) $nds = '0';
else $nds = '20';
if ($skl == '1') $fl_skl = '';
else $fl_skl = 'readonly';

$sql = "SELECT taks.ID_TAKS FROM taks WHERE taks.IDZM='$idzm' AND taks.DL='1'";
$atu = mysql_query($sql);
$old_taks = mysql_num_rows($atu);
mysql_free_result($atu);

if ($old_taks == 0) {
    $n_god = 0;
    $sql = "SELECT ng FROM ng,zamovlennya WHERE ng.dl='1' AND zamovlennya.D_PR>=ng.dtstart ORDER BY ng.dtstart ASC LIMIT 1";
    $atu = mysql_query($sql);
    while ($aut = mysql_fetch_array($atu)) {
        $n_god = $aut["ng"];
    }
    mysql_free_result($atu);
    ?>
    <script type="text/javascript">
        $(document).ready(
            function () {
                $(".zmview tr").mouseover(function () {
                    $(this).addClass("over");
                });

                $(".zmview tr").mouseout(function () {
                    $(this).removeClass("over");
                });
                $(".zmview tr:even").addClass("alt");
//-----------vnesennya dodatkovuh robit----------------
                $('#plus').click(add_dom);

                function add_dom(eventObj) {
                    $.ajax({
                        type: "POST",
                        url: "add_new_rob.php",
                        data: 'nrob=' + $("#nov_rob").val() + '&nom=' + $("select:last").attr("name"),
                        dataType: "html",
                        success: function (html) {
                            var reply = html.split(":", 9);
                            if (reply[0] != '') {
                                $(".zmview").append('<tr>\
<td><select name="s' + reply[8] + '">\
<option value=""></option>\
<option value="1">Бюро</option>\
<option value="4">Голуб Г.О.</option>\
<option value="8">Ільїн М.Ю.</option>\
<option value="9">Величко Г.А.</option>\
<option value="10">Соловей О.А.</option>\
<option value="11">Ішутко В.Г.</option>\
<option value="12">Петренко Г.А.</option>\
</select>\
</td>\
<td>' + reply[1] + '</td>\
<td>' + reply[2] + '</td>\
<td>' + reply[3] + '</td>\
<td><input type="text" size="7" maxlength="8" name="z' + reply[8] + '" value="1"/></td>\
<td><input type="text" size="7" maxlength="8" name="vum' + reply[8] + '" value="' + reply[4] + '" readonly/></td>\
<td><input type="text" size="7" maxlength="8" name="vuk' + reply[8] + '" value="' + reply[5] + '" readonly/></td>\
<td><input type="text" size="7" maxlength="8" name="kontr' + reply[8] + '" value="' + reply[6] + '" readonly/>\
<td><input type="text" size="4" maxlength="4" name="skl' + reply[8] + '" value="1" <?php echo $fl_skl; ?>/>\
<input type="hidden" name="v' + reply[8] + '" value="' + reply[7] + '"/>\
<input type="hidden" name="price' + reply[8] + '" value="' + reply[0] + '"/>\
</td>\
</tr>');
//alert(reply[8]);
                            }
                        },
                        error: function (html) {
                            alert(html.error);
                        }
                    });
                }

//------------------------------------------------------
            }
        );
    </script>

    <form action="taks_sum.php" name="myform" method="post">
        <table align="" class="zmview">
            <tr>
                <th colspan="9" style="font-size: 35px;"><b>Таксування</b></th>
            </tr>
            <tr>
                <td colspan="9">
                    Серія замовлення
                    <input type="text" size="6" maxlength="6" name="szam" value="<?php echo $sz; ?>" readonly/>
                    <!--Юр. замовлення
<input type="text" size="4" maxlength="4" name="szu" value="<?php echo $szu; ?>" readonly />-->
                    Номер замовлення
                    <input type="text" size="7" maxlength="7" name="nzam" value="<?php echo $nz; ?>" readonly/>
                    Норма часу
                    <input type="text" size="7" maxlength="7" name="nch" value="<?= $n_god ?>"/>
                    <input type="hidden" name="term" value="<?php echo $term; ?>"/>
                    &nbsp &nbsp &nbsp ПДВ <input type="text" size="2" maxlength="2" name="pdv"
                                                 value="<?php echo $nds; ?>" readonly/>
                    <input type="checkbox" name="okr" value="yes" <?php if ($okr == 'yes') echo 'checked'; ?> />Окр.
                    <input type="checkbox" name="zmi_yur" value="yes" <?php if ($zmi_yur == 'yes') echo 'checked'; ?> />Юр.зам.зміни
                    <input type="hidden" name="vud_zam" value="<?php echo $vud_zam; ?>"/>
                </td>
            </tr>
            <tr>
                <td colspan="9">
                    Технік &nbsp &nbsp &nbsp &nbsp <input type="text" name="tehnik" value="<?php echo $teh; ?>"
                                                          readonly/>
                    Приймальник <input type="text" name="priem" value="<?php echo $pri; ?>" readonly/>
                    Архіваріус <input type="text" name="arhiv" value="<?php echo $arhi; ?>" readonly/>
                </td>
            </tr>
            <tr>
                <td colspan="9">
                    Вимірювач <input type="text" name="vum" value="<?php echo $vum; ?>" readonly/>
                    Таксувальник <input type="text" name="taksir" value="<?php echo $tks; ?>" readonly/>
                    Бригадир&nbsp <input type="text" name="brug" value="<?php echo $brug; ?>" readonly/>
                </td>
            </tr>
            <tr>
                <td colspan="9" align="right" style="background: #FFA07A;">
                    <b>Додавання додаткових робіт</b> <input type="text" id="nov_rob" size="7" name="nov_rob" value=""/>
                    <input type="button" id="plus" name="plus" value="Додати"/>
                </td>
            </tr>
            <tr>
                <td align="center">Виконавець</td>
                <td align="center">Номер</td>
                <td align="center">Найменування робіт</td>
                <td align="center">Одиниці виміру</td>
                <td align="center">Кількість</td>
                <td align="center">Норма часу<br>вим.</td>
                <td align="center">Норма часу<br>вик.</td>
                <td align="center">Норма часу<br>контр.</td>
                <td align="center">Кф.<br>скл.</td>
            </tr>
            <?php
            $sql = "SELECT dlya_oformlennya.RB FROM dlya_oformlennya,zamovlennya 
			WHERE dlya_oformlennya.id_oform=zamovlennya.VUD_ROB AND zamovlennya.KEY='$idzm'";
            $atu = mysql_query($sql);
            while ($aut = mysql_fetch_array($atu)) {
                $rob = $aut["RB"];
            }
            mysql_free_result($atu);

            $n = substr_count($rob, ":");
            $robot = explode(":", $rob);
            //echo $robot[0];
            for ($i = 0; $i <= $n; $i++) {
                $def = '0';
                $sql1 = "SELECT * FROM price WHERE ID_PRICE='$robot[$i]'";
                $atu1 = mysql_query($sql1);
                while ($aut1 = mysql_fetch_array($atu1)) {
                    $id_pr = $aut1["ID_PRIСE"];
                    $vud = $aut1["VUD"];
                    $nom = $aut1["NOM"];
                    $naim = $aut1["NAIM"];
                    $odv = $aut1["ODV"];
                    $vum = $aut1["VUM"];
                    $vuk = $aut1["VUK"];
                    $kontr = $aut1["KONTR"];
                    $def = $aut1["DEF"];
                }
                mysql_free_result($atu1);
                $l = $i + 1;
                if ($def == '1') $fl_def = 'readonly';
                else $fl_def = '';
                if ($nom == '3.16.1') $ch_def = '10';
                else $ch_def = '1';
                ?>
                <tr>
                    <td><select name="<?php echo 's' . $l; ?>">
                            <option></option>
                            <?php
                            $sql7 = "SELECT ID_ROB,ROBS FROM robitnuku WHERE BRUGADA!=9 AND DL='1' ORDER BY ROBS";
                            $atu7 = mysql_query($sql7);
                            while ($aut7 = mysql_fetch_array($atu7)) {
                                switch ($vud) {
                                    case 1:
                                        if ($aut7["ROBS"] == $pri) echo '<option selected value=' . $aut7["ID_ROB"] . '>' . $aut7["ROBS"] . '</option>';
//else echo '<option value='.$aut7["ID_ROB"].'>'.$aut7["ROBS"].'</option>';	
                                        break;
                                    case 2:
                                        if ($aut7["ROBS"] == $arhi) echo '<option selected value=' . $aut7["ID_ROB"] . '>' . $aut7["ROBS"] . '</option>';
                                        else echo '<option value=' . $aut7["ID_ROB"] . '>' . $aut7["ROBS"] . '</option>';
                                        break;
                                    case 3:
                                        if ($robot[$i] == 83) {
                                            if ($aut7["ROBS"] == $tks) echo '<option selected value=' . $aut7["ID_ROB"] . '>' . $aut7["ROBS"] . '</option>';
                                            else echo '<option value=' . $aut7["ID_ROB"] . '>' . $aut7["ROBS"] . '</option>';
                                        } else {
                                            if ($aut7["ROBS"] == $teh) echo '<option selected value=' . $aut7["ID_ROB"] . '>' . $aut7["ROBS"] . '</option>';
                                            else echo '<option value=' . $aut7["ID_ROB"] . '>' . $aut7["ROBS"] . '</option>';
                                        }
                                        break;
                                    case 4:
                                        if ($aut7["ROBS"] == 'Бюро'/*$teh*/) echo '<option selected value=' . $aut7["ID_ROB"] . '>' . $aut7["ROBS"] . '</option>';
                                        else echo '<option value=' . $aut7["ID_ROB"] . '>' . $aut7["ROBS"] . '</option>';
                                        break;
                                    case 5:
                                        if ($aut7["ROBS"] == $teh) echo '<option selected value=' . $aut7["ID_ROB"] . '>' . $aut7["ROBS"] . '</option>';
                                        else echo '<option value=' . $aut7["ID_ROB"] . '>' . $aut7["ROBS"] . '</option>';
                                        break;
                                    default:
                                        break;
                                }
                            }
                            mysql_free_result($atu7);
                            ?></select></td>
                    <td><?php echo $nom; ?></td>
                    <td><?php echo $naim; ?></td>
                    <td><?php echo $odv; ?></td>
                    <td><input type="text" size="7" maxlength="8" name="<?php echo 'z' . $l; ?>"
                               value="<?php echo $ch_def; ?>" <?php echo $fl_def; ?>/></td>
                    <td><input type="text" size="7" maxlength="8" name="<?php echo 'vum' . $l; ?>"
                               value="<?php echo $vum; ?>" readonly/></td>
                    <td><input type="text" size="7" maxlength="8" name="<?php echo 'vuk' . $l; ?>"
                               value="<?php echo $vuk; ?>" readonly/></td>
                    <td><input type="text" size="7" maxlength="8" name="<?php echo 'kontr' . $l; ?>"
                               value="<?php echo $kontr; ?>" readonly/>
                    <td><input type="text" size="4" maxlength="4" name="<?php echo 'skl' . $l; ?>"
                               value="1" <?php echo $fl_skl; ?>/></td>
                    <input type="hidden" name="<?php echo 'v' . $l; ?>" value="<?php echo $vud; ?>"/>
                    <input type="hidden" name="<?php echo 'price' . $l; ?>" value="<?php echo $robot[$i]; ?>"/>
                    <input type="hidden" name="idzm" value="<?php echo $idzm; ?>"/>
                    </td>
                </tr>
                <?php
            }
            ?>
            <tr>
                <td colspan="3" align="center"><input type="submit" id="calc" value="Розрахунок"></td>
                <td colspan="6" align="center">
                    <a href="taks.php?filter=taks_view">
                        <input name="cancel" type="button" value="Відміна"></a>
                </td>
            </tr>
        </table>
    </form>
    <?php
} else {
    echo "Замовлення " . $sz . "/" . $nz . " протаксоване";
}
?>