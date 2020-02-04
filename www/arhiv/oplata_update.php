<?php
include("../function.php");
$kl=$_GET["kl"];
//$tsum=$_GET["tsum"];
$dt_opl=date_bd($_GET["dopl"]);
$sz=$_GET["szam"];
$nz=$_GET["nzam"];
$sum=$_GET["sum"];
$sum_km=$_GET["kom"];
$ssum=$sum+$sum_km;

$dtper=german_date($dt_opl);

$fl_s=0;

$sql="SELECT SUM FROM arhiv_zakaz WHERE SZ='$sz' AND NZ='$nz' AND DL='1'";
$atu=mysql_query($sql);
	while($aut=mysql_fetch_array($atu))
	{	
		$sum_zak=$aut["SUM"];
		if($sum_zak==$ssum){$fl_s=1;}
	}
mysql_free_result($atu);

$sql = "SELECT arhiv_kasa.* FROM arhiv_kasa WHERE arhiv_kasa.ID='$kl' AND arhiv_kasa.DL='1'";
$atu=mysql_query($sql);
  while($aut=mysql_fetch_array($atu))
 {	
$sz_st=$aut["SZ"];
$nz_st=$aut["NZ"];
}
mysql_free_result($atu);

if($fl_s==1){

		$ath=mysql_query("UPDATE arhiv_zakaz SET DOKVUT='0000-00-00' WHERE DL='1' AND SZ='$sz_st' AND NZ='$nz_st'");

		$ath=mysql_query("UPDATE arhiv_kasa SET SZ='$sz',NZ='$nz',DT='$dt_opl',SM='$sum',SM_KM='$sum_km' WHERE ID='$kl'");
	echo "Запис змінено!";
		}
else{
	echo "Помилка!<br> Замовлення $sz/$nz суми не співпадають<br>";
}
?>