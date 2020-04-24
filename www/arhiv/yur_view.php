<?php
include_once "../function.php";
?>
<table class="zmview">
    <tr>
        <th>#</th>
        <th>Договір</th>
        <th>Юридична особа</th>
        <th>Сертифікація</th>
        <th>Контактна інформація</th>
        <th>Банк</th>
    </tr>
    <?php
    $sql = "SELECT * FROM yur_kl WHERE yur_kl.DL='1' ORDER BY NAME";
    $atu = mysql_query($sql);
    while ($aut = mysql_fetch_array($atu)) {
        if ($aut["ED_POD"] == '0') $pdv = 'так';
        else $pdv = 'ні';
        ?>
        <tr bgcolor="#FFFAF0">
            <td align="center"><a href="arhiv.php?filter=edit_yur&kl=<?= $aut["ID"] ?>">
                    <img src="../images/b_edit.png" border="0"></a>
            </td>
            <td align="center"><?= $aut["N_DOG"] . '<br>від ' . german_date($aut["DT_DOG"]) . 'р.' ?></td>
            <td><?= $aut["NAME"] ?><br>ЄДРПОУ: <?= $aut["EDRPOU"] ?><br>ІПН: <?= $aut["IPN"] ?><br>Свідоцтво: <?= $aut["SVID"] ?><br>Платник ПДВ: <?= $pdv ?></td>
            <td>Сертифікат: <?= $aut["SERT_S"] . ' ' . $aut["SERT_N"] ?><br><?= $aut["SO_PR"] . ' ' . $aut["SO_IM"] . ' ' . $aut["SO_PB"] ?><br>Прилад: <?= $aut["PRILAD"] ?></td>
            <td><?= $aut["ADRES"] ?><br>Телефон: <?= $aut["TELEF"] ?><br>E-mail: <?= $aut["EMAIL"] ?></td>
            <td><?= $aut["BANK"] ?><br><br>р.р.: <?= $aut["RR"] ?><br>МФО: <?= $aut["MFO"] ?></td>
        </tr>
        <?php
    }
    mysql_free_result($atu);
    ?>
</table>

