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
$dgot=$_GET["dgot"];
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

$pdf-> SetFont('dejavu','',14);
$pdf->Text(60,10,'Відомість передачі замовлень на видачу');
$pdf-> SetFont('dejavu','',12);
$pdf->Text(10,15,'дата '.date("d.m.Y"));
$pdf->SetXY(10, 20);
$pdf->MultiCell(10,10,'№',1,'C',0);
$pdf->SetXY(20, 20);
$pdf->MultiCell(30,10,'Замовлення',1,'C',0);
$pdf->SetXY(50, 20);
$pdf->MultiCell(80,10,'Вид робіт',1,'C',0);
$pdf->SetXY(130, 20);
$pdf->MultiCell(40,10,'ПІБ',1,'C',0);
$pdf->SetXY(170, 20);
$pdf->MultiCell(30,10,'Дата вик.',1,'C',0);
$pdf-> SetFont('dejavu','',10);
$dd=date_bd($dgot);

$sql1="SELECT zamovlennya.SZ,zamovlennya.NZ,zamovlennya.PR,zamovlennya.IM,zamovlennya.PB,zamovlennya.DATA_GOT,
							 zamovlennya.BUD,zamovlennya.KVAR,dlya_oformlennya.document,rayonu.RAYON,nas_punktu.NSP, 
							 tup_nsp.TIP_NSP,vulutsi.VUL,tup_vul.TIP_VUL
				FROM zamovlennya, rayonu, nas_punktu, vulutsi, tup_nsp, tup_vul, dlya_oformlennya
				WHERE 
					zamovlennya.DATA_GOT='$dd' AND PS='1' 
					AND zamovlennya.DL='1'
					AND dlya_oformlennya.id_oform=zamovlennya.VUD_ROB
					AND rayonu.ID_RAYONA=RN
					AND nas_punktu.ID_NSP=NS
					AND vulutsi.ID_VUL=VL
					AND tup_nsp.ID_TIP_NSP=nas_punktu.ID_TIP_NSP
					AND tup_vul.ID_TIP_VUL=vulutsi.ID_TIP_VUL
					ORDER BY NZ";			
 $nn=1;
 $it=0;
 $it2=35;
 $it3=40;
 $it4=42;
 $atu1=mysql_query($sql1);  
  while($aut1=mysql_fetch_array($atu1))
 {
	$sz=$aut1["SZ"];
	$nz=$aut1["NZ"];
	$pr=$aut1["PR"];
	$im=$aut1["IM"];
    $pb=$aut1["PB"]; 
	$d_got=german_date($aut1["DATA_GOT"]);
	$rn=$aut1["RAYON"];
	$ns=$aut1["NSP"];
	$tns=$aut1["TIP_NSP"];
	$vl=$aut1["VUL"];
	$tvl=$aut1["TIP_VUL"];
	$bud=$aut1["BUD"];
	$kvar=$aut1["KVAR"];	
	$v_rob=$aut1["document"];	

if($bud!="") $budd="буд. ".$aut1["BUD"]; else $budd="";
if($kvar!="") $kvarr="кв. ".$aut1["KVAR"]; else $kvarr="";
//$pdf->SetXY(170, 25); 
$pdf->Text(12,$it2+$it,(string)$nn);
$pdf->Text(22,$it2+$it,$sz.'*'.$nz); 
$pdf->Text(53,$it2+$it,$v_rob);  
$pdf->Text(132,$it2+$it,$pr.' '.p_buk($im).'.'.p_buk($pb).'.');
$pdf->Text(172,$it2+$it,$d_got);  
$pdf->Text(22,$it3+$it,$rn.' '.$tns.$ns.' '.$tvl.$vl.' '.$budd.$kvarr);
$pdf->Line(10,$it4+$it,200,$it4+$it);  
$it=$it+12;
$nn=$nn+1;
if ($it>252) {
$it=0;
$it2=10;
$it3=15;
$it4=17;
$pdf->AddPage('P');
$pdf->SetDisplayMode('real', 'default');
$pdf->SetXY(05, 05);
}
 } 
 mysql_free_result($atu1);  

$pdf->Text(10,$it4+$it,'Всього  ________________________                                                Підпис _________________');   
 
if(mysql_close($db))
        {
        // echo("Закриття бази даних");
         }
         else
         {
          echo("Не можливо виконати закриття бази"); 
          }
		  
//виводимо документ на екран
$pdf->Output('akt_peredachi.pdf','I');
?>