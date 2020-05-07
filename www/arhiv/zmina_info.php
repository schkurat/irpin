<?php
include "../scriptu.php";
include "../function.php";
?>
    <script type="text/javascript">

        $(document).ready(function () {
            $('#dl_ofor').bind('blur', s_vart);
            $('#bt1').click(ShowElement);
            $('#bt2').click(HideElement);
            $('#add_ns').click(add_nsp);
            $('#add_vl').click(add_vul);
            $('input.bt').click(HideElement_cancel);
        });
        function s_vart(eventObj) {
            $.ajax({
                type: "POST",
                url: "var_rob.php",
                data: 'vr=' + $("#dl_ofor").val(),
                dataType: "html",
                success: function (html) {
                    var rep = html.split(":", 2);
                    $("#sm").val(rep[0]);
                    if (rep[1] != '') $("#date1").val(rep[1]);
                },
                error: function (html) {
                    alert(html.error);
                }
            });
        }
    </script>

<?php
$kl = $_GET['kl'];
$prav = $_GET['fl'];
$filter = array(
    "zakaz" => "readonly",
    "edrpou" => "readonly",
    "ipn" => "readonly",
    "svid" => "readonly",
    "subj" => "readonly",
    "adr_subj" => "readonly",
    "prilad" => "readonly",
    "tup_spr" => "readonly",
    "prizv" => "readonly",
    "zvat" => "readonly",
    "otche" => "readonly",
    "sert" => "readonly",
    "pasp" => "readonly",
    "telefon" => "readonly",
    "email" => "readonly",
    "prim" => "readonly",
    "vartist" => "readonly");
if ($prav == "subj") {
    $filter["edrpou"] = "";
    $filter["ipn"] = "";
    $filter["svid"] = "";
    $filter["subj"] = "";
    $filter["adr_subj"] = "";
    $filter["prilad"] = "";
}
if ($prav == "prizv") {
    $filter[$prav] = "";
    $filter["zvat"] = "";
    $filter["otche"] = "";
    $filter["sert"] = "";
}
if ($prav == "telefon") {
    $filter[$prav] = "";
    $filter["email"] = "";
}
if ($prav == "tup_spr") {
    $filter[$prav] = "";
    $filter["vartist"] = "";
}
if ($prav == "prim") {
    $filter[$prav] = "";
}
$filter[$prav] = "";

$sql = "SELECT arhiv_zakaz.*,arhiv_jobs.name FROM arhiv_zakaz, arhiv_jobs
		WHERE arhiv_zakaz.KEY='$kl' AND arhiv_zakaz.DL='1' AND arhiv_jobs.id=VUD_ROB";
