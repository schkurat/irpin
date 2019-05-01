<?php
include("../function.php");
$sz=$_GET["szam"];
$nz=$_GET["nzam"];
$sum=$_GET["sum"];
$dt_pov=date_bd($_GET["dpov"]);
$sum=number_format($sum,2);

$sql="SELECT SUM(SM) AS SM FROM kasa WHERE SZ='$sz' AND NZ='$nz' AND DL='1'";
	$atu=mysql_query($sql);
	while($aut=mysql_fetch_array($atu))
	{$sm_kas=$aut["SM"];}
	mysql_free_result($atu);
	
if($sum<=$sm_kas){
	$sum_v=($sum*(-1));
	$ath=mysql_query("INSERT INTO kasa(SZ,NZ,DT,SM) VALUES('$sz','$nz','$dt_pov','$sum_v')");
	
	/* $sql="SELECT SUM FROM zamovlennya WHERE SZ='$sz' AND NZ='$nz' AND DL='1'";
	$atu=mysql_query($sql);
	while($aut=mysql_fetch_array($atu))
	{$sm_zm=$aut["SUM"];}
	mysql_free_result($atu);
	if($sum==$sm_zm){
		$ath=mysql_query("UPDATE zamovlennya SET DOKVUT='0000-00-00' 
		WHERE DL='1' AND SZ='$sz' AND NZ='$nz'");
	} */
}
else 
echo "Сума каси меньша за суму повернення!!!";
?>