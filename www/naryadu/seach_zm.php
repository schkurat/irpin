<?php
session_start();
$lg = $_SESSION['LG'];
$pas = $_SESSION['PAS'];
header('Content-Type: text/html; charset=utf-8');

include "../function.php";
$p = '<tr><th>Замовлення</th><th>ПІБ (Назва)</th><th>Адреса</th><th>Сума аванса</th><th>Сума доплати</th></tr>';

$db = mysql_connect("localhost", $lg, $pas);
if (!$db) echo "Не вiдбулося зєднання з базою даних";
if (!@mysql_select_db(kpbti, $db)) {
    echo("Не завантажена таблиця");
    exit();
}

if (isset($_POST['szam']) and isset($_POST['nzam'])) {
    $szam = (isset($_POST['szam'])) ? $_POST['szam'] : '';
    $nzam = (isset($_POST['nzam'])) ? $_POST['nzam'] : '';
    $prz = (isset($_POST['prz'])) ? $_POST['prz'] : '';
    $filter = '';
    if(!empty($prz)){
        $filter = " LOCATE('$prz',PR)!=0 AND ";
    }
    if(!empty($szam) && !empty($nzam)){
        $filter .= " zamovlennya.SZ='$szam' AND zamovlennya.NZ='$nzam' AND ";
    }

    if (!empty($filter)) {
        $ath = mysql_query("SELECT zamovlennya.*,nas_punktu.NSP,tup_nsp.TIP_NSP,vulutsi.VUL,
	tup_vul.TIP_VUL FROM zamovlennya,nas_punktu,vulutsi,tup_nsp,tup_vul 
	WHERE " . $filter . " zamovlennya.DL='1'  
	AND nas_punktu.ID_NSP=zamovlennya.NS 
	AND vulutsi.ID_VUL=zamovlennya.VL 
	AND tup_nsp.ID_TIP_NSP=nas_punktu.ID_TIP_NSP 
	AND tup_vul.ID_TIP_VUL=vulutsi.ID_TIP_VUL;");
        if ($ath) {
            while ($aut = mysql_fetch_array($ath)) {
                $fio = $aut["PR"] . " " . $aut["IM"] . " " . $aut["PB"];
                $obj_ner = objekt_ner(1, $aut["BUD"], $aut["KVAR"]);
                $adr = $aut["TIP_NSP"] . $aut["NSP"] . " " . $aut["TIP_VUL"] . $aut["VUL"] . " " . $obj_ner;
                $sum = $aut["SUM"];
                $sumd = $aut["SUM_D"];
                $zak = $aut["SZ"] . "/" . $aut["NZ"];

                $p .= '<tr><td class="search-nz" data-sz="' . $aut["SZ"] . '" data-nz="' . $aut["NZ"] . '">' . $zak . '</td><td>' . $fio . '</td><td>' . $adr . '</td><td>' . $sum . '</td><td>' . $sumd . '</td></tr>';
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