$atu = mysql_query($sql);
while ($aut = mysql_fetch_array($atu)) {
    $priz = htmlspecialchars($aut["PR"], ENT_QUOTES);

    if ($aut["TUP_ZAM"] == 1) {
        $fiz = "checked";
        $yur = "";
    } else {
        $fiz = "";
        $yur = "checked";
    }
    $zaka_z = $aut["SZ"] . '/' . $aut["NZ"];

    $vst_vr = '<select id="dl_ofor" name="vud_rob" ' . $filter["tup_spr"] . '>
<option value="">Оберіть вид робіт</option>';

    $sql1 = "SELECT * FROM arhiv_jobs WHERE dl='1' ORDER BY name";
    $atu1 = mysql_query($sql1);
    while ($aut1 = mysql_fetch_array($atu1)) {
        if ($aut["name"] == $aut1["name"]) $vst_vr .= '<option selected value="' . $aut1["id"] . '">' . $aut1["name"] . '</option>';
        else $vst_vr .= '<option value="' . $aut1["id"] . '">' . $aut1["name"] . '</option>';
    }
    mysql_free_result($atu1);
    $vst_vr .= '</select>';
    ?>
    <body>
    <form action="update_zakaz.php" name="myform" method="post">
        <table align="" class="zmview">
            <tr>
                <th colspan="4" style="font-size: 35px;"><b>Редагування замовлення</b></th>
            </tr>
            <tr>
                <td>Номер замовлення</td>
                <td><input type="text" size="10" name="nzam" value="<?= $zaka_z ?>"<?= $filter["zakaz"] ?>/></td>
                <td>ЄДРПОУ:</td>
                <td>
                    <input type="text" id="edrpou" size="10" maxlength="10" name="edrpou" value="<?= $aut[" EDRPOU"] ?>"
                    <?= $filter["edrpou"] ?>/>
                    <input type="hidden" id="idpr" name="idpr" value="0"/>
                    <input type="hidden" id="sumt" name="sumt" value="0"/>
                    <input type="hidden" name="kll" value="<?= $kl ?>"/>
                </td>
            </tr>
            <tr>
                <td>ІПН:</td>
                <td><input type="text" id="ipn" size="15" maxlength="12" name="ipn" value="<?= $aut["IPN"] ?>"
                    <?= $filter["ipn"] ?>/>
                </td>
                <td>Св-тво:</td>
                <td><input type="text" id="svid" size="9" maxlength="9" name="svid" value="<?= $aut["SVID"] ?>"
                    <?= $filter["svid"] ?>/>
                </td>
            </tr>
            <tr>
                <td>Назва суб`єкта:</td>
                <td colspan="3"><input type="text" id="subj" size="59" maxlength="150" name="subj"
                                       value="<?= htmlspecialchars($aut["SUBJ"],ENT_QUOTES) ?>" <?= $filter["subj"] ?>
                    required/>
                </td>
            </tr>
            <tr>
                <td>Адреса суб`єкта:</td>
                <td colspan="3"><input type="text" id="adrs_subj" size="59" maxlength="150" name="adrs_subj"
                                       value="<?= htmlspecialchars($aut["ADR_SUBJ"],ENT_QUOTES) ?>"
                    <?= $filter["adr_subj"] ?> required/>
                </td>
            </tr>
            <tr>
                <td>Вимірювальний прилад:</td>
                <td colspan="3"><input type="text" id="prilad" size="59" maxlength="150" name="prilad"
                                       value="<?= htmlspecialchars($aut["PRILAD"],ENT_QUOTES) ?>" <?= $filter["prilad"] ?>
                    required/>
                </td>
            </tr>
            <tr>
                <td>Прізвище (назва):</td>
                <td colspan="3"><input type="text" id="pr" size="59" maxlength="150" name="priz" value="<?= $priz ?>"<?= $filter["prizv"] ?>/>
                </td>
            </tr>
            <tr>
                <td>Імя:</td>
                <td colspan="3"><input type="text" id="im" size="20" maxlength="20" name="imya"
                                       value="<?= htmlspecialchars($aut["IM"],ENT_QUOTES) ?>"<?= $filter["zvat"] ?>/>
                </td>
            </tr>
            <tr>
                <td>Побатькові:</td>
                <td colspan="3"><input type="text" id="pb" size="20" maxlength="20" name="pobat"
                                       value="<?= htmlspecialchars($aut["PB"],ENT_QUOTES) ?>"<?= $filter["otche"] ?>/>
                </td>
            </tr>
            <tr>
                <td>Сертифікат:</td>
                <td colspan="3"><input type="text" id="ser_sert" size="20" name="sert" value="<?= $aut["SERT"] ?>"
                    <?= $filter["sert"] ?>/>
                </td>
            </tr>
            <tr>
                <td>Телефон:</td>
                <td colspan="3"><input type="text" size="25" maxlength="25" name="tel" value="<?= $aut["TEL"] ?>"<?= $filter["telefon"] ?>/>
                    E-mail:<input type="text" size="20" name="email" value="<?= $aut["EMAIL"] ?>"<?= $filter["email"] ?>/>
                </td>
            </tr>
            <tr>
                <td>Примітка:</td>
                <td colspan="3"><input type="text" id="prim" size="59" name="prim" value="<?= htmlspecialchars($aut["PRIM"],ENT_QUOTES) ?>"<?= $filter["prim"] ?>/>
                </td>
            </tr>
            <tr>
                <td>Доручення:</td>
                <td colspan="3"><input type="text" id="doruch" size="59" maxlength="150" name="doruch"
                                       value="<?= htmlspecialchars($aut["DOR"],ENT_QUOTES) ?>"/>
                </td>
            </tr>
            <tr>
                <td>Тип справи:</td>
                <td colspan="3">
                    <?= $vst_vr ?>
                </td>
            </tr>
            <tr>
                <td>Сума:</td>
                <td colspan="3"><input type="text" id="sm" size="20" maxlength="20" name="sum" value="<?= $aut["SUM"] ?>"<?= $filter["vartist"] ?>/>
                </td>
            </tr>
            <tr>
                <td colspan="4" align="center"><input type="submit" id="submit" value="Редагувати"></td>
            </tr>
        </table>
    </form>
    <?php
}
mysql_free_result($atu);
?>