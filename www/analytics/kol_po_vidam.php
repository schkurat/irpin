<?php
/* include "../function.php";
include "../scriptu.php"; */

$rik=date('y');
$mes=date('m');
//$dt_k=date('m.d.y');
$i=0;
$max=0;
//$line='[';
$sql1 = "SELECT document,id_oform FROM dlya_oformlennya ORDER BY id_oform";
$atu1=mysql_query($sql1);
  while($aut1=mysql_fetch_array($atu1))
 {
	$docum=$aut1["document"];
	$v_rob=$aut1["id_oform"];
	$line[$v_rob]='[';

//AND SZ='$rik'
$sql = "SELECT COUNT(*) AS KL,D_PR,VUD_ROB FROM zamovlennya 
WHERE DL='1' AND VUD_ROB='$v_rob' AND MONTH(D_PR)!='$mes' GROUP BY MONTH(D_PR)";
//echo $sql;
$atu=mysql_query($sql);
  while($aut=mysql_fetch_array($atu))
 {
	if($i==0) $line[$v_rob].='["'.$aut["D_PR"].'",'.$aut["KL"].']';
	else 
	$line[$v_rob].=',["'.$aut["D_PR"].'",'.$aut["KL"].']';
	$i++;
	if($max<$aut["KL"]) $max=$aut["KL"];
}
mysql_free_result($atu);
$line[$v_rob].=']';
$i=0;
}
mysql_free_result($atu1);


//$line.=']';
$max=$max+10;
/* echo $line[1].'<br>';
echo $line[2].'<br>';
echo $line[3].'<br>';
echo $line[4].'<br>';
echo $line[5].'<br>';
echo $line[6].'<br>';
echo $line[7].'<br>';
echo $line[8].'<br>';
echo $line[17].'<br>';
echo $line[18].'<br>';
echo $line[19].'<br>'; */
//echo $line[20].'<br>';
/* echo $line[21].'<br>'; */
//echo $line[22].'<br>';
/* echo $line[23].'<br>';
echo $line[24].'<br>';
echo $line[25].'<br>';
echo $line[26].'<br>'; */
//  line20='.$line[20].';
//line22='.$line[22].';
// {lineWidth:4,color:"#22e2c5",label:"Супроводження в розробці документації із землеустрою"},
// {lineWidth:4,color:"#ffe2c5",label:"Супроводження у виготовленні Обмінного файлу"},
$p='<script type="text/javascript">
$(function(){
  line1='.$line[1].';
  line2='.$line[2].';
  line3='.$line[3].';
  line4='.$line[4].';
  line5='.$line[5].';
  line6='.$line[6].';
  line7='.$line[7].';
  line8='.$line[8].';
 /* line17='.$line[17].';
  line18='.$line[18].';
  line19='.$line[19].';
  line21='.$line[21].';
  line23='.$line[23].';
  line24='.$line[24].';
  line25='.$line[25].';
  line26='.$line[26].';*/
  
  $.jqplot("zagalna",
    [line1,line2,line3,line4,line5,line6,line7,line8/* ,line17,line18,line19,line21,
		line23,line24,line25,line26 */],
           {
           	 title: "Прийняті замовлення по видам робіт",
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
			   {lineWidth:4,color:"#006400",label:"1 кімнатні квартири"},
			   {lineWidth:4,color:"#000080",label:"2 кімнатні квартири"},
			   {lineWidth:4,color:"#00BFFF",label:"3 кімнатні квартири"},
			   {lineWidth:4,color:"#7CFC00",label:"4 кімнатні квартири"},
			   {lineWidth:4,color:"#FFFF00",label:"Житлові будинки"},
			   {lineWidth:4,color:"#CD5C5C",label:"Гаражі"},
			   {lineWidth:4,color:"#A52A2A",label:"Садові будинки"},
			   {lineWidth:4,color:"#9400D3",label:"Нежитлові приміщення"}
			   /* ,
			   {lineWidth:4,color:"#8B8378",label:"Оцінка нерухомості"},
			   {lineWidth:4,color:"#8B008B",label:"Оформлення документів на об`єкт нерухомого майна"},
			   {lineWidth:4,color:"#1C1C1C",label:"Технічне обстеження"},
			   {lineWidth:4,color:"#008B8B",label:"Витяги з Державного земельного кадастру"},
			   {lineWidth:4,color:"#FFA500",label:"Присвоєння Кадастрового номера"},
			   {lineWidth:4,color:"#FFE7BA",label:"Оцінка земелі"},
			   {lineWidth:4,color:"#FF8247",label:"Присвоєння поштової адреси"},
			   {lineWidth:4,color:"#CAFF70",label:"Введення об`єкта в експлуатацію"} */
           	 ],
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
