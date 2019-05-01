<?php
include_once "../function.php";
$flag="";

if(isset($_GET['rejum'])) $rej=$_GET['rejum'];

if($rej=="seach"){
	if(isset($_GET['info'])){
		$info=$_GET['info'];
		$flag="(LOCATE('".$info."',nas_punktu.NSP)!=0 OR LOCATE('".$info."',vulutsi.VUL)!=0 
		OR LOCATE('".$info."',arhiv.N_SPR)!=0) AND";
	}
} 

$p='<table align="center" class="zmview">
<tr>
<th>Номер справи</th>
<th>Адреса</th>
</tr>';

$zz=0;

	$sql="SELECT arhiv.N_SPR,nas_punktu.NSP,tup_nsp.TIP_NSP,vulutsi.VUL,tup_vul.TIP_VUL,
	arhiv.BD,arhiv.KV FROM arhiv,nas_punktu,vulutsi,tup_nsp,tup_vul,arh_sec  
	WHERE ".$flag." arhiv.DL='1' 
	AND arhiv.N_SPR=arh_sec.N_SPR AND arh_sec.DL='1' 
	AND nas_punktu.ID_NSP=arhiv.NS 
	AND vulutsi.ID_VUL=arhiv.VL 
	AND tup_nsp.ID_TIP_NSP=nas_punktu.ID_TIP_NSP 
	AND tup_vul.ID_TIP_VUL=vulutsi.ID_TIP_VUL";
	$atu=mysql_query($sql);
	while($aut=mysql_fetch_array($atu))
	{
	$zz++;
	$nom_spr=$aut["N_SPR"];
	$obj_ner=objekt_ner(0,$aut["BD"],$aut["KV"]);
	$adr=$aut["TIP_NSP"].$aut["NSP"]." ".$aut["TIP_VUL"].$aut["VUL"]." ".$obj_ner;
	}
	mysql_free_result($atu);
	if($zz!=0){
	$p.='<tr>
	<td align="center">'.$nom_spr.'</td>
	<td id="zal"><a href="admin.php?filter=sprava_info&inv_spr='.$nom_spr.'">'.$adr.'</a></td>
    </tr>';
	}
	else{
	$p.='<tr>
	<td colspan="2">Не знайдено жодної справи!</td>
    </tr>';
	}


$p.='</table>';
echo $p; 
?>