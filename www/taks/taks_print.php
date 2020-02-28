<?php
session_start();
$lg = $_SESSION['LG'];
$pas = $_SESSION['PAS'];
$db = mysql_connect("localhost", $lg, $pas);
if (!$db) echo "Не вiдбулося зєднання з базою даних";

if (!@mysql_select_db(kpbti, $db)) {
    echo("Не завантажена таблиця");
    exit();
}

include "../function.php";
require('../tfpdf/tfpdf.php');
// створюємо FPDF обєкт
$pdf = new TFPDF();

$pdf->SetAutoPageBreak('true', 2);
$pdf->SetMargins(05, 05, 2);

$pdf->AddFont('dejavu', '', 'DejaVuSans.ttf', true);
$pdf->AddFont('dejavub', '', 'DejaVuSans-Bold.ttf', true);

// Вказуємо автора та заголовок
$pdf->SetAuthor('Шкурат А.О.');
$pdf->SetTitle('Замовлення');

// задаємо шрифт та його колiр
$pdf->SetFont('dejavu', '', 10);
$pdf->SetTextColor(50, 60, 100);

//створюємо нову сторiнку та вказуємо режим її вiдображення
$pdf->AddPage('P');
$pdf->SetDisplayMode('real', 'default');

$pdf->SetXY(05, 05);
$pdf->SetDrawColor(50, 60, 100);

$idtaks = $_GET['idtaks'];
$storage = $_GET['storage'];

$sql = "SELECT zamovlennya.EA,zamovlennya.SZ,zamovlennya.NZ,zamovlennya.PR,zamovlennya.IM,rayonu.*,
	zamovlennya.PB,zamovlennya.BUD,zamovlennya.KVAR,nas_punktu.NSP,tup_nsp.TIP_NSP,
	vulutsi.VUL,tup_vul.TIP_VUL,taks.DATE_T,taks.SUM_OKR,taks.NDS,zamovlennya.PRIM   
	FROM zamovlennya,taks,rayonu,nas_punktu,vulutsi,tup_nsp,tup_vul
	WHERE 
	taks.ID_TAKS='$idtaks' AND taks.DL='1' AND zamovlennya.KEY=taks.IDZM
	AND rayonu.ID_RAYONA=zamovlennya.RN 
	AND nas_punktu.ID_NSP=zamovlennya.NS
	AND vulutsi.ID_VUL=zamovlennya.VL
	AND tup_nsp.ID_TIP_NSP=nas_punktu.ID_TIP_NSP
	AND tup_vul.ID_TIP_VUL=vulutsi.ID_TIP_VUL";


$atu = mysql_query($sql);
while ($aut = mysql_fetch_array($atu)) {
    if ($aut["BUD"] != "") $bud = "буд." . $aut["BUD"]; else $bud = "";
    if ($aut["KVAR"] != "") $kvar = "кв." . $aut["KVAR"]; else $kvar = "";
    $sz = $aut["SZ"];
    $rahunok = get_num_order($aut["ID_RAYONA"], $sz, $aut["NZ"]);
    $pib = $aut["PR"] . ' ' . $aut["IM"] . ' ' . $aut["PB"];
    $adr = $aut["TIP_NSP"] . $aut["NSP"] . " " . $aut["TIP_VUL"] . $aut["VUL"] . " " . $bud . " " . $kvar;
    $dtak = german_date($aut["DATE_T"]);
    $sum_okr = $aut["SUM_OKR"];
    $nds = $aut["NDS"];
    $prim = $aut["PRIM"];
    $ea = $aut["EA"];
}
mysql_free_result($atu);

$pdf->SetFont('dejavu', '', 14);
$pdf->Text(60, 10, 'Рахунок по замовленню № ' . $rahunok);
$pdf->SetFont('dejavu', '', 12);
$pdf->Text(19, 20, 'Адреса: ' . $adr);
$pdf->Text(19, 25, 'Замовник: ' . $pib . ' ' . $prim);
$pdf->SetFont('dejavu', '', 10);
$pdf->SetXY(14, 30);
$pdf->MultiCell(15, 12, '№', 1, 'C', 0);
$pdf->SetXY(29, 30);
$pdf->MultiCell(120, 12, 'Найменування робіт', 1, 'C', 0);
$pdf->SetXY(149, 30);
$pdf->MultiCell(15, 12, 'Кільк.', 1, 'C', 0);
$pdf->SetXY(164, 30);
$pdf->MultiCell(20, 6, 'Норма часу в г.', 1, 'C', 0);
$pdf->SetXY(184, 30);
$pdf->MultiCell(20, 12, 'Сума', 1, 'C', 0);
$pdf->SetFont('dejavu', '', 8);
$sql1 = "SELECT price.NOM,price.NAIM,price.VUD,taks_detal.NORM,taks_detal.KL,taks_detal.KF,taks_detal.KF_SKL,taks_detal.SUM,
	robitnuku.ROBS
	FROM price, taks_detal, robitnuku
	WHERE 
		taks_detal.ID_TAKS='$idtaks' AND taks_detal.DL='1' AND taks_detal.ID_PRICE=price.ID_PRICE
		AND taks_detal.ID_ROB=robitnuku.ID_ROB AND robitnuku.DL='1' ORDER BY robitnuku.ROBS,price.NOM";

