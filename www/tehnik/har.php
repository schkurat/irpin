<?php
include_once "../function.php";

 $sql = "SELECT zamovlennya.SZ,zamovlennya.NZ,zamovlennya.RN,zamovlennya.NS,zamovlennya.VL,zamovlennya.BUD,
				zamovlennya.KVAR,rayonu.RAYON,nas_punktu.NSP,tup_nsp.TIP_NSP,zamovlennya.OBJ, 
				vulutsi.VUL,tup_vul.TIP_VUL
			 FROM zamovlennya, rayonu, nas_punktu, vulutsi, tup_nsp, tup_vul
				WHERE 
					zamovlennya.DL='1' AND zamovlennya.VUK='$vuk' AND zamovlennya.KEY='$kl_zm'   
					AND rayonu.ID_RAYONA=zamovlennya.RN
					AND nas_punktu.ID_NSP=zamovlennya.NS
					AND vulutsi.ID_VUL=zamovlennya.VL
					AND tup_nsp.ID_TIP_NSP=nas_punktu.ID_TIP_NSP
					AND tup_vul.ID_TIP_VUL=vulutsi.ID_TIP_VUL
					ORDER BY SZ, NZ DESC";
$atu=mysql_query($sql);
  while($aut=mysql_fetch_array($atu))
 {
$nr=$aut["RN"];
$ns=$aut["NS"];
$vl=$aut["VL"];
$bd=$aut["BUD"];
$kv=$aut["KVAR"];
$obj_ner=objekt_ner($aut["OBJ"],$aut["BUD"],$aut["KVAR"]);
$zakaz=$aut['SZ'].'/'.$aut['NZ'].' '.$aut['RAYON'].' '.$aut['TIP_NSP'].$aut['NSP'].' '.
$aut['TIP_VUL'].$aut['VUL'].' '.$obj_ner;
}
mysql_free_result($atu); 

$p='<table align="center"><tr bgcolor="#B5B5B5"><th>'.$zakaz.'</th></tr>
<tr bgcolor="#F4A460" align="center"><td>Раніше створені характеристики</td></tr>';

$k=0;
$sql="SELECT HAR FROM tehnik WHERE tehnik.DL='1' AND tehnik.NR='$nr' AND tehnik.NS='$ns' 
	AND tehnik.VL='$vl' AND tehnik.BD='$bd' AND tehnik.KV='$kv'";
$atu=mysql_query($sql);
  while($aut=mysql_fetch_array($atu))
 {	
if($aut["HAR"]!=""){
$poz=strpos($aut["HAR"],'HAR')+4;
$rez_obr=substr($aut["HAR"],$poz);
$p.='<tr bgcolor="#FFFAF0"><td id="zal" align="center"><a href="download_zm.php?hr='.$aut["HAR"].'">'.$rez_obr.'</a></td></tr>';
$k=1;}
}
mysql_free_result($atu);

if($k==0) $p.='<tr bgcolor="#FFFAF0"><td align="center">За даною адресою характеристики раніше не створювались!</td></tr>';
$p.='<tr bgcolor="#F4A460"><td align="center">Шаблон характеристики</td></tr>
<tr bgcolor="#FFFAF0"><td id="zal" align="center"><a href="download_sb.php?kl=har">Завантажити шаблон</a></td></tr>';

$p.='<tr bgcolor="#F4A460"><th>Вкажіть файл зі створеною характеристикою</th></tr>';
$p.='<form action="add_har.php" method="post" enctype="multipart/form-data">
<tr bgcolor="#FFFAF0"><td>
<input type="file" name="filename" size="40">
<input name="Ok" type="submit" value="Додати"/>
</td></tr></form>';
$p.='</table>';
echo $p; 
?>