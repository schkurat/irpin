<?php
session_start();
$lg = $_SESSION['LG'];
$pas = $_SESSION['PAS'];

include_once "../function.php";
$user = $_SESSION['PR'] . ' ' . p_buk($_SESSION['IM']) . '.' . p_buk($_SESSION['PB']) . '.';

$kl = (int)$_GET['kl'];
$dod = (int)$_GET['dod'];
$kl_adr = (isset($_GET['kl_adr']))? (int)$_GET['kl_adr']: 0;
$db = mysql_connect("localhost", $lg, $pas);
if (!$db) echo "Не вiдбулося зєднання з базою даних";

if (!@mysql_select_db(kpbti, $db)) {
    echo("Не завантажена таблиця");
    exit();
}
$count = 0;
$address = [];
$sql = "SELECT arhiv_zakaz.*,arhiv_jobs.name,rayonu.RAYON,rayonu.ID_RAYONA,nas_punktu.NSP, tup_nsp.TIP_NSP,
		    arhiv_jobs.id,vulutsi.VUL,tup_vul.TIP_VUL,arhiv_dop_adr.bud,arhiv_dop_adr.kvar,arhiv_dop_adr.status,arhiv_dop_adr.VD,arhiv_dop_adr.id   
		FROM arhiv_zakaz 
            LEFT JOIN arhiv_jobs ON arhiv_zakaz.VUD_ROB=arhiv_jobs.id 
            LEFT JOIN arhiv_dop_adr ON arhiv_zakaz.KEY=arhiv_dop_adr.id_zm 
            LEFT JOIN rayonu ON rayonu.ID_RAYONA=arhiv_dop_adr.rn 
            LEFT JOIN nas_punktu ON nas_punktu.ID_NSP=arhiv_dop_adr.ns 
            LEFT JOIN vulutsi ON vulutsi.ID_VUL=arhiv_dop_adr.vl
            LEFT JOIN tup_nsp ON tup_nsp.ID_TIP_NSP=nas_punktu.ID_TIP_NSP
            LEFT JOIN tup_vul ON tup_vul.ID_TIP_VUL=vulutsi.ID_TIP_VUL
		WHERE 
		    arhiv_zakaz.KEY='$kl' AND arhiv_zakaz.DL='1' ORDER BY arhiv_dop_adr.id";

$atu = mysql_query($sql);
while ($aut = mysql_fetch_array($atu)) {
    $count++;
    if ($count == 1) {
        $kod_rn = $aut["ID_RAYONA"];
        $serial = get_num_order($kod_rn, $aut["SZ"], $aut["NZ"]);
        $dt_serial = $dtdog = german_date($aut["D_PR"]);
        $pruymalnuk = $aut["PR_OS"];
        $sum = $aut["SUM"];
        $edrpou = $aut["EDRPOU"];
        $kod_rob = $aut["id"];
        $sert_os = $aut["PR"] . ' ' . p_buk($aut["IM"]) . '.' . p_buk($aut["PB"]). '.';

        $address[] = [
            'id' => (int)$aut["id"],
            'npp' => $count,
            'address' => $aut["RAYON"] . ' ' . $aut["TIP_NSP"] . ' ' . $aut["NSP"] . ', ' . $aut["TIP_VUL"] . ' ' . $aut["VUL"] . ', ' . objekt_ner(0, $aut["bud"], $aut["kvar"]),
            'status' => $aut["status"],
            'vudacha' => $aut["VD"],
            'type' => (!empty($aut["kvar"])) ? 'квартира' : 'будинок'
        ];
    } else {
        $address[] = [
            'id' => (int)$aut["id"],
            'npp' => $count,
            'address' => $aut["RAYON"] . ' ' . $aut["TIP_NSP"] . ' ' . $aut["NSP"] . ', ' . $aut["TIP_VUL"] . ' ' . $aut["VUL"] . ', ' . objekt_ner(0, $aut["bud"], $aut["kvar"]),
            'status' => $aut["status"],
            'vudacha' => $aut["VD"],
            'type' => (!empty($aut["kvar"])) ? 'квартира' : 'будинок'
        ];
    }
}
mysql_free_result($atu);
$count_address = count($address);

