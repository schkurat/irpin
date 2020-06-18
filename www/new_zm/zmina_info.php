<?php
include "../scriptu.php";
include "../function.php";
?>
    <script type="text/javascript">

        $(document).ready(function () {
            $('#idn').bind('blur', net_fokusa);
            $('#dl_ofor').bind('blur', s_vart);
            $('#plos').bind('blur', sum_vart);
            $('#bt1').click(ShowElement);
            $('#bt2').click(HideElement);
            $('#add_ns').click(add_nsp);
            $('#add_vl').click(add_vul);
            $('input.bt').click(HideElement_cancel);
        });

        function net_fokusa(eventObj) {
            $.ajax({
                type: "POST",
                url: "test_idn.php",
                data: 'kod=' + $("#idn").val(),
                dataType: "html",
                success: function (html) {
                    var reply = html.split(":", 4);
                    $("#pr").val(reply[0]);
                    $("#im").val(reply[1]);
                    $("#pb").val(reply[2]);
                    $("#dn").val(reply[3]);
                },
                error: function (html) {
                    alert(html.error);
                }
            });
        }

        function s_vart(eventObj) {
            $.ajax({
                type: "POST",
                url: "var_rob.php",
                data: 'vr=' + $("#dl_ofor").val(),
                dataType: "html",
                success: function (html) {
                    var rep = html.split(":", 4);
                    if (rep[1] == 1) {
                        $("#plos").attr("disabled", "disabled");
                        $("#plos").val("");
                        $("#sm").val(rep[0]);
                        $("#sumt").val(0);
                    }
                    if (rep[1] == 2) {
                        $("#plos").attr("disabled", "");
                        $("#idpr").val(rep[2]);
                        $("#sumt").val(rep[0]);
                        $("#sm").val(rep[0]);
                    }
                },
                error: function (html) {
                    alert(html.error);
                }
            });
        }

        function sum_vart(eventObj) {
            $.ajax({
                type: "POST",
                url: "var_rob2.php",
                data: 'kl=' + $("#idpr").val() + '&sm=' + $("#sumt").val() + '&pl=' + $("#plos").val(),
                dataType: "html",
                success: function (html) {
                    var rp = html;
                    $("#sm").val(rp);
                },
                error: function (html) {
                    alert(html.error);
                }
            });
        }

        function ShowElement() {
            $("#add_vul").fadeOut();
            $("#add_nas_punkt").fadeIn(3000);
        }

        function HideElement() {
            $("#add_nas_punkt").fadeOut();
            $("#add_vul").fadeIn(3000);
        }

        function HideElement_cancel() {
            $("#add_nas_punkt").fadeOut();
            $("#add_vul").fadeOut();
        }

        function add_nsp(eventObj) {
            $.ajax({
                type: "POST",
                url: "nspadd.php",
                data: 'nsp2=' + $("#nsp2").val() + '&tup2=' + $("#tup2").val(),
                dataType: "html",
                success: function (html) {
                    var rp = html;
                    if (rp == '1') {
                        $("#nas_punkt :nth-child(1)").attr("selected", "selected");
                        $("#vulutsya").empty();
                        $("#nas_punkt").attr("disabled", false);
                        $("#vulutsya").attr("disabled", "disabled");
                        HideElement_cancel();
                    }
                },
                error: function (html) {
                    alert(html.error);
                }
            });
        }

        function add_vul(eventObj) {
            $.ajax({
                type: "POST",
                url: "vladd.php",
                data: 'nsp3=' + $("#nas_punkt3").val() + '&vul3=' + $("#vul3").val() + '&tup3=' + $("#tup3").val(),
                dataType: "html",
                success: function (html) {
                    var rp = html;
                    if (rp == '1') {
                        $("#nas_punkt :nth-child(1)").attr("selected", "selected");
                        $("#vulutsya").empty();
                        $("#nas_punkt").attr("disabled", false);
                        $("#vulutsya").attr("disabled", "disabled");
                        HideElement_cancel();
                    }
                },
                error: function (html) {
                    alert(html.error);
                }
            });
        }
    </script>
    <body>
    <div id="add_nas_punkt">
        <table>
            <tr>
                <th colspan="2">Додавання нового нас. пункту</th>
            </tr>
            <tr>
                <td colspan="2">
                    Район<br>
                    <select class="sel_ad" id="rayon2" name="rajon2">
                        <option value="0">Оберіть район</option>
                        <?php
                        $id_rn = '';
                        $rajn = '';
                        $sql = "SELECT rayonu.ID_RAYONA,rayonu.RAYON FROM rayonu ORDER BY rayonu.ID_RAYONA";
                        $atu = mysql_query($sql);
                        while ($aut = mysql_fetch_array($atu)) {
                            $dl_s = strlen($aut["RAYON"]) - 10;
                            $n_rjn = substr($aut["RAYON"], 0, $dl_s);
                            echo '<option ' . $sl[$aut["ID_RAYONA"]] . ' value="' . $aut["ID_RAYONA"] . '">' . $n_rjn . '</option>';
                        }
                        mysql_free_result($atu);
                        ?>
                    </select></td>
            </tr>
            <tr>
                <td colspan="2">
                    Назва населеного пункту<br><input type="text" id="nsp2" name="nsp2" value=""
                                                      style="width:200px;"/><br>
                    Тип населеного пункту<br>
                    <select id="tup2" name="tup2" class="sel_ad">
                        <option value="0">Оберіть тип</option>
                        <?php
                        $sql = "SELECT tup_nsp.ID_TIP_NSP,tup_nsp.TIP_NSP FROM tup_nsp ORDER BY tup_nsp.ID_TIP_NSP";
                        $atu = mysql_query($sql);
                        while ($aut = mysql_fetch_array($atu)) {
                            echo '<option value="' . $aut["ID_TIP_NSP"] . '">' . $aut["TIP_NSP"] . '</option>';
                        }
                        mysql_free_result($atu);
                        ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td align="center">
                    <input type="button" id="add_ns" name="ok" style="width:80px;margin-top:15px;" value="Ок">
                </td>
                <td align="center">
                    <input type="button" class="bt" style="width:80px;margin-top:15px;" value="Вiдмiна">
                </td>
            </tr>
        </table>
    </div>
    <div id="add_vul">
        <table>
            <tr>
                <th colspan="2">Додавання нової вулиці</th>
            </tr>
            <tr>
                <td colspan="2">
                    Район<br>
                    <select class="sel_ad" id="rayon3" name="rajon3">
                        <option value="0">Оберіть район</option>
                        <?php
                        $id_rn = '';
                        $rajn = '';
                        $sql = "SELECT rayonu.ID_RAYONA,rayonu.RAYON FROM rayonu ORDER BY rayonu.ID_RAYONA";
                        $atu = mysql_query($sql);
                        while ($aut = mysql_fetch_array($atu)) {
                            $dl_s = strlen($aut["RAYON"]) - 10;
                            $n_rjn = substr($aut["RAYON"], 0, $dl_s);
                            echo '<option ' . $sl[$aut["ID_RAYONA"]] . ' value="' . $aut["ID_RAYONA"] . '">' . $n_rjn . '</option>';
                        }
                        mysql_free_result($atu);
                        ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    Населений пункт: <br><select class="sel_ad" id="nas_punkt3" name="nsp3"
                                                 disabled="disabled"></select>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    Назва<br><input type="text" size="25" id="vul3" name="vul3" value="" style="width:200px"/>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    Тип<br>
                    <select id="tup3" name="tup3" class="sel_ad">
                        <option value="0">Оберіть тип</option>
                        <?php
                        $sql = "SELECT tup_vul.ID_TIP_VUL,tup_vul.TIP_VUL FROM tup_vul ORDER BY tup_vul.ID_TIP_VUL";
                        $atu = mysql_query($sql);
                        while ($aut = mysql_fetch_array($atu)) {
                            echo '<option value="' . $aut["ID_TIP_VUL"] . '">' . $aut["TIP_VUL"] . '</option>';
                        }
                        mysql_free_result($atu);
                        ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td align="center">
                    <input type="button" id="add_vl" name="ok" style="width:80px;margin-top:15px;" value="Ок">
                </td>
                <td align="center">
                    <input type="button" class="bt" style="width:80px;margin-top:15px;" value="Вiдмiна">
                </td>
            </tr>
        </table>
    </div>
    <?php
    $kl = $_GET['kl'];
    $prav = $_GET['fl'];
    $filter = array(
        "zakaz" => "readonly",
        "kod_os" => "readonly",
        "tup_zam" => "readonly",
        "prizv" => "readonly",
        "prim" => "readonly",
        "zvat" => "readonly",
        "otche" => "readonly",
        "nard" => "readonly",
        "pasp" => "readonly",
        "telefon" => "readonly",
        "email" => "readonly",
        "budunok" => "readonly",
        "kvartura" => "readonly",
        "vartist" => "readonly",
        /* "vuhidd"=>"readonly", */
        "gotd" => "readonly");
    if ($prav == "prizv") {
        $filter[$prav] = "";
        $filter["kod_os"] = "";
        $filter["zvat"] = "";
        $filter["otche"] = "";
        $filter["nard"] = "";
        $filter["pasp"] = "";
        $filter["telefon"] = "";
        $filter["email"] = "";
    }
    if ($prav == "vud_zm") {
        $filter[$prav] = "";
        $filter["tup_zam"] = "";
        $filter["vartist"] = "";
    }
    if ($prav == "prim") {
        $filter[$prav] = "";
    }
    $filter[$prav] = "";
    if ($prav == "adres") {
        $adr = "123";
        $filter[budunok] = "";
        $filter[kvartura] = "";
    } else {
        $adr = "";
    }

    $sql = "SELECT zamovlennya.*,rayonu.*,dlya_oformlennya.document,nas_punktu.NSP, tup_nsp.TIP_NSP,vulutsi.VUL,tup_vul.TIP_VUL
			 FROM zamovlennya, rayonu, nas_punktu, vulutsi, tup_nsp, tup_vul, dlya_oformlennya
				WHERE 
					zamovlennya.KEY='$kl' AND zamovlennya.DL='1' 
					AND rayonu.ID_RAYONA=RN 
					AND dlya_oformlennya.id_oform=VUD_ROB
					AND nas_punktu.ID_NSP=NS
					AND vulutsi.ID_VUL=VL
					AND tup_nsp.ID_TIP_NSP=nas_punktu.ID_TIP_NSP
					AND tup_vul.ID_TIP_VUL=vulutsi.ID_TIP_VUL";
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
    $zaka_z = get_num_order($aut["ID_RAYONA"], $aut["SZ"], $aut["NZ"]);
    $zm_rn = $aut["ID_RAYONA"];
    $zm_ns = $aut["NS"];
    $zm_vl = $aut["VL"];
    $zm_bd = $aut["BUD"];
    $zm_kv = $aut["KVAR"];
    $zm_sum = $aut["SUM"];
    $zm_dt_got = $aut["DATA_GOT"];

    $vst_vr = '<select id="dl_ofor" name="vud_rob" ' . $filter["tup_zam"] . '>
