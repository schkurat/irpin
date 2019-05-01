<?php
session_start();
$lg=$_SESSION['LG'];
$pas=$_SESSION['PAS'];
$pr_prie=$_SESSION['PR'];
$im_prie=$_SESSION['IM'];
$pb_prie=$_SESSION['PB'];

include "../function.php";
//require('../tfpdf/tfpdf.php');

$bdat=date_bd($_POST['bdate']);
$edat=date_bd($_POST['edate']);
//$vuk=$_POST['vukon'];
$vuk=$pr_prie.' '.p_buk($im_prie).'.'.p_buk($pb_prie).'.';

$db=mysql_connect("localhost",$lg,$pas);
if(!$db) echo "Не вiдбулося зєднання з базою даних";
  
 if(!@mysql_select_db(kpbti,$db))
  {
   echo("Не завантажена таблиця");
   exit(); 
   }

 // створюємо FPDF обєкт
/* $pdf = new TFPDF();

$pdf->SetMargins(05,05,2);

$pdf-> AddFont('dejavu','','DejaVuSans.ttf',true); 
$pdf-> AddFont('dejavub','','DejaVuSans-Bold.ttf',true); */

// Вказуємо автора та заголовок
/* $pdf->SetAuthor('Шкурат А.О.');
$pdf->SetTitle('Наряд по 1 виконавцю'); */

// задаємо шрифт та його колiр
/* $pdf-> SetFont('dejavu','',10);
$pdf->SetTextColor(50, 60, 100); */
 
//створюємо нову сторiнку та вказуємо режим її вiдображення
/* $pdf->AddPage('L');
$pdf->SetDisplayMode('real', 'default');
$pdf->SetAutoPageBreak('true',4); */
//
/* $pdf->SetXY(05, 05);
$pdf->SetDrawColor(50, 60, 100); */
$p='<table border="1" cellpadding="0" cellspacing="0">
<tr><th colspan="11" align="left">Виконавець: '.$vuk.'</th></tr>
<tr><th colspan="11" align="left">Період: з '.german_date($bdat).' по '.german_date($edat).'</th></tr>
<tr><th align="center">Дата спл.</th>
<th align="center">Ном. зам.</th>
<th align="center">Адреса</th>
<th align="center">ПІБ (назва) замовника</th>
<th align="center">Сума (тех)</th>
<th align="center">Сума (пр.)</th>
<th align="center">Сума (арх.)</th>
<th align="center">Сума (комп.)</th>
<th align="center">Сума (такс.)</th>
<th align="center">Сума (бюро)</th>
<th align="center">Сума (заг.)</th></tr>';
/* $pdf-> SetFont('dejavub','',12);
$pdf->Text(05,10,'Виконавець: '.$vuk);
$pdf->Text(05,15,'Період: з '.german_date($bdat).' по '.german_date($edat));
$pdf-> SetFont('dejavub','',10);
$pdf->SetXY(05, 20); */
/* $pdf->MultiCell(22,10,'Дата спл.',1,'C',0);
$pdf->SetXY(27, 20);
$pdf->MultiCell(22,10,'Ном. зам.',1,'C',0);
$pdf->SetXY(49, 20);
$pdf->MultiCell(80,10,'Адреса',1,'C',0);
$pdf->SetXY(129, 20);
$pdf->MultiCell(48,10,'ПІБ (назва) замовника',1,'C',0);
$pdf->SetXY(177, 20);
$pdf->MultiCell(13,5,'Сума (тех)',1,'C',0);
$pdf->SetXY(190, 20);
$pdf->MultiCell(16,5,'Сума (пр.)',1,'C',0);
$pdf->SetXY(206, 20);
$pdf->MultiCell(14,5,'Сума (арх.)',1,'C',0);
$pdf->SetXY(220, 20);
$pdf->MultiCell(17,5,'Сума (комп.)',1,'C',0);
$pdf->SetXY(237, 20);
$pdf->MultiCell(19,5,'Сума (такс.)',1,'C',0);
$pdf->SetXY(256, 20);
$pdf->MultiCell(17,5,'Сума (бюро)',1,'C',0);
$pdf->SetXY(273, 20);
$pdf->MultiCell(18,5,'Сума (заг.)',1,'C',0);
$pdf-> SetFont('dejavu','',9); */

