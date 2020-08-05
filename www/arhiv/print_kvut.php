<?php
session_start();
$lg = $_SESSION['LG'];
$pas = $_SESSION['PAS'];

include_once "../function.php";
$kl = (int)$_GET['kl'];
//$id_vr = $_GET['tz'];

$db = mysql_connect("localhost", $lg, $pas);
if (!$db) echo "Не вiдбулося зєднання з базою даних";

if (!@mysql_select_db(kpbti, $db)) {
    echo("Не завантажена таблиця");
    exit();
}

$sql = "SELECT arhiv_zakaz.*,arhiv_jobs.name,rayonu.RAYON,rayonu.ID_RAYONA,nas_punktu.NSP, tup_nsp.TIP_NSP,
		    arhiv_jobs.id,vulutsi.VUL,tup_vul.TIP_VUL,arhiv_dop_adr.bud,arhiv_dop_adr.kvar 
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


$i = 1;
$pilga = 0;
$atu = mysql_query($sql);
while ($aut = mysql_fetch_array($atu)) {
	//var_dump($aut);
    if ($aut["bud"] != "") $bud = "буд." . $aut["bud"]; else $bud = "";
    if ($aut["kvar"] != "") $kvar = "кв." . $aut["kvar"]; else $kvar = "";
    if($i == 1){
        $kod_rn = $aut["ID_RAYONA"];
        $s_rah = 0;
        $dtzak = german_date($aut["D_PR"]);
        $vidrob = $aut["name"];
        $kod_rob = $aut["id"];
        $zakaz = get_num_order($kod_rn, $aut["SZ"], $aut["NZ"]);
        //$datagot = german_date($aut["DATA_GOT"]);

        $address = $aut["TIP_NSP"] . ' ' . $aut["NSP"] . ' ' . $aut["TIP_VUL"] . ' ' . $aut["VUL"] . ' ' . $bud . ' ' . $kvar;
        $sum = number_format($aut["SUM"], 2, '.', '');

        if(!empty($aut["SUBJ"])){
            $zamovnuk = $aut["SUBJ"];
            $edrpou = $aut["EDRPOU"];
        }
        else{
            $zamovnuk = $aut["PR"] . ' ' . p_buk($aut["IM"]) . '.' . p_buk($aut["PB"]) . '.';
        }
    }else{
        $address .= ' ' . $aut["TIP_NSP"] . ' ' . $aut["NSP"] . ' ' . $aut["TIP_VUL"] . ' ' . $aut["VUL"] . ' ' . $bud . ' ' . $kvar;
    }
    $i++;
}
mysql_free_result($atu);

$grn = (int)$sum;
$kop = fract($sum);
$sumpr = in_str($grn);
//if ($pilga == 0) {
//    $sbpdv = number_format(round($sum / 1.2, 2), 2, '.', '');
//    $spdv = number_format(round($sum / 6, 2), 2, '.', '');
//    $smpr = $sumpr . ' грн. ' . $kop . ' коп. в т.ч. ПДВ – 20%';
//
//    $grnpdv = (int)$spdv;
//    $koppdv = fract($spdv);
//    $spdvpr = in_str($grnpdv);
//    $prpdv = $spdvpr . ' грн. ' . $koppdv . ' коп.';
//} else {
$sbpdv = number_format($sum, 2, '.', '');
$spdv = number_format(0, 2, '.', '');
$smpr = $sumpr . ' грн. ' . $kop . ' коп.';
$prpdv = '';
//}


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
$pdf->SetAuthor('КП КОР "Зберігач"');
$pdf->SetTitle('Квитанція');

//створюємо нову сторiнку та вказуємо режим її вiдображення
$pdf->AddPage('P');
$pdf->SetDisplayMode('real', 'default');

$pdf->SetXY(05, 05);
$pdf->SetDrawColor(50, 60, 100);

$pdf->SetFont('dejavu', '', 9);

$x = 10;
$y = 5;
$pdf->SetXY($x, $y);
$pdf->MultiCell(50, 50, '', 1, '', 0);
$pdf->SetXY($x, $y+50);
$pdf->MultiCell(50, 50, '', 1, '', 0);
$pdf->Text(12, 9, 'Повідомлення');
$pdf->Text(12, 52, 'Касир:');
$pdf->Text(12, 59, 'Квитанція');
$pdf->Text(12, 103, 'Касир:');

