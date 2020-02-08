<?php
session_start();
$lg = $_SESSION['LG'];
$pas = $_SESSION['PAS'];
include_once "../function.php";
$kl = $_GET['kl'];

$db = mysql_connect("localhost", $lg, $pas);
if (!$db) echo "Не вiдбулося зєднання з базою даних";

if (!@mysql_select_db(kpbti, $db)) {
    echo("Не завантажена таблиця");
    exit();
}

$sql = "SELECT zamovlennya.*,dlya_oformlennya.document,rayonu.RAYON,rayonu.ID_RAYONA,nas_punktu.NSP, tup_nsp.TIP_NSP,
			dlya_oformlennya.id_oform,vulutsi.VUL,tup_vul.TIP_VUL,zamovlennya.SZ,zamovlennya.NZ
				FROM zamovlennya, rayonu,nas_punktu, vulutsi, tup_nsp, tup_vul, dlya_oformlennya
		WHERE 
		zamovlennya.KEY='$kl'
		AND zamovlennya.DL='1' AND dlya_oformlennya.id_oform=zamovlennya.VUD_ROB
		AND rayonu.ID_RAYONA=RN AND nas_punktu.ID_NSP=NS AND vulutsi.ID_VUL=VL
		AND tup_nsp.ID_TIP_NSP=nas_punktu.ID_TIP_NSP
		AND tup_vul.ID_TIP_VUL=vulutsi.ID_TIP_VUL";
$atu = mysql_query($sql);
while ($aut = mysql_fetch_array($atu)) {
    $b_rn = p_buk($aut["RAYON"]);
    $kod_rn = $aut["ID_RAYONA"];
    $tup_zam = $aut["TUP_ZAM"];
    $ndog = get_num_order($kod_rn, $aut["SZ"], $aut["NZ"]);
    $dtzak = german_date($aut["D_PR"]);
    $vidrob = $aut["document"];
    $kod_rob = $aut["id_oform"];
    $edrpou = $aut["EDRPOU"];
    $idn = $aut["IDN"];
    $pasport = $aut["PASPORT"];
    $zamovnuk = $aut["PR"] . ' ' . $aut["IM"] . ' ' . $aut["PB"];
    $tel = $aut["TEL"];
    if ($aut["BUD"] != "") $bud = "буд." . $aut["BUD"]; else $bud = "";
    if ($aut["KVAR"] != "") $kvar = "кв." . $aut["KVAR"]; else $kvar = "";
    $adresa = $aut["TIP_NSP"] . ' ' . $aut["NSP"] . ' ' . $aut["TIP_VUL"] . ' ' . $aut["VUL"] . ' ' . $bud . ' ' . $kvar;
    /* if($aut["DOKVUT"]!='0000-00-00') $sma=$aut["SUM"];
    if($aut["DODOP"]!='0000-00-00') $smd=$aut["SUM_D"];
    $sum=number_format(($sma+$smd),2,'.',''); */
    $dtpidp = german_date($aut["DATA_PS"]);
}
mysql_free_result($atu);

$taks = 0;
$nds = 0;
$sql = "SELECT taks.SUM,taks.SUM_OKR,taks.NDS FROM taks WHERE taks.IDZM='$kl' AND DL='1'";
$atu = mysql_query($sql);
while ($aut = mysql_fetch_array($atu)) {
    $taks = $aut["SUM"] + $aut["SUM_OKR"];
    $nds = $aut["NDS"];
}
mysql_free_result($atu);
if ($taks != 0) {
    $sum = round((($nds + 100) * $taks) / 100, 2);
}

$grn = (int)$sum;
$kop = fract($sum);
$sumpr = in_str($grn);
$smpr = $sumpr . ' грн. ';
if ($kop != 0) $smpr .= $kop . ' коп.';

//$file_fiz='akt_fiz_zm.xml';
//$file_fiz_new='akt_fiz_new.xml';
//$file_ur='akt.xml';
//$file_ur_new='akt_new.xml';
//
//$rahunok="26002283741";

