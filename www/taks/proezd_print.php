<?php
session_start();
$lg=$_SESSION['LG'];
$pas=$_SESSION['PAS'];
$db=mysql_connect("localhost",$lg,$pas);
if(!$db) echo "Не вiдбулося зєднання з базою даних";
  
 if(!@mysql_select_db(kpbti,$db))
  {
   echo("Не завантажена таблиця");
   exit(); 
   }
   
include "../function.php";
require('../tfpdf/tfpdf.php');
 // створюємо FPDF обєкт
$pdf = new TFPDF();

$pdf->SetAutoPageBreak('true',2);
$pdf->SetMargins(05,05,2);

$pdf-> AddFont('dejavu','','DejaVuSans.ttf',true); 
$pdf-> AddFont('dejavub','','DejaVuSans-Bold.ttf',true);

// Вказуємо автора та заголовок
$pdf->SetAuthor('Шкурат А.О.');
$pdf->SetTitle('Замовлення');

// задаємо шрифт та його колiр
$pdf-> SetFont('dejavu','',10);
$pdf->SetTextColor(50, 60, 100);
 
//створюємо нову сторiнку та вказуємо режим її вiдображення
$pdf->AddPage('P');
$pdf->SetDisplayMode('real', 'default');

$pdf->SetXY(05, 05);
$pdf->SetDrawColor(50, 60, 100);

$vukon=$_GET['vukon'];
$bdate=$_GET['bdate'];
$edate=$_GET['edate'];

$pdf-> SetFont('dejavu','',8);
$pdf->Text(188,10,'Додаток1');
$pdf->Text(155,13,'до наказу №12 від 12.03.2015р.');
$pdf-> SetFont('dejavub','',10);
$pdf->Text(178,20,'Погоджено: ');
$pdf-> SetFont('dejavu','',10);
$pdf->Text(110,25,'Провідний інженер з якості_______________________');
$pdf->Text(182,29,'ФІО,підпис');
$pdf-> SetFont('dejavub','',14);
$pdf->Text(100,35,'ЗВІТ');
$pdf-> SetFont('dejavu','',10);
$pdf->Text(40,40,'про фактичні виїзди для проведення обмірів об`єктів нерухомого майна');
$pdf->Text(51,44,'в м. Ірпінь, в населені пункти Ірпінського регіону');
//$pdf->Text(54,48,'в м. Комсомольськ та прилеглі до нього населені пункти');
$pdf->Line(14,55,204,55);  
$pdf-> SetFont('dejavu','',7);
$pdf->Text(90,58,'П.І.Б., посада виконавця');
$pdf-> SetFont('dejavu','',10);
$pdf->Text(14,65,'за');
$pdf->Line(20,65,204,65);  
$pdf-> SetFont('dejavu','',7);
$pdf->Text(93,68,'період - місяць, рік');
//------------------таблиця-----------------
$pdf-> SetFont('dejavu','',8);
$pdf->SetXY(14, 70);
$pdf->MultiCell(19,5,'Дата прийому',1,'C',0);
$pdf->SetXY(33, 70);
$pdf->MultiCell(19,5,'Дата виїзду',1,'C',0);
$pdf->SetXY(52, 70);
$pdf->MultiCell(19,10,'Замовл.',1,'C',0);
$pdf->SetXY(71, 70);
$pdf->MultiCell(81,10,'Адреса',1,'C',0);
$pdf->SetXY(152, 70);
$pdf->MultiCell(15,5,'Витр. кошти',1,'C',0);
$pdf->SetXY(167, 70);
$pdf->MultiCell(37,5,'Примітка (посилання на додатки)',1,'C',0);
$pdf-> SetFont('dejavu','',8);
$it=40;

