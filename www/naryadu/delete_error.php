<?php
include "../function.php";
$id=$_GET["id"];
$script=$_GET["script"];
//берем запись по id
$sql="SELECT * FROM kasa_error WHERE kasa_error.DL='1' 
			AND kasa_error.ID='$id'";
$atu=mysql_query($sql);
	while($aut=mysql_fetch_array($atu))
	{	
		$sd=$aut["SD"];
		$nz=$aut["NZ"];
		$szu=$aut["SZU"];
		$nzu=$aut["NZU"];
		$kodp=$aut["KODP"];
		$sum=$aut["SM"];
		$sum_km=$aut["SM_KM"];
		$dt_opl=$aut["DT"];
		$prim=$aut["PRIM"];
		$n_file=$aut["N_FILE"];
		$ssum=$sum+$sum_km;
	}
mysql_free_result($atu);

$sql="SELECT KODP,SUM,SUM_D FROM zamovlennya WHERE DL='1' AND SZ='$sd' AND NZ='$nz' 
	AND SZU='$szu' AND NZU='$nzu' AND KODP='$kodp' AND (SUM='$ssum' OR SUM_D='$ssum')";
$atu=mysql_query($sql);
/*  $num_rows=mysql_num_rows($atu);
if($num_rows!=0){  */
$atu=mysql_query($sql);
while($aut=mysql_fetch_array($atu))
	{
//vtavka v kasu
$ath=mysql_query("INSERT INTO kasa(SD,NZ,SZU,NZU,DT,SM,SM_KM,PRIM,KODP) 
VALUES('$sd','$nz','$szu','$nzu','$dt_opl','$sum','$sum_km','$prim','$kodp')");
//obnovl v bd zakazov pole datu oplatu
$sm_z=$aut["SUM"];
$smd_z=$aut["SUM_D"];
if($sm_z==$ssum){
$ath=mysql_query("UPDATE zamovlennya SET DOKVUT='$dt_opl' 
WHERE DL='1' AND SZ='$sd' AND NZ='$nz' AND SZU='$szu' AND NZU='$nzu' AND KODP='$kodp' AND SUM='$ssum'");
if(!$ath){echo "Запис не змінився";}}
if($smd_z==$ssum){
$ath=mysql_query("UPDATE zamovlennya SET DODOP='$dt_opl' 
WHERE DL='1' AND SZ='$sd' AND NZ='$nz' AND SZU='$szu' AND NZU='$nzu' AND KODP='$kodp' AND SUM_D='$ssum'");
if(!$ath){echo "Запис не змінився";}}
//удаляем из кассы_ерор перенесенную строку 
$ath=mysql_query("UPDATE kasa_error SET DL='0' WHERE kasa_error.ID='$id'");
if(!$ath){echo "Запис не змінився";} 
//из с_обр берем суму неопределенных заказов и их коммисию
$sql="SELECT SM,SM_KM FROM s_obr WHERE DL='1' AND KODP=1063 AND N_FILE='$n_file'";
$atu=mysql_query($sql);
while($aut=mysql_fetch_array($atu)){	
	$sm_nev=$aut["SM"];
	$sm_kom=$aut["SM_KM"];
}
mysql_free_result($atu);
//отнемаем суму исправленого заказа
$sm_nev=$sm_nev-$sum;
$sm_kom=$sm_kom-$sum_km;
if($sm_nev==0){//если сумма оказалась последней то удаляем строку с неопр. заказ.
$ath=mysql_query("UPDATE s_obr SET SM='$sm_nev',SM_KM='$sm_kom',DL='0' 
WHERE DL='1' AND KODP=1063 AND N_FILE='$n_file'");
if(!$ath){echo "Запис не змінився";}
}
else{//обновляем суму неопредел. заказов
$ath=mysql_query("UPDATE s_obr SET SM='$sm_nev',SM_KM='$sm_kom' 
WHERE DL='1' AND KODP=1063 AND N_FILE='$n_file'");
if(!$ath){echo "Запис не змінився";}
}
//проверяем естли в с_обр строка з таким же кодп
$sql="SELECT KODP FROM s_obr WHERE DL='1' AND KODP='$kodp' AND N_FILE='$n_file'";
$atu=mysql_query($sql);
$num_rows=mysql_num_rows($atu);
if($num_rows!=0){//если есть  то берем ее суму
$sql1="SELECT SM,SM_KM FROM s_obr WHERE DL='1' AND KODP='$kodp' AND N_FILE='$n_file'";
$atu1=mysql_query($sql1);
while($aut1=mysql_fetch_array($atu1)){	
	$sm_sobr=$aut1["SM"];
	$sm_km_sobr=$aut1["SM_KM"];
}
mysql_free_result($atu1);
$sm_sobr=$sm_sobr+$sum;//добавл. суму исправл. строки
$sm_km_sobr=$sm_km_sobr+$sum_km;
$ath=mysql_query("UPDATE s_obr SET SM='$sm_sobr',SM_KM='$sm_km_sobr' 
WHERE DL='1' AND KODP='$kodp' AND N_FILE='$n_file'");
if(!$ath){echo "Запис не змінився";}
}
else{//если нет добавл новую.
$dt_obr=date("Y-m-d");//дата обр. файла
$vr_obr=date("H:i:s");//время обр. файла
$ath=mysql_query("INSERT INTO s_obr(N_FILE,D_OBR,T_OBR,KODP,SM,SM_KM) 
VALUES('$n_file','$dt_obr','$vr_obr','$kodp','$sum','$sum_km')");
}
mysql_free_result($atu);

header("location: naryadu.php?filter=".$script."");
}
mysql_free_result($atu);
echo "Не всі помилки виправлені!";
?>