<option value="">Оберіть вид робіт</option>';

    $sql1 = "SELECT id_oform,document FROM dlya_oformlennya WHERE ROB=1 ORDER BY document";
    $atu1 = mysql_query($sql1);
    while ($aut1 = mysql_fetch_array($atu1)) {
        if ($aut["document"] == $aut1["document"]) $vst_vr .= '<option selected value="' . $aut1["id_oform"] . '">' . $aut1["document"] . '</option>';
        else $vst_vr .= '<option value="' . $aut1["id_oform"] . '">' . $aut1["document"] . '</option>';
    }
    mysql_free_result($atu1);
    $vst_vr .= '</select>';

    ?>
    <form action="update_info.php" name="myform" method="post">
        <table align="" class="zmview">
            <tr>
                <th colspan="4" style="font-size: 35px;"><b>Редагування замовлення</b></th>
            </tr>
            <tr>
                <td>Номер замовлення</td>
                <td><input type="text" name="nzam" value="<?= $zaka_z ?>"<?= $filter["zakaz"] ?>/></td>
                <td><input id="r1" type="radio" name="vud_zam" value="1" <?= $fiz ?>/><label for="r1">Фізичне</label>
                </td>
                <td><input id="r2" type="radio" name="vud_zam" value="2" <?= $yur ?>/><label for="r2">Юридичне</label>
                </td>
            </tr>
            <tr>
                <td>ІДН замовника:</td>
                <td colspan="3"><input type="text" id="idn" size="12" maxlength="12" name="kod"
                                       value="<?= $aut["IDN"] ?>"<?= $filter["kod_os"] ?>/></td>
                <input type="hidden" id="idpr" name="idpr" value="0"/>
                <input type="hidden" id="sumt" name="sumt" value="0"/>
                <input type="hidden" name="kll" value="<?= $kl ?>"/>
            </tr>
            <tr>
                <td>Для оформлення:</td>
                <td colspan="3">
                    <?= $vst_vr ?>
                </td>
            </tr>
            <tr>
                <td>Прізвище (назва):</td>
                <td colspan="3"><input type="text" id="pr" size="59" maxlength="150" name="priz"
                                       value="<?= $priz ?>"<?= $filter["prizv"] ?>/></td>
            </tr>
            <tr>
                <td>Імя:</td>
                <td colspan="3"><input type="text" id="im" size="20" maxlength="20" name="imya"
                                       value="<?= $aut["IM"] ?>"<?= $filter["zvat"] ?>/></td>
            </tr>
            <tr>
                <td>Побатькові:</td>
                <td colspan="3"><input type="text" id="pb" size="20" maxlength="20" name="pobat"
                                       value="<?= $aut["PB"] ?>"<?= $filter["otche"] ?>/></td>
            </tr>
            <tr>
                <td>Примітка:</td>
                <td colspan="3"><input type="text" id="prim" size="59" name="prim"
                                       value="<?= $aut["PRIM"] ?>"<?= $filter["prim"] ?>/></td>
            </tr>
            <tr>
                <td>Дата народження:</td>
                <td colspan="3"><input type="text" id="dn" size="10" maxlength="10" name="dnar"
                                       value="<?= german_date($aut["D_NAR"]) ?>"<?= $filter["nard"] ?>/></td>
            </tr>
            <tr>
                <td>Паспорт:</td>
                <td colspan="3"><input type="text" id="pasport" size="30" maxlength="30" name="pasport"
                                       value="<?= $aut["PASPORT"] ?>"<?= $filter["pasp"] ?>/></td>
            </tr>
            <tr>
                <td>Телефон:</td>
                <td colspan="3"><input type="text" size="25" maxlength="25" name="tel"
                                       value="<?= $aut["TEL"] ?>"<?= $filter["telefon"] ?>/>
                    E-mail:<input type="text" size="20" name="email"
                                  value="<?= $aut["EMAIL"] ?>"<?= $filter["email"] ?>/>
                </td>
            </tr>
            <?php
            if ($adr == "") {
                ?>
                <tr>
                    <td>Район:</td>
                    <td colspan="3">
                        <div class="border">
                            <select class="sel_ad" name="rjn" required>
                                <option value="<?= $aut["RN"] ?>"><?= $aut["RAYON"] ?></option>
                            </select>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>Населений пункт:</td>
                    <td colspan="3">
                        <div class="border">
                            <select class="sel_ad" name="nsp" readonly>
                                <option value="<?= $aut["NS"] ?>"><?= $aut["NSP"] . ' ' . $aut["TIP_NSP"] ?></option>
                            </select>
                            <input type="button" id="bt1" value="Додати нас. пункт" disabled/>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>Вулиця:</td>
                    <td colspan="3">
                        <div class="border">
                            <select class="sel_ad" name="vyl" readonly>
                                <option value="<?= $aut["VL"] ?>"><?= $aut["VUL"] . ' ' . $aut["TIP_VUL"] ?></option>
                            </select>
                            <input type="button" id="bt2" value="Додати вулицю" disabled/>
                        </div>
                    </td>
                </tr>
                <?php
            } else {
                ?>
                <tr>
                    <td>Район:</td>
                    <td colspan="3">
                        <div class="border">
                            <select class="sel_ad" id="rayon" name="rjn" required>
                                <option value="">Оберіть район</option>
                                <?php
                                $sql = "SELECT rayonu.ID_RAYONA,rayonu.RAYON FROM rayonu ORDER BY rayonu.ID_RAYONA";
                                $atu = mysql_query($sql);
                                while ($aut = mysql_fetch_array($atu)) {
                                    $dl_s = strlen($aut["RAYON"]) - 10;
                                    $n_rjn = substr($aut["RAYON"], 0, $dl_s);
                                    $selected = ($aut["ID_RAYONA"] == $zm_rn) ? 'selected' : '';
                                    echo '<option ' . $selected . ' value="' . $aut["ID_RAYONA"] . '">' . $n_rjn . '</option>';
                                }
                                mysql_free_result($atu);
                                ?>
                            </select>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>Населений пункт:</td>
                    <td colspan="3">
                        <div class="border">
                            <input type="hidden" id="idns" value="<?= $zm_ns ?>">
                            <select class="sel_ad" id="nas_punkt" name="nsp" required>
                                <option value="">Оберіть населений пункт</option>
                                <?php
                                $sql = "SELECT nas_punktu.ID_NSP,nas_punktu.NSP,tup_nsp.TIP_NSP FROM nas_punktu,tup_nsp 
		                                WHERE nas_punktu.ID_TIP_NSP=tup_nsp.ID_TIP_NSP ORDER BY nas_punktu.ID_NSP";
                                $atu = mysql_query($sql);
                                while ($aut = mysql_fetch_array($atu)) {
                                    echo '<option value="' . $aut["ID_NSP"] . '">' . $aut["NSP"] . ' ' . $aut["TIP_NSP"] . '</option>';
                                }
                                mysql_free_result($atu);
                                ?>
                            </select>
                            <input type="button" id="bt1" value="Додати нас. пункт" style="width:125px;"/>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>Вулиця:</td>
                    <td colspan="3">
                        <div class="border">
                            <input type="hidden" id="idvl" value="<?= $zm_vl ?>">
                            <select class="sel_ad" id="vulutsya" name="vyl" disabled="disabled" required></select>
                            <input type="button" id="bt2" value="Додати вулицю" style="width:125px;"/>
                        </div>
                    </td>
                </tr>
                <?php
            }
            ?>
            <tr>
                <td>Будинок:</td>
                <td><input type="text" size="10" maxlength="10" name="bud"
                           value="<?= $zm_bd ?>"<?= $filter["budunok"] ?>/></td>
                <td>Квартира:</td>
                <td><input type="text" size="3" maxlength="3" name="kvar"
                           value="<?= $zm_kv ?>"<?= $filter["kvartura"] ?>/></td>
            </tr>
            <tr>
                <td>Сума:</td>
                <td colspan="3"><input type="text" id="sm" size="20" maxlength="20" name="sum"
                                       value="<?= $zm_sum ?>"<?= $filter["vartist"] ?>/></td>
            </tr>
            <tr>
                <td>Дата готовності:</td>
                <td colspan="3">
                    <input type="text" id="date1" size="10" maxlength="10" name="datag"
                           value="<?= german_date($zm_dt_got) ?>"<?= $filter["gotd"] ?>/></td>
            </tr>
            <tr>
                <td colspan="2" align="center"><input type="submit" id="submit" value="Редагувати"></td>
                <td colspan="2" align="center"><input name="reset" type="reset" id="reset" value="Очистити"></td>
            </tr>
        </table>
    </form>
    <?php
}
mysql_free_result($atu);
?>