<?php
session_start();
$lg=$_SESSION['LG'];
$pas=$_SESSION['PAS'];

include "../function.php";

$bdat=date_bd($_POST['bdate']);
$edat=date_bd($_POST['edate']);
$vuk=$_POST['vukon'];

$db=mysql_connect("localhost",$lg,$pas);
if(!$db) echo "Не вiдбулося зєднання з базою даних";
  
 if(!@mysql_select_db(kpbti,$db))
  {
   echo("Не завантажена таблиця");
   exit(); 
   }

$p='<table border="1" cellpadding="0" cellspacing="0">
<tr><th colspan="5" align="left">Виконавець: '.$vuk.'</th></tr>
<tr><th colspan="5" align="left">Період: з '.german_date($bdat).' по '.german_date($edat).'</th></tr>
<tr>
<th align="center">Ном. зам.</th>
<th align="center">Адреса</th>
<th align="center">Сума</th>
<th align="center">ПДВ</th>
<th align="center">Всього</th>
</tr>';

$sql = "SELECT ID_ROB FROM robitnuku WHERE robitnuku.ROBS='".$vuk."'"; 
 $atu=mysql_query($sql);
  while($aut=mysql_fetch_array($atu))
  {	
	$kod_rob=$aut["ID_ROB"]; 
}
mysql_free_result($atu);


$ssum="";
$rsum="";
$sh="";
$rajon="";
$t_sz="";
$t_nz="";
$t_kodp="";
$t_adres="";

$sql1="SELECT zamovlennya.SZ,zamovlennya.NZ,zamovlennya.DATA_PS,zamovlennya.BUD,zamovlennya.KVAR,
	rayonu.RAYON,nas_punktu.NSP, tup_nsp.TIP_NSP,vulutsi.VUL,tup_vul.TIP_VUL,zamovlennya.KEY,zamovlennya.KODP, 
	taks_detal.SUM AS SM,taks_detal.KF,taks_detal.NDS 
		FROM zamovlennya,rayonu,nas_punktu,vulutsi,tup_nsp,tup_vul,taks_detal
		WHERE 
	zamovlennya.DATA_PS>='$bdat' AND zamovlennya.DATA_PS<='$edat' AND PS='1' 
	AND zamovlennya.DL='1' AND zamovlennya.KEY=taks_detal.IDZM AND taks_detal.DL='1' 
	AND taks_detal.ID_ROB='$kod_rob' 
	AND rayonu.ID_RAYONA=zamovlennya.RN
	AND nas_punktu.ID_NSP=zamovlennya.NS
	AND vulutsi.ID_VUL=zamovlennya.VL
	AND tup_nsp.ID_TIP_NSP=nas_punktu.ID_TIP_NSP
	AND tup_vul.ID_TIP_VUL=vulutsi.ID_TIP_VUL
	ORDER BY RAYON,SZ,NZ";			

 $atu1=mysql_query($sql1);  
  while($aut1=mysql_fetch_array($atu1))
 {	$nds=0;
	$sz=$aut1["SZ"];
	$nz=$aut1["NZ"];
	$kodp=$aut1["KODP"];
	$rn=$aut1["RAYON"];
	$ns=$aut1["NSP"];
	$tns=$aut1["TIP_NSP"];
	$vl=$aut1["VUL"];
	$tvl=$aut1["TIP_VUL"];
	$bud=$aut1["BUD"];
	$kvar=$aut1["KVAR"];
	$kf=$aut1["KF"];
	$nds=$aut1["NDS"];
	if($t_sz=="" and $t_nz=="" and $t_kodp==""){
	$t_sz=$sz;
	$t_nz=$nz;
	$t_kodp=$kodp;
	}
	if($bud!="") $budd="буд. ".$aut1["BUD"]; else $budd="";
    if($kvar!="") $kvarr="кв. ".$aut1["KVAR"]; else $kvarr="";
	$adres=$rn.' '.$tns.' '.$ns.' '.$tvl.' '.$vl.' '.$budd.' '.$kvarr;
	if($kf==2) $sum=round(($aut1["SM"]*1.5),2);
	else $sum=round(($aut1["SM"]*$kf),2);
	if($t_sz==$sz and $t_nz==$nz and $t_kodp==$kodp){
	$sum_zak=$sum_zak+$sum;
	$t_adres=$adres;
	}
	else{
	$sum_pdv=round((($sum_zak*$nds)/100),2);
	$sum_vs=$sum+$sum_pdv;
	$p.='<tr>
<td align="center">'.$t_sz.'*'.$t_nz.'</td>
<td>'.$t_adres.'</td>
<td align="center">'.$sum_zak.'</td>
<td align="center">'.$sum_pdv.'</td>
<td align="center">'.$sum_vs.'</td>
</tr>';
	$ssum=$ssum+$sum_zak;
	$ssum_pdv=$ssum_pdv+$sum_pdv;
	$ssum_vs=$ssum_vs+$sum_vs;
	$sum_zak=$sum;
	$sum_pdv=0;
	$sum_vs=0;
	$t_sz=$sz;
	$t_nz=$nz;
	$t_kodp=$kodp;
	$t_adres=$adres;
	$sh=$sh+1;
	}
	
if($rajon!=$rn){
$rajon=$rn;
$p.='<tr><td colspan="5">'.$rn.'</td></tr>';
} 

 } 
 mysql_free_result($atu1);  

//-----------------------------
$sum_pdv=round((($sum_zak*$nds)/100),2);
	$sum_vs=$sum+$sum_pdv;
	$p.='<tr>
<td align="center">'.$t_sz.'*'.$t_nz.'</td>
<td>'.$t_adres.'</td>
<td align="center">'.$sum_zak.'</td>
<td align="center">'.$sum_pdv.'</td>
<td align="center">'.$sum_vs.'</td>
</tr>';
	$ssum=$ssum+$sum_zak;
	$ssum_pdv=$ssum_pdv+$sum_pdv;
	$ssum_vs=$ssum_vs+$sum_vs;
//------------------------------
 
$p.='<tr>
<td colspan="2" align="right"><b>Загальна сума по виконавцю:</b></td>
<td align="center"><b>'.$ssum.'</b></td>
<td align="center"><b>'.$ssum_pdv.'</b></td>
<td align="center"><b>'.$ssum_vs.'</b></td>
</tr>
<tr align="right"><td colspan="2"><b>Загальна кількість:</b></td>
<td align="center" colspan="3"><b>'.$sh.'</b></td>
</tr>';
$p.='</table>';
echo $p;
echo '<br>Виконавець ___________________ '.$vuk.'<br><br>';
echo 'Контролер  ___________________ ';
if(mysql_close($db))
        {
        // echo("Закриття бази даних");
         }
         else
         {
          echo("Не можливо виконати закриття бази"); 
          }		  
?>