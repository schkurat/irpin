<?php
session_start();
$lg = $_SESSION['LG'];
$pas = $_SESSION['PAS'];
header('Content-Type: text/html; charset=utf-8');

include "../function.php";
$p = '<tr><th>Замовлення</th><th>ПІБ (Назва)</th><th>Адреса</th><th>Сума</th></tr>';

$db = mysql_connect("localhost", $lg, $pas);
if (!$db) echo "Не вiдбулося зєднання з базою даних";
if (!@mysql_select_db(kpbti, $db)) {
    echo("Не завантажена таблиця");
    exit();
}

if (isset($_POST['szam']) and isset($_POST['nzam'])) {
    $szam = $_POST['szam'];
    $nzam = $_POST['nzam'];


    if ($szam != "" and $nzam != "") {
        $ath = mysql_query("SELECT arhiv_zakaz.* FROM arhiv_zakaz  
	WHERE arhiv_zakaz.SZ='$szam' AND arhiv_zakaz.NZ='$nzam' AND arhiv_zakaz.DL='1';");
        if ($ath) {
            while ($aut = mysql_fetch_array($ath)) {
                $subj = htmlspecialchars($aut["SUBJ"], ENT_QUOTES);
                $fio = $aut["PR"] . " " . $aut["IM"] . " " . $aut["PB"];
                $address = '';
                $sum = $aut["SUM"];
                //$sumd=$aut["SUM_D"];
                $zak = $szam . "/" . $nzam;
                $zm_id = $aut["KEY"];

                $sql1 = "SELECT arhiv_dop_adr.*, arhiv_dop_adr.id AS ID, rayonu.RAYON,nas_punktu.NSP,tup_nsp.TIP_NSP,
			vulutsi.VUL,tup_vul.TIP_VUL
			 FROM arhiv_dop_adr, rayonu, nas_punktu, vulutsi, tup_nsp, tup_vul
				WHERE 
					arhiv_dop_adr.id_zm='$zm_id' 
					AND rayonu.ID_RAYONA=arhiv_dop_adr.rn
					AND nas_punktu.ID_NSP=arhiv_dop_adr.ns
					AND vulutsi.ID_VUL=arhiv_dop_adr.vl
					AND tup_nsp.ID_TIP_NSP=nas_punktu.ID_TIP_NSP
					AND tup_vul.ID_TIP_VUL=vulutsi.ID_TIP_VUL
					ORDER BY arhiv_dop_adr.id DESC";
                //echo $sql1;
                $atu1 = mysql_query($sql1);
                while ($aut1 = mysql_fetch_array($atu1)) {
                    $rayon = $aut1["rn"];
                    $bd = trim($aut1["bud"]);
                    $kv = trim($aut1["kvar"]);
                    $obj_ner_dop = objekt_ner(0, $bd, $kv);
                    $address .= $aut1["TIP_NSP"] . $aut1["NSP"] . " " . $aut1["TIP_VUL"] . $aut1["VUL"] . " " . $obj_ner_dop . "<br>";
                }
                mysql_free_result($atu1);

                $p .= '<tr><td>' . $zak . '</td><td>' . $subj . '</td><td>' . $address . '</td><td>' . $sum . '</td></tr>';
            }
            mysql_free_result($ath);
        }
    } else
        $p .= '<tr><td colspan="5">Замовлення не знайдено</td></tr>';
    //echo 'Текст:вася:петя';
    if (mysql_close($db)) {
    } else {
        echo("Не можливо виконати закриття бази");
    }
} else {
    $p .= '<tr><td colspan="5">Поле номер замовлення пусте</td></tr>';
}
echo $p;
?>