$sql = "SELECT * FROM yur_kl WHERE yur_kl.EDRPOU='$edrpou' AND yur_kl.DL='1'";
$atu = mysql_query($sql);
while ($aut = mysql_fetch_array($atu)) {
    $ndog = $aut["N_DOG"];
    $dtdog = german_date($aut["DT_DOG"]);
    $name_client = $aut["NAME"];
    $address_subj = $aut["ADRES"];
    $phone = $aut["TELEF"];
    $bank = $aut["BANK"];
    $rahunok = $aut["RR"];
    $boss = $aut["BOSS"];
    $pidstava = $aut["PIDSTAVA"];
}
mysql_free_result($atu);
//echo '<pre>';
//var_dump($address);
//echo '</pre>';
//die();

require('../tfpdf/tfpdf.php');
// створюємо FPDF обєкт
$pdf = new TFPDF();

$pdf->SetAutoPageBreak('true', 2);
$pdf->SetMargins(05, 05, 2);

$pdf->AddFont('dejavu', '', 'DejaVuSans.ttf', true);
$pdf->AddFont('dejavub', '', 'DejaVuSans-Bold.ttf', true);

// Вказуємо автора та заголовок
$pdf->SetAuthor('КП КОР ЗБЕРІГАЧ');
$pdf->SetTitle('Замовлення');

//створюємо нову сторiнку та вказуємо режим її вiдображення
$pdf->AddPage('P');
$pdf->SetDisplayMode('real', 'default');
$pdf->SetDrawColor(50, 60, 100);

$pdf->SetFont('dejavu', '', 10);

