<?php
session_start();
$lg=$_SESSION['LG'];
$pas=$_SESSION['PAS'];
$sz=$_GET['sz'];
$nz=$_GET['nz']; 

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
 
$sql1= "SELECT zamovlennya.SZ,zamovlennya.NZ,zamovlennya.KVUT,zamovlennya.DOKVUT,zamovlennya.PR,
							 zamovlennya.IM,zamovlennya.PB,zamovlennya.BUD,zamovlennya.KVAR,zamovlennya.SUM,
							 dlya_oformlennya.document,rayonu.RAYON,nas_punktu.NSP,tup_nsp.TIP_NSP,vulutsi.VUL,
							 tup_vul.TIP_VUL
				FROM zamovlennya, rayonu, nas_punktu, vulutsi, tup_nsp, tup_vul, dlya_oformlennya
				WHERE
					zamovlennya.NZ='$nz' AND zamovlennya.SZ='$sz' AND zamovlennya.VUD_ROB=19
					AND zamovlennya.DL='1' 
					AND dlya_oformlennya.id_oform=zamovlennya.VUD_ROB
					AND rayonu.ID_RAYONA=zamovlennya.RN
					AND nas_punktu.ID_NSP=zamovlennya.NS
					AND vulutsi.ID_VUL=zamovlennya.VL
					AND tup_nsp.ID_TIP_NSP=nas_punktu.ID_TIP_NSP
					AND tup_vul.ID_TIP_VUL=vulutsi.ID_TIP_VUL
					ORDER BY SZ, NZ DESC"; 
 $atu1=mysql_query($sql1);  
  while($aut1=mysql_fetch_array($atu1))
 {
	$pr=$aut1["PR"];
	$im=$aut1["IM"];
   $pb=$aut1["PB"]; 
	$rn=$aut1["RAYON"];
	$ns=$aut1["NSP"];
	$tns=$aut1["TIP_NSP"];
	$vl=$aut1["VUL"];
	$tvl=$aut1["TIP_VUL"];
	$bud=$aut1["BUD"];
	$kvar=$aut1["KVAR"];	
	$v_rob=$aut1["document"];	
	$sm=$aut1["SUM"];	
	$kvut=$aut1["KVUT"];

if($aut1["BUD"]!="") $budd="буд. ".$aut1["BUD"]; else $budd="";
if($aut1["KVAR"]!="") $kvarr="кв. ".$aut1["KVAR"]; else $kvarr="";
 } 
 mysql_free_result($atu1); 
 
$sql3="SELECT * FROM config"; 
 $atu3=mysql_query($sql3);  
  while($aut3=mysql_fetch_array($atu3))
 {
	$bti=$aut3["NAME"];
	$edrpou=$aut3["EDRPOU"];
    $adr_bti=$aut3["ADR"];
	$ipn=$aut3["IPN"];
	$sv=$aut3["SV"];
 }
 mysql_free_result($atu3); 
 
$sql4="SELECT * FROM rahunku WHERE ID_RAH=1"; 
 $atu4=mysql_query($sql4);  
  while($aut4=mysql_fetch_array($atu4))
 {
	$viddil=$aut4["VIDDIL"];
	$rah=$aut4["RAH"];
    $mfo=$aut4["MFO"];
 }
 mysql_free_result($atu4);  
 
//-------------------------Квитанція-------------------------------------------
$kop=fract($sm);
$grn=(int)$sm;

$sm_pg=in_str($grn);

$pdf->SetFont('dejavu','',8);
$pdf->Text(82,15,$bti.' ЄДРПОУ - '.$edrpou);
$pdf->Text(82,19,'Р/р '.$rah.' в '.$viddil.', МФО '.$mfo);
$pdf->Text(82,23,'ІПН '.$ipn.', свідоцтво № '.$sv);
$pdf->Text(82,27,'Адреса: '.$adr_bti);
$pdf->Text(160,35,$kvut.'             ДОПЛАТА');
$pdf->Text(120,40,date('d.m.Y').'р.');
$pdf->Text(90,45,'Гром. '.$pr.' '.p_buk($im).'. '.p_buk($pb).'.');
$pdf->Text(90,50,'Адреса:'.$rn.' '.$tns.' '.$ns.' '.$tvl.' '.$vl.' '.$budd.' '.$kvarr);
$pdf->Text(110,55,$v_rob);
$pdf->Text(90,60,'Замовлення:   '.$sz.'*'.$nz);
$pdf->Text(90,65,'Сума:   '.$sm);
$pdf->Text(90,70,$sm_pg." грн. ".$kop." коп.");

$pdf->Text(82,15+65,$bti.' ЄДРПОУ - '.$edrpou);
$pdf->Text(82,19+65,'Р/р '.$rah.' в '.$viddil.', МФО '.$mfo);
$pdf->Text(82,23+65,'ІПН '.$ipn.', свідоцтво № '.$sv);
$pdf->Text(82,27+65,'Адреса: '.$adr_bti);
$pdf->Text(160,35+65,$kvut.'             ДОПЛАТА');
$pdf->Text(120,40+65,date('d.m.Y').'р.');
$pdf->Text(90,45+65,'Гром. '.$pr.' '.p_buk($im).'. '.p_buk($pb).'.');
$pdf->Text(90,50+65,'Адреса:'.$rn.' '.$tns.' '.$ns.' '.$tvl.' '.$vl.' '.$budd.' '.$kvarr);
$pdf->Text(110,55+65,$v_rob);
$pdf->Text(90,60+65,'Замовлення:   '.$sz.'*'.$nz);
$pdf->Text(90,65+65,'Сума:   '.$sm);
$pdf->Text(90,70+65,$sm_pg." грн. ".$kop." коп.");
	
$pdf->Line(10,75,203,75);
$pdf->Line(80,10,80,140);
$pdf->SetFont('dejavu','',10);
$pdf->Text(13,73,'Касир');
$pdf->SetFont('dejavub','',12);
$pdf->Text(105,35,'ПОВІДОМЛЕННЯ № _______________');
$pdf->Text(112,100,'КВИТАНЦІЯ № _______________');
//----------------------------------------------------------------------------------

if(mysql_close($db))
        {
        // echo("Закриття бази даних");
         }
         else
         {
          echo("Не можливо виконати закриття бази"); 
          }
		  
//виводимо документ на екран
$pdf->Output('doplata.pdf','I');
?>