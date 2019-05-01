<?php
session_start();
$lg=$_SESSION['LG'];
$pas=$_SESSION['PAS'];
$data=$_POST['dat'];
$vhid=$_POST['n_vhid']; 

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

$pdf->Text(80,10,'Вхiдна кореспонденцiя за '.$data);
$pdf-> SetFont('dejavub','',12);
$pdf->Text(05,20,'Дата, № кореспонднту ');
$pdf->Text(05,25,'Дата, № вхідної інформації ');

$pdf->SetXY(05, 30);
$pdf-> SetFont('dejavu','',12);
$pdf->MultiCell(10,8,'№ п/п',1,'C',0);
$pdf->SetXY(15, 30);
$pdf->MultiCell(70,16,'Найменування',1,'C',0);
$pdf->SetXY(85, 30);
$pdf->MultiCell(110,16,'Змiст',1,'C',0);
$pdf->SetXY(195, 30);
$pdf->MultiCell(52,16,'Виконавець',1,'C',0);
$pdf->SetXY(247, 30);
$pdf->MultiCell(45,16,'Підпис',1,'C',0);
//$pdf->SetXY(05,46);
$pdf-> SetFont('dejavu','',10);

$dat=substr($data,6,4)."-".substr($data,3,2)."-".substr($data,0,2);

$db=mysql_connect("localhost",$lg,$pas);
if(!$db) echo "Не вiдбулося зєднання з базою даних";
  
 if(!@mysql_select_db(kpbti,$db))
  {
   echo("Не завантажена таблиця");
   exit(); 
   }

$z=38;
$k=8;
$n=1;
$sql = "SELECT NAIM,NKL,DATAKL,ZMIST FROM kans 
		WHERE DATAV='$dat' AND NV='$vhid' AND PR='1'"; 
 $atu=mysql_query($sql);
  while($aut=mysql_fetch_array($atu))
 {  
	$naim=$aut["NAIM"];
	$dl=strlen($naim);
	$nkl=$aut["NKL"];
	$datkl=$aut["DATAKL"];
	$vid=' вiд ';
	$zmist=$aut["ZMIST"];
	$dl1=strlen($zmist);
	
	$pdf->Text(80,20,$nkl.$vid.german_date($aut["DATAKL"]));
	$pdf->Text(80,25,$vhid.$vid.$data);
	
	if($dl>30){
	$dd=4;}
	else{
	$dd=8;}
	
	if($dl1>80){
	$zmist = wordwrap($zmist,80,"\n");
	$dd1=4;}
	else{
	$dd1=8;}
	
	if($nkl==''or ($aut["DATAKL"]==0000-00-00)){
	$dv=8;}
	else{
	$dv=4;}
	
	if($nv==''){
	$dv1=8;}
	else{
	$dv1=4;}

	$sql1 = "SELECT VK FROM kans_vuk 
		WHERE DATAV='$dat' AND NV='$vhid'"; 
 
	$atu1=mysql_query($sql1);
	while($aut1=mysql_fetch_array($atu1))
	{
		$vuk=$aut1["VK"];
		
	$pdf->SetXY(05,$z+$k);
	$pdf->MultiCell(10,$dv1,$n,1,'C',0);
	$pdf->SetXY(15,$z+$k);
	$t1=$pdf->GetY();
	$pdf->MultiCell(70,$dd,$naim,1,'C',0);
	$t2=$pdf->GetY();
	$pdf->SetXY(85,$z+$k);
	$pdf->MultiCell(110,$dd1,$zmist,1,'C',0);
		
	$pdf->SetXY(195,$z+$k);
	$pdf->MultiCell(52,8,$vuk,1,'C',0);	
	$pdf->SetXY(247,$z+$k);
	$pdf->MultiCell(45,8,'',1,'C',0);	
	
	$t3=$t2-$t1;
	if($t2>=200){
	$pdf->AddPage('L');
	$pdf->SetDisplayMode('real', 'default');
	$z=05;
	$k=0;
	}
	
	$k=$k+8;
	$n=$n+1;
	}
	mysql_free_result($atu1);

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