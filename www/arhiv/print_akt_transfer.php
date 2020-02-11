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
$address = array();
$sql = "SELECT arhiv_zakaz.*,rayonu.RAYON,rayonu.ID_RAYONA,nas_punktu.NSP, tup_nsp.TIP_NSP,vulutsi.VUL,tup_vul.TIP_VUL
		FROM arhiv_zakaz, rayonu,nas_punktu, vulutsi, tup_nsp, tup_vul
		WHERE 
		arhiv_zakaz.KEY='$kl' AND arhiv_zakaz.DL='1' 
		AND rayonu.ID_RAYONA=arhiv_zakaz.RN AND nas_punktu.ID_NSP=arhiv_zakaz.NS AND vulutsi.ID_VUL=arhiv_zakaz.VL
		AND tup_nsp.ID_TIP_NSP=nas_punktu.ID_TIP_NSP
		AND tup_vul.ID_TIP_VUL=vulutsi.ID_TIP_VUL";
//echo $sql;
$atu = mysql_query($sql);
while ($aut = mysql_fetch_array($atu)) {
//    $b_rn = p_buk($aut["RAYON"]);
//    $tup_zam = $aut["TUP_ZAM"];
//    $vidrob = $aut["document"];

    $kod_rn = $aut["ID_RAYONA"];
    $num_akt = get_num_order($kod_rn, $aut["SZ"], $aut["NZ"]);
    $dt_akt = german_date($aut["D_PR"]);
    $edrpou = $aut["EDRPOU"];
    $idn = $aut["IDN"];
    $pasport = $aut["PASPORT"];
    $subj = $aut["SUBJ"];
    $adr_subj = $aut["ADR_SUBJ"];
    $pip_osobu = $aut["PR"] . ' ' . $aut["IM"] . ' ' . $aut["PB"];
    $tel = $aut["TEL"];


//    if ($aut["BUD"] != "") $bud = "буд." . $aut["BUD"]; else $bud = "";
//    if ($aut["KVAR"] != "") $kvar = "кв." . $aut["KVAR"]; else $kvar = "";
    $address[] = array('type_obj' => (!empty($aut["KVAR"])) ? 'квартира' : 'будинок',
        'address' => $aut["TIP_NSP"] . ' ' . $aut["NSP"] . ' ' . $aut["TIP_VUL"] . ' ' . $aut["VUL"] . ' ' . objekt_ner(0, $aut["BUD"], $aut["KVAR"]));
//    $dtpidp = german_date($aut["DATA_PS"]);
}
mysql_free_result($atu);

$sql = "SELECT arhiv_dop_adr.*,rayonu.RAYON,nas_punktu.NSP,tup_nsp.TIP_NSP,
				vulutsi.VUL,tup_vul.TIP_VUL
			 FROM arhiv_dop_adr, rayonu, nas_punktu, vulutsi, tup_nsp, tup_vul
				WHERE 
					arhiv_dop_adr.id_zm='$kl' 
					AND rayonu.ID_RAYONA=arhiv_dop_adr.rn
					AND nas_punktu.ID_NSP=arhiv_dop_adr.ns
					AND vulutsi.ID_VUL=arhiv_dop_adr.vl
					AND tup_nsp.ID_TIP_NSP=nas_punktu.ID_TIP_NSP
					AND tup_vul.ID_TIP_VUL=vulutsi.ID_TIP_VUL
					ORDER BY arhiv_dop_adr.id ASC";
// echo $sql;
$atu = mysql_query($sql);
while ($aut = mysql_fetch_array($atu)) {

    $address[] = array('type_obj' => (!empty($aut["kvar"])) ? 'квартира' : 'будинок',
        'address' => $aut["TIP_NSP"] . $aut["NSP"] . " " . $aut["TIP_VUL"] . $aut["VUL"] . " " . objekt_ner(0, $aut["bud"], $aut["kvar"]));
}
mysql_free_result($atu);

//---------------------------Create PDF -----------------------------------
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
$pdf->SetAuthor('КП КОР ЗБЕРІГАЧ');
$pdf->SetTitle('Акт виконаних робіт');

//створюємо нову сторiнку та вказуємо режим її вiдображення
$pdf->AddPage('P');
$pdf->SetDisplayMode('real', 'default');

$pdf->SetXY(05, 05);
$pdf->SetDrawColor(50, 60, 100);

