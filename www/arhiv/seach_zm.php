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

if ((!empty($_POST['szam']) and !empty($_POST['nzam'])) OR (!empty($_POST['pib']) AND mb_strlen($_POST['pib']) > 2)) {
    $szam = $_POST['szam'];
    $nzam = $_POST['nzam'];
    $pib = $_POST['pib'];

    if (!empty($pib)) {
        $ath = mysql_query("SELECT arhiv_zakaz.* FROM arhiv_zakaz  
	WHERE (LOCATE('$pib',arhiv_zakaz.SUBJ)!=0 OR LOCATE('$pib',arhiv_zakaz.PR)!=0 OR LOCATE('$pib',arhiv_zakaz.IM)!=0) 
	OR LOCATE('$pib',arhiv_zakaz.PB)!=0 AND arhiv_zakaz.DL='1';");
    } else {
        $ath = mysql_query("SELECT arhiv_zakaz.* FROM arhiv_zakaz  
	WHERE arhiv_zakaz.SZ='$szam' AND arhiv_zakaz.NZ='$nzam' AND arhiv_zakaz.DL='1';");
    }
    if ($ath) {
        if (mysql_num_rows($ath) == 0) {
            $p .= '<tr><td colspan="5">Замовлення не знайдено</td></tr>';
        } else {
            while ($aut = mysql_fetch_array($ath)) {
                $subj = (!empty($aut["SUBJ"])) ? htmlspecialchars($aut["SUBJ"], ENT_QUOTES) : $aut["PR"] . ' ' . $aut["IM"] . ' ' . $aut["PB"];
                $fio = $aut["PR"] . " " . $aut["IM"] . " " . $aut["PB"];
                $address = '';
                $sum = $aut["SUM"];
                //$sumd=$aut["SUM_D"];
                $zak = $aut["SZ"] . "/" . $aut["NZ"];
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
        }
        mysql_free_result($ath);
    }
    if (mysql_close($db)) {
    } else {
        echo("Не можливо виконати закриття бази");
    }
} elseif (isset($_POST['address']) and !empty($_POST['address']) and mb_strlen($_POST['address']) > 2) {
    $adr_key = $_POST['address'];
    $sql1 = "SELECT arhiv_dop_adr.*, arhiv_dop_adr.id AS ID, rayonu.RAYON,nas_punktu.NSP,tup_nsp.TIP_NSP,
			vulutsi.VUL,tup_vul.TIP_VUL,arhiv_zakaz.SZ,arhiv_zakaz.NZ,arhiv_zakaz.SUBJ,arhiv_zakaz.PR,arhiv_zakaz.IM,arhiv_zakaz.PB,arhiv_zakaz.SUM   
			 FROM arhiv_dop_adr, rayonu, nas_punktu, vulutsi, tup_nsp, tup_vul, arhiv_zakaz
				WHERE 
					LOCATE('$adr_key',vulutsi.VUL)!=0 AND
					arhiv_zakaz.KEY=arhiv_dop_adr.id_zm 
					AND rayonu.ID_RAYONA=arhiv_dop_adr.rn
					AND nas_punktu.ID_NSP=arhiv_dop_adr.ns
					AND vulutsi.ID_VUL=arhiv_dop_adr.vl
					AND tup_nsp.ID_TIP_NSP=nas_punktu.ID_TIP_NSP
					AND tup_vul.ID_TIP_VUL=vulutsi.ID_TIP_VUL
					ORDER BY arhiv_dop_adr.id DESC";
    $atu1 = mysql_query($sql1);
    while ($aut1 = mysql_fetch_array($atu1)) {
        $zak = $aut1["SZ"] . "/" . $aut1["NZ"];
        $subj = (!empty($aut1["SUBJ"])) ? htmlspecialchars($aut1["SUBJ"], ENT_QUOTES) : $aut1["PR"] . ' ' . $aut1["IM"] . ' ' . $aut1["PB"];
        $bd = trim($aut1["bud"]);
        $kv = trim($aut1["kvar"]);
        $obj_ner_dop = objekt_ner(0, $bd, $kv);
        $address = $aut1["TIP_NSP"] . $aut1["NSP"] . " " . $aut1["TIP_VUL"] . $aut1["VUL"] . " " . $obj_ner_dop;
        $sum = $aut1["SUM"];
        $p .= '<tr><td>' . $zak . '</td><td>' . $subj . '</td><td>' . $address . '</td><td>' . $sum . '</td></tr>';
    }
    mysql_free_result($atu1);
} else {
    $p .= '<tr><td colspan="5">Поле номер замовлення пусте</td></tr>';
}
echo $p;
