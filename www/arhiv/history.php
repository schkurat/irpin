<?php
include_once "../function.php";

$npr = date_bd($_GET['npr']);
$kpr = date_bd($_GET['kpr']);
$subj = (int)$_GET['subj'];
?>
<style>
    .subj_info {
        background-color: #fffef6;
        padding: 5px;
    }

    .subj_info h3 {
        text-align: center;
        margin-top: 5px;
    }

    .subj_info p {
        margin: 5px 0;
    }

    .subj_info span {
        font-weight: bold;
        padding: 5px;
    }

    .fal {
        padding: 5px 2px;
    }

    .fa-paperclip {
        color: #009aff;
    }
</style>
<?php
$sql = "SELECT * FROM yur_kl WHERE EDRPOU='$subj' AND DL='1'";
$atu = mysql_query($sql);
while ($aut = mysql_fetch_array($atu)) {
    ?>
    <div class="subj_info">
        <h3><?= $aut['NAME_F'] ?></h3>
        <p><span>Договір №</span><?= $aut['N_DOG'] ?> <span>від</span> <?= german_date($aut['DT_DOG']) ?>
            <span>ЄДРПОУ:</span> <?= $aut['EDRPOU'] ?> <span>ІПН:</span> <?= $aut['IPN'] ?>
            <span>Свідоцтво:</span> <?= $aut['SVID'] ?></p>
        <p><span>Рахунок:</span> <?= $aut['RR'] ?> <span>Банк:</span> <?= $aut['BANK'] ?>
            <span>МФО:</span> <?= $aut['MFO'] ?></p>
        <p><span>Керівник:</span> <?= $aut['BOSS_F'] ?> <span>Діє на підставі:</span> <?= $aut['PIDSTAVA'] ?></p>
        <p><span>Адреса:</span> <?= $aut['ADRES'] ?> <span>Телефон:</span> <?= $aut['TELEF'] ?>
            <span>E-mail:</span> <?= $aut['EMAIL'] ?></p>
        <p><span>Сертифікована особа:</span> <?= $aut['SO_PR'] ?> <?= $aut['SO_IM'] ?> <?= $aut['SO_PB'] ?> <span>Сертифікат:</span> <?= $aut['SERT_S'] ?> <?= $aut['SERT_N'] ?>
            <span>ІПН:</span> <?= $aut['SO_IPN'] ?></p>
        <p><span>Вимірювальний прилад:</span> <?= $aut['PRILAD'] ?></p>

    </div>
    <?php
}
mysql_free_result($atu);

$sql = "SELECT arhiv_zakaz.KEY, arhiv_zakaz.SZ, arhiv_zakaz.NZ, arhiv_jobs.name,arhiv_jobs.type, arhiv_jobs.id, rayonu.RAYON,
                rayonu.ID_RAYONA,nas_punktu.NSP, tup_nsp.TIP_NSP,vulutsi.VUL,tup_vul.TIP_VUL,arhiv_dop_adr.bud,
                arhiv_dop_adr.kvar, arhiv_dop_adr.status, arhiv_dop_adr.id  
		FROM arhiv_zakaz 
            LEFT JOIN arhiv_jobs ON arhiv_zakaz.VUD_ROB=arhiv_jobs.id 
            LEFT JOIN arhiv_dop_adr ON arhiv_zakaz.KEY=arhiv_dop_adr.id_zm 
            LEFT JOIN rayonu ON rayonu.ID_RAYONA=arhiv_dop_adr.rn 
            LEFT JOIN nas_punktu ON nas_punktu.ID_NSP=arhiv_dop_adr.ns 
            LEFT JOIN vulutsi ON vulutsi.ID_VUL=arhiv_dop_adr.vl
            LEFT JOIN tup_nsp ON tup_nsp.ID_TIP_NSP=nas_punktu.ID_TIP_NSP
            LEFT JOIN tup_vul ON tup_vul.ID_TIP_VUL=vulutsi.ID_TIP_VUL
		WHERE 
			arhiv_zakaz.EDRPOU='$subj' AND arhiv_zakaz.D_PR>'$npr' AND arhiv_zakaz.D_PR<'$kpr' AND arhiv_zakaz.DL='1'  
		ORDER BY arhiv_zakaz.SZ,arhiv_zakaz.NZ DESC";
//    echo $sql;
$atu = mysql_query($sql);
$count_result = mysql_num_rows($atu);
if ($count_result > 0) {
    ?>
    <table class="zmview fixtable">
        <thead>
        <tr>
            <th>Адреса</th>
            <th>Д1</th>
            <th>Д2</th>
            <th>Д3</th>
            <th>Д4</th>
            <th>Д5</th>
            <th>Д6</th>
        </tr>
        </thead>
        <tbody>
        <?php
        while ($aut = mysql_fetch_array($atu)) {
            $d1 = $d2 = $d3 = $d4 = $d5 = $d6 = '';
            $address = $aut["RAYON"] . " " . $aut["TIP_NSP"] . $aut["NSP"] . " " . $aut["TIP_VUL"] . $aut["VUL"] . " " . objekt_ner(1, trim($aut["bud"]), trim($aut["kvar"]));
            if ($aut["type"] == 3) {
                $d1 = '<a href="print_dod.php?kl=' . $aut["KEY"] . '&dod=1" class="text-link" title="Додаток 1 до договору"><i class="fal fa-paperclip d1">1</i></a>';
                $d2 = '<a href="print_dod.php?kl=' . $aut["KEY"] . '&dod=2" class="text-link" title="Додаток 2 до договору"><i class="fal fa-paperclip d2">2</i></a>';
                $d3 = '<a href="print_dod.php?kl=' . $aut["KEY"] . '&dod=3" class="text-link" title="Додаток 3 до договору"><i class="fal fa-paperclip d3">3</i></a>';
            } elseif ($aut["type"] == 1) {
                $d4 = '<a href="print_dod.php?kl=' . $aut["KEY"] . '&dod=4" class="text-link" title="Додаток 4 до договору"><i class="fal fa-paperclip d4">4</i></a>';
                $d5 = '<a href="print_dod.php?kl=' . $aut["KEY"] . '&dod=5" class="text-link" title="Додаток 5 до договору"><i class="fal fa-paperclip d5">5</i></a>';
                if ($aut["status"] != 2) {
                    $d6 = '<a href="print_dod.php?kl=' . $aut["KEY"] . '&dod=6&kl_adr=' . $aut["id"] . '" title="Додаток 6 до договору"><i class="fal fa-paperclip d6">6</i></a>';
                }
            }
            ?>
            <tr>
                <td><?= $address ?></td>
                <td><?= $d1 ?></td>
                <td><?= $d2 ?></td>
                <td><?= $d3 ?></td>
                <td><?= $d4 ?></td>
                <td><?= $d5 ?></td>
                <td><?= $d6 ?></td>
            </tr>
            <?php
        }
        ?>
        </tbody>
    </table>
    <?php
}
mysql_free_result($atu);
?>

<script language="JavaScript">
    $(document).ready(function () {
        $('.zmview').on('mouseover', '.fa-inbox-out', function () {
            $(this).css('cursor', 'pointer');
        }).on('click', '.fa-inbox-out', function () {
            let element = $(this);
            let kl = element.data("kl");
            $.ajax({
                type: "GET",
                url: "vudacha.php",
                data: "kl=" + kl,
                dataType: "html",
                success: function (html) {
                    if (html == '1') {
                        element.remove();
                    }
                },
                error: function (html) {
                    alert(html.error);
                }
            });
        });
    });
</script>
