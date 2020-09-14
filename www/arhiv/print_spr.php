<?php
session_start();
$lg = $_SESSION['LG'];
$pas = $_SESSION['PAS'];
$pr_prie = $_SESSION['PR'];
$im_prie = $_SESSION['IM'];
$pb_prie = $_SESSION['PB'];
include_once "../function.php";
$kl = (int)$_GET['kl'];
$sp = (int)$_GET['sp'];

$db = mysql_connect("localhost", $lg, $pas);
if (!$db) echo "Не вiдбулося зєднання з базою даних";

if (!@mysql_select_db(kpbti, $db)) {
    echo("Не завантажена таблиця");
    exit();
}

$vukonav = $pr_prie . ' ' . p_buk($im_prie) . '.' . p_buk($pb_prie) . '.';

$sql = "SELECT arhiv_zakaz.SZ, arhiv_zakaz.NZ,arhiv_zakaz.D_PR,arhiv_zakaz.EDRPOU,arhiv_zakaz.PRIM,arhiv_zakaz.SUM,
            arhiv_zakaz.TEL,arhiv_zakaz.PR,arhiv_zakaz.IM,arhiv_zakaz.PB,
            arhiv_jobs.name,rayonu.RAYON,rayonu.ID_RAYONA,nas_punktu.NSP, tup_nsp.TIP_NSP,arhiv_jobs.id,vulutsi.VUL,
            tup_vul.TIP_VUL,arhiv_dop_adr.rn,arhiv_dop_adr.ns,arhiv_dop_adr.vl,arhiv_dop_adr.bud,arhiv_dop_adr.kvar  
		FROM arhiv_zakaz 
            LEFT JOIN arhiv_jobs ON arhiv_zakaz.VUD_ROB=arhiv_jobs.id 
            LEFT JOIN arhiv_dop_adr ON arhiv_zakaz.KEY=arhiv_dop_adr.id_zm 
            LEFT JOIN rayonu ON rayonu.ID_RAYONA=arhiv_dop_adr.rn 
            LEFT JOIN nas_punktu ON nas_punktu.ID_NSP=arhiv_dop_adr.ns 
            LEFT JOIN vulutsi ON vulutsi.ID_VUL=arhiv_dop_adr.vl
            LEFT JOIN tup_nsp ON tup_nsp.ID_TIP_NSP=nas_punktu.ID_TIP_NSP
            LEFT JOIN tup_vul ON tup_vul.ID_TIP_VUL=vulutsi.ID_TIP_VUL
		WHERE 
		    arhiv_zakaz.KEY='$kl' AND arhiv_zakaz.DL='1' LIMIT 1";

$atu = mysql_query($sql);
while ($aut = mysql_fetch_array($atu)) {
    $kod_rn = $aut["ID_RAYONA"];
    $ndog = get_num_order($kod_rn, $aut["SZ"], $aut["NZ"]);
    $dtdog = german_date($aut["D_PR"]);
//    $edrpou = $aut["EDRPOU"];
//    $vidrob = $aut["name"];
//    $kod_rob = $aut["id"];
    $zamovnuk = $aut["PR"] . ' ' . $aut["IM"] . ' ' . $aut["PB"];
    $vlasnuk = $zamovnuk;
    $prumitka = $aut["PRIM"];
    if($aut["RAYON"] == 'Ірпінський район'){
        $address = 'Київська обл.' . $aut["TIP_NSP"] . ' ' . $aut["NSP"] . ', ' . $aut["TIP_VUL"] . ' ' . $aut["VUL"] . ', ' . objekt_ner(0, $aut["bud"], $aut["kvar"]);
    }else{
        $address = 'Київська обл.' . $aut["RAYON"] . ' ' . $aut["TIP_NSP"] . ' ' . $aut["NSP"] . ', ' . $aut["TIP_VUL"] . ' ' . $aut["VUL"] . ', ' . objekt_ner(0, $aut["bud"], $aut["kvar"]);
    }
    $zmad = $aut["TIP_NSP"] . ' ' . $aut["NSP"] . ', ' . $aut["TIP_VUL"] . ' ' . $aut["VUL"] . ', ' . objekt_ner(0, $aut["bud"], $aut["kvar"]);
//    $vart = $aut["SUM"];
//    $tel = $aut["TEL"];
//    $contract_location = $aut["TIP_NSP"] . ' ' . $aut["NSP"];
    $rn = $aut["rn"];
    $ns = $aut["ns"];
    $vl = $aut["vl"];
    $bud = $aut["bud"];
    $kvar = $aut["kvar"];
}
mysql_free_result($atu);

$sprava = '';
$sql = "SELECT * FROM arhiv WHERE RN='$rn' AND NS='$ns' AND VL='$vl' AND BD='$bud' AND KV='$kvar'";
$atu = mysql_query($sql);
while ($aut = mysql_fetch_array($atu)) {
    $sprava = $aut["N_SPR"];
    $dtinv = $aut["FIRST_DT_INV"];
    $vkinv = $aut["FIRST_VUK"];
    $plzag = $aut["PL_ZAG"];
    $pljit = $aut["PL_JIT"];
    $pldop = $aut["PL_DOP"];
    $sklchast = $aut["SKL_CHAST"];
    $sp_prumitka = $aut["PRIM"];
}
mysql_free_result($atu);

$file_fiz = 'dovidka1.xml';
if($sp == 2){
    $file_fiz = 'dovidka2.xml';
}elseif ($sp == 3){
    $file_fiz = 'dovidka3.xml';
}
$file_fiz_new = 'dovidka_new.xml';
//$file_ur='akt.xml';
//$file_ur_new='dovidka_new.xml';
//
//$rahunok="26002283741";


$file = fopen($file_fiz, 'r');
$text_rah = fread($file, filesize($file_fiz));
fclose($file);

$patterns[0] = "[zamovnuk]";
$patterns[1] = "[zmad]";
$patterns[2] = "[ndog]";
$patterns[3] = "[dtdog]";
$patterns[4] = "[address]";
$patterns[5] = "[vlasnuk]";
$patterns[6] = "[sprava]";
$patterns[7] = "[prumitka]";
$patterns[8] = "[vukonav]";
$patterns[9] = "[dtinv]";
$patterns[10] = "[vkinv]";
$patterns[11] = "[plzag]";
$patterns[12] = "[pljit]";
$patterns[13] = "[pldop]";
$patterns[14] = "[sklchast]";

$replacements[0] = $zamovnuk;
$replacements[1] = $zmad;
$replacements[2] = $ndog;
$replacements[3] = $dtdog;
$replacements[4] = $address;
$replacements[5] = $vlasnuk;
$replacements[6] = $sprava;
$replacements[7] = $sp_prumitka;
$replacements[8] = $vukonav;
$replacements[9] = $dtinv;
$replacements[10] = $vkinv;
$replacements[11] = $plzag;
$replacements[12] = $pljit;
$replacements[13] = $pldop;
$replacements[14] = $sklchast;

$text_rah_new = preg_replace($patterns, $replacements, $text_rah);

$filez = fopen($file_fiz_new, 'w+');
fwrite($filez, $text_rah_new);
fclose($filez);

$download_size = filesize($file_fiz_new);
header("Content-type: application/msword");
header("Content-Disposition: attachment; filename=" . $file_fiz_new . ";");
header("Accept-Ranges: bytes");
header("Content-Length: " . $download_size);
readfile($file_fiz_new);

//Zakrutie bazu       
if (mysql_close($db)) {
    // echo("Закриття бази даних");
} else {
    echo("Не можливо виконати закриття бази");
}
