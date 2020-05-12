<?php
session_start();
$lg = $_SESSION['LG'];
$pas = $_SESSION['PAS'];
header('Content-Type: text/html; charset=utf-8');

include "../function.php";
$db = mysql_connect("localhost", $lg, $pas);
if (!$db) echo "Не вiдбулося зєднання з базою даних";
if (!@mysql_select_db(kpbti, $db)) {
    echo("Не завантажена таблиця");
    exit();
}
$response = '';
if ($_POST['action'] == 'select') {
    $ie_ea = $_POST['id_ea'];
    $adr = $_POST['adr'];
    $dir = 'ea/' . $ie_ea . '/keeper';
    $response = open_dir($dir, $adr);
} elseif ($_POST['action'] == 'search') {
    $rn = $_POST['rn'];
    $ns = $_POST['ns'];
    $vl = $_POST['vl'];
    $bd = $_POST['bd'];
    $kv = $_POST['kv'];

    $ath = mysql_query("SELECT arhiv.ID,arhiv.N_SPR,arhiv.RN,rayonu.RAYON,nas_punktu.NSP,tup_nsp.TIP_NSP,vulutsi.VUL,tup_vul.TIP_VUL,
                                arhiv.BD,arhiv.KV 
                        FROM arhiv,rayonu,nas_punktu,tup_nsp,vulutsi,tup_vul
                        WHERE arhiv.Dl='1' AND arhiv.RN='$rn' AND arhiv.NS='$ns' AND arhiv.VL='$vl' 
                            AND LOCATE('$bd',arhiv.BD)!=0 AND LOCATE('$kv',arhiv.KV)!=0 
                                AND rayonu.ID_RAYONA=arhiv.RN
                                AND nas_punktu.ID_NSP=arhiv.NS
                                AND vulutsi.ID_VUL=arhiv.VL
                                AND tup_nsp.ID_TIP_NSP=nas_punktu.ID_TIP_NSP
                                AND tup_vul.ID_TIP_VUL=vulutsi.ID_TIP_VUL;");
    if ($ath) {
        while ($aut = mysql_fetch_array($ath)) {
            $inventory_number = ($aut["N_SPR"] > '')? 'Інв. № ' . str_pad($aut["RN"],2,0,STR_PAD_LEFT) . $aut["N_SPR"]: '';
            $obj_ner = objekt_ner(0, $aut["BD"], $aut["KV"]);
            $response .= '<tr>
                        <td>' . $inventory_number . '</td>
                        <td class="arh-item-adr">' . $aut["TIP_NSP"] . $aut["NSP"] . " " . $aut["TIP_VUL"] . $aut["VUL"] . " " . $obj_ner . '</td>
                   </tr>';
        }
        mysql_free_result($ath);
    }
} elseif ($_POST['action'] == 'delete'){
    $url = $_POST['url'];
    $rez = unlink($url);
    if (!$rez) $response = 'Помилка видалення файла!';
}

if (mysql_close($db)) {
} else {
    echo("Не можливо виконати закриття бази");
}

echo $response;