$ssum="";
$ss_arh="";
$ss_pr="";
$ss_ree="";
$ss_comp="";
$ss_bti="";
$ss_teh="";
$rsum="";
$rs_arh="";
$rs_pr="";
$rs_ree="";
$rs_comp="";
$rs_bti="";
$rs_teh="";

$sh="";
$rajon="";

$sql2 = "SELECT robitnuku.BRUGADA FROM robitnuku WHERE robitnuku.ROBS='$vuk' AND robitnuku.DL='1'"; 
 $atu2=mysql_query($sql2);
  while($aut2=mysql_fetch_array($atu2))
{
	$identy_brigada=$aut2["BRUGADA"];
}	
mysql_free_result($atu2);

switch($identy_brigada)
{
case 1: 
			$flag="AND taks.ID_TEH=robitnuku.ID_ROB";
			break;
case 2:
			$flag="AND taks.ID_TEH=robitnuku.ID_ROB";
			break;
case 3:
			$flag="AND taks.ID_TEH=robitnuku.ID_ROB";
			break;
case 4:
			$flag="AND taks.ID_TEH=robitnuku.ID_ROB";
			break;
case 5:
			$flag="AND taks.ID_REE=robitnuku.ID_ROB";
			break;
case 6:
			$flag="AND (taks.ID_COMP=robitnuku.ID_ROB OR taks.ID_PR=robitnuku.ID_ROB)";
			break;
case 7:
			$flag="AND taks.ID_PR=robitnuku.ID_ROB";
			break;
case 8:
			$flag="AND taks.ID_ARH=robitnuku.ID_ROB";
			break;
default:
			$flag="";
			break;
}

