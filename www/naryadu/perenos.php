<?php
include("../function.php");
$dt=$_GET["dt"];
$dt='01.'.$dt;
$dt=date_bd($dt);

$sql="SELECT KODP FROM n_ostatok WHERE DT='$dt'"; 
//echo $sql;
$atu=mysql_query($sql);
$num_rows=mysql_num_rows($atu);
if($num_rows!=0){
$ath=mysql_query("DELETE FROM n_ostatok WHERE DT='$dt'");
}
mysql_free_result($atu);

$sql1="SELECT * FROM saldo";
$atu1=mysql_query($sql1);
while($aut1=mysql_fetch_array($atu1)){
$sz=$aut1["SZ"];
$nz=$aut1["NZ"];
$deb=$aut1["DEB_K"];
$kre=$aut1["KRE_K"];
if($deb!=0 or $kre!=0){
$ath=mysql_query("INSERT INTO `kpbti`.`n_ostatok`(`SZ`,`NZ`,`DT`,`DEB`,`KRE`) 
	VALUES ('$sz','$nz','$dt','$deb','$kre')");}
}
mysql_free_result($atu1);
echo "Перенесення кінцевих залишків виконано!";
?>