$sql = "SELECT zamovlennya.SZ,zamovlennya.NZ,zamovlennya.KEY,
zamovlennya.TUP_ZAM,zamovlennya.BUD,zamovlennya.KVAR,nas_punktu.NSP,tup_nsp.TIP_NSP,
vulutsi.VUL,tup_vul.TIP_VUL,zamovlennya.D_PR,zamovlennya.DATA_VUH,zamovlennya.SM_PROEZD,PRIM_PROEZD 
FROM zamovlennya,nas_punktu,vulutsi,tup_nsp,tup_vul 
	WHERE 
		zamovlennya.DATA_VUH>='$bdate' AND zamovlennya.DATA_VUH<='$edate' AND zamovlennya.SM_PROEZD!=0 
		AND zamovlennya.VUK='$vukon' AND zamovlennya.VUD_ROB!=9 
		AND nas_punktu.ID_NSP=zamovlennya.NS
		AND vulutsi.ID_VUL=zamovlennya.VL
		AND tup_nsp.ID_TIP_NSP=nas_punktu.ID_TIP_NSP
		AND tup_vul.ID_TIP_VUL=vulutsi.ID_TIP_VUL
	ORDER BY DATA_VUH";

 $atu=mysql_query($sql);
  while($aut=mysql_fetch_array($atu))
 {	
if($aut["BUD"]!="") $bud="буд.".$aut["BUD"]; else $bud="";
if($aut["KVAR"]!="") $kvar="кв.".$aut["KVAR"]; else $kvar="";
$zakaz=$aut["SZ"].'/'.$aut["NZ"];

$d_pr=german_date($aut["D_PR"]);
$d_vuh=german_date($aut["DATA_VUH"]);
$adres=$aut["TIP_NSP"].$aut["NSP"]." ".$aut["TIP_VUL"].$aut["VUL"]." ".$bud." ".$kvar;
$sm_pr=$aut["SM_PROEZD"];
$prim=$aut["PRIM_PROEZD"];

if($it>240){
$pdf->AddPage('P');
$pdf->SetDisplayMode('real', 'default');
$pdf->SetXY(05, 05);
$pdf->SetDrawColor(50, 60, 100);
$it=-30;
}

$pdf->SetXY(14, 40+$it);
$pdf->MultiCell(19,5,$d_pr,1,'C',0);
$pdf->SetXY(33, 40+$it);
$pdf->MultiCell(19,5,$d_vuh,1,'C',0);
$pdf->SetXY(52, 40+$it);
$pdf->MultiCell(19,5,$zakaz,1,'C',0);
$pdf->SetXY(71, 40+$it);
$pdf->MultiCell(81,5,$adres,1,'L',0);
$pdf->SetXY(152, 40+$it);
$pdf->MultiCell(15,5,$sm_pr,1,'C',0);
$pdf->SetXY(167, 40+$it);
$pdf->MultiCell(37,5,$prim,1,'C',0);
$it=$it+5;

}
mysql_free_result($atu);
if($it<230){
for($i=$it;$i<230;$i=$i+5){
$pdf->SetXY(14, 40+$i);
$pdf->MultiCell(19,5,'',1,'C',0);
$pdf->SetXY(33, 40+$i);
$pdf->MultiCell(19,5,'',1,'C',0);
$pdf->SetXY(52, 40+$i);
$pdf->MultiCell(19,5,'',1,'C',0);
$pdf->SetXY(71, 40+$i);
$pdf->MultiCell(81,5,'',1,'L',0);
$pdf->SetXY(152, 40+$i);
$pdf->MultiCell(15,5,'',1,'C',0);
$pdf->SetXY(167, 40+$i);
$pdf->MultiCell(37,5,'',1,'C',0);
}
}

$pdf->Line(20,280,110,280);  
$pdf->Line(120,280,150,280);  
$pdf->Line(160,280,204,280);  
$pdf-> SetFont('dejavu','',7);
$pdf->Text(55,283,'Посада виконавця');
$pdf->Text(130,283,'Підпис');
$pdf->Text(180,283,'П.І.Б.');
$pdf->Text(173,279,$vukon);
$pdf-> SetFont('dejavu','',10);
$pdf->Text(18,290,'"______"_____________________________________201__р.');

if(mysql_close($db))
        {
        // echo("Закриття бази даних");
         }
         else
         {
          echo("Не можливо виконати закриття бази"); 
          }
		  
//виводимо документ на екран
$pdf->Output('proezd.pdf','I');
?>