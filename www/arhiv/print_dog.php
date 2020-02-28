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

$atu = mysql_query($sql);
while ($aut = mysql_fetch_array($atu)) {
//    $t_zak = $aut["TUP_ZAM"];
    $kod_rn = $aut["ID_RAYONA"];
//    $b_rn = p_buk($aut["RAYON"]);
    $ndog = get_num_order($kod_rn, $aut["SZ"] , $aut["NZ"]);
    $dtdog = german_date($aut["D_PR"]);
//    $datavuh = german_date($aut["DATA_VUH"]);
//    $datagot = german_date($aut["DATA_GOT"]);
    $pruymalnuk = $aut["PR_OS"];
//    $idn = $aut["IDN"];
    $vidrob = $aut["name"];
    $kod_rob = $aut["id"];
    $zamovnuk = $aut["PR"] . ' ' . $aut["IM"] . ' ' . $aut["PB"];
    $zayavnuk = p_buk($aut["IM"]) . '.' . p_buk($aut["PB"]) . '. ' . $aut["PR"];
//    $pasport = $aut["PASPORT"];
    $primitka = $aut["PRIM"];

    $adresa = $aut["RAYON"] . ' ' . $aut["TIP_NSP"] . ' ' . $aut["NSP"] . ', ' . $aut["TIP_VUL"] . ' ' . $aut["VUL"] . ', ' . objekt_ner(0,$aut["bud"],$aut["kvar"]);
    $vart = $aut["SUM"];
    $tel = $aut["TEL"];
//    $term = $aut["TERM"];
}
mysql_free_result($atu);

//$dodvl = '';
//$sql = "SELECT PR,IM,PB	FROM zm_dod WHERE IDZM='$kl'";
//$atu = mysql_query($sql);
//while ($aut = mysql_fetch_array($atu)) {
//    $dodvl .= ', ' . $aut["PR"] . ' ' . $aut["IM"] . ' ' . $aut["PB"];
//}
//mysql_free_result($atu);

$grn = (int)$vart;
$kop = fract($vart);
$sumpr = in_str($grn);
if ($kop != 0) $smpr = $sumpr . ' грн. ' . $kop . ' коп.';
else $smpr = $sumpr . ' грн. ';

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

if($kod_rob == 6 || $kod_rob == 7){
    $pdf->Text(25, 10, 'КП КОР «Зберігач»');
    $pdf->Text(125, 10, 'Від гр. ' . $zamovnuk);
    $pdf->Text(125, 15, 'Що проживає:');
    $pdf->SetXY(124, 16);
    $pdf->MultiCell(75, 5, $adresa, 0, 'L', 0);
    $pdf->Text(125, 30, 'Тел: ' . $tel);
    $pdf->Text(80, 50, 'Замовлення № ' . $ndog);
    $pdf->Text(95, 57, $dtdog . 'р.');

    $pdf->Text(20, 70, 'Прошу: ' . $vidrob);
    $pdf->SetXY(19, 72);
    $pdf->MultiCell(185, 7, 'Об’єкт нерухомого майна знаходиться за адресою: ' . $adresa, 0, 'L', 0);
    $pdf->Text(20, 90, 'Належить: _____________________________________________________________________________');
    $pdf->Text(20, 97, 'До заяви додаються: ___________________________________________________________________');
    $pdf->Text(20, 104, 'Вартість роботи: ' . $vart . 'грн.');
    $pdf->Text(20, 111, 'Оплачено: ' . $vart . ' грн. Квитанція № ' . $ndog . ' від ' . $dtdog . 'р.');

    if($kod_rob == 6){
        $pdf->SetFont('dejavu', '', 8);
        $pdf->Text(20, 118, 'Зобов’язання та гарантії:');
        $pdf->SetXY(19, 120);
        $pdf->MultiCell(185, 5, '   1. Засвідчую, що до комунального підприємства Київської обласної ради «Зберігач» (далі – Зберігач) надані всі 
       необхідні документи (право власності, технічний паспорт…)
   2. У випадку надання замовником неточних, або недостовірних необхідних документів, Зберігач звільняється від 
       відповідальності, а виконані роботи вважаються виконаними належним чином і підлягають оплаті відповідно до 
       цього замовлення.
   3. Вартість послуг щодо надання інформації про об’єкт нерухомого майна визначається з урахуванням складності та 
       обсягу виконання робіт та складає_______ грн.
   4. Не пізніше трьох робочих днів з дня складання даного замовлення здійснити оплату на розрахунковий рахунок 
       Зберігача у розмірі передбаченим п. 3 даного замовлення.
   5. Термін виконання замовлення щодо надання інформації про об’єкт нерухомого майна рахується  відповідно до 
       чинного законодавства. При необхідності, виконання роботи в скорочений термін розраховується із застосуванням 
       коефіцієнту 2,0 за відсутності порушень замовником передбачених п.4, 1 даного замовлення.   
   6. У випадку порушення замовником зобов’язання даного замовлення Зберігач має право відмовитись від виконання 
       даного замовлення (припинити його юридичну дію) в односторонньому порядку.
   7. Інформація про об’єкт нерухомого майна, виконується після присвоєння інвентаризаційного номера на 
       вищезазначений об’єкт.  
   8. Відповідно до положень Закону України «Про захист персональних даних» надаю згоду на обробку моїх 
       персональних даних Зберігачем, а саме на обробку виданих на моє ім’я документів, підписаних мною документів та 
       відомостей, що надаються мною.
', 0, 'L', 0);
        $y = 230;
    }elseif ($kod_rob == 7){
        $y = 150;
    }
    $pdf->SetFont('dejavu', '', 10);
    $pdf->Text(20, $y, 'Замовник: ____________ ' . $zayavnuk . ' ' . $dtdog);
    $pdf->Text(120, $y, 'Замовлення прийняв: ____________ ' . $pruymalnuk . ' ' . $dtdog);
    $pdf->Text(20, $y + 20, 'Документи відповідно до замовлення отримав: _________________ ' . $pruymalnuk . ' ' . $dtdog);
}


//Zakrutie bazu
if (mysql_close($db)) {
    // echo("Закриття бази даних");
} else {
    echo("Не можливо виконати закриття бази");
}
$pdf->Output('dogovir.pdf', 'I');
