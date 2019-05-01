<?php
include "../function.php";
$id=$_GET["id"];
$script=$_GET["script"];
if(isset($_GET['szm'])) $sd=$_GET['szm']; else $sd="";
if(isset($_GET['zamov'])) $zm=$_GET['zamov']; else $zm="";
if(isset($_GET['szu'])) $szu=$_GET['szu']; else $szu="";
if(isset($_GET['nzu'])) $nzu=$_GET['nzu']; else $nzu="";
if(isset($_GET['sum'])) $sum=$_GET['sum']; else $sum="";
if(isset($_GET['sum_km'])) $sum_km=$_GET['sum_km']; else $sum_km="";
if(isset($_GET['dat'])) $dat=date_bd($_GET['dat']); else $dat="";
if(isset($_GET['rayon'])) $rjn=$_GET['rayon']; else $rjn="";

$ath=mysql_query("UPDATE kasa_error SET SD='$sd',NZ='$zm',SZU='$szu',NZU='$nzu',DT='$dat',
	SM='$sum',SM_KM='$sum_km',KODP='$rjn'
	WHERE kasa_error.ID='$id'");
if(!$ath){echo "Запис не змінився";}  	

header("location: naryadu.php?filter=".$script."");
?>