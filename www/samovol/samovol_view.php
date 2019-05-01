<?php
include_once "../function.php";
	$flag="";

if(isset($_GET['srt'])) $sort=$_GET['srt'];
else $sort="NPP";

$rej=$_GET['rejum'];
if ($rej=="seach"){
$rjs=$_GET['rj_saech'];
switch($rjs) 
{
   case "npp": 
	$flag="NPP=".$_GET['n_pp'];
   break;
   case "adr": 
   if($_GET['bud']!="" AND $_GET['kv']!="")
	$flag="NS='".$_GET['nsp']."' AND VL='".$_GET['vyl']."' AND BD='".$_GET['bud']."' AND KV='".$_GET['kv']."'";
	else{
	if($_GET['bud']=="" AND $_GET['kv']!="")
	$flag="NS='".$_GET['nsp']."' AND VL='".$_GET['vyl']."' AND KV='".$_GET['kv']."'";
	else{
		if($_GET['bud']=="" AND $_GET['kv']=="")
	$flag="NS='".$_GET['nsp']."' AND VL='".$_GET['vyl']."'";
	else
	$flag="NS='".$_GET['nsp']."' AND VL='".$_GET['vyl']."' AND BD='".$_GET['bud']."'";
	}
	}
   break;
   case "hpor": 
	$flag="LOCATE('".$_GET['por']."',POR)!=0";
	break;
	case "priz": 
	$flag="LOCATE('".$_GET['pr']."',PR)!=0";
	break;
	case "in_n": 
	$flag="LOCATE('".$_GET['inv']."',IN_N)!=0";
	break;
   case "prim": 
	$flag="LOCATE('".$_GET['prum']."',PRIM)!=0";
	break;
}
}

$p='<table align="center" 	class="zmview">
<tr bgcolor="#B5B5B5">
<th colspan="2">#</th>
<th id="zal"><a href="samovol.php?filter=samovol_view&rejum=view&srt=NPP" style="color: white;">№</a></th>
<th id="zal"><a href="samovol.php?filter=samovol_view&rejum=view&srt=DT" style="color: white;">Дата</a></th>
<th id="zal"><a href="samovol.php?filter=samovol_view&rejum=view&srt=NS" style="color: white;">Нас. пункт</a></th>
<th id="zal"><a href="samovol.php?filter=samovol_view&rejum=view&srt=VL" style="color: white;">Вул.</a></th>
<th id="zal"><a href="samovol.php?filter=samovol_view&rejum=view&srt=BD" style="color: white;">Буд.</a></th>
<th id="zal"><a href="samovol.php?filter=samovol_view&rejum=view&srt=KV" style="color: white;">Кв.</a></th>
<th id="zal"><a href="samovol.php?filter=samovol_view&rejum=view&srt=POR" style="color: white;">Характер порушення</a></th>
<th id="zal"><a href="samovol.php?filter=samovol_view&rejum=view&srt=PR" style="color: white;">ПІБ</a></th>
<th id="zal"><a href="samovol.php?filter=samovol_view&rejum=view&srt=PRIM" style="color: white;">Відмітка</a></th>
<th id="zal"><a href="samovol.php?filter=samovol_view&rejum=view&srt=IN_N" style="color: white;">Інв.№</a></th>
</tr>';
if($flag==""){
$sql="SELECT samovol.ID,samovol.NPP,samovol.DT,samovol.BD,samovol.KV,samovol.POR,samovol.PR,
		samovol.IM,samovol.PB,samovol.PRIM,samovol.IN_N,nas_punktu.NSP,
		tup_nsp.TIP_NSP,vulutsi.VUL,tup_vul.TIP_VUL 
	FROM samovol,nas_punktu,vulutsi,tup_nsp,tup_vul 
	WHERE  
	nas_punktu.ID_NSP=samovol.NS
	AND vulutsi.ID_VUL=samovol.VL
	AND tup_nsp.ID_TIP_NSP=nas_punktu.ID_TIP_NSP
	AND tup_vul.ID_TIP_VUL=vulutsi.ID_TIP_VUL
	AND DL='1' ORDER BY ".$sort." DESC LIMIT 30";
}
else{
$sql="SELECT samovol.ID,samovol.NPP,samovol.DT,samovol.BD,samovol.KV,samovol.POR,samovol.PR,
		samovol.IM,samovol.PB,samovol.PRIM,samovol.IN_N,nas_punktu.NSP,
		tup_nsp.TIP_NSP,vulutsi.VUL,tup_vul.TIP_VUL 
	FROM samovol,nas_punktu,vulutsi,tup_nsp,tup_vul 
	WHERE 
	nas_punktu.ID_NSP=samovol.NS
	AND vulutsi.ID_VUL=samovol.VL
	AND tup_nsp.ID_TIP_NSP=nas_punktu.ID_TIP_NSP
	AND tup_vul.ID_TIP_VUL=vulutsi.ID_TIP_VUL
	AND DL='1' AND ".$flag;
	
}
//echo $sql;
 $atu=mysql_query($sql);
  while($aut=mysql_fetch_array($atu))
{	
$pib=$aut["PR"].' '.$aut["IM"].' '.$aut["PB"];
$p.='<tr bgcolor="#FFFAF0">
<td align="center"><a href="samovol.php?filter=edit_info&id_zp='.$aut["ID"].'"><img src="../images/b_edit.png" border="0"></a></td>
<td align="center"><a href="samovol.php?filter=delete_zap&id_zp='.$aut["ID"].'"><img src="../images/b_drop.png" border="0"></a></td>
	<td align="center">'.$aut["NPP"].'</td>
      <td align="center">'.german_date($aut["DT"]).'</td>
      <td align="left">'.$aut["TIP_NSP"].$aut["NSP"].'</td>
	  <td align="left">'.$aut["TIP_VUL"].$aut["VUL"].'</td>
	  <td align="center">'.$aut["BD"].'</td>
	  <td align="center">'.$aut["KV"].'</td>
	  <td align="left">'.$aut["POR"].'</td>
	  <td align="left">'.$pib.'</td>
	  <td align="left">'.$aut["PRIM"].'</td>
	  <td align="center">'.$aut["IN_N"].'</td>
      </tr>';
}
mysql_free_result($atu);
$p.='</table>';
echo $p; 
?>