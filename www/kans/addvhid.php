<?php
require('top.php');
include "../function.php";
include "../scriptu.php";
?>
    <script type="text/javascript">
        $(document).ready(function () {
            // $("#ex").autocompleteArray([
            //         "виготовити свідоцтво про право власності на майно",
            //         "видати свідоцтво про право власності на майно",
            //         "за ким зареєстровано майно по",
            //         "зняти арешт",
            //         "надати копії технічної документації",
            //         "накласти арешт",
            //         "позивач-",
            //         "про належність земельної ділянки",
            //         "про належність власності",
            //         "чи зареєстрована власність"],
            //     {
            //         delay: 10,
            //         minChars: 1,
            //         matchSubset: 1,
            //         autoFill: true,
            //         maxItemsToShow: 10
            //     }
            // );

            // $(".worker").autocomplete("../js/robitnuk.php", {
            //     delay: 10,
            //     minChars: 2,
            //     matchSubset: 1,
            //     autoFill: true,
            //     matchContains: 1,
            //     cacheLength: 10,
            //     selectFirst: true,
            //     formatItem: liFormat,
            //     maxItemsToShow: 30,
            // });

            $('#bt1').click(ShowElement);
            $('#bt2').click(HideElement);
            $('#add_ns').click(add_nsp);
            $('#add_vl').click(add_vul);
            $('input.bt').click(HideElement_cancel);


            $('#vulutsya').change(searchArhiv);
            $('#bd, #kv').keyup(searchArhiv);
            $('#e_arhiv').on('click', '.set-arh-item', selectArhiv);
            $('#e_arhiv').on('click', '.del-file', delFile);
            $('#kores, #nkores').change(checkEaSelect);

        });

        // function liFormat(row, i, num) {
        //     let result = row[0];
        //     return result;
        // }

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
                data: 'rajon2=' + $("#rayon2").val() + '&nsp2=' + $("#nsp2").val() + '&tup2=' + $("#tup2").val(),
                dataType: "html",
                success: function (html) {
                    var rp = html;
                    if (rp == '1') {
                        $("#rayon :nth-child(1)").attr("selected", "selected");
                        $("#nas_punkt").empty();
                        $("#vulutsya").empty();
                        $("#nas_punkt").attr("disabled", "disabled");
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
                data: 'rajon3=' + $("#rayon3").val() + '&nsp3=' + $("#nas_punkt3").val() + '&vul3=' + $("#vul3").val() + '&tup3=' + $("#tup3").val(),
                dataType: "html",
                success: function (html) {
                    var rp = html;
                    if (rp == '1') {
                        $("#rayon :nth-child(1)").attr("selected", "selected");
                        $("#nas_punkt").empty();
                        $("#vulutsya").empty();
                        $("#nas_punkt").attr("disabled", "disabled");
                        $("#vulutsya").attr("disabled", "disabled");
                        HideElement_cancel();
                    }
                },
                error: function (html) {
                    alert(html.error);
                }
            });
        }

        // jQuery(function ($) {
        //     $("#date1").mask("99.99.9999");
        //     $("#date2").mask("99.99.9999");
        //     $("#date3").mask("99.99.9999");
        //     $("#chas").mask("99:99:99");
        //     $("#phone").mask("99-99-99");
        //     $("#tin").mask("99-9999999");
        //     $("#ssn").mask("999-99-9999");
        // });
    </script>

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
    <form action="vhidadd.php" name="myform" method="post" enctype="multipart/form-data" style="float: left;">
        <table class="zmview">
            <tr>
                <th colspan="5">Інформація про об'єкт</th>
            </tr>
            <tr>
                <td>Район:</td>
                <td colspan="3">
                    <div class="border">
                        <select class="sel_ad" id="rayon" name="rajon">
                            <option value="">Оберіть район</option>
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
                    </div>
                </td>
            </tr>
            <tr>
                <td>Населений пункт:</td>
                <td colspan="3">
                    <div class="border">
                        <select class="sel_ad" id="nas_punkt" name="nsp"></select>
                        <input type="button" id="bt1" value="Додати нас. пункт" style="width:125px;"/>
                    </div>
                </td>
            </tr>
            <tr>
                <td>Вулиця:</td>
                <td colspan="3">
                    <div class="border">
                        <select class="sel_ad" id="vulutsya" name="vyl" disabled="disabled"></select>
                        <input type="button" id="bt2" value="Додати вулицю" style="width:125px;"/>
                    </div>
                </td>
            </tr>
            <tr>
                <td>Будинок:</td>
                <td><input type="text" id="bd" size="10" name="bud" value=""/></td>
                <td>Квартира:</td>
                <td><input type="text" id="kv" size="3" maxlength="3" name="kvar" value=""/></td>
            </tr>
            <tr id="selected_ea" style="display: none;">
                <td colspan="4">
                    <input type="text" name="adr_el_arh" id="adr_el_arh" value=""/>
                    <input type="hidden" name="id_el_arh" id="id_el_arh" value=""/>
                </td>
            </tr>
            <tr>
                <td colspan="2">Файли для електронного архіву</td>
                <td colspan="3">
                    <input type="file" name="file[]" size="40" multiple>
                </td>
            </tr>
            <tr>
                <th colspan="5" align="center">Вхiдна документацiя</th>
            </tr>
            <tr>
                <td>
                    Кореспондент
                </td>
                <td colspan="3">
                    <input type="text" size="40" maxlength="40" id="kores" name="kores" value=""/>
                </td>
            </tr>
            <tr>
                <td>
                    Номер кореспондента
                </td>
                <td>
                    <input type="text" size="20" maxlength="20" id="nkores" name="nkores" value=""/>
                </td>
                <td>
                    Дата кор.
                </td>
                <td colspan="2">
                    <input type="text" id="date1" size="10" maxlength="10" name="datakor" value="<?= date("d.m.Y") ?>"/>
                </td>
            </tr>
            <tr>
                <td>
                    П.I.Б.
                </td>
                <td>
                    <input type="text" size="20" maxlength="20" name="pib" value=""/>
                </td>
                <td>
                    Тип:
                </td>
                <td>
                    <select name="tup" size="1">
                        <option value="арешт, зняття">арешт, зняття</option>
                        <option value="замовлення">замовлення</option>
                        <option selected value="запити інші">запити інші</option>
                        <option value="запити ВДВС">запити ВДВС</option>
                        <option value="листи">листи</option>
                        <option value="позовна заява">позовна заява</option>
                        <option value="судові засідання">судові засідання</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td>
                    Змiст
                </td>
                <td colspan="3">
                    <textarea rows="3" cols="42" id="ex" name="zmist"></textarea>
                </td>
            </tr>
            <tr>
                <td>
                    Дата вхiдної кор.
                </td>
                <td>
                    <input type="text" id="date2" size="10" maxlength="10" name="data_vhod"
                           value="<?= date("d.m.Y") ?>"/>
                </td>
                <td colspan="2">
                    Час: <input type="text" id="chas" size="8" maxlength="8" name="vrem" value="<?= date("H:i:s") ?>"/>
                </td>
            </tr>
            <tr>
                <td>
                    Дата виконання:
                </td>
                <td colspan="3">
                    <input type="text" id="date3" size="10" maxlength="10" name="data_vuk" value="" required/>
                </td>
            </tr>
            <?php
            $robitnuku = '<option value=""></option>';
            $sql = "SELECT ROBS FROM robitnuku WHERE DL='1' AND BRUGADA<8 OR ID_ROB=15 ORDER BY ROBS";
            $atu = mysql_query($sql);
            while ($aut = mysql_fetch_array($atu)) {
                $robitnuku .= '<option value="' . $aut["ROBS"] . '">' . $aut["ROBS"] . '</option>';
            }
            mysql_free_result($atu);
            ?>
            <tr>
                <td>
                    Виконавець1:
                </td>
                <td>
