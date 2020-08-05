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
/*
if ($tz == 2) {
    $sql = "SELECT zamovlennya.*,dlya_oformlennya.document,dlya_oformlennya.name_for_dog,rayonu.RAYON,rayonu.ID_RAYONA,nas_punktu.NSP, tup_nsp.TIP_NSP,
		yur_kl.ADRES,dlya_oformlennya.id_oform,vulutsi.VUL,tup_vul.TIP_VUL,
		zamovlennya.SZ,zamovlennya.NZ,yur_kl.PILGA 
		FROM zamovlennya, rayonu, nas_punktu, vulutsi, tup_nsp, tup_vul, dlya_oformlennya,yur_kl 
		WHERE 
			zamovlennya.KEY='$kl' AND zamovlennya.EDRPOU=yur_kl.EDRPOU 
			AND zamovlennya.DL='1' AND dlya_oformlennya.id_oform=zamovlennya.VUD_ROB
			AND rayonu.ID_RAYONA=RN AND nas_punktu.ID_NSP=NS AND vulutsi.ID_VUL=VL
			AND tup_nsp.ID_TIP_NSP=nas_punktu.ID_TIP_NSP
			AND tup_vul.ID_TIP_VUL=vulutsi.ID_TIP_VUL";
	$patterns1[0] = "[nomer]";
    $patterns1[1] = "[adresa]";
    $patterns1[2] = "[sbpdv]";
} else {
    $sql = "SELECT zamovlennya.*,dlya_oformlennya.document,dlya_oformlennya.name_for_dog,rayonu.RAYON,rayonu.ID_RAYONA,nas_punktu.NSP, tup_nsp.TIP_NSP,
		dlya_oformlennya.id_oform,vulutsi.VUL,tup_vul.TIP_VUL,zamovlennya.SZ,zamovlennya.NZ
		FROM zamovlennya, rayonu, nas_punktu, vulutsi, tup_nsp, tup_vul, dlya_oformlennya
		WHERE 
		zamovlennya.KEY='$kl' 
		AND zamovlennya.DL='1' AND dlya_oformlennya.id_oform=zamovlennya.VUD_ROB
		AND rayonu.ID_RAYONA=RN AND nas_punktu.ID_NSP=NS AND vulutsi.ID_VUL=VL
		AND tup_nsp.ID_TIP_NSP=nas_punktu.ID_TIP_NSP
		AND tup_vul.ID_TIP_VUL=vulutsi.ID_TIP_VUL";
}*/
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
//echo $sql;
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

$rahunok = 'UA703204780000026009924432768';


$grn = (int)$sum;
$kop = fract($sum);
$sumpr = in_str($grn);
if ($pilga == 0) {
    $sbpdv = number_format(round($sum / 1.2, 2), 2, '.', '');
    $spdv = number_format(round($sum / 6, 2), 2, '.', '');
    $smpr = $sumpr . ' грн. ' . $kop . ' коп. в т.ч. ПДВ – 20%';

    $grnpdv = (int)$spdv;
    $koppdv = fract($spdv);
    $spdvpr = in_str($grnpdv);
    $prpdv = $spdvpr . ' грн. ' . $koppdv . ' коп.';
} else {
    $sbpdv = number_format($sum, 2, '.', '');
    $spdv = number_format(0, 2, '.', '');
    $smpr = $sumpr . ' грн. ' . $kop . ' коп.';
    $prpdv = '';
}

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
    $pdf->SetAuthor('КП КОР "КИЇВСЬКЕ ОБЛАСНЕ БТІ"');
    $pdf->SetTitle('Рахунок');