$it = 0;
//$sum_temp="";
$ssum = "";
$sum_vuk = "";
$rob_temp = "";
$text_skl = '';
$text_skl2 = '';
$atu1 = mysql_query($sql1);
while ($aut1 = mysql_fetch_array($atu1)) {
    $nomer = $aut1["NOM"];
    $naim = $aut1["NAIM"];
    $vud = $aut1["VUD"];
    $norma = $aut1["NORM"];
    $kilk = $aut1["KL"];
    $skl = $aut1["KF_SKL"];
    $koef = $aut1["KF"];
    $sum1 = $aut1["SUM"];
    $robitnuk = $aut1["ROBS"];
    if ($skl == 1.25) {
        $naim .= '*';
        $text_skl = '*Під час викреслювання та копіювання поверхових планів з особливо складними зовнішніми окресленнями і архітектурним';
        $text_skl2 = 'оформленням до норм часу 2.20; 2.21; 2.24; 2.27, що належать до третьої категорії складності, застосовується коефіцієнт 1.25';
    }
    if ($skl == 1.75) {
        $naim .= '**';
        $text_skl = '**Під час складання поверхових планів з особливо складними зовнішніми окресленнями і архітектурним оформленням';
        $text_skl2 = 'до норм часу 2.18; 2.19; 2.22; 2.23, що належать до третьої категорії складності, застосовується коефіцієнт 1.75';
    }
    if ($skl == 0.9) {
        $naim .= '***';
        $text_skl = '***Під час складання поверхових планів адміністративних або інших будівель із середньою площею приміщень (кімнат)';
        $text_skl2 = 'більше 50 кв. м до норм часу 2.18-2.24 застосовується коефіцієнт 0.9';
    }

    if ($koef == 2) {
        $sum1 = round(($sum1 * 2), 2);
    }

    if (($rob_temp != $robitnuk) and ($rob_temp != "")) {

        $ssum = $ssum + $sum_vuk;

        $pdf->Text(19, 50 + $it, "Сума по виконавцю");

        $pdf->Text(190, 50 + $it, (string)number_format($sum_vuk, 2));
        $sum_vuk = "";
        $it = $it + 5;
    }
    if ($rob_temp != $robitnuk) {
        $pdf->SetFont('dejavub', '', 10);
        $pdf->Text(15, 50 + $it, $robitnuk);
        $pdf->SetFont('dejavu', '', 8);
        $rob_temp = $robitnuk;
        $it = $it + 5;
    }
    if ($it > 215) {
        $pdf->AddPage('P');
        $pdf->SetDisplayMode('real', 'default');
        $pdf->SetXY(05, 05);
        $pdf->SetDrawColor(50, 60, 100);
        $it = -30;
    }

    $pdf->Text(17, 50 + $it, $nomer);
    $pdf->Text(30, 50 + $it, $naim);
    $pdf->Text(152, 50 + $it, $kilk);
    $pdf->Text(172, 50 + $it, $norma);
    $pdf->Text(191, 50 + $it, (string)number_format($sum1, 2));
    $pdf->Line(15, 51 + $it, 200, 51 + $it);
    $it = $it + 4;

    $sum_vuk = $sum_vuk + $sum1;
}
mysql_free_result($atu1);

$pdf->Text(19, 52 + $it - 2, "Сума по виконавцю");

$ssum = $ssum + $sum_vuk;

$pdf->Text(190, 52 + $it - 2, (string)number_format($sum_vuk, 2));

//----pdv i sum s pdv---------
$ssum = $ssum + $sum_okr;
$pdv = round(($ssum * ($nds / 100)), 2);
$sm_spdv = round(($ssum * (($nds / 100) + 1)), 2);
//---------------------------
$nadb = 0;
if ($text_skl != '') {
    $pdf->Text(15, 52 + $it + 5, $text_skl);
    $pdf->Text(15, 52 + $it + 8, $text_skl2);
    $nadb = 10;
}

$n_god = 0;
$sql = "SELECT ng FROM ng,zamovlennya WHERE ng.dl='1' AND zamovlennya.D_PR>=ng.dtstart ORDER BY ng.dtstart ASC LIMIT 1";
$atu = mysql_query($sql);
while ($aut = mysql_fetch_array($atu)) {
    $n_god = $aut["ng"];
}
mysql_free_result($atu);

$pdf->SetFont('dejavu', '', 10);
$pdf->Text(19, 52 + $it + $nadb + 5, 'Вартість 1 нормо-години: '. $n_god);
$pdf->Text(19, 52 + $it + $nadb + 10, 'Округлення до гривні');
$pdf->Text(182, 52 + $it + $nadb + 10, (string)number_format($sum_okr, 3));
$pdf->Text(19, 52 + $it + $nadb + 15, 'Разом по рахунку:');
$pdf->Text(182, 52 + $it + $nadb + 15, (string)number_format($ssum, 2));
$pdf->Text(19, 52 + $it + $nadb + 20, 'ПДВ-20%');
$pdf->Text(182, 52 + $it + $nadb + 20, (string)number_format($pdv, 2));
$pdf->SetFont('dejavub', '', 10);
$pdf->Text(19, 52 + $it + $nadb + 25, 'Всього');
$pdf->Text(182, 52 + $it + $nadb + 25, (string)number_format($sm_spdv, 2));
$pdf->Text(19, 52 + $it + $nadb + 32, 'Таксувальник                                   ___________________________________        ' . $dtak . 'р.');

if (mysql_close($db)) {
    // echo("Закриття бази даних");
} else {
    echo("Не можливо виконати закриття бази");
}

//виводимо документ на екран
if ($storage == 0) {
    $pdf->Output('taks.pdf', 'I');
} else {
    $tax_name = 'ea/' . $ea . '/technical/tax_time_' . date('d_m_Y_H_i_s_') . '.pdf';
    $pdf->Output($tax_name, 'F');
    echo "Файл збережено до електронного архіву";
}

