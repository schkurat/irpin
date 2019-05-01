<?php
include "scriptu.php";

$sz=$_GET['sz'];
$nz=$_GET['nz'];
$kl=$_GET['kl'];
?>

<form action="add_prdoc.php" name="myform" method="post">
<h1><b>Документи, що додаються до замовлення</b></h1>
<table align="" class=bordur>
<tr>
<td>Серія замовлення</td>
<td><input type="text" size="2" maxlength="2" name="szam" value="<?php echo $sz; ?>"/></td>
<td>Номер замовлення</td>
<td><input type="text" size="7" maxlength="7" name="nzam" value="<?php echo $nz; ?>"/>
<input type="hidden" name="kll" value="<?php echo $kl; ?>"/>
</td>
</tr>
<tr>
<td colspan="4">
<?php 
$sql2="SELECT PRDOC FROM zamovlennya WHERE zamovlennya.KEY='$kl' AND SZ='$sz' AND NZ='$nz' AND DL='1' AND VUD_ROB!=19";
$atu2=mysql_query($sql2);
  while($aut2=mysql_fetch_array($atu2))
 {
	$j=substr_count($aut2["PRDOC"],":");
	$ndoc=explode(":",$aut2["PRDOC"]);
 }
  mysql_free_result($atu2); 
 $kk="";
$sql = "SELECT * FROM pravo_doc ORDER BY ID_PRDOC"; 
 $atu=mysql_query($sql);
  while($aut=mysql_fetch_array($atu))
 {
	$id_doc=$aut["ID_PRDOC"];
	$doc=$aut["PRDOC"];
	for($i=0; $i<=$j; $i++){
	if($ndoc[$i]==$id_doc)$kk="checked"; }
	?>   
<input name="<?php echo $id_doc; ?>" type="checkbox" value="<?php echo $doc;?>"<?php echo $kk; ?>><?php echo $doc;?><br> 
<?php
	$kk="";
	}	
 mysql_free_result($atu); 

?>
<!--<input name="1" type="checkbox" value="Технічний паспорт">Технічний паспорт<br>
<input name="2" type="checkbox" value="Договір куплі-продажу">Договір куплі-продажу<br>
<input name="3" type="checkbox" value="Договір міни">Договір міни<br>
<input name="4" type="checkbox" value="Свідоцтво про право на спадщину">Свідоцтво про право на спадщину<br>
<input name="5" type="checkbox" value="Свідоцтво про право власності">Свідоцтво про право власності<br>
<input name="6" type="checkbox" value="Договір дарування">Договір дарування<br>-->
</td>
</tr>
<tr>
<td colspan="2" align="center"><input type="submit" id="submit" value="Додати"></td>
<td colspan="2" align="center">

<a href="zamovlennya.php?filter=zm_view.php">
<input name="cancel" type="button" value="Відміна"></a>

</td>
</tr>
</table>
</form>