$x = 60;
$y = 5;
$pdf->SetXY($x, $y);
$pdf->MultiCell(145, 5, 'Отримувач: КП КОР «Зберігач»', 1, '', 0);
$pdf->SetXY($x, $y+=5);
$pdf->MultiCell(145, 5, 'Р/Р UA703204780000026009924432768 в АБ «УКРГАЗБАНК», м. Київ', 1, '', 0);
$pdf->SetXY($x, $y+=5);
$pdf->MultiCell(100, 5, 'Код отримувача:', 1, '', 0);
$pdf->SetXY($x+100, $y);
$pdf->MultiCell(45, 5, '38733758', 1, '', 0);
$pdf->SetXY($x, $y+=5);
$pdf->MultiCell(145, 5, 'ПІБ платника: ' . $zamovnuk, 1, '', 0);
$pdf->SetXY($x, $y+=5);
$pdf->MultiCell(145, 5, 'Адреса платника: ' . $address, 1, '', 0);
$pdf->SetXY($x, $y+=5);
$pdf->SetFont('dejavub', '', 9);
$pdf->MultiCell(90, 5, 'призначення платежу', 1, '', 0);
$pdf->SetXY($x+90, $y);
$pdf->MultiCell(25, 5, 'дата', 1, 'C', 0);
$pdf->SetXY($x+115, $y);
$pdf->MultiCell(30, 5, 'сума', 1, 'R', 0);
$pdf->SetXY($x, $y+=5);
$pdf->SetFont('dejavu', '', 9);
$pdf->MultiCell(90, 5, 'оплата за замовлення
№ ' . $zakaz . ' ,
' . $vidrob, 1, '', 0);
$pdf->SetXY($x+90, $y);
$pdf->MultiCell(25, 15, $dtzak, 1, 'C', 0);
$pdf->SetXY($x+115, $y);
$pdf->MultiCell(30, 15, $sum, 1, 'R', 0);
$pdf->SetXY($x, $y+=15);
$pdf->MultiCell(145, 5, 'Підпис платника:', 1, '', 0);

//----------------------------------------------------------------------------------------------------

$pdf->SetXY($x, $y+=5);
$pdf->MultiCell(145, 5, 'Отримувач: КП КОР «Зберігач»', 1, '', 0);
$pdf->SetXY($x, $y+=5);
$pdf->MultiCell(145, 5, 'Р/Р UA703204780000026009924432768 в АБ «УКРГАЗБАНК», м. Київ', 1, '', 0);
$pdf->SetXY($x, $y+=5);
$pdf->MultiCell(100, 5, 'Код отримувача:', 1, '', 0);
$pdf->SetXY($x+100, $y);
$pdf->MultiCell(45, 5, '38733758', 1, '', 0);
$pdf->SetXY($x, $y+=5);
$pdf->MultiCell(145, 5, 'ПІБ платника: ' . $zamovnuk, 1, '', 0);
$pdf->SetXY($x, $y+=5);
$pdf->MultiCell(145, 5, 'Адреса платника: ' . $address, 1, '', 0);
$pdf->SetXY($x, $y+=5);
$pdf->SetFont('dejavub', '', 9);
$pdf->MultiCell(90, 5, 'призначення платежу', 1, '', 0);
$pdf->SetXY($x+90, $y);
$pdf->MultiCell(25, 5, 'дата', 1, 'C', 0);
$pdf->SetXY($x+115, $y);
$pdf->MultiCell(30, 5, 'сума', 1, 'R', 0);
$pdf->SetXY($x, $y+=5);
$pdf->SetFont('dejavu', '', 9);
$pdf->MultiCell(90, 5, 'оплата за замовлення
№ ' . $zakaz . ' ,
' . $vidrob, 1, '', 0);
$pdf->SetXY($x+90, $y);
$pdf->MultiCell(25, 15, $dtzak, 1, 'C', 0);
$pdf->SetXY($x+115, $y);
$pdf->MultiCell(30, 15, $sum, 1, 'R', 0);
$pdf->SetXY($x, $y+=15);
$pdf->MultiCell(145, 5, 'Підпис платника:', 1, '', 0);

//Zakrutie bazu
if (mysql_close($db)) {
    // echo("Закриття бази даних");
} else {
    echo("Не можливо виконати закриття бази");
}
$pdf->Output('receipt.pdf', 'I');