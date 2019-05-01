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
$pdf->AddPage('P');
$pdf->SetDisplayMode('real', 'default');

$pdf->SetXY(05,05);
$pdf->SetDrawColor(50, 60, 100);

$pdf->MultiCell(200,8,'Вхiдна кореспонденцiя за '.$data1,1,'C',0);
$pdf->SetXY(05, 13);
$pdf-> SetFont('dejavu','',12);
$pdf->MultiCell(10,8,'№ п/п',1,'C',0);
$pdf->SetXY(15, 13);
$pdf->MultiCell(70,16,'Найменування',1,'C',0);
$pdf->SetXY(85, 13);
$pdf->MultiCell(28,8,'Дата, № кореспонд.',1,'C',0);
$pdf->SetXY(113, 13);
$pdf->MultiCell(28,8,'Дата, № вх. iнформацiї',1,'C',0);
$pdf->SetXY(141, 13);
$pdf->MultiCell(39,16,'Виконавець',1,'C',0);
$pdf->SetXY(180, 13);
$pdf->MultiCell(25,16,'Пiдпис',1,'C',0);
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
$n=1;
$z=21;
$k=8;

$sql = "SELECT NAIM,NKL,DATAKL,NV,DATAV FROM kans WHERE 
		kans.DATAV>='$dat1' AND kans.DATAV<='$dat2'"; 
 $atu=mysql_query($sql);
  while($aut=mysql_fetch_array($atu))
 {  
	$naim=$aut["NAIM"];
	$dl=strlen($naim);
	$nkl=$aut["NKL"];
	$vid=' вiд ';
	$nv=$aut["NV"];
	
	if($dl>45){
	$dd=4;}
	else{
	$dd=8;}
	
	if($nkl==''or ($aut["DATAKL"]==0000-00-00)){
	$dv=8;}
	else{
	if((strlen($nkl))>1)
	$dv=4;
	else $dv=8;}
	
	if($nv==''){
	$dv1=8;}
	else{
	if((strlen($nv))>1)
	$dv1=4;
	else $dv1=8;}
	
    $pdf->SetXY(05,$z+$k);
	$pdf->MultiCell(10,8,$n,1,'C',0);
	$pdf->SetXY(15,$z+$k);
	$t1=$pdf->GetY();
	$pdf->MultiCell(70,$dd,$naim,1,'C',0);
	$t2=$pdf->GetY();
	$pdf-> SetFont('dejavu','',8);
	$pdf->SetXY(85,$z+$k);
	$pdf->MultiCell(28,$dv,$nkl.$vid.german_date($aut["DATAKL"]),1,'C',0);
	$pdf->SetXY(113,$z+$k);
	$pdf->MultiCell(28,$dv1,$nv.$vid.german_date($aut["DATAV"]),1,'C',0);
	$pdf-> SetFont('dejavu','',10);
	$pdf->SetXY(141,$z+$k);
	$pdf->MultiCell(39,8,'',1,'C',0);
	$pdf->SetXY(180,$z+$k);
	$pdf->MultiCell(25,8,'',1,'C',0);
	
	$t3=$t2-$t1;
	if($t2>=280){
	$pdf->AddPage('P');
	$pdf->SetDisplayMode('real', 'default');
	$z=05;
	$k=0;
	}
	
	$n=$n+1;
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