if ($tup_zam == 2) {
    $sql = "SELECT * FROM yur_kl WHERE yur_kl.DL='1' AND yur_kl.EDRPOU='$edrpou'";
    $atu = mysql_query($sql);
    while ($aut = mysql_fetch_array($atu)) {
        $zamovnuk = $aut["NAME"];
        $adrzamovn = $aut["ADRES"];
        $tel = $aut["TELEF"];
        $bank = $aut["BANK"];
        $mfo = $aut["MFO"];
        $rahzamovn = $aut["RR"];
        $svzamovn = $aut["SVID"];
        $pnzamovn = $aut["IPN"];
    }
    mysql_free_result($atu);
}

//------------------------------------------------------------------------------------------------
require('../tfpdf/tfpdf.php');
// створюємо FPDF обєкт
$pdf = new TFPDF();

$pdf->SetAutoPageBreak('true', 2);
$pdf->SetMargins(05, 05, 2);

$pdf->AddFont('dejavu', '', 'DejaVuSans.ttf', true);
$pdf->AddFont('dejavub', '', 'DejaVuSans-Bold.ttf', true);
//$pdf->AddFont('dejavu_bobl', '', 'DejaVuSans-BoldOblique.ttf', true);
$pdf->AddFont('dejavu_light', '', 'DejaVuSans-ExtraLight.ttf', true);
$pdf->AddFont('dejavu_i', '', 'DejaVuSans-Oblique.ttf', true);

// Вказуємо автора та заголовок
$pdf->SetAuthor('КП КОР Північне БТІ');
$pdf->SetTitle('Акт виконаних робіт');

//створюємо нову сторiнку та вказуємо режим її вiдображення
$pdf->AddPage('P');
$pdf->SetDisplayMode('real', 'default');

$pdf->SetXY(05, 05);
$pdf->SetDrawColor(50, 60, 100);

$pdf->SetFont('dejavu', '', 12);
$pdf->Text(15, 15, 'ЗАТВЕРДЖУЮ');

$pdf->SetFont('dejavub', '', 10);
$pdf->Text(15, 20, 'В.о. генерального директора');
$pdf->Text(15, 25, 'КП КОР “Північне БТІ”');
$pdf->Text(15, 32, '___________________________ О.Я.Костиліна');
$pdf->SetFont('dejavu', '', 10);
$pdf->Text(15, 37, 'М.П.');

$pdf->SetFont('dejavub', '', 12);
$pdf->Text(65, 60, 'АКТ виконаних робіт № ');
$pdf->SetFont('dejavub', '', 10);
$pdf->Text(125, 60, $ndog);
$pdf->SetFont('dejavu', '', 8);
$pdf->Text(92, 64, 'від ' . $dtzak . ' року');

