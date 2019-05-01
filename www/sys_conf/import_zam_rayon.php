<?php
include "../fun2.php";
echo "<h1>START TIME:".date("H:i s")."</h1>";

$sql = "SELECT tb1.*,tb2.KRE FROM bti.ZM AS tb1 
	INNER JOIN kpbti.n_ostatok AS tb2 
	ON tb2.KODP!=1010 AND tb2.KODP=tb1.KODP AND tb2.SZ=tb1.SD AND tb2.NZ=tb1.NZ AND tb1.VR!='ДП'"; 
	/* dl_of.id_oform,nrn.PNR,nsl.SNS,pgf.AP,
	INNER JOIN bti.NRN AS nrn ON tb1.NR=nrn.NR 
	INNER JOIN bti.NSL AS nsl ON tb1.NS=nsl.NS AND nrn.NR=nsl.CNR 
	INNER JOIN bti.PGF AS pgf ON tb1.VL=pgf.VC AND nsl.CNR=pgf.NR AND nsl.NS=pgf.NS  
	INNER JOIN bti.PRICE AS price ON tb1.VR=price.KD
	INNER JOIN kpbti.dlya_oformlennya AS dl_of ON dl_of.document=price.VR */
$atu=mysql_query($sql);
while($aut=mysql_fetch_array($atu))
{
$kodp=$aut['KODP'];
$sz=$aut['SD'];
$nz=$aut['NZ'];
$tup_zam=1;
$term=1;
//$vud_rob=$aut['id_oform'];
$idn=$aut['IDN'];
$pr=$aut['PR'];
$im=$aut['IM'];
$pb=$aut['PB'];
$d_nar=$aut['RN'];
$tel=$aut['TEL'];
$rn=1;
$ns=1;
$vl=1;
$bud=1;
$kvar=1;
//$old_ad=$aut['PNR'].' '.$aut['SNS'].' '.$aut['AP'].' буд '.$aut['BD'];
//if($aut['KV']!='') $old_ad.=' кв. '.$aut['KV'];
$sum=$aut['KRE'];
$d_pr=$aut['D_PR'];
$data_got=$aut['D_GOT'];

$sql_buf="INSERT INTO zamovlennya (KODP,SZ,NZ,TUP_ZAM,TERM,VUD_ROB,IDN,PR,IM,PB,D_NAR,TEL,RN,NS,VL,BUD,KVAR,
OLD_AD,SUM,D_PR,DATA_GOT) 
VALUES ('$kodp','$sz','$nz','$tup_zam','$term','$vud_rob','$idn','$pr','$im','$pb','$d_nar','$tel','$rn',
'$ns','$vl','$bud','$kvar','$old_ad','$sum','$d_pr','$data_got');";
mysql_query($sql_buf);
}
mysql_free_result($atu);

$sql = "SELECT dl_of.id_oform,nrn.PNR,nsl.SNS,pgf.AP,tb1.* FROM bti.ZM AS tb1 
	INNER JOIN kpbti.zamovlennya AS tb2 
	ON tb2.KODP=tb1.KODP AND tb2.SZ=tb1.SD AND tb2.NZ=tb1.NZ AND tb1.VR!='ДП'
	INNER JOIN bti.NRN AS nrn ON tb1.NR=nrn.NR 
	INNER JOIN bti.NSL AS nsl ON tb1.NS=nsl.NS AND nrn.NR=nsl.CNR 
	INNER JOIN bti.PGF AS pgf ON tb1.VL=pgf.VC AND nsl.CNR=pgf.NR AND nsl.NS=pgf.NS  
	INNER JOIN bti.PRICE AS price ON tb1.VR=price.KD
	INNER JOIN kpbti.dlya_oformlennya AS dl_of ON dl_of.document=price.VR"; 
$atu=mysql_query($sql);
while($aut=mysql_fetch_array($atu))
{
$vud_rob=$aut['id_oform'];
$old_ad=$aut['PNR'].' '.$aut['SNS'].' '.$aut['AP'].' буд '.$aut['BD'];
if($aut['KV']!='') $old_ad.=' кв. '.$aut['KV'];
$kodp=$aut['KODP'];
$sz=$aut['SD'];
$nz=$aut['NZ'];

$sql_buf="UPDATE zamovlennya SET VUD_ROB='$vud_rob',OLD_AD='$old_ad' WHERE KODP='$kodp' AND SZ='$sz' AND 
	NZ='$nz';";
mysql_query($sql_buf);
}
mysql_free_result($atu);
		  echo "<h1>STOP TIME:".date("H:i s")."</h1>";
?>