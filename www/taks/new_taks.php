<?php
include "../scriptu.php";
?>
<script type="text/javascript">
    $(document).ready(function () {
        $('#nz').bind('blur', net_fokusa);
        $("input[ name='vud_zam']").change(radio_click);
    });

    function net_fokusa(eventObj) {
        var ser = $("#sz").val(), nom = $("#nz").val(), tip = $("input[ name='vud_zam']:checked").val();
        $.ajax({
            type: "POST",
            url: "opr_adr.php",
            data: 'sz=' + ser + '&nz=' + nom + '&vud=' + tip,
            dataType: "html",
            success: function (html) {
                var reply = html.split(":", 12);
                $("#adres").val(reply[0] + ' ' + reply[1] + ' ' + reply[2] + ' ' + reply[3] + ' ' + reply[4] + ' ' + reply[5]);
                $("#vr").val(reply[6]);
                $("#vu").val(reply[7]);
                $("#prm").val(reply[8]);
                $("#idzm").val(reply[9]);
                $("#term").val(reply[10]);
                $("#skl").val(reply[11]);
            },
            error: function (html) {
                alert(html.error);
            }
        });
    }

    function radio_click() {
        if ($("input[name='vud_zam']:checked").val() == "1") {
//	$("#szu").attr("disabled","disabled");
            $("#zmi_yur").attr("disabled", "disabled");
        } else {
//	$("#szu").attr("disabled",false);
            $("#zmi_yur").attr("disabled", false);
        }
    }

</script>
<form action="taks.php?filter=taks_info" name="myform" method="post">
    <table align="" class="zmview">
        <tr>
            <th colspan="4" style="font-size: 35px;"><b>Нове таксування</b></th>
        </tr>
        <tr>
            <td>Тип замовлення</td>
            <td colspan="3">
                <input id="r1" type="radio" name="vud_zam" value="1" checked/><label for="r1">Фізичне</label>
                <input id="r2" type="radio" name="vud_zam" value="2"/><label for="r2">Юридичне</label>
                <!--&nbsp &nbsp Дата юр.
<input type="text" id="szu" size="4" maxlength="4" name="szu" value="<?php echo date("dm"); ?>" disabled/>-->
                <input type="checkbox" name="okr" value="yes" checked>Округлення
                <input type="checkbox" id="zmi_yur" name="zmi_yur" value="yes" disabled/>Юр.зам.зміни
            </td>
        </tr>
        <tr>
            <td>Серія замовлення</td>
            <td><input type="text" id="sz" size="6" maxlength="6" name="szam" value="<?php echo date("dmy"); ?>"/></td>
            <td>Номер замовлення</td>
            <td><input type="text" id="nz" size="6" maxlength="6" name="nzam" value=""/></td>
        </tr>
        <tr>
            <td colspan="4">
                <input type="text" id="adres" size="80" name="adr" value="" style="background-color: silver"/>
            </td>
        </tr>
        <tr>
            <td>Вид робіт</td>
            <td colspan="3"><input type="text" id="vr" size="42" name="vrob" value="" required readonly/></td>
        </tr>
        <tr>
            <td>Технік</td>
            <td colspan="3"><input type="text" id="vu" size="25" name="teh" value=""/></td>
        </tr>
        <tr>
            <td>Приймальник</td>
            <td colspan="3"><input type="text" id="prm" size="25" name="priem" value="Дєтковська В.І."/></td>
        </tr>
        <tr>
            <td>Архіваріус</td>
            <td colspan="3"><input type="text" id="arh" size="25" name="arhiv" value="Приходько К.В."/></td>
        </tr>
        <tr>
            <td>Вимірювач</td>
            <td colspan="3">
                <select name="vum" class="sel_ad">
                    <option value=""></option>
                    <?php
                    $sql = "SELECT ROBS FROM robitnuku WHERE DL='1' AND BRUGADA=1 ORDER BY ROBS";
                    $atu = mysql_query($sql);
                    while ($aut = mysql_fetch_array($atu)) {
                        echo '<option value="' . $aut["ROBS"] . '">' . $aut["ROBS"] . '</option>';
                    }
                    mysql_free_result($atu);
                    ?>
                </select>
                <!-- <input type="text" id="vum" size="25" name="vum" value=""/>-->
            </td>
        </tr>
        <tr>
            <td>Бригадир</td>
            <td colspan="3">
                <select name="brug" class="sel_ad">
                    <option value=""></option>
                    <?php
                    $sql = "SELECT ROBS FROM robitnuku WHERE DL='1' AND BRUGADA=8 ORDER BY ROBS";
                    $atu = mysql_query($sql);
                    while ($aut = mysql_fetch_array($atu)) {
                        echo '<option value="' . $aut["ROBS"] . '">' . $aut["ROBS"] . '</option>';
                    }
                    mysql_free_result($atu);
                    ?>
                </select>
            </td>
        </tr>
        <tr>
            <td>Таксувальник</td>
            <td colspan="3">
                <select name="taks" class="sel_ad">
                    <option value=""></option>
                    <?php
                    $sql = "SELECT ROBS FROM robitnuku WHERE DL='1' AND BRUGADA=1 ORDER BY ROBS";
                    $atu = mysql_query($sql);
                    while ($aut = mysql_fetch_array($atu)) {
                        echo '<option value="' . $aut["ROBS"] . '">' . $aut["ROBS"] . '</option>';
                    }
                    mysql_free_result($atu);
                    ?>
                </select>
<!--                <input type="text" id="taks" size="25" maxlength="25" name="taks" value="Дєтковська В.І."/>-->
                <input type="hidden" id="idzm" name="idzm" value=""/>
                <input type="hidden" id="term" name="term" value=""/>
                <input type="hidden" id="skl" name="skl" value=""/>
            </td>
        </tr>
        <tr>
            <td colspan="2" align="center"><input type="submit" id="submit" value="Створити"></td>
            <td colspan="2" align="center"><input name="reset" type="reset" id="reset" value="Очистити"></td>
        </tr>
    </table>