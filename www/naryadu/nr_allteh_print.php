<?php
session_start();
$lg=$_SESSION['LG'];
$pas=$_SESSION['PAS'];

include "../function.php";
require('../tfpdf/tfpdf.php');

$bdat=date_bd($_POST['bdate']);
$edat=date_bd($_POST['edate']);

$db=mysql_connect("localhost",$lg,$pas);
if(!$db) echo "Не вiдбулося зєднання з базою даних";
  
 if(!@mysql_select_db(kpbti,$db))
  {
   echo("Не завантажена таблиця");
   exit(); 
   }

 // створюємо FPDF обєкт
$pdf = new TFPDF();

$pdf->SetAutoPageBreak('true',2);
$pdf->SetMargins(05,05,2);

$pdf-> AddFont('dejavu','','DejaVuSans.ttf',true); 
$pdf-> AddFont('dejavub','','DejaVuSans-Bold.ttf',true);

// Вказуємо автора та заголовок
$pdf->SetAuthor('Шкурат А.О.');
$pdf->SetTitle('Наряд по всім технікам');

// задаємо шрифт та його колiр
$pdf-> SetFont('dejavu','',10);
$pdf->SetTextColor(50, 60, 100);
 
//створюємо нову сторiнку та вказуємо режим її вiдображення
$pdf->AddPage('P');
$pdf->SetDisplayMode('real', 'default');

$pdf->SetXY(05, 05);
$pdf->SetDrawColor(50, 60, 100);

$pdf-> SetFont('dejavub','',12);
$pdf->Text(15,10,'Звіт по всім технікам');
$pdf->Text(15,15,'Період: з '.german_date($bdat).' по '.german_date($edat));
$pdf-> SetFont('dejavub','',10);
$pdf->SetXY(15, 20);
$pdf->MultiCell(162,10,'ПІБ виконавця',1,'C',0);
$pdf->SetXY(177, 20);
$pdf->MultiCell(28,10,'Сума (заг.)',1,'C',0);

$pdf-> SetFont('dejavu','',9);

$sum=0;
$s_sum=0;
$sum_sum=0;

$sql1="SELECT * FROM robitnuku WHERE DL='1' ORDER BY ROBITNUK";
$atu1=mysql_query($sql1);  
  while($aut1=mysql_fetch_array($atu1))
 {
	$rob=$aut1["ROBITNUK"];
	$kod_rob=$aut1["ID_ROB"];

//--------
$sql2="SELECT * FROM zakruttya WHERE zakruttya.DT_ZAK>='$bdat' AND zakruttya.DT_ZAK<='$edat' 
	AND zakruttya.DL='1' AND zakruttya.VK='$kod_rob'";
$atu2=mysql_query($sql2);  
  while($aut2=mysql_fetch_array($atu2))
 {
	$sum=$aut2["1"]+$aut2["2"]+$aut2["3"]+$aut2["4"]+$aut2["5"]+$aut2["6"]+$aut2["7"]+$aut2["8"]+$aut2["9"]+$aut2["10"]+$aut2["11"]+$aut2["12"];
	$s_sum=$s_sum+$sum;
	$sum=0;
} 
mysql_free_result($atu2);  
//--------	
$s_sum=number_format($s_sum, 2, '.', '');
if($s_sum!=0){
$y=$pdf->GetY();
$pdf->SetXY(15, $y);
$pdf->MultiCell(162,5,$rob,1,'L',0);
$pdf->SetXY(177,$y);
$pdf->MultiCell(28,5,$s_sum,1,'R',0); 
$sum_sum=$sum_sum+$s_sum;
$s_sum=0;
}
} 
mysql_free_result($atu1);  

$pdf-> SetFont('dejavub','',9);
$x=$pdf->GetX(); 
$y=$pdf->GetY();
$pdf->SetXY($x+10,$y);
$pdf->MultiCell(162,5,'Загальна сума по усім виконавцям:',1,'R',0);
$pdf->SetXY($x+172,$y);
$pdf->MultiCell(28,5,$sum_sum,1,'R',0);

if(mysql_close($db))
        {
        // echo("Закриття бази даних");
         }
         else
         {
          echo("Не можливо виконати закриття бази"); 
          }		  
//виводимо документ на екран
$pdf->Output('nr_allteh_print.pdf','I');
?>