//створюємо нову сторiнку та вказуємо режим її вiдображення
    $pdf->AddPage('P');
    $pdf->SetDisplayMode('real', 'default');

    $pdf->SetXY(05, 05);
    $pdf->SetDrawColor(50, 60, 100);

    $pdf->SetFont('dejavub', '', 10);
    $pdf->Text(15, 15, 'Постачальник');
    $pdf->Line(45, 15, 100, 15);
    $pdf->Text(15, 22, 'Адреса');
    $pdf->Line(33, 22, 100, 22);
    $pdf->Line(33, 29, 100, 29);
    $pdf->Text(15, 36, 'IBAN');
    $pdf->Line(27, 36, 100, 36);
    $pdf->Text(15, 43, 'в');
    $pdf->Line(20, 43, 100, 43);
    $pdf->Text(15, 50, 'ЄДРПОУ');
    $pdf->Line(35, 50, 100, 50);
    $pdf->Text(15, 57, 'Телефон');
    $pdf->Line(37, 57, 100, 57);

    $pdf->SetFont('dejavu_light', '', 10);
    $pdf->Text(48, 14, 'КП КОР "КИЇВСЬКЕ ОБЛАСНЕ БТІ"');
    $pdf->Text(38, 21, '07400 Київська обл.,');
    $pdf->Text(38, 28, 'м.Бровари, вул.Шевченка, 8а,');
    $pdf->Text(30, 35, $rahunok);
    $pdf->Text(20, 42, 'в АБ «УКРГАЗБАНК», м. Київ');
    $pdf->Text(40, 49, '38250947');
    $pdf->Text(40, 56, '(045) 944-13-21');

    $pdf->SetFont('dejavub', '', 14);
    $pdf->Text(125, 20, 'РАХУНОК-ФАКТУРА');

    $pdf->SetFont('dejavu', '', 12);
    $pdf->SetXY(134, 25);
    $pdf->MultiCell(40, 10, $zakaz, 1, 'C', 0);

    $pdf->SetFont('dejavu', '', 10);
    $pdf->Text(125, 45, 'від');
    $pdf->Line(135, 45, 175, 45);
    $pdf->Text(177, 45, 'р.');
    $pdf->Text(145, 44, $dtzak);

    $pdf->SetFont('dejavub', '', 10);
    $pdf->Text(15, 69, 'Платник');
    $pdf->Line(15, 70, 100, 70);
    $pdf->SetFont('dejavu_i', '', 10);
    $pdf->Text(35, 69, $zamovnuk);
    $pdf->SetFont('dejavu_light', '', 7);
    $pdf->Text(110, 73, 'замовлення вважається укладеним після сплати рахунку фактури');

    $pdf->SetFont('dejavub', '', 9);
    $pdf->SetXY(15, 80);
    $pdf->MultiCell(100, 10, 'Найменування', 1, 'C', 0);
    $pdf->SetXY(115, 80);
    $pdf->MultiCell(20, 10, 'Одиниця', 1, 'C', 0);
    $pdf->SetXY(135, 80);
    $pdf->MultiCell(20, 10, 'Кількість', 1, 'C', 0);
    $pdf->SetXY(155, 80);
    $pdf->MultiCell(25, 10, 'Ціна', 1, 'C', 0);
    $pdf->SetXY(180, 80);
    $pdf->MultiCell(25, 10, 'Сума', 1, 'C', 0);

    $job = $vidrob . ' за адресою ' . $address;
    $len_str = mb_strlen($job);
    $count_job_str = ceil(($len_str/55));

    $pdf->SetFont('dejavu', '', 9);
    $pdf->SetXY(15, 90);
    $pdf->MultiCell(100, 5, $job, 1, 'L', 0);
    $pdf->SetXY(115, 90);
    $pdf->MultiCell(20, 5 * $count_job_str, 'послуга', 1, 'C', 0);
    $pdf->SetXY(135, 90);
    $pdf->MultiCell(20, 5 * $count_job_str, '1', 1, 'C', 0);
    $pdf->SetXY(155, 90);
    $pdf->MultiCell(25, 5 * $count_job_str, number_format($sbpdv, 2), 1, 'R', 0);
    $pdf->SetXY(180, 90);
    $pdf->MultiCell(25, 5 * $count_job_str, number_format($sbpdv, 2), 1, 'R', 0);

    $pdf->SetFont('dejavub', '', 9);
    $pdf->SetXY(15, 90 + 5 * $count_job_str);
    $pdf->MultiCell(165, 5, 'Аванс:', 1, 'L', 0);
    $pdf->SetXY(180, 90 + 5 * $count_job_str);
    $pdf->MultiCell(25, 5, number_format($sbpdv, 2), 1, 'R', 0);
    $pdf->SetXY(15, 95 + 5 * $count_job_str);
    $pdf->MultiCell(165, 5, 'Податок на додану вартість (ПДВ)', 1, 'L', 0);
    $pdf->SetXY(180, 95 + 5 * $count_job_str);
    $pdf->MultiCell(25, 5, $spdv, 1, 'R', 0);
    $pdf->SetXY(15, 100 + 5 * $count_job_str);
    $pdf->MultiCell(165, 5, 'Загальна сума з ПДВ', 1, 'L', 0);
    $pdf->SetXY(180, 100 + 5 * $count_job_str);
    $pdf->MultiCell(25, 5, $sum, 1, 'R', 0);

    $pdf->SetFont('dejavub', '', 8);
    $pdf->Text(15, 115 + 5 * $count_job_str, 'Загальна сума, що підлягає оплаті');
    $pdf->Line(75, 116 + 5 * $count_job_str, 200, 116 + 5 * $count_job_str);
    $pdf->SetFont('dejavu', '', 8);
    $pdf->Text(80, 115 + 5 * $count_job_str, $smpr);

    $pdf->SetFont('dejavub', '', 8);
    $pdf->Text(15, 130 + 5 * $count_job_str, 'Директор _________________________');
    $pdf->Text(120, 130 + 5 * $count_job_str, 'Гол. бухгалтер _________________________');

//Zakrutie bazu       
if (mysql_close($db)) {
    // echo("Закриття бази даних");
} else {
    echo("Не можливо виконати закриття бази");
}
$pdf->Output('rahunok.pdf', 'I');