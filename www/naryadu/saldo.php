<?php
session_start();
$lg=$_SESSION['LG'];
$pas=$_SESSION['PAS'];
include("../function.php");
   
$dt_n=date_bd($_GET["date1"]);
$dt_k=date_bd($_GET["date2"]);
$rest = substr($_GET["date1"],3,7);

$db=mysql_connect("localhost",$lg,$pas);
if(!$db) echo "Не вiдбулося зєднання з базою даних";
  
 if(!@mysql_select_db(kpbti,$db))
  {
   echo("Не завантажена таблиця");
   exit(); 
   }
   
$ath=mysql_query("TRUNCATE TABLE  `saldo`");

//vstavka s zakazov
$sql="SELECT zamovlennya.*,nas_punktu.NSP,tup_nsp.TIP_NSP,
	vulutsi.VUL,tup_vul.TIP_VUL,taks.SUM AS SM_T,taks.SUM_OKR,taks.NDS  
FROM nas_punktu,tup_nsp,vulutsi,tup_vul,zamovlennya,taks  
WHERE zamovlennya.DATA_PS>='$dt_n' AND zamovlennya.DATA_PS<='$dt_k'
	AND zamovlennya.DL='1' AND zamovlennya.KEY=taks.IDZM AND taks.DL='1'  
	AND nas_punktu.ID_NSP=zamovlennya.NS 
	AND vulutsi.ID_VUL=zamovlennya.VL
	AND tup_nsp.ID_TIP_NSP=nas_punktu.ID_TIP_NSP
	AND tup_vul.ID_TIP_VUL=vulutsi.ID_TIP_VUL
