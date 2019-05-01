<?php
/* include "../function.php";
include "../scriptu.php"; */

$rik=date('y');
$mes=date('m');
//$dt_k=date('m.d.y');
$i=0;
$max=0;
$line1='[';
//AND SZ='$rik'
$sql = "SELECT SUM(SUM) AS SM,D_PR FROM zamovlennya 
WHERE DL='1' AND MONTH(D_PR)!='$mes' AND KODP<'1400' GROUP BY MONTH(D_PR)";
//echo $sql;
$atu=mysql_query($sql);
  while($aut=mysql_fetch_array($atu))
 {
	if($i==0) $line1.='["'.$aut["D_PR"].'",'.$aut["SM"].']';
	else 
	$line1.=',["'.$aut["D_PR"].'",'.$aut["SM"].']';
	$i++;
	if($max<$aut["SM"]) $max=$aut["SM"];
}
mysql_free_result($atu);
$line1.=']';
$max=$max+50000;
$sm_kas=0;
$i=0;
$line2='[';
//AND SD='$rik'
$sql = "SELECT SUM(SM) AS SM,SUM(SM_KM) AS SMKM,DT FROM kasa 
WHERE DL='1' AND MONTH(DT)!='$mes' GROUP BY MONTH(DT)";
//echo $sql;
$atu=mysql_query($sql);
  while($aut=mysql_fetch_array($atu))
 {	$sm_kas=$aut["SM"]+$aut["SMKM"];
 
	if($i==0) $line2.='["'.$aut["DT"].'",'.$sm_kas.']';
	else 
	$line2.=',["'.$aut["DT"].'",'.$sm_kas.']';
	$i++;
	if($max<$sm_kas) $max=$sm_kas;
	$sm_kas=0;
}
mysql_free_result($atu);
$line2.=']';

//echo $line1.'<br><br><br>';
//echo $line2.'<br>';

$p='<script type="text/javascript">
$(function(){
  line1='.$line1.';
  line2='.$line2.';
  
  $.jqplot("zagalna",
    [line1,line2],
           {
           	 title: "Загальний вал бюро",
           	 axes: {
           	 	yaxis: {
           	 		min:0, max:'.$max.'
           	 	 },
           	 	 xaxis: {
           	 	 	renderer:$.jqplot.DateAxisRenderer,
					 tickOptions:{formatString:"%d.%m.%y"}/*,
					min:"04.01.13",
					max:"'.$dt_k.'"					 */
           	 	 }
           	 },
           	 series: [
			   {lineWidth:4,color:"#006400",label:"Вал по прийнятих замовленнях"},
			   {lineWidth:4,color:"#000080",label:"Вал по сплачених замовленнях"}
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
<div id="zagalna" style="height:800px;width:1000px; "></div>
</td></tr>
</table>';
echo $p;
/* $tt=mail('bti_m@ukr.net','test','proverka', 'From:bti_m@ukr.net'); 
if(!$tt){ echo "Error";} */
//echo phpinfo();

/*  if (mail('bti_m@ukr.net', 'Письмо из скрипта', 'Привет, Василий! Как дела?')){
  echo 'Письмо успешно отправлено!';
 }else{
  echo 'При отправке письма возникла ошибка';
 } */

?>
