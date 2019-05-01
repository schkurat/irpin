<?php
include("../function.php");
$id=$_GET["id"];
$path=$_GET["path"];
if(isset($_GET['dat'])) $dat=date_bd($_GET['dat']); else $dat="";
if(isset($_GET['zamov'])) $zm=$_GET['zamov']; else $zm="";
if(isset($_GET['tip'])) $tip=$_GET['tip']; else $tip="";
if(isset($_GET['sum'])) $sum=$_GET['sum']; else $sum="";
if(isset($_GET['sum_km'])) $sum_km=$_GET['sum_km']; else $sum_km="";
if(isset($_GET['prim'])) $prim=$_GET['prim']; else $prim="";

$ath=mysql_query("UPDATE temp_kasa SET DATE='$dat',SUM='$sum',SUM_KM='$sum_km',NZ='$zm',TIP='$tip',PRIM='$prim'
	WHERE temp_kasa.ID='$id'");
if(!$ath){echo "Запис не змінився";}  	
header("location: naryadu.php?filter=obrobka2&path=".$path."");
//header("location: obrobka.php");
?>