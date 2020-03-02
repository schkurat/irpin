<?php
include "../scriptu.php";
$idtaks = $_GET['idtaks'];
$skl = $_GET['skl'];
if ($skl == '1') $fl_skl = '';
else $fl_skl = 'readonly';

for ($i = 1; $i <= 6; $i++) {
    $idr[$i] = 0;
} //обнуление массива для типов работников
$sql = "SELECT taks_detal.SZ,taks_detal.NZ,taks_detal.KF,taks_detal.NDS,
	taks_detal.IDZM,taks_detal.TR,taks_detal.ID_ROB,taks_detal.KF_NAR FROM taks_detal 
	WHERE taks_detal.ID_TAKS='$idtaks' AND taks_detal.DL='1'";
$atu = mysql_query($sql);
while ($aut = mysql_fetch_array($atu)) {
    $sz = $aut["SZ"];
    $nz = $aut["NZ"];
    $pdv = $aut["NDS"];
    $kf = $aut["KF"];
    $kf_nar = $aut["KF_NAR"];
    /* if($szu!='' and $kf==2 and $kf_nar==1.5){
    $zmi_yur=='yes';
    }
    else $zmi_yur==''; */

    $idzm = $aut["IDZM"];
    $idr[$aut["TR"]] = $aut["ID_ROB"];
}
mysql_free_result($atu);

if ($kf == 1) $chek1 = 'checked';
else $chek2 = 'checked';

