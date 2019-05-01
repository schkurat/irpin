<style type="text/css">
td,th{
	border:1px solid lightgrey;
	padding:0px 5px;
}
</style>
<?php
session_start();
$lg=$_SESSION['LG'];
$pas=$_SESSION['PAS'];

include "../function.php";

$bdat=date_bd($_POST['date1']);
$edat=date_bd($_POST['date2']);
$flg=$_POST['flag'];

$db=mysql_connect("localhost",$lg,$pas);
if(!$db) echo "Не вiдбулося зєднання з базою даних";
  
 if(!@mysql_select_db(kpbti,$db))
  {
   echo("Не завантажена таблиця");
   exit(); 
   }

$p='<b>Період: з  '.german_date($bdat).' по '.german_date($edat).'</b>
	<table style="border-collapse: collapse;font-size:13px; border:1px solid lightgrey;"><tr>
	<th>Замовлення</th>
	<th>Замовник</th>
	<th>Вид робіт</th>
	<th>Адреса</th>
	<th>Телефон</th>
	<th>Виконавець</th>
	<th>Дата оплати</th>
	<th>Статус</th>
	</tr>';

if($flg=="reestr"){ 
$vukonavets=$_POST['isp'];
$kr_fl="AND zamovlennya.D_PR>='$bdat' AND zamovlennya.D_PR<='$edat' 
	AND zamovlennya.VUK='$vukonavets'";
}
if($flg=="vid_rob"){ 
$vidr=$_POST['vidr'];
$kr_fl="AND zamovlennya.D_PR>='$bdat' AND zamovlennya.D_PR<='$edat' 
	AND zamovlennya.VUD_ROB='$vidr'";
}
if($flg=="vukon"){ 
$kr_fl="AND zamovlennya.DATA_PS>='$bdat' AND zamovlennya.DATA_PS<='$edat' AND zamovlennya.PS='1' AND zamovlennya.VUD_ROB>20";
}
if($flg=="nespl"){ 
$kr_fl="AND zamovlennya.D_PR>='$bdat' AND zamovlennya.D_PR<='$edat' AND zamovlennya.DOKVUT='0000-00-00' AND zamovlennya.VUD_ROB>20";
}

$sql="SELECT zamovlennya.*,dlya_oformlennya.document,nas_punktu.NSP,tup_nsp.TIP_NSP,
		vulutsi.VUL,tup_vul.TIP_VUL  
		FROM zamovlennya, nas_punktu, vulutsi, tup_nsp, tup_vul, dlya_oformlennya
		WHERE
		zamovlennya.DL='1' 
		".$kr_fl." 
		AND nas_punktu.ID_NSP=zamovlennya.NS
		AND vulutsi.ID_VUL=zamovlennya.VL
		AND tup_nsp.ID_TIP_NSP=nas_punktu.ID_TIP_NSP
		AND tup_vul.ID_TIP_VUL=vulutsi.ID_TIP_VUL
		AND dlya_oformlennya.id_oform=zamovlennya.VUD_ROB
		ORDER BY zamovlennya.KEY";			

 $atu=mysql_query($sql);  
  while($aut=mysql_fetch_array($atu))
 {
/* if($aut1["BUD"]!="") $bud="буд.".$aut1["BUD"]; else $bud="";
if($aut1["KVAR"]!="") $kvar="кв.".$aut1["KVAR"]; else $kvar="";

$zakaz=$aut1["SZ"].'/'.$aut1["NZ"];

	$pr=$aut1["PR"];
	$im=$aut1["IM"];
    $pb=$aut1["PB"]; 
	$ns=$aut1["NSP"];
	$tns=$aut1["TIP_NSP"];
	$vl=$aut1["VUL"];
	$tvl=$aut1["TIP_VUL"];
	$vud_rob=$aut1["document"];
	
$adres=$tns.' '.$ns.' '.$tvl.' '.$vl.' '.$bud.' '.$kvar;
$fio=$pr.' '.$im.' '.$pb;
$tel=$aut1["TEL"];
$vukon=$aut1["VUK"];
if($vukon=="") $vukon="-";
if($tel=="") $tel="-";
if($aut1["PS"]=='1') $pidpus='так';
else $pidpus='ні'; */
$dt_opl=german_date($aut["DOKVUT"]);
//$zakaz=$aut["SZ"].'/'.$aut["NZ"];
$nree=$aut["NREE"];
$obj_ner=objekt_ner(0,$aut["BUD"],$aut["KVAR"]);
$adres=$aut["TIP_NSP"].$aut["NSP"]." ".$aut["TIP_VUL"].$aut["VUL"]." ".$obj_ner;
if($aut["PS"]=='1') {$status='виконане'; $dt_stat=german_date($aut["DATA_PS"]);}
elseif($aut["PS"]=='0' and $aut["D_STOP"]=='0000-00-00') {$status='в роботі'; $dt_stat='';}
elseif($aut["D_STOP"]!='0000-00-00') {$status='призупинено'; $dt_stat=german_date($aut["D_STOP"]);}

/* 	$p.='<tr>
	<td align="center"><font size="2">'.$zakaz.'</font></td>
	<td><font size="2">'.$adres.'</td>
	<td align="center"><font size="2">'.$vud_rob.'</font></td>
	<td align="center"><font size="2">'.$fio.'</font></td>
	<td align="center"><font size="2">'.german_date($aut1["D_PR"]).'</font></td>
	<td align="center"><font size="2">'.german_date($aut1["DATA_GOT"]).'</font></td>
	<!--<td align="center"><font size="2">'.$d_taks.'</font></td>-->
	<td align="center"><font size="2">'.$vukon.'</font></td>
	<td align="center"><font size="2">'.$aut1["PR_OS"].'</font></td>
	<td align="center"><font size="2">'.$tel.'</font></td>
	<td align="center"><font size="2">'.$pidpus.'</font></td>
	</tr>';	 */
	$p.='<tr>
	<td align="center">№ '.$nree.'</br>від '.german_date($aut["D_PR"]).'</td>
    <td align="center">'.$aut["PR"]." ".$aut["IM"]." ".$aut["PB"].'</td>
	<td align="center">'.$aut["document"].'</td>
	<td align="center">'.$adres.'</td>
    <td align="center">'.$aut["TEL"].'</td>
    <td align="center">'.$aut["VUK"].'</td>
	<td align="center">'.$dt_opl.'</td>
	<td align="center">'.$status.'</br>'.$dt_stat.'</td>
    </tr>';
 } 
 mysql_free_result($atu);  
 $p.='</table>';
 echo $p;
if(mysql_close($db))
        {
        // echo("Закриття бази даних");
         }
         else
         {
          echo("Не можливо виконати закриття бази"); 
          }		  
?>