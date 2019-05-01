<?php
$fl=$_GET["fl"];
$mes=$_GET["mis"];
$rik=$_GET["rik"];
if($fl=='kil'){
$i=0;
$line='[';
for($k=1;$k<=3;$k++){
if($k==1) $brigada='Кременчук';
if($k==2) $brigada='Лубни';
if($k==3) $brigada='Миргород';
$sql = "SELECT COUNT(*) AS KL FROM zamovlennya,spr_nr 
WHERE DL='1' AND zamovlennya.KODP=spr_nr.KODP AND spr_nr.BR='$k' AND MONTH(D_PR)='$mes' AND zamovlennya.SZ='$rik' 
AND zamovlennya.KODP!='1400' AND zamovlennya.KODP!='1401' AND zamovlennya.KODP!='1402'";
//echo $sql;
$atu=mysql_query($sql);
  while($aut=mysql_fetch_array($atu))
 {
	if($i==0) $line.='["'.$brigada.'",'.$aut["KL"].']';
	else 
	$line.=',["'.$brigada.'",'.$aut["KL"].']';
	$i++;
}
mysql_free_result($atu);
}
$line.=']';

$p='<script type="text/javascript">
$(function(){
  line ='.$line.';
  $.jqplot ("zagalna", [line], 
    { 
	title: "Кількісь замовлень по філіям",
    seriesDefaults: {
    renderer: $.jqplot.PieRenderer, 
    rendererOptions: {showDataLabels: true, sliceMargin:8}
					}, 
    legend: { show:true, location: "e" }
    }
  );
});
</script>';
}

if($fl=='val'){
$i=0;
$line='[';
for($k=1;$k<=3;$k++){
if($k==1) $brigada='Кременчук';
if($k==2) $brigada='Лубни';
if($k==3) $brigada='Миргород';
$sql = "SELECT SUM(SUM) AS SM FROM zamovlennya,spr_nr 
WHERE DL='1' AND zamovlennya.KODP=spr_nr.KODP AND spr_nr.BR='$k' AND MONTH(DOKVUT)='$mes' AND zamovlennya.SZ='$rik' 
AND zamovlennya.KODP!='1400' AND zamovlennya.KODP!='1401' AND zamovlennya.KODP!='1402'";
//echo $sql;
$atu=mysql_query($sql);
  while($aut=mysql_fetch_array($atu))
 {
	if($i==0) $line.='["'.$brigada.'",'.$aut["SM"].']';
	else 
	$line.=',["'.$brigada.'",'.$aut["SM"].']';
	$i++;
}
mysql_free_result($atu);
}
$line.=']';

$p='<script type="text/javascript">
$(function(){
  line ='.$line.';
  $.jqplot ("zagalna", [line], 
    { 
	title: "Вал бюро по філіям",
    seriesDefaults: {
    renderer: $.jqplot.PieRenderer, 
    rendererOptions: {showDataLabels: true, sliceMargin:8}
					}, 
    legend: { show:true, location: "e" }
    }
  );
});
</script>';
}

$p.='<table border="0" align="center">
<tr><td colspan="2" align="center">
<div id="zagalna" style="height:500px;width:560px; "></div>
</td></tr>
</table>';
echo $p;
?>
