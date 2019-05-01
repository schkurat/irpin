<?php
/* include "../function.php";
include "../scriptu.php"; */

$rik=date('y');
$mes=date('m');
//$dt_k=date('m.d.y');
$n_goda=/* date('Y'). */'2013-01-01';
$dt_seg=date('Y-m-d');
$i=0;
$max=0;

$sql1 = "SELECT RADA,ID FROM radu ORDER BY ID";
$atu1=mysql_query($sql1);
  while($aut1=mysql_fetch_array($atu1))
 {
	$id=$aut1["ID"];
	$rada[$id]=$aut1["RADA"];
	$line[$id]='[';
	
$sql = "SELECT COUNT(*) AS KL,DT,RADA FROM samovol 
WHERE DL='1' AND DT>='$n_goda' AND RADA='$id' AND MONTH(DT)!='$mes' GROUP BY MONTH(DT)";
//echo $sql;
$atu=mysql_query($sql);
  while($aut=mysql_fetch_array($atu))
 {
	if($i==0) $line[$id].='["'.$aut["DT"].'",'.$aut["KL"].']';
	else 
	$line[$id].=',["'.$aut["DT"].'",'.$aut["KL"].']';
	$i++;
	if($max<$aut["KL"]) $max=$aut["KL"];
}
mysql_free_result($atu);
$line[$id].=']';
$i=0;
}
mysql_free_result($atu1);


$max=$max+1;
/* echo $line[1].'<br>';
echo $line[2].'<br>';
echo $line[3].'<br>';
echo $line[4].'<br>';
echo $line[5].'<br>';
echo $line[6].'<br>'; */

for($i=1;$i<=$id;$i++){
//$temp=strlen($line[$i]);
if(strlen($line[$i])==2){
$line[$i]='[["'.$dt_seg.'",0]]';
}
}

$p='<script type="text/javascript">
$(function(){
  line1='.$line[1].';
  line2='.$line[2].';
  line3='.$line[3].';
  line4='.$line[4].';
  line5='.$line[5].';
  line6='.$line[6].';
  $.jqplot("zagalna",
    [line1,line2,line3,line4,line5,line6],
           {
           	 title: "Кількість виявлених самочинних побудов",
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
			   {lineWidth:4,color:"#006400",label:"'.$rada[1].'"},
			   {lineWidth:4,color:"#000080",label:"'.$rada[2].'"},
			   {lineWidth:4,color:"#00BFFF",label:"'.$rada[3].'"},
			   {lineWidth:4,color:"#7CFC00",label:"'.$rada[4].'"},
			   {lineWidth:4,color:"#FFFF00",label:"'.$rada[5].'"},
			   {lineWidth:4,color:"#CD5C5C",label:"'.$rada[6].'"}
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
?>
