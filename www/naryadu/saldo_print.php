<?php
session_start();
$lg=$_SESSION['LG'];
$pas=$_SESSION['PAS'];
include("../function.php");
   
$dt_n=$_GET["date1"];
$dt_k=$_GET["date2"];
$rest = substr(german_date($_GET["date1"]),3,7);

$db=mysql_connect("localhost",$lg,$pas);
if(!$db) echo "Не вiдбулося зєднання з базою даних";
  
 if(!@mysql_select_db(kpbti,$db))
  {
   echo("Не завантажена таблиця");
   exit(); 
   }
   
$ath=mysql_query("TRUNCATE TABLE  `saldo`");

//vstavka s zakazov
$sql="SELECT zamovlennya.*,rayonu.RAYON,nas_punktu.NSP,tup_nsp.TIP_NSP,
	vulutsi.VUL,tup_vul.TIP_VUL,taks.SUM AS SM_T,taks.SUM_OKR,taks.NDS  
FROM rayonu,nas_punktu,tup_nsp,vulutsi,tup_vul,zamovlennya,taks  
WHERE zamovlennya.DATA_PS>='$dt_n' AND zamovlennya.DATA_PS<='$dt_k'
	AND zamovlennya.DL='1' AND zamovlennya.KEY=taks.IDZM AND taks.DL='1'  
	AND rayonu.ID_RAYONA=zamovlennya.RN
	AND nas_punktu.ID_NSP=zamovlennya.NS 
	AND vulutsi.ID_VUL=zamovlennya.VL
	AND tup_nsp.ID_TIP_NSP=nas_punktu.ID_TIP_NSP
	AND tup_vul.ID_TIP_VUL=vulutsi.ID_TIP_VUL
