<?php
/* include "../function.php";
include "../scriptu.php"; */

$rik=date('y');
$mes=date('m');
$i=0;
$max=0;
$line1='[';
//AND SZ='$rik'
$sql = "SELECT COUNT(*) AS KL,D_PR FROM zamovlennya WHERE DL='1'  
AND MONTH(D_PR)!='$mes' GROUP BY MONTH(D_PR)";
$atu=mysql_query($sql);
  while($aut=mysql_fetch_array($atu))
 {
	if($i==0) $line1.='["'.$aut["D_PR"].'",'.$aut["KL"].']';
	else 
	$line1.=',["'.$aut["D_PR"].'",'.$aut["KL"].']';
	$i++;
	if($max<$aut["KL"]) $max=$aut["KL"];
}
mysql_free_result($atu);
$line1.=']';
$max=$max+100;
//echo $line1;
//---------fiz i yur zakazu-----------
$i=0;
$max2=0;
$line2='[';
//AND SZ='$rik'
$sql = "SELECT COUNT(*) AS KL,D_PR FROM zamovlennya WHERE DL='1' AND TUP_ZAM=1  
AND MONTH(D_PR)!='$mes' GROUP BY MONTH(D_PR)";
$atu=mysql_query($sql);
  while($aut=mysql_fetch_array($atu))
 {
	if($i==0) $line2.='["'.$aut["D_PR"].'",'.$aut["KL"].']';
	else 
	$line2.=',["'.$aut["D_PR"].'",'.$aut["KL"].']';
	$i++;
	if($max2<$aut["KL"]) $max2=$aut["KL"];
}
mysql_free_result($atu);
$line2.=']';
$max2=$max2+100;
//--
$i=0;
$max3=0;
$line3='[';
//AND SZ='$rik'
$sql = "SELECT COUNT(*) AS KL,D_PR FROM zamovlennya WHERE DL='1' AND TUP_ZAM=2  
AND MONTH(D_PR)!='$mes' GROUP BY MONTH(D_PR)";
$atu=mysql_query($sql);
  while($aut=mysql_fetch_array($atu))
 {
	if($i==0) $line3.='["'.$aut["D_PR"].'",'.$aut["KL"].']';
	else 
	$line3.=',["'.$aut["D_PR"].'",'.$aut["KL"].']';
	$i++;
	if($max3<$aut["KL"]) $max3=$aut["KL"];
}
mysql_free_result($atu);
$line3.=']';
$max3=$max3+5;
//------------------------------------
$p='<script type="text/javascript">
$(function(){
  line1 ='.$line1.';
  $.jqplot("zagalna",
           [line1],
           {
           	 title: "Загальна кількість замовлень",
           	 axes: {
           	 	yaxis: {
           	 		min:0, max:'.$max.'
           	 	 },
           	 	 xaxis: {
           	 	 	renderer:$.jqplot.DateAxisRenderer,
					 tickOptions:{formatString:"%d.%m.%y"}
           	 	 }
           	 },
           	 series: [
			   {lineWidth:4,color:"#4bb2c5",label:"Замовлення"}
           	 ],
			seriesDefaults: { 
				showMarker:false,
				pointLabels: { show:true } 
			},
           	 legend: {
           	 	show: true,
           	 	location: "nw",
           	 	xoffset: 12,
           	 	yoffset: 12 }
           }
          );
});
</script>';

$p.='<script type="text/javascript">
$(function(){
  line2 ='.$line2.';
  $.jqplot("fiz",
           [line2],
           {
           	 title: "Кількість замовлень фізичних осіб",
           	 axes: {
           	 	yaxis: {
           	 		min:0, max:'.$max2.'
           	 	 },
           	 	 xaxis: {
           	 	 	renderer:$.jqplot.DateAxisRenderer,
					 tickOptions:{formatString:"%d.%m.%y"}
           	 	 }
           	 },
           	 series: [
			   {lineWidth:4,color:"#839557",label:"Фізичні"}
           	 ],
			seriesDefaults: { 
				showMarker:false,
				pointLabels: { show:true } 
			},
           	 legend: {
           	 	show: true,
           	 	location: "nw",
           	 	xoffset: 12,
           	 	yoffset: 12 }
           }
          );
});
</script>';

$p.='<script type="text/javascript">
$(function(){
  line3 ='.$line3.';
  $.jqplot("yur",
           [line3],
           {
           	 title: "Кількість замовлень юридичних осіб",
           	 axes: {
           	 	yaxis: {
           	 		min:0, max:'.$max3.'
           	 	 },
           	 	 xaxis: {
           	 	 	renderer:$.jqplot.DateAxisRenderer,
					 tickOptions:{formatString:"%d.%m.%y"}
           	 	 }
           	 },
           	 series: [
			   {lineWidth:4,color:"#EAA228",label:"Юридичні"}
           	 ],
			seriesDefaults: { 
				showMarker:false,
				pointLabels: { show:true } 
			},
           	 legend: {
           	 	show: true,
           	 	location: "nw",
           	 	xoffset: 12,
           	 	yoffset: 12 }
           }
          );
});
</script>';

$p.='<table border="0" align="center">
<tr><td colspan="2" align="center">
<div id="zagalna" style="height:300px;width:600px; "></div>
</td></tr>
<tr><td>
<div id="fiz" style="height:300px;width:500px; "></div>
</td><td>
<div id="yur" style="height:300px;width:500px; "></div>
</td></tr>
</table>';
echo $p;
?>