for ($i = 1; $i <= 6; $i++) {
    $rab = $idr[$i];
    $rob[$i] = '';
    if ($rab != 0) {
        $sql = "SELECT robitnuku.ROBS FROM robitnuku WHERE robitnuku.ID_ROB='$rab' AND robitnuku.DL='1'";
// echo $sql."<br>";
        $atu = mysql_query($sql);
        while ($aut = mysql_fetch_array($atu)) {
            $rob[$i] = $aut["ROBS"];
        }
        mysql_free_result($atu);
    }
}
$v_teh = $rob[4];
$v_pr = $rob[1];
$v_arh = $rob[2];
$v_vum = $rob[3];
$v_brug = $rob[5];
$v_tks = $rob[6];

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
                        var reply = html.split(":", 10);
                        if (reply[0] != '') {
                            $(".zmview").append('<tr>\
<td>' + reply[9] + '</td>\
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

<form action="add_edit.php" name="myform" method="post">
    <table align="" class="zmview">
        <tr>
            <th colspan="9" style="font-size: 35px;"><b>Корегування таксування</b></th>
        </tr>
        <tr>
            <td colspan="9">
                Серія замовлення<input type="text" size="6" maxlength="6" name="szam" value="<?php echo $sz; ?>"
                                       readonly/>
                <!--Юр. замовлення<input type="text" size="4" maxlength="4" name="szu" value="" readonly />-->
                Номер замовлення<input type="text" size="6" maxlength="6" name="nzam" value="<?php echo $nz; ?>"
                                       readonly/>
                <input type="checkbox" name="zmi_yur" value="yes" <?php /* if($zmi_yur=='yes') echo 'checked'; */ ?> />Термінове
                юридичне замовлення зі змінами
            </td>
        </tr>
        <tr>
            <td colspan="9">
                Норма часу<input type="text" size="5" maxlength="5" name="nch" value="<?= $n_god ?>"/>
                <input id="r1" type="radio" name="t_zm" value="1" <?php echo $chek1; ?>/><label
                        for="r1">Звичайне</label>
                <input id="r2" type="radio" name="t_zm" value="2" <?php echo $chek2; ?>/><label
                        for="r2">Термінове</label>
                &nbsp &nbsp &nbsp ПДВ <input type="text" size="2" maxlength="2" name="pdv" value="<?php echo $pdv; ?>"
                                             readonly/>
                <input type="checkbox" name="okr" value="yes" checked/>Окр.
            </td>
        </tr>
        <tr>
            <td colspan="9">
                Технік &nbsp &nbsp &nbsp &nbsp <input type="text" id="vu" name="tehnik" value="<?php echo $v_teh; ?>"
                                                      readonly/>
                Приймальник <input type="text" name="priem" value="<?php echo $v_pr; ?>" readonly/>
                Архіваріус <input type="text" name="arhiv" value="<?php echo $v_arh; ?>" readonly/>
            </td>
        </tr>
        <tr>
            <td colspan="9">
                Вимірювач <input type="text" name="vum" value="<?php echo $v_vum; ?>" readonly/>
                Таксувальник <input type="text" name="taksir" value="<?php echo $v_tks; ?>" readonly/>
                Бригадир&nbsp <input type="text" id="brug" name="brug" value="<?php echo $v_brug; ?>"/>
            </td>
        </tr>
        <tr>
            <td colspan="9" align="right" style="background: #FFA07A;">
                <b>Додавання додаткових робіт</b> <input type="text" id="nov_rob" size="10" name="nov_rob" value=""/>
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
        $i = 0;

        $sql = "SELECT ID_PRICE,KL,ID_ROB,KF_SKL FROM taks_detal 
	WHERE taks_detal.ID_TAKS='$idtaks' AND taks_detal.TR!=3 AND taks_detal.TR!=5 AND taks_detal.DL='1'";
        $atu = mysql_query($sql);
        while ($aut = mysql_fetch_array($atu)) {
            $kol = "";
            $skl = "";
            $id_rob = $aut["ID_ROB"];
            $robot = $aut["ID_PRICE"];
            $kol = $aut["KL"];
            $skl = $aut["KF_SKL"];

            $def = '0';
            $sql1 = "SELECT * FROM price WHERE ID_PRICE='$robot'";
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
            $i++;
            if ($def == '1') $fl_def = 'readonly';
            else $fl_def = '';

            ?>
            <tr>
                <td><select name="<?php echo 's' . $i; ?>">
                        <option></option>
                        <?php
                        $sql7 = "SELECT ID_ROB,ROBS FROM robitnuku WHERE BRUGADA!=9 AND DL='1' ORDER BY ROBS";
                        $atu7 = mysql_query($sql7);
                        while ($aut7 = mysql_fetch_array($atu7)) {
                            if ($aut7["ID_ROB"] == $id_rob) echo '<option selected value=' . $aut7["ID_ROB"] . '>' . $aut7["ROBS"] . '</option>';
                            else echo '<option value=' . $aut7["ID_ROB"] . '>' . $aut7["ROBS"] . '</option>';
                        }
                        mysql_free_result($atu7);
                        ?></select></td>
                <td><?php echo $nom; ?></td>
                <td><?php echo $naim; ?></td>
                <td><?php echo $odv; ?></td>
                <td><input type="text" size="7" maxlength="8" name="<?php echo 'z' . $i; ?>"
                           value="<?php echo $kol; ?>" <?php echo $fl_def; ?>/></td>
                <td><input type="text" size="7" maxlength="8" name="<?php echo 'vum' . $i; ?>"
                           value="<?php echo $vum; ?>" readonly/></td>
                <td><input type="text" size="7" maxlength="8" name="<?php echo 'vuk' . $i; ?>"
                           value="<?php echo $vuk; ?>" readonly/></td>
                <td><input type="text" size="7" maxlength="8" name="<?php echo 'kontr' . $i; ?>"
                           value="<?php echo $kontr; ?>" readonly/>
                <td><input type="text" size="4" maxlength="4" name="<?php echo 'skl' . $i; ?>"
                           value="<?php echo $skl; ?>" <?php echo $fl_skl; ?>/></td>
                <input type="hidden" name="<?php echo 'v' . $i; ?>" value="<?php echo $vud; ?>"/>
                <input type="hidden" name="<?php echo 'price' . $i; ?>" value="<?php echo $robot; ?>"/>
                <input type="hidden" name="idzm" value="<?php echo $idzm; ?>"/>
                <input type="hidden" name="idtaks" value="<?php echo $idtaks; ?>"/>
                </td>
            </tr>
            <?php

        }
        mysql_free_result($atu);
        ?>
        <tr>
            <td colspan="3" align="center"><input type="submit" id="calc" value="Корегувати"></td>
            <td colspan="6" align="center">
                <a href="taks.php?filter=taks_view">
                    <input name="cancel" type="button" value="Відміна"></a>
            </td>
        </tr>
    </table>
</form>