$pdf->SetFont('dejavu', '', 10);
$pdf->SetXY(14, 70);
$pdf->MultiCell(190, 4, 'Ми, що нижче підписалися, ' . $zamovnuk . ' з одного боку, та представник виконавця О.Я.Костиліна з іншого боку, склали цей акт про те, що на підставі наведених документів:
Замовлення-зобов’язання: № ' . $ndog . ' від ' . $dtzak . ' р.
Виконавцем були виконані наступні роботи (надані такі послуги):', 0, 'L', 0);
//$pdf->Text(15, 81, 'Замовлення-зобов’язання: № '. $ndog .' від '. $dtzak .' р.');
//$pdf->Text(15, 85, 'Виконавцем були виконані наступні роботи (надані такі послуги):');

$pdf->SetXY(15, 90);
$pdf->MultiCell(10, 5, '№ п/п', 1, 'C', 0);
$pdf->SetXY(25, 90);
$pdf->MultiCell(100, 10, 'Найменування робіт, послуг', 1, 'C', 0);
$pdf->SetXY(125, 90);
$pdf->MultiCell(10, 5, 'Кіл- сть', 1, 'C', 0);
$pdf->SetXY(135, 90);
$pdf->MultiCell(20, 10, 'Од.', 1, 'C', 0);
$pdf->SetXY(155, 90);
$pdf->MultiCell(25, 10, 'Ціна', 1, 'C', 0);
$pdf->SetXY(180, 90);
$pdf->MultiCell(25, 10, 'Сума', 1, 'C', 0);
$pdf->SetXY(15, 100);
$pdf->MultiCell(10, 10, '1', 1, 'C', 0);
$pdf->SetXY(25, 100);
$h_l = 5;
if (strlen($vidrob) > 90) $h_l = 3.33;
$pdf->MultiCell(100, $h_l, $vidrob . ' за адресою ' . $adresa.strlen($vidrob), 1, 'L', 0);
$pdf->SetXY(125, 100);
$pdf->MultiCell(10, 10, '1', 1, 'C', 0);
$pdf->SetXY(135, 100);
$pdf->MultiCell(20, 10, 'послуга', 1, 'C', 0);
$pdf->SetXY(155, 100);
$pdf->MultiCell(25, 10, number_format($sum, 2), 1, 'R', 0);
$pdf->SetXY(180, 100);
$pdf->MultiCell(25, 10, number_format($sum, 2), 1, 'R', 0);
$pdf->SetXY(155, 110);
$pdf->SetFont('dejavub', '', 9);
$pdf->MultiCell(25, 10, 'Всього:', 0, 'R', 0);
$pdf->SetXY(180, 110);
$pdf->MultiCell(25, 10, number_format($sum, 2), 0, 'R', 0);

$pdf->SetFont('dejavub', '', 10);
$pdf->Text(15, 125, 'Загальна вартість виконаних робіт:');
$pdf->Text(15, 130, $smpr);

$pdf->SetFont('dejavu', '', 10);
$pdf->Text(15, 140, 'Замовник претензій по об’єму, якості та строкам виконання робіт (надання послуг) не має.');

$pdf->SetFont('dejavu', '', 12);
$pdf->Text(40, 155, 'ВИКОНАВЕЦЬ');
$pdf->Text(130, 155, 'ЗАМОВНИК');

$pdf->SetFont('dejavub', '', 10);
$pdf->Text(16, 165, 'КП КОР “Північне БТІ”');
$pdf->Text(111, 165, $zamovnuk);

$pdf->SetFont('dejavu', '', 10);
$pdf->SetXY(15, 167);
$pdf->MultiCell(85, 4, 'Поштова адреса: 08200, Київська область, 
місто Ірпінь, вул. Стельмаха, 9-А
Тел.: 098 012 28 02
ЄДРПОУ: 38733758
Банк: АБ "Укргазбанк"
Р/рахунок: UA703204780000026009924432768', 0, 'L', 0);

$pdf->SetXY(110, 167);
$pdf->MultiCell(85, 4, 'Адреса: ' . $adresa . ' 
Телефон: ' . $tel . '
ІПН: ' . $idn . '
Паспорт: ' . $pasport, 0, 'L', 0);


$pdf->SetFont('dejavu', '', 10);
$pdf->Text(16, 205, 'В.о. генерального директора');
$pdf->Text(16, 210, 'КП КОР “Північне БТІ”');
$pdf->Text(16, 217, '___________________________');
$pdf->Text(111, 217, '___________________________');
$pdf->Text(16, 222, 'О.Я.Костиліна');
$pdf->Text(111, 222, $zamovnuk);
$pdf->Text(16, 227, 'М.П.');


//------------------------------------------------------------------------------------------------
//    $file = fopen($file_ur, 'r');
//    $text_rah = fread($file, filesize($file_ur));
//    fclose($file);
//
//    $patterns[0] = "[zamovnuk]";
//    $patterns[1] = "[adrzamovn]";
//    $patterns[2] = "[tel]";
//    $patterns[3] = "[edrpou]";
//    $patterns[4] = "[vidrob]";
//    $patterns[5] = "[dodat]";
//    $patterns[6] = "[adresa]";
//    $patterns[7] = "[sum]";
//    $patterns[8] = "[smpr]";
//    $patterns[9] = "[dtzak]";
//    $patterns[10] = "[ndog]";
//    $patterns[11] = "[rahunok]";
//    $patterns[12] = "[sbpdv]";
//    $patterns[13] = "[spdv]";
//    $patterns[14] = "[dtpidp]";
//    $patterns[15] = "[bank]";
//    $patterns[16] = "[mfo]";
//    $patterns[17] = "[rahzamovn]";
//    $patterns[18] = "[svzamovn]";
//    $patterns[19] = "[pnzamovn]";
//
//    $replacements[0] = $zamovnuk;
//    $replacements[1] = $adrzamovn;
//    $replacements[2] = $tel;
//    $replacements[3] = $edrpou;
//    $replacements[4] = $vidrob;
//    $replacements[5] = $dodat;
//    $replacements[6] = $adresa;
//    $replacements[7] = $sum;
//    $replacements[8] = $smpr;
//    $replacements[9] = $dtzak;
//    $replacements[10] = $ndog;
//    $replacements[11] = $rahunok;
//    $replacements[12] = $sbpdv;
//    $replacements[13] = $spdv;
//    $replacements[14] = $dtpidp;
//    $replacements[15] = $bank;
//    $replacements[16] = $mfo;
//    $replacements[17] = $rahzamovn;
//    $replacements[18] = $svzamovn;
//    $replacements[19] = $pnzamovn;
//
//    $text_rah_new = preg_replace($patterns, $replacements, $text_rah);
//
//    $filez = fopen($file_ur_new, 'w+');
//    fwrite($filez, $text_rah_new);
//    fclose($filez);
//
//    $download_size = filesize($file_ur_new);
//    header("Content-type: application/msword");
//    header("Content-Disposition: attachment; filename=" . $file_ur_new . ";");
//    header("Accept-Ranges: bytes");
//    header("Content-Length: " . $download_size);
//    readfile($file_ur_new);
//} else {
//    $file = fopen($file_fiz, 'r');
//    $text_rah = fread($file, filesize($file_fiz));
//    fclose($file);
//
//    $patterns[0] = "[zamovnuk]";
//    $patterns[1] = "[adrzamovn]";
//    $patterns[2] = "[pasport]";
//    $patterns[3] = "[idn]";
//    $patterns[4] = "[tel]";
//    $patterns[5] = "[vidrob]";
//    $patterns[6] = "[adresa]";
//    $patterns[7] = "[sum]";
//    $patterns[8] = "[smpr]";
//    $patterns[9] = "[dtzak]";
//    $patterns[10] = "[ndog]";
//    $patterns[11] = "[rahunok]";
//    $patterns[12] = "[dtpidp]";
//
//    $replacements[0] = $zamovnuk;
//    $replacements[1] = $adrzamovn;
//    $replacements[2] = $pasport;
//    $replacements[3] = $idn;
//    $replacements[4] = $tel;
//    $replacements[5] = $vidrob;
//    $replacements[6] = $adresa;
//    $replacements[7] = $sum;
//    $replacements[8] = $smpr;
//    $replacements[9] = $dtzak;
//    $replacements[10] = $ndog;
//    $replacements[11] = $rahunok;
//    $replacements[12] = $dtpidp;
//
//    $text_rah_new = preg_replace($patterns, $replacements, $text_rah);
//
//    $filez = fopen($file_fiz_new, 'w+');
//    fwrite($filez, $text_rah_new);
//    fclose($filez);
//
//    $download_size = filesize($file_fiz_new);
//    header("Content-type: application/msword");
//    header("Content-Disposition: attachment; filename=" . $file_fiz_new . ";");
//    header("Accept-Ranges: bytes");
//    header("Content-Length: " . $download_size);
//    readfile($file_fiz_new);
//}
//Zakrutie bazu       
if (mysql_close($db)) {
    // echo("Закриття бази даних");
} else {
    echo("Не можливо виконати закриття бази");
}
$pdf->Output('akt.pdf', 'I');