//$pdf->SetFont('dejavu', '', 12);
//$pdf->Text(15, 15, 'ЗАТВЕРДЖУЮ');
//$pdf->SetFont('dejavub', '', 10);
//$pdf->Text(15, 20, 'В.о. генерального директора');
//$pdf->Text(15, 25, 'КП КОР “Північне БТІ”');
//$pdf->Text(15, 32, '___________________________ О.Я.Костиліна');
//$pdf->SetFont('dejavu', '', 10);
//$pdf->Text(15, 37, 'М.П.');

$pdf->SetFont('dejavub', '', 12);
$pdf->Text(65, 60, 'АКТ виконаних робіт № ');
$pdf->SetFont('dejavub', '', 10);
$pdf->Text(125, 60, $num_akt);
$pdf->SetFont('dejavu', '', 8);
$pdf->Text(92, 64, 'від ' . $dt_akt . ' року');

$pdf->SetFont('dejavu', '', 10);
$pdf->SetXY(14, 70);
$pdf->MultiCell(190, 6, 'Ми, що нижче підписалися, суб`єкт господарювання, в особі ______________________________________
_____________________________________________________________________________________________(Сторона 1)
та КП КОР "ЗБЕРІГАЧ", в особі __________________________________________________________________________
(Сторона 2), склали цей акт про те, що Стороною 1 передано, а Стороною 2 прійнято на зберігання наступні матеріали технічної інвентаризації:', 0, 'L', 0);

$pdf->SetXY(15, 100);
$pdf->MultiCell(10, 5, '№ п/п', 1, 'C', 0);
$pdf->SetXY(25, 100);
$pdf->MultiCell(35, 10, 'Тип об`єкта', 1, 'C', 0);
$pdf->SetXY(60, 100);
$pdf->MultiCell(100, 10, 'Адреса', 1, 'C', 0);
$pdf->SetXY(160, 100);
$pdf->MultiCell(22, 5, 'Кількість, шт', 1, 'C', 0);
$pdf->SetXY(182, 100);
$pdf->MultiCell(22, 5, 'Вартість, грн.', 1, 'C', 0);

$y = 110;
foreach ($address as $key => $adr) {
    $pdf->SetXY(15, $y);
    $pdf->MultiCell(10, 5, $key + 1, 1, 'C', 0);
    $pdf->SetXY(25, $y);
    $pdf->MultiCell(35, 5, $adr['type_obj'], 1, 'C', 0);
    $pdf->SetXY(60, $y);
    $pdf->MultiCell(100, 5, $adr['address'], 1, 'L', 0);
    $pdf->SetXY(160, $y);
    $pdf->MultiCell(22, 5, '', 1, 'R', 0);
    $pdf->SetXY(182, $y);
    $pdf->MultiCell(22, 5, '', 1, 'R', 0);
    $y += 5;
}

$y +=10;
//$pdf->SetFont('dejavub', '', 10);
$pdf->Text(15, $y, 'Вартість:');
//$pdf->Text(15, 130, $smpr);

$y +=5;
$pdf->SetFont('dejavu', '', 10);
$pdf->SetXY(14, $y);
$pdf->MultiCell(190, 4, 'Цей акт складено у двох примірниках, що мають однакову юридичну силу, по одному для 
кожної строни.
Сторони одна до одної претензій не мають.', 0, 'L', 0);
$y +=20;

$pdf->SetFont('dejavu', '', 12);
$pdf->Text(40, $y, 'СТОРОНА 1');
$pdf->Text(130, $y, 'СТОРОНА 2');

$y +=10;
$pdf->SetFont('dejavub', '', 10);
$pdf->Text(16, $y, 'КП КОР “Зберігач”');
//$pdf->Text(111, 165, $zamovnuk);

$pdf->SetFont('dejavu', '', 10);
$pdf->SetXY(15, $y+5);
$pdf->MultiCell(85, 4, 'Поштова адреса: 08205, Київська область, 
місто Ірпінь, вул. Миру, 2-А
Тел.: 098 012 28 02
ЄДРПОУ: 38733758
Банк: АБ "Укргазбанк"
Р/рахунок: UA703204780000026009924432768', 0, 'L', 0);

$pdf->SetFont('dejavub', '', 10);
$pdf->Text(110, $y, $subj);
$pdf->SetFont('dejavu', '', 10);
$pdf->SetXY(110, $y+5);
$pdf->MultiCell(85, 4, 'Адреса: ' . $adr_subj . '
Телефон: ' . $tel . '
ПІП: ' . $pip_osobu . '
ІПН: ' . $idn . '
Паспорт: ' . $pasport, 0, 'L', 0);

//Zakrutie bazu       
if (mysql_close($db)) {
    // echo("Закриття бази даних");
} else {
    echo("Не можливо виконати закриття бази");
}
$pdf->Output('akt.pdf', 'I');