$sql1="SELECT zamovlennya.SZ,zamovlennya.NZ,zamovlennya.PR,zamovlennya.IM,zamovlennya.PB,zamovlennya.DOKVUT,
						zamovlennya.BUD,zamovlennya.KVAR,rayonu.RAYON,nas_punktu.NSP, tup_nsp.TIP_NSP,vulutsi.VUL,
						tup_vul.TIP_VUL,taks.SUM,taks.S_TEH,taks.S_PR,taks.S_ARH,taks.S_COMP,taks.S_REE,taks.S_BTI,
						zamovlennya.SUM AS SUM1,zamovlennya.VD
				FROM zamovlennya,rayonu,nas_punktu,vulutsi,tup_nsp,tup_vul,taks,robitnuku
				WHERE 
					zamovlennya.DOKVUT>='$bdat' AND zamovlennya.DOKVUT<='$edat'
					AND zamovlennya.DL='1' AND taks.DL='1' 
	AND zamovlennya.VUD_ROB=19 AND zamovlennya.VD=1
					AND robitnuku.ROBS='$vuk' ".$flag." AND robitnuku.DL='1' 
					AND zamovlennya.SZ=taks.SZ AND zamovlennya.NZ=taks.NZ
					AND rayonu.ID_RAYONA=zamovlennya.RN
					AND nas_punktu.ID_NSP=zamovlennya.NS
					AND vulutsi.ID_VUL=zamovlennya.VL
					AND tup_nsp.ID_TIP_NSP=nas_punktu.ID_TIP_NSP
					AND tup_vul.ID_TIP_VUL=vulutsi.ID_TIP_VUL
					ORDER BY RAYON,SZ,NZ";			

 $atu1=mysql_query($sql1);  
  while($aut1=mysql_fetch_array($atu1))
 {
	$sz=$aut1["SZ"];
	$nz=$aut1["NZ"];
	$pr=$aut1["PR"];
	$im=$aut1["IM"];
    $pb=$aut1["PB"]; 
	$d_okv=german_date($aut1["DOKVUT"]);
	$rn=$aut1["RAYON"];
	$ns=$aut1["NSP"];
	$tns=$aut1["TIP_NSP"];
	$vl=$aut1["VUL"];
	$tvl=$aut1["TIP_VUL"];
	$bud=$aut1["BUD"];
	$kvar=$aut1["KVAR"];
	$sum=$aut1["SUM"];	
	$s_teh=$aut1["S_TEH"];	
	$s_pr=$aut1["S_PR"];
	$s_arh=$aut1["S_ARH"];
	$s_comp=$aut1["S_COMP"];
	$s_ree=$aut1["S_REE"];
	$s_bti=$aut1["S_BTI"];
	$sum1=$aut1["SUM1"];
	$vd=$aut1["VD"];
	
if($bud!="") $budd="буд. ".$aut1["BUD"]; else $budd="";
if($kvar!="") $kvarr="кв. ".$aut1["KVAR"]; else $kvarr="";
$adres=$rn.' '.$tns.' '.$ns.' '.$tvl.' '.$vl.' '.$budd.' '.$kvarr;
$raz_str=strlen($adres);
if($raz_str>80) $vs=5;
else $vs=10;
$fio=$pr.' '.$im.' '.$pb;
$raz_str2=strlen($fio);
if($raz_str2>47) $vs2=5;
else $vs2=10;

if($rajon!=$rn){
$rajon=$rn;
//$pdf->MultiCell(286,5,$rn,1,'L',0);
$p.='<tr><td colspan="11">'.$rn.'</td></tr>';
$rsum="";
$rs_arh="";
$rs_pr="";
$rs_ree="";
$rs_comp="";
$rs_bti="";
$rs_teh="";
}
if($vd==0){
$s_arh=0;
$s_pr=0;
$s_ree=0;
$s_comp=0;
$s_bti=0;
$s_teh=$sum1;
$sum=$sum1;
}
$p.='<tr><td>'.$d_okv.'</td>
<td align="center">'.$sz.'*'.$nz.'</td>
<td align="center">'.$adres.'</td>
<td align="center">'.$fio.'</td>
<td align="center">'.$s_teh.'</td>
<td align="center">'.$s_pr.'</td>
<td align="center">'.$s_arh.'</td>
<td align="center">'.$s_comp.'</td>
<td align="center">'.$s_ree.'</td>
<td align="center">'.$s_bti.'</td>
<td align="center">'.$sum.'</td>
</tr>';
/* $y=$pdf->GetY();
if($y>190){
$pdf->AddPage('L');
$pdf->SetDisplayMode('real', 'default');
$pdf->SetXY(05, 05);
$pdf->SetDrawColor(50, 60, 100);
$y=05;
}
$pdf->MultiCell(22,10,$d_okv,1,'C',0);
$pdf->SetXY(27,$y);
$pdf->MultiCell(22,10,$sz.'*'.$nz,1,'C',0);
$pdf->SetXY(49, $y);
$pdf->MultiCell(80,$vs,$adres,1,'C',0);
$pdf->SetXY(129,$y);
$pdf->MultiCell(48,$vs2,$fio,1,'C',0);
$pdf-> SetFont('dejavu','',8);
$pdf->SetXY(177,$y);
$pdf->MultiCell(13,10,$s_teh,1,'C',0);
$pdf->SetXY(190,$y);
$pdf->MultiCell(16,10,$s_pr,1,'C',0);
$pdf->SetXY(206,$y);
$pdf->MultiCell(14,10,$s_arh,1,'C',0);
$pdf->SetXY(220,$y);
$pdf->MultiCell(17,10,$s_comp,1,'C',0);
$pdf->SetXY(237,$y);
$pdf->MultiCell(19,10,$s_ree,1,'C',0);
$pdf->SetXY(256,$y);
$pdf->MultiCell(17,10,$s_bti,1,'C',0);
$pdf->SetXY(273,$y);
$pdf->MultiCell(18,10,$sum,1,'C',0); */

$ssum=$ssum+$sum;
$ss_arh=$ss_arh+$s_arh;
$ss_pr=$ss_pr+$s_pr;
$ss_ree=$ss_ree+$s_ree;
$ss_comp=$ss_comp+$s_comp;
$ss_bti=$ss_bti+$s_bti;
$ss_teh=$ss_teh+$s_teh;
$rsum=$rsum+$sum;
$rs_arh=$rs_arh+$s_arh;
$rs_pr=$rs_pr+$s_pr;
$rs_ree=$rs_ree+$s_ree;
$rs_comp=$rs_comp+$s_comp;
$rs_bti=$rs_bti+$s_bti;
$rs_teh=$rs_teh+$s_teh;

$sh=$sh+1;
 } 
 mysql_free_result($atu1);  