<!--                    <input type="text" id="rob1" class="worker" size="15" maxlength="10" name="vukon1" value=""/>-->
                    <select name="vukon1">
                        <?= $robitnuku ?>
                    </select>
                </td>
                <td>
                    Виконавець3:
                </td>
                <td>
<!--                    <input type="text" id="rob3" class="worker" size="15" maxlength="10" name="vukon3" value=""/>-->
                    <select name="vukon3">
                        <?= $robitnuku ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td>
                    Виконавець2:
                </td>
                <td>
<!--                    <input type="text" id="rob2" class="worker" size="15" maxlength="10" name="vukon2" value=""/>-->
                    <select name="vukon2">
                        <?= $robitnuku ?>
                    </select>
                </td>
                <td>
                    Виконавець4:
                </td>
                <td>
<!--                    <input type="text" id="rob4" class="worker" size="15" maxlength="10" name="vukon4" value=""/>-->
                    <select name="vukon4">
                        <?= $robitnuku ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td align="center" colspan="4">
                    <input type="submit" name="ok" style="width:70px;" value="Ок">
                </td>
            </tr>
        </table>
    </form>
    <table class="zmview" id="e_arhiv" style="display: none;">
        <thead>
        <tr>
            <th colspan="2">Електронний архів</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td>
                <button class="set-arh-item" data-arh="0">+</button>
            </td>
            <td>test</td>
        </tr>
        </tbody>
    </table>
<?php
require('bottom.php');