$pdf->SetFont('dejavu', '', 8);
$pdf->Text(185, 10, 'Додаток ' . $dod);
$pdf->SetXY(160, 11);
$pdf->MultiCell(45, 4, 'До Договору про надання
послуг № ' . $ndog . '
від ' . $dtdog . 'р.', 0, 'L', 0);

if ($dod == 1) {
    $pdf->SetFont('dejavub', '', 10);
    $pdf->SetXY(19, 40);
    $pdf->MultiCell(188, 5, 'Перелік адрес матеріалів технічної інвентаризації об’єктів нерухомого майна, які здаються на постійне зберігання
від ' . $dt_serial . ' року Серія ' . $serial, 0, 'C', 0);
    $pdf->SetFont('dejavu', '', 10);
    $pdf->SetXY(19, 60);
    $pdf->MultiCell(188, 5, 'Ми, що нижче підписалися, КП КОР «ЗБЕРІГАЧ», в особі ' . $user . ' (Виконавець) та суб’єкт господарювання ' . $name_client . ', в особі ' . $sert_os . ' (Замовник) склали цей перелік про те, що Замовником передано, а Виконавцем прийнято на опрацювання наступні матеріали технічної інвентаризації:', 0, 'L', 0);

    $pdf->SetXY(20, 85);
    $pdf->MultiCell(10, 5, '№ з/п', 1, 'C', 0);
    $pdf->SetXY(30, 85);
    $pdf->MultiCell(130, 10, 'Адреса об’єкта', 1, 'C', 0);
    $pdf->SetXY(160, 85);
    $pdf->MultiCell(22, 5, 'Тип об’єкта', 1, 'C', 0);
    $pdf->SetXY(182, 85);
    $pdf->MultiCell(22, 10, 'Варт.', 1, 'C', 0);

    $pdf->SetFont('dejavu', '', 7);
    $y = 0;
    $adr_cost = number_format(($sum / $count_address), 2);
    foreach ($address as $adr) {
        $pdf->SetXY(20, 95 + $y);
        $pdf->MultiCell(10, 5, $adr['npp'], 1, 'C', 0);
        $pdf->SetXY(30, 95 + $y);
        $pdf->MultiCell(130, 5, $adr['address'], 1, 'L', 0);
        $pdf->SetXY(160, 95 + $y);
        $pdf->MultiCell(22, 5, $adr['type'], 1, 'C', 0);
        $pdf->SetXY(182, 95 + $y);
        $pdf->MultiCell(22, 5, $adr_cost, 1, 'R', 0);
        $y += 5;
    }
    $pdf->SetFont('dejavu', '', 10);
    $pdf->SetXY(20, 95 + $y);
    $pdf->MultiCell(162, 5, 'Всього:', 1, 'L', 0);
    $pdf->SetXY(182, 95 + $y);
    $pdf->MultiCell(22, 5, $sum, 1, 'R', 0);

} elseif ($dod == 2) {

    $pdf->SetFont('dejavub', '', 10);
    $pdf->SetXY(19, 40);
    $pdf->MultiCell(188, 5, 'Перелік адрес матеріалів технічної інвентаризації об’єктів нерухомого майна, які приймаються на постійне зберігання
від ' . $dt_serial . ' року Серія ' . $serial, 0, 'C', 0);
    $pdf->SetFont('dejavu', '', 10);
    $pdf->SetXY(19, 60);
    $pdf->MultiCell(188, 5, 'Ми, що нижче підписалися, КП КОР «ЗБЕРІГАЧ», в особі ' . $user . ' (Виконавець) та суб’єкт господарювання ' . $name_client . ', в особі ' . $sert_os . ' (Замовник) склали цей перелік про те, що Замовником передано, а Виконавцем прийнято на зберігання наступні матеріали технічної інвентаризації:', 0, 'L', 0);

    $pdf->SetXY(20, 85);
    $pdf->MultiCell(10, 5, '№ з/п', 1, 'C', 0);
    $pdf->SetXY(30, 85);
    $pdf->MultiCell(22, 5, 'Тип об’єкта', 1, 'C', 0);
    $pdf->SetXY(52, 85);
    $pdf->MultiCell(152, 10, 'Адреса об’єкта', 1, 'C', 0);

    $pdf->SetFont('dejavu', '', 7);
    $y = 0;
//    $adr_cost = number_format(($sum / $count_address), 2);
    foreach ($address as $adr) {
        if($adr['status'] == 1){
            $pdf->SetXY(20, 95 + $y);
            $pdf->MultiCell(10, 5, $adr['npp'], 1, 'C', 0);
            $pdf->SetXY(30, 95 + $y);
            $pdf->MultiCell(22, 5, $adr['type'], 1, 'C', 0);
            $pdf->SetXY(52, 95 + $y);
            $pdf->MultiCell(152, 5, $adr['address'], 1, 'L', 0);
            $y += 5;
        }
    }
    $pdf->SetFont('dejavu', '', 10);
    $pdf->SetXY(20, 95 + $y);
    $pdf->MultiCell(184, 5, 'Всього: ' . $count_address, 1, 'L', 0);
    $pdf->Text(20, 110 + $y, 'Сторони одна до одної претензій не мають.');
    $y += 10;
} elseif ($dod == 3) {
    $pdf->SetFont('dejavub', '', 10);
    $pdf->SetXY(19, 40);
    $pdf->MultiCell(188, 5, 'Перелік адрес матеріалів технічної інвентаризації об’єктів нерухомого майна, які повертаються на доопрацювання
від ' . $dt_serial . ' року Серія ' . $serial, 0, 'C', 0);
    $pdf->SetFont('dejavu', '', 10);
    $pdf->SetXY(19, 60);
    $pdf->MultiCell(188, 5, 'Ми, що нижче підписалися, КП КОР «ЗБЕРІГАЧ», в особі ' . $user . ' (Виконавець) та суб’єкт господарювання ' . $name_client . ', в особі ' . $sert_os . ' (Замовник) склали цей перелік про те, що Виконавцем передано, а Замовником прийнято на доопрацювання наступні матеріали технічної інвентаризації:', 0, 'L', 0);

    $pdf->SetXY(20, 85);
    $pdf->MultiCell(10, 5, '№ з/п', 1, 'C', 0);
    $pdf->SetXY(30, 85);
    $pdf->MultiCell(113, 10, 'Адреса об’єкта', 1, 'C', 0);
    $pdf->SetXY(143, 85);
    $pdf->MultiCell(19, 5, 'Тип об’єкта', 1, 'C', 0);
    $pdf->SetXY(162, 85);
    $pdf->MultiCell(42, 10, 'Порушення', 1, 'C', 0);

    $pdf->SetFont('dejavu', '', 7);
    $y = 0;
    $adr_cost = number_format(($sum / $count_address), 2);
    foreach ($address as $adr) {
        if($adr['status'] == 2) {
            $pdf->SetXY(20, 95 + $y);
            $pdf->MultiCell(10, 5, $adr['npp'], 1, 'C', 0);
            $pdf->SetXY(30, 95 + $y);
            $pdf->MultiCell(113, 5, $adr['address'], 1, 'L', 0);
            $pdf->SetXY(143, 95 + $y);
            $pdf->MultiCell(19, 5, $adr['type'], 1, 'C', 0);
            $pdf->SetXY(162, 95 + $y);
            $pdf->MultiCell(42, 5, '', 1, 'R', 0);
            $y += 5;
        }
    }
    $pdf->SetFont('dejavu', '', 10);
    $pdf->Text(20, 105 + $y, 'Сторони одна до одної претензій не мають.');

} elseif ($dod == 4) {
    $pdf->SetFont('dejavub', '', 10);
    $pdf->SetXY(19, 40);
    $pdf->MultiCell(188, 5, 'Перелік адрес об’єктів нерухомого майна, на які суб’єкт господарювання надає запит про надання матеріалів технічної інвентаризації для проведення технічної інвентаризації
від ' . $dt_serial . ' року Серія ' . $serial, 0, 'C', 0);
    $pdf->SetFont('dejavu', '', 10);
    $pdf->SetXY(19, 60);
    $pdf->MultiCell(188, 5, 'Ми, що нижче підписалися, КП КОР «ЗБЕРІГАЧ», в особі ' . $user . ' (Виконавець) та суб’єкт господарювання ' . $name_client . ', в особі ' . $sert_os . ' (Замовник) склали цей перелік про те, що Замовником передано, а Виконавцем прийнято на опрацювання запити за наступними адресами:', 0, 'L', 0);

    $pdf->SetXY(20, 85);
    $pdf->MultiCell(10, 5, '№ з/п', 1, 'C', 0);
    $pdf->SetXY(30, 85);
    $pdf->MultiCell(130, 10, 'Адреса об’єкта', 1, 'C', 0);
    $pdf->SetXY(160, 85);
    $pdf->MultiCell(22, 5, 'Тип об’єкта', 1, 'C', 0);
    $pdf->SetXY(182, 85);
    $pdf->MultiCell(22, 10, 'Варт.', 1, 'C', 0);

    $pdf->SetFont('dejavu', '', 7);
    $y = 0;
    $adr_cost = number_format(($sum / $count_address), 2);
    foreach ($address as $adr) {
        $pdf->SetXY(20, 95 + $y);
        $pdf->MultiCell(10, 5, $adr['npp'], 1, 'C', 0);
        $pdf->SetXY(30, 95 + $y);
        $pdf->MultiCell(130, 5, $adr['address'], 1, 'L', 0);
        $pdf->SetXY(160, 95 + $y);
        $pdf->MultiCell(22, 5, $adr['type'], 1, 'C', 0);
        $pdf->SetXY(182, 95 + $y);
        $pdf->MultiCell(22, 5, $adr_cost, 1, 'R', 0);
        $y += 5;
    }
    $pdf->SetFont('dejavu', '', 10);
    $pdf->SetXY(20, 95 + $y);
    $pdf->MultiCell(162, 5, 'Всього:', 1, 'L', 0);
    $pdf->SetXY(182, 95 + $y);
    $pdf->MultiCell(22, 5, $sum, 1, 'R', 0);
} elseif ($dod == 5) {

    $pdf->SetFont('dejavub', '', 10);
    $pdf->SetXY(19, 40);
    $pdf->MultiCell(188, 5, 'Перелік адрес матеріалів технічної інвентаризації об’єктів нерухомого майна, які видаються суб’єкту господарювання для проведення технічної інвентаризації
від ' . $dt_serial . ' року Серія ' . $serial, 0, 'C', 0);
    $pdf->SetFont('dejavu', '', 10);
    $pdf->SetXY(19, 60);
    $pdf->MultiCell(188, 5, 'Ми, що нижче підписалися, КП КОР «ЗБЕРІГАЧ», в особі ' . $user . ' (Виконавець) та суб’єкт господарювання ' . $name_client . ', в особі ' . $sert_os . ' (Замовник) склали цей перелік про те, що Виконавцем видано, а Замовником прийнято на наступні матеріали технічної інвентаризації:', 0, 'L', 0);

    $pdf->SetXY(20, 85);
    $pdf->MultiCell(10, 5, '№ з/п', 1, 'C', 0);
    $pdf->SetXY(30, 85);
    $pdf->MultiCell(130, 10, 'Адреса об’єкта', 1, 'C', 0);
    $pdf->SetXY(160, 85);
    $pdf->MultiCell(22, 5, 'Тип об’єкта', 1, 'C', 0);
    $pdf->SetXY(182, 85);
    $pdf->MultiCell(22, 10, 'Варт.', 1, 'C', 0);

    $pdf->SetFont('dejavu', '', 7);
    $y = 0;
    $adr_cost = number_format(($sum / $count_address), 2);
    foreach ($address as $adr) {
        if($adr['vudacha'] == '1') {
            $pdf->SetXY(20, 95 + $y);
            $pdf->MultiCell(10, 5, $adr['npp'], 1, 'C', 0);
            $pdf->SetXY(30, 95 + $y);
            $pdf->MultiCell(130, 5, $adr['address'], 1, 'L', 0);
            $pdf->SetXY(160, 95 + $y);
            $pdf->MultiCell(22, 5, $adr['type'], 1, 'C', 0);
            $pdf->SetXY(182, 95 + $y);
            $pdf->MultiCell(22, 5, $adr_cost, 1, 'R', 0);
            $y += 5;
        }
    }
    $pdf->SetFont('dejavu', '', 10);
    $pdf->SetXY(20, 95 + $y);
    $pdf->MultiCell(162, 5, 'Всього:', 1, 'L', 0);
    $pdf->SetXY(182, 95 + $y);
    $pdf->MultiCell(22, 5, $sum, 1, 'R', 0);
    $pdf->SetFont('dejavu', '', 10);
    $y += 5;
    $pdf->Text(20, 105 + $y, 'Сторони одна до одної претензій не мають.');

} elseif ($dod == 6) {
    $pdf->SetFont('dejavub', '', 14);
    $pdf->Text(73, 40 + $y, 'КИЇВСЬКА ОБЛАСНА РАДА');
    $pdf->SetFont('dejavu', '', 16);
    $pdf->Text(25, 50 + $y, 'КОМУНАЛЬНЕ ПІДПРИЄМСТВО КИЇВСЬКОЇ ОБЛАСНОЇ РАДИ');
    $pdf->SetFont('dejavub', '', 16);
    $pdf->Text(93, 60 + $y, '«ЗБЕРІГАЧ»');
    $pdf->SetFont('dejavu', '', 10);
    $pdf->Text(37, 65 + $y, '08202, м. Ірпінь, вул. Миру, 2-а, тел. моб. +38 098 012 28 02, ЄДРПОУ 38733758');
    $pdf->Text(83, 70 + $y, 'e-mail: zberigach.bti@gmail.com');
    $pdf->SetLineWidth(1);
    $pdf->Line(20, 72, 202, 72);
    $pdf->SetLineWidth(0.2);
    $pdf->SetXY(19, 100);
    $pdf->SetFont('dejavu', '', 12);
    $pdf->MultiCell(188, 5, 'ПОВІДОМЛЕННЯ
про відсутність матеріалів технічної інвентаризації на об’єкт нерухомості
на запит від ' . $dt_serial . ' року Серія ' . $serial, 0, 'C', 0);
    $pdf->SetFont('dejavu', '', 10);
    $pdf->SetXY(19, 130);
    $dod_six_adr = '';
    foreach ($address as $adr){
        if($adr['id'] == $kl_adr){
            $dod_six_adr = $adr['address'];
        }
    }
    $pdf->MultiCell(188, 5, 'Комунальне підприємство Київської обласної ради «Зберігач» повідомляє, що станом на ' . $dt_serial . 'р. на об’єкт нерухомого майна, що знаходиться за адресою: ' . $dod_six_adr . ', матеріали технічної інвентаризації відсутні.', 0, 'L', 0);
    $pdf->Text(20, 160, 'Генеральний директор');
    $pdf->Text(20, 170, 'КП КОР «ЗБЕРІГАЧ»                     ___________________  О.Я. Костиліна');
}

//-----------------------------------
if ($dod != 6) {
    $pdf->SetFont('dejavub', '', 10);
    $pdf->Text(50, 115 + $y, 'Виконавець');
    $pdf->Text(150, 115 + $y, 'Замовник');
    $pdf->Text(20, 120 + $y, 'КП КОР “Зберігач”');
    $pdf->Text(116, 120 + $y, $name_client);
    $pdf->SetFont('dejavu', '', 10);
    $pdf->SetXY(19, 122 + $y);
    $pdf->MultiCell(90, 5, 'Поштова адреса: 08205, Київська область,
місто Ірпінь, вул. Миру, 2-а
Тел.: 098 012 28 02
ЄДРПОУ: 38733758
Банк: АБ “Укргазбанк”
Р/рахунок: UA703204780000026009924432768

Підпис _____________________', 0, 'L', 0);

    $pdf->SetXY(115, 122 + $y);
    $pdf->MultiCell(93, 5, 'Поштова адреса: ' . $address_subj . '
Тел.: ' . $phone . '
ЄДРПОУ: ' . $edrpou . '
Банк: ' . $bank . '
Р/рахунок: ' . $rahunok . '

Підпис _____________________', 0, 'L', 0);
}
//-----------------------------------

//Zakrutie bazu
if (mysql_close($db)) {
    // echo("Закриття бази даних");
} else {
    echo("Не можливо виконати закриття бази");
}
$pdf->Output('dogovir.pdf', 'I');
