<?php
include_once "../function.php";
$kl = $_GET['kl'];

$sql = "SELECT * FROM yur_kl WHERE yur_kl.ID='$kl' AND yur_kl.DL='1'";
$atu = mysql_query($sql);
while ($aut = mysql_fetch_array($atu)) {
    if ($aut["ED_POD"] == 1) {
        $neplat = "checked";
        $plat = "";
    } else {
        $neplat = "";
        $plat = "checked";
    }
    ?>
    <form action="update_yur.php" name="myform" method="get">
        <table align="center" cellspacing=0 class="zmview">
            <tr>
                <th colspan="4" align="center">Редагування інформації про клієнта</th>
            </tr>
            <tr>
                <td>Скорочена назва:</td>
                <td colspan="3"><input name="name" type="text" size="60"
                                       value="<?php echo htmlspecialchars($aut["NAME"], ENT_QUOTES); ?>"/></td>
            </tr>
            <tr>
                <td>Повна назва:</td>
                <td colspan="3"><input name="namef" type="text" size="60"
                                       value="<?php echo htmlspecialchars($aut["NAME_F"], ENT_QUOTES); ?>"/></td>
            </tr>
            <tr>
                <td>Керівник(скор.):</td>
                <td colspan="3"><input name="boss" type="text" size="60"
                                       value="<?php echo htmlspecialchars($aut["BOSS"], ENT_QUOTES); ?>"/></td>
            </tr>
            <tr>
                <td>Керівник(повністю):</td>
                <td colspan="3"><input name="boss_f" type="text" size="60"
                                       value="<?php echo htmlspecialchars($aut["BOSS_F"], ENT_QUOTES); ?>"/></td>
            </tr>
            <tr>
                <td>Діє на підставі:</td>
                <td colspan="3"><input name="pidstava" type="text" size="60"
                                       value="<?php echo htmlspecialchars($aut["PIDSTAVA"], ENT_QUOTES); ?>"/></td>
            </tr>
            <tr>
                <td>Адреса:</td>
                <td colspan="3"><input name="adres" type="text" size="60"
                                       value="<?php echo htmlspecialchars($aut["ADRES"], ENT_QUOTES); ?>"/></td>
            </tr>
            <tr>
                <td>Телефон:</td>
                <td><input name="telef" type="text" size="20" value="<?php echo $aut["TELEF"]; ?>"/></td>
                <td>E-mail:</td>
                <td><input name="email" type="text" size="20" value="<?php echo $aut["EMAIL"]; ?>"/></td>
            </tr>
            <tr>
                <td>Платник ПДВ:</td>
                <td>
                    <input id="r1" type="radio" name="pdv" value="0" <?php echo $plat; ?>/><label for="r1">Так</label>
                    <input id="r2" type="radio" name="pdv" value="1" <?php echo $neplat; ?>/><label for="r2">Ні</label>
                </td>
                <td>ЄДРПОУ:</td>
                <td><input name="edrpou" type="text" size="20" value="<?php echo $aut["EDRPOU"]; ?>"/></td>
            </tr>
            <tr>
                <td>Свідоцтво:</td>
                <td><input name="svid" type="text" size="20" value="<?php echo $aut["SVID"]; ?>"/></td>
                <td>ІПН:</td>
                <td><input name="ipn" type="text" size="20" value="<?php echo $aut["IPN"]; ?>"/></td>
            </tr>
            <tr>
                <td>Банк:</td>
                <td colspan="3"><input name="bank" type="text" size="60"
                                       value="<?php echo htmlspecialchars($aut["BANK"], ENT_QUOTES); ?>"/></td>
            </tr>
            <tr>
                <td>МФО:</td>
                <td><input name="mfo" type="text" size="20" value="<?php echo $aut["MFO"]; ?>"/></td>
                <td>Рахунок:</td>
                <td><input name="rr" type="text" size="20" value="<?php echo $aut["RR"]; ?>"/>
                    <input name="kl" type="hidden" value="<?php echo $kl; ?>"/>
                </td>
            </tr>
            <tr>
                <td>Прилад:</td>
                <td colspan="3"><input name="prilad" type="text" size="60" value="<?= htmlspecialchars($aut["PRILAD"], ENT_QUOTES) ?>"/></td>
                </td>
            </tr>
            <tr>
                <td>Сертифікат:</td>
                <td colspan="3">
                    <input type="text" id="ser_sert" size="2" maxlength="2" name="ser_sert" value="<?= htmlspecialchars($aut["SERT_S"], ENT_QUOTES) ?>"/>
                    <input type="text" id="numb_sert" size="18" maxlength="30" name="numb_sert" value="<?= htmlspecialchars($aut["SERT_N"], ENT_QUOTES) ?>"/>
                </td>
                </td>
            </tr>
            <tr>
                <th colspan="4">Сертифікована особа</th>
            </tr>
            <tr>
                <td>ІПН:</td>
                <td colspan="3">
                    <input type="text" id="so_ipn" size="60" name="so_ipn" value="<?= htmlspecialchars($aut["SO_IPN"], ENT_QUOTES) ?>"/>
                </td>
                </td>
            </tr>
            <tr>
                <td>Прізвище:</td>
                <td colspan="3">
                    <input type="text" id="so_pr" size="60" name="so_pr" value="<?= htmlspecialchars($aut["SO_PR"], ENT_QUOTES) ?>"/>
                </td>
                </td>
            </tr>
            <tr>
                <td>Ім'я:</td>
                <td colspan="3">
                    <input type="text" id="so_im" size="60" name="so_im" value="<?= htmlspecialchars($aut["SO_IM"], ENT_QUOTES) ?>"/>
                </td>
                </td>
            </tr>
            <tr>
                <td>По батькові:</td>
                <td colspan="3">
                    <input type="text" id="so_pb" size="60" name="so_pb" value="<?= htmlspecialchars($aut["SO_PB"], ENT_QUOTES) ?>"/>
                </td>
                </td>
            </tr>
            <tr>
                <th colspan="4">Договір</th>
            </tr>
            <tr>
                <td>Номер:</td>
                <td><input name="ndog" type="text" size="20" value="<?= htmlspecialchars($aut["N_DOG"], ENT_QUOTES) ?>"/></td>
                <td>Дата:</td>
                <td><input name="dtdog" type="text"  size="20" class="datepicker" value=""/></td>
            </tr>
            <tr>
                <td align="center" colspan="4">
                    <input name="Ok" type="submit" style="width:80px" value="Змінити"/></td>
            </tr>
        </table>
    </form>
    <script language="JavaScript">
        $(function () {
            $(".datepicker").datepicker("setDate",'<?= german_date($aut["DT_DOG"]) ?>');
        });
    </script>
    <?php
}
mysql_free_result($atu);
