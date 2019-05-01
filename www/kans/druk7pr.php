<?php
session_start();
$lg=$_SESSION['LG'];
$pas=$_SESSION['PAS'];
$data1=$_POST['dat1'];
$data2=$_POST['dat2'];

include "function.php";
require('../tfpdf/tfpdf.php');
 // створюємо FPDF обєкт
$pdf = new TFPDF();

$pdf->SetAutoPageBreak('true',2);
$pdf->SetMargins(05,05,2);

$pdf-> AddFont('dejavu','','DejaVuSans.ttf',true); 
$pdf-> AddFont('dejavub','','DejaVuSans-Bold.ttf',true);

// Вказуємо автора та заголовок
$pdf->SetAuthor('Шкурат А.О.');
$pdf->SetTitle('Секретарь');

// задаємо шрифт та його колiр
$pdf-> SetFont('dejavub','',14);
$pdf->SetTextColor(50, 60, 100);
 
//створюємо нову сторiнку та вказуємо режим її вiдображення
$pdf->AddPage('L');
$pdf->SetDisplayMode('real', 'default');

$pdf->SetXY(05, 05);
$pdf->SetDrawColor(50, 60, 100);

$pdf->MultiCell(288,8,'Вихiдна кореспонденцiя за '.$data1,1,'C',0);
$pdf->SetXY(05, 13);
$pdf-> SetFont('dejavu','',12);
$pdf->MultiCell(28,8,'Дата, № вих. iнф.',1,'C',0);
$pdf->SetXY(33, 13);
$pdf->MultiCell(80,16,'Найменування',1,'C',0);
$pdf->SetXY(113, 13);
$pdf->MultiCell(135,16,'Змiст',1,'C',0);
$pdf->SetXY(248, 13);
$pdf->MultiCell(45,16,'Підпис',1,'C',0);
$pdf->SetXY(05,29);
$pdf-> SetFont('dejavu','',10);

$dat1=substr($data1,6,4)."-".substr($data1,3,2)."-".substr($data1,0,2);
$dat2=substr($data2,6,4)."-".substr($data2,3,2)."-".substr($data2,0,2);

$db=mysql_connect("localhost",$lg,$pas);
if(!$db) echo "Не вiдбулося зєднання з базою даних";
  
 if(!@mysql_select_db(kpbti,$db))
  {
   echo("Не завантажена таблиця");
   exit(); 
   }

$z=21;
$k=8;
$sql = "SELECT NAIM,DATAI,NI,ZMIST FROM kans WHERE 
		kans.DATAI>='$dat1' AND kans.DATAI<='$dat2' AND PR='2'"; 
 $atu=mysql_query($sql);
  while($aut=mysql_fetch_array($atu))
 {  
	$naim=$aut["NAIM"];
	$dl=strlen($naim);
	$datai=german_date($aut["DATAI"]);
	$vid=' вiд ';
	$ni=$aut["NI"];
	$zmist=$aut["ZMIST"];
	$dl1=strlen($zmist);
	
	if($dl>30){
	$dd=4;}
	else{
	$dd=8;}
	
	if($dl1>80){
	$zmist = wordwrap($zmist,80,"\n");
	$dd1=4;}
	else{
	$dd1=8;}
	
	if($ni==''or ($aut["DATAI"]==0000-00-00)){
	$dv=8;}
	else{
	$dv=4;}
	
	if($ni==''){
	$dv1=8;}
	else{
	$dv1=4;}
	
	$pdf->SetXY(05,$z+$k);
	$pdf->MultiCell(28,$dv1,$ni.$vid.$datai,1,'C',0);
	$pdf->SetXY(33,$z+$k);
	$t1=$pdf->GetY();
	$pdf->MultiCell(80,$dd,$naim,1,'C',0);
	$t2=$pdf->GetY();
	$pdf->SetXY(113,$z+$k);
	$pdf->MultiCell(135,$dd1,$zmist,1,'C',0);
	$pdf->SetXY(248,$z+$k);
	$pdf->MultiCell(45,8,'',1,'C',0);
	
		
	$t3=$t2-$t1;
	if($t2>=200){
	$pdf->AddPage('L');
	$pdf->SetDisplayMode('real', 'default');
	$z=05;
	$k=0;
	}
	
	$k=$k+8;
	
 }
 mysql_free_result($atu); 
 
//виводимо документ на екран
$pdf->Output('spvuk.pdf','I');


 if(mysql_close($db))
        {
        // echo("Закриття бази даних");
         }
         else
         {
          echo("Не можливо виконати закриття бази"); 
          }
?>