ORDER BY zamovlennya.KODP,zamovlennya.SZ,zamovlennya.NZ,zamovlennya.DOKVUT";
//echo $sql;
$atu=mysql_query($sql);
while($aut=mysql_fetch_array($atu)){
if($aut["BUD"]!="") $bud="буд.".$aut["BUD"]; else $bud="";
if($aut["KVAR"]!="") $kvar="кв.".$aut["KVAR"]; else $kvar="";
$kodp=$aut["KODP"];
$sz=$aut["SZ"];
$nz=$aut["NZ"];
$szu=$aut["SZU"];
$nzu=$aut["NZU"];
$adres=$aut["TIP_NSP"].' '.$aut["NSP"].' '.$aut["TIP_VUL"].' '.$aut["VUL"].' '.$bud.' '.$kvar;
$fio=$aut["PR"].' '.$aut["IM"].' '.$aut["PB"];
//$sum_zak=$aut["SUM"]+$aut["SUM_D"];
$sum_zak=round((($aut["SM_T"]+$aut["SUM_OKR"])*(($aut["NDS"]/100)+1)),2);
$dt_ps=$aut["DATA_PS"];
$dt_opl=$aut["DOKVUT"];
$dt_opl_d=$aut["DODOP"];

if($dt_ps>$dt_k or $dt_ps=='0000-00-00'){
$sum_zak=0;
}

$sql1="SELECT KODP FROM saldo WHERE KODP='$kodp' AND SZ='$sz' AND NZ='$nz' AND SZU='$szu' AND NZU='$nzu'"; 
$atu1=mysql_query($sql1);
$num_rows=mysql_num_rows($atu1);
if($num_rows!=0){
$ath=mysql_query("UPDATE saldo SET SM_ZAK='$sum_zak',DT_OPL='$dt_opl',DT_OPL_DOP='$dt_opl_d' 
	WHERE KODP='$kodp' AND SZ='$sz' AND NZ='$nz' AND SZU='$szu' AND NZU='$nzu'");
}
else{
$ath=mysql_query("INSERT INTO saldo(KODP,SZ,NZ,SZU,NZU,ADRES,ZAMOVNUK,SM_ZAK,DT_PS,DT_OPL,DT_OPL_DOP) 
	VALUES('$kodp','$sz','$nz','$szu','$nzu','$adres','$fio','$sum_zak','$dt_ps','$dt_opl','$dt_opl_d')");
}
mysql_free_result($atu1);

}
mysql_free_result($atu);
//--------------------
//vstavl s opl
$sql="SELECT kasa.*,rayonu.RAYON,nas_punktu.NSP,tup_nsp.TIP_NSP,zamovlennya.SUM,zamovlennya.DODOP,
	vulutsi.VUL,tup_vul.TIP_VUL,zamovlennya.BUD,zamovlennya.KVAR,zamovlennya.PR,zamovlennya.IM,zamovlennya.DOKVUT,
	zamovlennya.PB,zamovlennya.DATA_PS FROM rayonu,nas_punktu,tup_nsp,vulutsi,tup_vul,zamovlennya,kasa 
WHERE kasa.DT>='$dt_n' AND kasa.DT<='$dt_k' AND
	zamovlennya.DL='1' AND kasa.DL='1' 
	AND zamovlennya.SZ=kasa.SD AND zamovlennya.NZ=kasa.NZ 
	AND zamovlennya.SZU=kasa.SZU AND zamovlennya.NZU=kasa.NZU 
	AND zamovlennya.KODP=kasa.KODP
	AND rayonu.ID_RAYONA=zamovlennya.RN
	AND nas_punktu.ID_NSP=zamovlennya.NS 
	AND vulutsi.ID_VUL=zamovlennya.VL
	AND tup_nsp.ID_TIP_NSP=nas_punktu.ID_TIP_NSP
	AND tup_vul.ID_TIP_VUL=vulutsi.ID_TIP_VUL
ORDER BY kasa.KODP,kasa.SD,kasa.NZ,kasa.DT";
//echo $sql;
$atu=mysql_query($sql);
while($aut=mysql_fetch_array($atu)){
if($aut["BUD"]!="") $bud="буд.".$aut["BUD"]; else $bud="";
if($aut["KVAR"]!="") $kvar="кв.".$aut["KVAR"]; else $kvar="";
$kodp=$aut["KODP"];
$sz=$aut["SD"];
$nz=$aut["NZ"];
$szu=$aut["SZU"];
$nzu=$aut["NZU"];
$adres=$aut["TIP_NSP"].' '.$aut["NSP"].' '.$aut["TIP_VUL"].' '.$aut["VUL"].' '.$bud.' '.$kvar;
$fio=$aut["PR"].' '.$aut["IM"].' '.$aut["PB"];
$sum_zak=$aut["SUM"];
$sum_kas=$aut["SM"];
$sum_kom=$aut["SM_KM"];
$dt_ps=$aut["DATA_PS"];
$dt_opl=$aut["DOKVUT"];
$dt_opl_d=$aut["DODOP"];
$sum_voz=0;

if($dt_opl>$dt_k or $dt_opl<$dt_n){
$sum_kas=0;
}

if($sum_kas<0){
$sum_voz=$sum_kas*(-1);
if($sum_zak>$sum_voz) $sum_zak=$sum_zak-$sum_voz;
if($sum_zak==$sum_voz or $dt_ps>$dt_k or $dt_ps=='0000-00-00'){$sum_zak=0;}
//echo "sz=".$sz."nz=".$nz."kodp=".$kodp;
//echo "sum_vozv=".$sum_voz;
//echo "sum_zak=".$sum_zak;
$sql7="SELECT KODP FROM saldo WHERE KODP='$kodp' AND SZ='$sz' AND NZ='$nz' AND SZU='$szu' AND NZU='$nzu'"; 
$atu7=mysql_query($sql7);
$num_rows=mysql_num_rows($atu7);
if($num_rows!=0){
$ath=mysql_query("UPDATE saldo SET POVER='$sum_voz',SM_ZAK='$sum_zak' 
		WHERE SZ='$sz' AND NZ='$nz' AND SZU='$szu' AND NZU='$nzu' AND KODP='$kodp'");
}
else{
$ath=mysql_query("INSERT INTO saldo(KODP,SZ,NZ,SZU,NZU,ADRES,ZAMOVNUK,POVER,SM_ZAK,DT_PS,DT_OPL,DT_OPL_DOP) 
	VALUES('$kodp','$sz','$nz','$szu','$nzu','$adres','$fio','$sum_voz','$sum_zak','$dt_ps','$dt_opl','$dt_opl_d')");
}
mysql_free_result($atu7);
}
else{
$sql1="SELECT KODP FROM saldo WHERE KODP='$kodp' AND SZ='$sz' AND NZ='$nz' AND SZU='$szu' AND NZU='$nzu'"; 
$atu1=mysql_query($sql1);
$num_rows=mysql_num_rows($atu1);
if($num_rows!=0){
$ath=mysql_query("UPDATE saldo SET SUM_KAS=SUM_KAS+'$sum_kas',POSL=POSL+'$sum_kom',DT_OPL='$dt_opl',DT_OPL_DOP='$dt_opl_d'  
	WHERE KODP='$kodp' AND SZ='$sz' AND NZ='$nz' AND SZU='$szu' AND NZU='$nzu'");
}
else{
$ath=mysql_query("INSERT INTO saldo(KODP,SZ,NZ,SZU,NZU,ADRES,ZAMOVNUK,SUM_KAS,POSL,DT_PS,DT_OPL,DT_OPL_DOP) 
	VALUES('$kodp','$sz','$nz','$szu','$nzu','$adres','$fio','$sum_kas','$sum_kom','$dt_ps','$dt_opl','$dt_opl_d')");
}
mysql_free_result($atu1);
}	

}
mysql_free_result($atu);
//---------------
//vstavka nachalnuh ostatkov
$sql="SELECT n_ostatok.*,rayonu.RAYON,nas_punktu.NSP,tup_nsp.TIP_NSP,vulutsi.VUL,tup_vul.TIP_VUL,
	zamovlennya.BUD,zamovlennya.KVAR,zamovlennya.PR,zamovlennya.IM,zamovlennya.PB,zamovlennya.DOKVUT,
	zamovlennya.DATA_PS,zamovlennya.OLD_AD,zamovlennya.DODOP 
	FROM n_ostatok,zamovlennya,rayonu,nas_punktu,tup_nsp,vulutsi,tup_vul 
	WHERE DT>='$dt_n' AND DT<='$dt_k'
	AND n_ostatok.KODP=zamovlennya.KODP 
	AND n_ostatok.SZ=zamovlennya.SZ AND n_ostatok.NZ=zamovlennya.NZ
	AND n_ostatok.SZU=zamovlennya.SZU AND n_ostatok.NZU=zamovlennya.NZU	
	AND rayonu.ID_RAYONA=zamovlennya.RN
	AND nas_punktu.ID_NSP=zamovlennya.NS 
	AND vulutsi.ID_VUL=zamovlennya.VL
	AND tup_nsp.ID_TIP_NSP=nas_punktu.ID_TIP_NSP
	AND tup_vul.ID_TIP_VUL=vulutsi.ID_TIP_VUL";
$atu=mysql_query($sql);
while($aut=mysql_fetch_array($atu)){
if($aut["BUD"]!="") $bud="буд.".$aut["BUD"]; else $bud="";
if($aut["KVAR"]!="") $kvar="кв.".$aut["KVAR"]; else $kvar="";
$kodp=$aut["KODP"];
$sz=$aut["SZ"];
$nz=$aut["NZ"];
$szu=$aut["SZU"];
$nzu=$aut["NZU"];
if($aut["OLD_AD"]!='') $adres=$aut["OLD_AD"];
else
$adres=$aut["TIP_NSP"].' '.$aut["NSP"].' '.$aut["TIP_VUL"].' '.$aut["VUL"].' '.$bud.' '.$kvar;
$fio=$aut["PR"].' '.$aut["IM"].' '.$aut["PB"];
$deb=$aut["DEB"];
$kre=$aut["KRE"];
$dt_ps=$aut["DATA_PS"];
$dt_opl=$aut["DOKVUT"];
$dt_opl_d=$aut["DODOP"];

$sql1="SELECT KODP FROM saldo WHERE KODP='$kodp' AND SZ='$sz' AND NZ='$nz' AND SZU='$szu' AND NZU='$nzu'"; 
$atu1=mysql_query($sql1);
$num_rows=mysql_num_rows($atu1);
if($num_rows!=0){
$ath=mysql_query("UPDATE saldo SET DEB_P='$deb',KRE_P='$kre' WHERE KODP='$kodp' AND SZ='$sz' AND NZ='$nz' AND SZU='$szu' AND NZU='$nzu'");
}
else{
$ath=mysql_query("INSERT INTO saldo(KODP,SZ,NZ,SZU,NZU,ADRES,ZAMOVNUK,DEB_P,KRE_P,DT_PS,DT_OPL,DT_OPL_DOP) 
	VALUES('$kodp','$sz','$nz','$szu','$nzu','$adres','$fio','$deb','$kre','$dt_ps','$dt_opl','$dt_opl_d')");
}
mysql_free_result($atu1);
}
mysql_free_result($atu);
//---------------------------

$sql="SELECT * FROM saldo";
$atu=mysql_query($sql);
while($aut=mysql_fetch_array($atu)){
$kodp=$aut["KODP"];
$sz=$aut["SZ"];
$nz=$aut["NZ"];
$szu=$aut["SZU"];
$nzu=$aut["NZU"];
$deb_p=$aut["DEB_P"];
$kre_p=$aut["KRE_P"];
$pov=$aut["POVER"];
$sm_zak=$aut["SM_ZAK"];
$sm_kas=$aut["SUM_KAS"];
$posl=$aut["POSL"];
$s_itog=$deb_p-$kre_p+$pov+$sm_zak-$sm_kas-$posl;
if($s_itog>0){
$ath=mysql_query("UPDATE saldo SET DEB_K='$s_itog' 
		WHERE SZ='$sz' AND NZ='$nz' AND SZU='$szu' AND NZU='$nzu' AND KODP='$kodp'");
}
if($s_itog<0){
$s_itog=$s_itog*(-1);
$ath=mysql_query("UPDATE saldo SET KRE_K='$s_itog' 
		WHERE SZ='$sz' AND NZ='$nz' AND SZU='$szu' AND NZU='$nzu' AND KODP='$kodp'");
}
}
mysql_free_result($atu);

$p='<b>Оборотно-сальдова за рах 361 "Кінцевий споживач" за '.$rest.'</b>
	<table border="1" cellpadding="0" cellspacing="0"><tr>
	<th align="center" rowspan="2"><font size="2">Договір</font></th>
	<th align="center" rowspan="2"><font size="2">Адреса</font></th>
	<th align="center" rowspan="2"><font size="2">Замовник</font></th>
	<th align="center" colspan="2"><font size="2">С-до на початок</font></th>
	<th align="center" colspan="2"><font size="2">ОБ ДТ</font></th>
	<th align="center"><font size="2">ОБ КТ</font></th>
	<th align="center"><font size="2">-</font></th>
	<th align="center" colspan="2"><font size="2">С-до на кінець</font></th>
	</tr>
	<th align="center"><font size="2">ДТ</font></th>
	<th align="center"><font size="2">КТ</font></th>
	<th align="center"><font size="2">31</font></th>
	<th align="center"><font size="2">70</font></th>
	<th align="center"><font size="2">31</font></th>
	<th align="center"><font size="2">94</font></th>
	<th align="center"><font size="2">ДТ</font></th>
	<th align="center"><font size="2">КТ</font></th>	
	</tr>';
$s_deb_n=0;
$s_kre_n=0;
$s_vorv=0;
$s_zakr=0;
$s_opl=0;
$s_kom=0;
$s_deb_k=0;
$s_kre_k=0;

$sql="SELECT saldo.*,spr_nr.KOD_ZM FROM saldo,spr_nr 
WHERE saldo.KODP=spr_nr.KODP ORDER BY saldo.KODP,saldo.SZ,saldo.NZ";
$atu=mysql_query($sql);
while($aut=mysql_fetch_array($atu)){
$kodp=$aut["KODP"];
$s_deb_n=$s_deb_n+$aut["DEB_P"];
$s_kre_n=$s_kre_n+$aut["KRE_P"];
$s_vorv=$s_vorv+$aut["POVER"];
$s_zakr=$s_zakr+$aut["SM_ZAK"];
$s_opl=$s_opl+$aut["SUM_KAS"];
$s_kom=$s_kom+$aut["POSL"];
$s_deb_k=$s_deb_k+$aut["DEB_K"];
$s_kre_k=$s_kre_k+$aut["KRE_K"];

if($aut["DEB_P"]==0) $deb_n="&nbsp"; else $deb_n=$aut["DEB_P"];
if($aut["KRE_P"]==0) $kre_n="&nbsp"; else $kre_n=$aut["KRE_P"];
if($aut["POVER"]==0) $pover="&nbsp"; else $pover=$aut["POVER"];
if($aut["SM_ZAK"]==0) $zakr="&nbsp"; else $zakr=$aut["SM_ZAK"];
if($aut["SUM_KAS"]==0) $opl="&nbsp"; else $opl=$aut["SUM_KAS"];
if($aut["POSL"]==0) $kom="&nbsp"; else $kom=$aut["POSL"];
if($aut["DEB_K"]==0) $deb_k="&nbsp"; else $deb_k=$aut["DEB_K"];
if($aut["KRE_K"]==0) $kre_k="&nbsp"; else $kre_k=$aut["KRE_K"];

/* if($aut["KOD_ZM"]=="") $zakaz=$aut["SZ"].'*'.$aut["NZ"];
else $zakaz=$aut["SZ"].'*'.$aut["NZ"].'-'.$aut["KOD_ZM"]; */

if($aut["SZU"]!=''){
$zakaz=$aut["SZ"].'*'.$aut["SZU"].'/'.$aut["NZU"];
}
else{
$zakaz=$aut["SZ"].'*'.$aut["NZ"].'-'.$aut["KOD_ZM"];
}

$p.='<tr>
<td align="center"><font size="1">'.$zakaz.'</font></td>
<td><font size="1">'.$aut["ADRES"].'</font></td>
<td><font size="1">'.$aut["ZAMOVNUK"].'</font></td>
<td align="right"><font size="1">'.$deb_n.'</font></td>
<td align="right"><font size="1">'.$kre_n.'</font></td>
<td align="right"><font size="1">'.$pover.'</font></td>
<td align="right"><font size="1">'.$zakr.'</font></td>
<td align="right"><font size="1">'.$opl.'</font></td>
<td align="right"><font size="1">'.$kom.'</font></td>
<td align="right"><font size="1">'.$deb_k.'</font></td>
<td align="right"><font size="1">'.$kre_k.'</font></td>
</tr>';
}
mysql_free_result($atu);
$p.='<tr>
<td colspan="3" ><b>Усього</b></td>
<td align="right"><font size="1"><b>'.number_format($s_deb_n,2).'</b></font></td>
<td align="right"><font size="1"><b>'.number_format($s_kre_n,2).'</b></font></td>
<td align="right"><font size="1"><b>'.number_format($s_vorv,2).'</b></font></td>
<td align="right"><font size="1"><b>'.number_format($s_zakr,2).'</b></font></td>
<td align="right"><font size="1"><b>'.number_format($s_opl,2).'</b></font></td>
<td align="right"><font size="1"><b>'.number_format($s_kom,2).'</b></font></td>
<td align="right"><font size="1"><b>'.number_format($s_deb_k,2).'</b></font></td>
<td align="right"><font size="1"><b>'.number_format($s_kre_k,2).'</b></font></td>
</tr>';
$p.='</table>';
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