ORDER BY zamovlennya.SZ,zamovlennya.NZ,zamovlennya.DOKVUT";
//echo $sql;
$atu=mysql_query($sql);
while($aut=mysql_fetch_array($atu)){
if($aut["BUD"]!="") $bud="буд.".$aut["BUD"]; else $bud="";
if($aut["KVAR"]!="") $kvar="кв.".$aut["KVAR"]; else $kvar="";
$taks=0;
$sz=$aut["SZ"];
$nz=$aut["NZ"];
$adres=$aut["TIP_NSP"].' '.$aut["NSP"].' '.$aut["TIP_VUL"].' '.$aut["VUL"].' '.$bud.' '.$kvar;
$fio=$aut["PR"].' '.$aut["IM"].' '.$aut["PB"];
//$sum_zak=$aut["SUM"]+$aut["SUM_D"];
$sum_zak=round((((($aut["SM_T"]+$aut["SUM_OKR"])*(($aut["NDS"]/100)+1))*$aut["VIDSOTOK"])/100),2);
$taks=$sum_zak;
$pdv=round((((($aut["SM_T"]+$aut["SUM_OKR"])*($aut["NDS"]/100))*$aut["VIDSOTOK"])/100),2);
$dt_ps=$aut["DATA_PS"];
$dt_opl=$aut["DOKVUT"];
$dt_opl_d=$aut["DODOP"];

if($dt_ps>$dt_k or $dt_ps=='0000-00-00'){
$sum_zak=0;
}

$sql1="SELECT ID FROM saldo WHERE SZ='$sz' AND NZ='$nz'"; 
$atu1=mysql_query($sql1);
$num_rows=mysql_num_rows($atu1);
if($num_rows!=0){
$ath=mysql_query("UPDATE saldo SET SM_ZAK='$sum_zak',SM_PDV='$pdv',DT_OPL='$dt_opl',TAKS='$taks',
	DT_OPL_DOP='$dt_opl_d' WHERE SZ='$sz' AND NZ='$nz'");
}
else{
$ath=mysql_query("INSERT INTO saldo(SZ,NZ,ADRES,ZAMOVNUK,SM_ZAK,TAKS,SM_PDV,DT_PS,DT_OPL,DT_OPL_DOP) 
	VALUES('$sz','$nz','$adres','$fio','$sum_zak','$taks','$pdv','$dt_ps','$dt_opl','$dt_opl_d')");
}
mysql_free_result($atu1);
$taks=0;
$pdv=0;
}
mysql_free_result($atu);
//--------------------
//vstavl s opl
$sql="SELECT kasa.*,nas_punktu.NSP,tup_nsp.TIP_NSP,zamovlennya.SUM,zamovlennya.DODOP,
	vulutsi.VUL,tup_vul.TIP_VUL,zamovlennya.BUD,zamovlennya.KVAR,zamovlennya.KEY,zamovlennya.SUM_D, 
	zamovlennya.PR,zamovlennya.IM,zamovlennya.DOKVUT,zamovlennya.PB,zamovlennya.DATA_PS 
	FROM nas_punktu,tup_nsp,vulutsi,tup_vul,zamovlennya,kasa  
WHERE kasa.DT>='$dt_n' AND kasa.DT<='$dt_k' AND
	zamovlennya.DL='1' AND kasa.DL='1'  
	AND zamovlennya.SZ=kasa.SZ AND zamovlennya.NZ=kasa.NZ 
	AND nas_punktu.ID_NSP=zamovlennya.NS 
	AND vulutsi.ID_VUL=zamovlennya.VL
	AND tup_nsp.ID_TIP_NSP=nas_punktu.ID_TIP_NSP
	AND tup_vul.ID_TIP_VUL=vulutsi.ID_TIP_VUL
ORDER BY kasa.SZ,kasa.NZ,kasa.DT";
//echo $sql;
$atu=mysql_query($sql);
while($aut=mysql_fetch_array($atu)){
if($aut["BUD"]!="") $bud="буд.".$aut["BUD"]; else $bud="";
if($aut["KVAR"]!="") $kvar="кв.".$aut["KVAR"]; else $kvar="";
$sz=$aut["SZ"];
$nz=$aut["NZ"];
$idzak=$aut["KEY"];
$adres=$aut["TIP_NSP"].' '.$aut["NSP"].' '.$aut["TIP_VUL"].' '.$aut["VUL"].' '.$bud.' '.$kvar;
$fio=$aut["PR"].' '.$aut["IM"].' '.$aut["PB"];
$sum_zak=$aut["SUM"]+$aut["SUM_D"];
$sum_kas=$aut["SM"];
$sum_kom=$aut["SM_KM"];
$dt_ps=$aut["DATA_PS"];
$dt_opl=$aut["DT"];
$dt_opl_a=$aut["DOKVUT"];
$dt_opl_d=$aut["DODOP"];
$taks=0;
$pdv=0;
$sql1="SELECT taks.SUM AS SM_T,taks.SUM_OKR,taks.NDS FROM zamovlennya,taks 
WHERE zamovlennya.KEY='$idzak' AND zamovlennya.KEY=taks.IDZM AND taks.DL='1'";
//echo $sql;
$atu1=mysql_query($sql1);
while($aut1=mysql_fetch_array($atu1)){
$taks=round((($aut1["SM_T"]+$aut1["SUM_OKR"])*(($aut1["NDS"]/100)+1)),2);
$pdv=round((($aut1["SM_T"]+$aut1["SUM_OKR"])*($aut1["NDS"]/100)),2);//vst pdv
}
mysql_free_result($atu1);
$sum_voz=0;

if($dt_opl>$dt_k or $dt_opl<$dt_n){
$sum_kas=0;
}

if($sum_kas<0){
$sum_voz=$sum_kas*(-1);
/* if($sum_zak>$sum_voz) $sum_zak=$sum_zak-$sum_voz;
if($sum_zak==$sum_voz or $dt_ps<$dt_k or $dt_ps=='0000-00-00'){$sum_zak=0;} */

$sql7="SELECT ID FROM saldo WHERE SZ='$sz' AND NZ='$nz'"; 
$atu7=mysql_query($sql7);
$num_rows=mysql_num_rows($atu7);
if($num_rows!=0){
//,SM_ZAK='$sum_zak'
$ath=mysql_query("UPDATE saldo SET POVER='$sum_voz',TAKS='$taks' WHERE SZ='$sz' AND NZ='$nz'");
}
else{
//,SM_ZAK  ,'$sum_zak'
$ath=mysql_query("INSERT INTO saldo(SZ,NZ,ADRES,ZAMOVNUK,POVER,TAKS,DT_PS,DT_OPL,DT_OPL_DOP) 
	VALUES('$sz','$nz','$adres','$fio','$sum_voz','$taks','$dt_ps','$dt_opl_a','$dt_opl_d')");
}
mysql_free_result($atu7);
}
else{
$sql1="SELECT ID FROM saldo WHERE SZ='$sz' AND NZ='$nz'"; 
$atu1=mysql_query($sql1);
$num_rows=mysql_num_rows($atu1);
if($num_rows!=0){
$ath=mysql_query("UPDATE saldo SET SUM_KAS=SUM_KAS+'$sum_kas',POSL=POSL+'$sum_kom',DT_OPL='$dt_opl_a',DT_OPL_DOP='$dt_opl_d',TAKS='$taks',SM_PDV='$pdv'   
	WHERE SZ='$sz' AND NZ='$nz'");
}
else{
$ath=mysql_query("INSERT INTO saldo(SZ,NZ,ADRES,ZAMOVNUK,TAKS,SM_PDV,SUM_KAS,POSL,DT_PS,DT_OPL,DT_OPL_DOP) 
	VALUES('$sz','$nz','$adres','$fio','$taks','$pdv','$sum_kas','$sum_kom','$dt_ps','$dt_opl_a','$dt_opl_d')");
}
mysql_free_result($atu1);
}	
$taks=0;
}
mysql_free_result($atu);
//---------------
//vstavka nachalnuh ostatkov
$sql="SELECT n_ostatok.*,nas_punktu.NSP,tup_nsp.TIP_NSP,vulutsi.VUL,tup_vul.TIP_VUL,
	zamovlennya.BUD,zamovlennya.KVAR,zamovlennya.PR,zamovlennya.IM,zamovlennya.PB,zamovlennya.DOKVUT,
	zamovlennya.DATA_PS,zamovlennya.DODOP,zamovlennya.KEY  
	FROM n_ostatok,zamovlennya,nas_punktu,tup_nsp,vulutsi,tup_vul  
	WHERE n_ostatok.DT>='$dt_n' AND n_ostatok.DT<='$dt_k' AND zamovlennya.DL='1' 
	AND n_ostatok.SZ=zamovlennya.SZ AND n_ostatok.NZ=zamovlennya.NZ
	AND nas_punktu.ID_NSP=zamovlennya.NS 
	AND vulutsi.ID_VUL=zamovlennya.VL
	AND tup_nsp.ID_TIP_NSP=nas_punktu.ID_TIP_NSP
	AND tup_vul.ID_TIP_VUL=vulutsi.ID_TIP_VUL";
$atu=mysql_query($sql);
while($aut=mysql_fetch_array($atu)){
if($aut["BUD"]!="") $bud="буд.".$aut["BUD"]; else $bud="";
if($aut["KVAR"]!="") $kvar="кв.".$aut["KVAR"]; else $kvar="";
$sz=$aut["SZ"];
$nz=$aut["NZ"];
$adres=$aut["TIP_NSP"].' '.$aut["NSP"].' '.$aut["TIP_VUL"].' '.$aut["VUL"].' '.$bud.' '.$kvar;
$fio=$aut["PR"].' '.$aut["IM"].' '.$aut["PB"];
$deb=$aut["DEB"];
$kre=$aut["KRE"];
$dt_ps=$aut["DATA_PS"];
$dt_opl=$aut["DOKVUT"];
$dt_opl_d=$aut["DODOP"];
$idzak=$aut["KEY"];
$taks=0;
$pdv=0;
$sql1="SELECT taks.SUM AS SM_T,taks.SUM_OKR,taks.NDS FROM zamovlennya,taks 
WHERE zamovlennya.KEY='$idzak' AND zamovlennya.KEY=taks.IDZM AND taks.DL='1'";
//echo $sql;
$atu1=mysql_query($sql1);
while($aut1=mysql_fetch_array($atu1)){
$taks=round((($aut1["SM_T"]+$aut1["SUM_OKR"])*(($aut1["NDS"]/100)+1)),2);
$pdv=round((($aut1["SM_T"]+$aut1["SUM_OKR"])*($aut1["NDS"]/100)),2);//vst pdv
}
mysql_free_result($atu1);
//$taks=round((($aut["SM_T"]+$aut["SUM_OKR"])*(($aut["NDS"]/100)+1)),2);

$sql1="SELECT ID FROM saldo WHERE SZ='$sz' AND NZ='$nz'"; 
$atu1=mysql_query($sql1);
$num_rows=mysql_num_rows($atu1);
if($num_rows!=0){
$ath=mysql_query("UPDATE saldo SET DEB_P='$deb',KRE_P='$kre',TAKS='$taks',SM_PDV='$pdv' WHERE SZ='$sz' AND NZ='$nz'");
}
else{
$ath=mysql_query("INSERT INTO saldo(SZ,NZ,ADRES,ZAMOVNUK,DEB_P,KRE_P,TAKS,SM_PDV,DT_PS,DT_OPL,DT_OPL_DOP) 
	VALUES('$sz','$nz','$adres','$fio','$deb','$kre','$taks','$pdv','$dt_ps','$dt_opl','$dt_opl_d')");
}
mysql_free_result($atu1);
$taks=0;
}
mysql_free_result($atu);
//---------------------------
//vstavka s zakazov 71 cheta
$sql="SELECT zamovlennya.*,nas_punktu.NSP,tup_nsp.TIP_NSP,
	vulutsi.VUL,tup_vul.TIP_VUL,n_ostatok.KRE AS SM_71   
FROM nas_punktu,tup_nsp,vulutsi,tup_vul,zamovlennya,n_ostatok  
WHERE zamovlennya.DT_71>='$dt_n' AND zamovlennya.DT_71<='$dt_k'
	AND n_ostatok.DT>='$dt_n' AND n_ostatok.DT<='$dt_k' 
	AND zamovlennya.DL='1' AND zamovlennya.SZ=n_ostatok.SZ AND zamovlennya.NZ=n_ostatok.NZ 
	AND nas_punktu.ID_NSP=zamovlennya.NS 
	AND vulutsi.ID_VUL=zamovlennya.VL
	AND tup_nsp.ID_TIP_NSP=nas_punktu.ID_TIP_NSP
	AND tup_vul.ID_TIP_VUL=vulutsi.ID_TIP_VUL
ORDER BY zamovlennya.SZ,zamovlennya.NZ,zamovlennya.DOKVUT";
//echo $sql;
$atu=mysql_query($sql);
while($aut=mysql_fetch_array($atu)){
if($aut["BUD"]!="") $bud="буд.".$aut["BUD"]; else $bud="";
if($aut["KVAR"]!="") $kvar="кв.".$aut["KVAR"]; else $kvar="";
$sz=$aut["SZ"];
$nz=$aut["NZ"];
$adres=$aut["TIP_NSP"].' '.$aut["NSP"].' '.$aut["TIP_VUL"].' '.$aut["VUL"].' '.$bud.' '.$kvar;
$fio=$aut["PR"].' '.$aut["IM"].' '.$aut["PB"];
$sum_71=$aut["SM_71"];
$dt_ps=$aut["DATA_PS"];
$dt_opl=$aut["DOKVUT"];
$dt_opl_d=$aut["DODOP"];

$sql1="SELECT ID FROM saldo WHERE SZ='$sz' AND NZ='$nz'"; 
$atu1=mysql_query($sql1);
$num_rows=mysql_num_rows($atu1);
if($num_rows!=0){
$ath=mysql_query("UPDATE saldo SET `71`='$sum_71' WHERE SZ='$sz' AND NZ='$nz'");
}
else{
$ath=mysql_query("INSERT INTO saldo(SZ,NZ,ADRES,ZAMOVNUK,`71`,DT_PS,DT_OPL,DT_OPL_DOP) 
	VALUES('$sz','$nz','$adres','$fio','$sum_71','$dt_ps','$dt_opl','$dt_opl_d')");
}
mysql_free_result($atu1);
}
mysql_free_result($atu);
//------------------------------------------------------

$sql="SELECT * FROM saldo";
$atu=mysql_query($sql);
while($aut=mysql_fetch_array($atu)){
$sz=$aut["SZ"];
$nz=$aut["NZ"];
$deb_p=$aut["DEB_P"];
$kre_p=$aut["KRE_P"];
$pov=$aut["POVER"];
$sm_zak=$aut["SM_ZAK"];
$d71=$aut["71"];
$sm_kas=$aut["SUM_KAS"];
$posl=$aut["POSL"];
$s_itog=$deb_p-$kre_p+$pov+$sm_zak+$d71-$sm_kas-$posl;
if($s_itog>0){
$ath=mysql_query("UPDATE saldo SET DEB_K='$s_itog' WHERE SZ='$sz' AND NZ='$nz'");
}
if($s_itog<0){
$s_itog=$s_itog*(-1);
$ath=mysql_query("UPDATE saldo SET KRE_K='$s_itog' WHERE SZ='$sz' AND NZ='$nz'");
}
}
mysql_free_result($atu);

$p='
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script type="text/javascript" src="../js/jquery.stickytableheaders.js"></script>
<link rel="stylesheet" type="text/css" href="../my.css" />
<script type="text/javascript">
$(document).ready(
  function()
  { 
  	$(".zmview tr").mouseover(function() {
  		$(this).addClass("over");
  	});
  
  	$(".zmview tr").mouseout(function() {
  		$(this).removeClass("over");
  	});
	$(".zmview tr:even").addClass("alt");
	$("table").stickyTableHeaders();
  }
);
</script>
<b>Оборотно-сальдова за рах 361 "Кінцевий споживач" за '.$rest.'</b> <a href="saldo_print.php?date1='.$dt_n.'&date2='.$dt_k.'"><img src="../images/print.png" border="0"></a>
<table class="zmview"><thead><tr>
	<th align="center" rowspan="2"><font size="2">Договір</font></th>
	<th align="center" rowspan="2"><font size="2">Адреса</font></th>
	<th align="center" rowspan="2"><font size="2">Замовник</font></th>
	<th align="center" colspan="2"><font size="2">С-до на початок</font></th>
	<th align="center" colspan="3"><font size="2">ОБ ДТ</font></th>
	<th align="center" rowspan="2"><font size="2">Такс.</font></th>
	<th align="center" rowspan="2"><font size="2">ПДВ</font></th>
	<th align="center"><font size="2">ОБ КТ</font></th>
	<th align="center"><font size="2">-</font></th>
	<th align="center" colspan="2"><font size="2">С-до на кінець</font></th>
	<th align="center" colspan="3"><font size="2">Дата</font></th>
	</tr><tr>
	<th align="center"><font size="2">ДТ</font></th>
	<th align="center"><font size="2">КТ</font></th>
	<th align="center"><font size="2">31</font></th>
	<th align="center"><font size="2">70</font></th>
	<th align="center"><font size="2">71</font></th>
	<th align="center"><font size="2">31</font></th>
	<th align="center"><font size="2">94</font></th>
	<th align="center"><font size="2">ДТ</font></th>
	<th align="center"><font size="2">КТ</font></th>
	<th align="center"><font size="2">виконання</font></th>
	<th align="center"><font size="2">оплата</font></th>
	<th align="center"><font size="2">оплата доп.</font></th>	
	</tr></thead><tbody>';
$s_deb_n=0;
$s_kre_n=0;
$s_vorv=0;
$s_zakr=0;
$s_71=0;
$s_pdv=0;
$s_opl=0;
$s_kom=0;
$s_deb_k=0;
$s_kre_k=0;

$sql="SELECT saldo.* FROM saldo ORDER BY saldo.SZ,saldo.NZ";
$atu=mysql_query($sql);
while($aut=mysql_fetch_array($atu)){
$s_deb_n=$s_deb_n+$aut["DEB_P"];
$s_kre_n=$s_kre_n+$aut["KRE_P"];
$s_vorv=$s_vorv+$aut["POVER"];
$s_zakr=$s_zakr+$aut["SM_ZAK"];
$s_71=$s_71+$aut["71"];
$s_pdv=$s_pdv+$aut["SM_PDV"];
$s_opl=$s_opl+$aut["SUM_KAS"];
$s_kom=$s_kom+$aut["POSL"];
$s_deb_k=$s_deb_k+$aut["DEB_K"];
$s_kre_k=$s_kre_k+$aut["KRE_K"];

if($aut["DEB_P"]==0) $deb_n="&nbsp"; else $deb_n=$aut["DEB_P"];
if($aut["KRE_P"]==0) $kre_n="&nbsp"; else $kre_n=$aut["KRE_P"];
if($aut["POVER"]==0) $pover="&nbsp"; else $pover=$aut["POVER"];
if($aut["SM_ZAK"]==0) $zakr="&nbsp"; else $zakr=$aut["SM_ZAK"];
if($aut["71"]==0) $r71="&nbsp"; else $r71=$aut["71"];
if($aut["TAKS"]==0) $taksir="&nbsp"; else $taksir=$aut["TAKS"];
if($aut["SM_PDV"]==0) $spdv="&nbsp"; else $spdv=$aut["SM_PDV"];
if($aut["SUM_KAS"]==0) $opl="&nbsp"; else $opl=$aut["SUM_KAS"];
if($aut["POSL"]==0) $kom="&nbsp"; else $kom=$aut["POSL"];
if($aut["DEB_K"]==0) $deb_k="&nbsp"; else $deb_k=$aut["DEB_K"];
if($aut["KRE_K"]==0) $kre_k="&nbsp"; else $kre_k=$aut["KRE_K"];

/* if($aut["KOD_ZM"]=="") $zakaz=$aut["SZ"].'*'.$aut["NZ"];
else $zakaz=$aut["SZ"].'*'.$aut["NZ"].'-'.$aut["KOD_ZM"]; */

$zakaz=$aut["SZ"].'/'.$aut["NZ"];

if(german_date($aut["DT_PS"])=='-') $pidpus='';
else $pidpus=german_date($aut["DT_PS"]);
if(german_date($aut["DT_OPL"])=='-') $avans='';
else $avans=german_date($aut["DT_OPL"]);
if(german_date($aut["DT_OPL_DOP"])=='-') $doplata='';
else $doplata=german_date($aut["DT_OPL_DOP"]);
$p.='<tr>
<td align="center"><font size="1">'.$zakaz.'</font></td>
<td><font size="1">'.$aut["ADRES"].'</font></td>
<td><font size="1">'.$aut["ZAMOVNUK"].'</font></td>
<td align="right"><font size="1">'.$deb_n.'</font></td>
<td align="right"><font size="1">'.$kre_n.'</font></td>
<td align="right"><font size="1">'.$pover.'</font></td>
<td align="right"><font size="1">'.$zakr.'</font></td>
<td align="right"><font size="1">'.$r71.'</font></td>
<td align="right" style="background-color: #98FB98;"><font size="1">'.$taksir.'</font></td>
<td align="right" style="background-color: #FAEBD7;"><font size="1">'.$spdv.'</font></td>
<td align="right"><font size="1">'.$opl.'</font></td>
<td align="right"><font size="1">'.$kom.'</font></td>
<td align="right"><font size="1">'.$deb_k.'</font></td>
<td align="right"><font size="1">'.$kre_k.'</font></td>
<td align="center"><font size="1">'.$pidpus.'</font></td>
<td align="center"><font size="1">'.$avans.'</font></td>
<td align="center"><font size="1">'.$doplata.'</font></td>
</tr>';
}
mysql_free_result($atu);
$p.='<tr>
<td colspan="3" ><b>Усього</b></td>
<td align="right"><font size="1"><b>'.number_format($s_deb_n,2).'</b></font></td>
<td align="right"><font size="1"><b>'.number_format($s_kre_n,2).'</b></font></td>
<td align="right"><font size="1"><b>'.number_format($s_vorv,2).'</b></font></td>
<td align="right"><font size="1"><b>'.number_format($s_zakr,2).'</b></font></td>
<td align="right"><font size="1"><b>'.number_format($s_71,2).'</b></font></td>
<td align="center"><font size="1"><b>-</b></font></td>
<td align="right"><font size="1"><b>'.number_format($s_pdv,2).'</b></font></td>
<td align="right"><font size="1"><b>'.number_format($s_opl,2).'</b></font></td>
<td align="right"><font size="1"><b>'.number_format($s_kom,2).'</b></font></td>
<td align="right"><font size="1"><b>'.number_format($s_deb_k,2).'</b></font></td>
<td align="right"><font size="1"><b>'.number_format($s_kre_k,2).'</b></font></td>
<td align="center" colspan="3">-</td>
</tr>';
$p.='</tbody></table>';
echo $p;

//Zakrutie bazu--       
       if(mysql_close($db))
        {
        // echo("Закриття бази даних");
         }
         else
         {
          echo("Не можливо виконати закриття бази"); 
          }
?>