$p.='<tr><td colspan="4" align="right">Загальна сума по району:</td>
<td align="center">'.$rs_teh.'</td>
<td align="center">'.$rs_pr.'</td>
<td align="center">'.$rs_arh.'</td>
<td align="center">'.$rs_comp.'</td>
<td align="center">'.$rs_ree.'</td>
<td align="center">'.$rs_bti.'</td>
<td align="center">'.$rsum.'</td></tr>
<tr>
<td colspan="4" align="right">Загальна сума по виконавцю:</td>
<td align="center">'.$ss_teh.'</td>
<td align="center">'.$ss_pr.'</td>
<td align="center">'.$ss_arh.'</td>
<td align="center">'.$ss_comp.'</td>
<td align="center">'.$ss_ree.'</td>
<td align="center">'.$ss_bti.'</td>
<td align="center">'.$ssum.'</td></tr>
<tr align="right"><td colspan="4">Загальна кількість:</td>
<td colspan="7" align="center">'.$sh.'</td>
</tr>';
/* $pdf-> SetFont('dejavub','',9);
$x=$pdf->GetX(); 
$y=$pdf->GetY();
$pdf->MultiCell(172,5,'Загальна сума по району:',1,'R',0);
$pdf->SetXY($x+172,$y);
$pdf-> SetFont('dejavub','',8);
$pdf->MultiCell(13,5,$rs_teh,1,'C',0);
$pdf->SetXY($x+172+13,$y);
$pdf->MultiCell(16,5,$rs_pr,1,'C',0);
$pdf->SetXY($x+172+29,$y);
$pdf->MultiCell(14,5,$rs_arh,1,'C',0);
$pdf->SetXY($x+172+43,$y);
$pdf->MultiCell(17,5,$rs_comp,1,'C',0);
$pdf->SetXY($x+172+60,$y);
$pdf->MultiCell(19,5,$rs_ree,1,'C',0);
$pdf->SetXY($x+172+79,$y);
$pdf->MultiCell(17,5,$rs_bti,1,'C',0);
$pdf->SetXY($x+172+79+17,$y);
$pdf->MultiCell(18,5,$rsum,1,'C',0);
$x=$pdf->GetX(); 
$y=$pdf->GetY();
$pdf-> SetFont('dejavub','',9); */
/* $pdf->MultiCell(172,5,'Загальна сума по виконавцю:',1,'R',0);
$pdf->SetXY($x+172,$y);
$pdf-> SetFont('dejavub','',8);
$pdf->MultiCell(13,5,$ss_teh,1,'C',0);
$pdf->SetXY($x+172+13,$y);
$pdf->MultiCell(16,5,$ss_pr,1,'C',0);
$pdf->SetXY($x+172+29,$y);
$pdf->MultiCell(14,5,$ss_arh,1,'C',0);
$pdf->SetXY($x+172+43,$y);
$pdf->MultiCell(17,5,$ss_comp,1,'C',0);
$pdf->SetXY($x+172+60,$y);
$pdf->MultiCell(19,5,$ss_ree,1,'C',0);
$pdf->SetXY($x+172+79,$y);
$pdf->MultiCell(17,5,$ss_bti,1,'C',0);
$pdf->SetXY($x+172+79+17,$y);
$pdf->MultiCell(18,5,$ssum,1,'C',0);
$y=$pdf->GetY();
$pdf-> SetFont('dejavub','',9); */
/* $pdf->MultiCell(172,5,'Загальна кількість:',1,'R',0);
$pdf->SetXY(177,$y);
$pdf->MultiCell(114,5,$sh,1,'C',0);
 */
//$pdf->Text(10,42+$it,'Всього  ________________________                                                Підпис _________________');   
$p.='</table>';
echo $p;
if(mysql_close($db))
        {
        // echo("Закриття бази даних");
         }
         else
         {
          echo("Не можливо виконати закриття бази"); 
          }		  
//виводимо документ на екран
//$pdf->Output('nr_vuk_print.pdf','I');
?>