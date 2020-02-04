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
if (isset($_POST['id_ea'])) {
    $ie_ea = $_POST['id_ea'];
    $adr = $_POST['adr'];
    $dir = 'ea/' . $ie_ea . '/priyom';
    $response = open_dir($dir, $adr);
} else {
    $rn = $_POST['rn'];
    $ns = $_POST['ns'];
    $vl = $_POST['vl'];
    $bd = $_POST['bd'];
    $kv = $_POST['kv'];

    $ath = mysql_query("SELECT arhiv.ID,rayonu.RAYON,nas_punktu.NSP,tup_nsp.TIP_NSP,vulutsi.VUL,tup_vul.TIP_VUL,
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
            $obj_ner = objekt_ner(0, $aut["BD"], $aut["KV"]);
            $response .= '<tr>
                        <td><button class="set-arh-item" data-arh="' . $aut["ID"] . '">+</button></td>
                        <td class="arh-item-adr">' . $aut["TIP_NSP"] . $aut["NSP"] . " " . $aut["TIP_VUL"] . $aut["VUL"] . " " . $obj_ner . '</td>
                   </tr>';
        }
        mysql_free_result($ath);
    }
}

if (mysql_close($db)) {
} else {
    echo("Не можливо виконати закриття бази");
}

echo $response;