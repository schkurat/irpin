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
$kat='ea';
if ($dh = opendir($kat)) {
    while (false !== ($file = readdir($dh))) { 
    if ($file != "." && $file != "..") { 
	//$p.='<tr><td>'.$file.'</td></tr>';	
	$sql="SELECT nas_punktu.NSP,tup_nsp.TIP_NSP,vulutsi.VUL,tup_vul.TIP_VUL,arhiv.BD,arhiv.KV 
	FROM arhiv,nas_punktu,vulutsi,tup_nsp,tup_vul 
	WHERE ".$flag." arhiv.DL='1' AND arhiv.N_SPR=".$file." 
	AND nas_punktu.ID_NSP=arhiv.NS 
	AND vulutsi.ID_VUL=arhiv.VL 
	AND tup_nsp.ID_TIP_NSP=nas_punktu.ID_TIP_NSP 
	AND tup_vul.ID_TIP_VUL=vulutsi.ID_TIP_VUL";
	$atu=mysql_query($sql);
	while($aut=mysql_fetch_array($atu))
	{
	$zz++;
	$obj_ner=objekt_ner(0,$aut["BD"],$aut["KV"]);
	$adr=$aut["TIP_NSP"].$aut["NSP"]." ".$aut["TIP_VUL"].$aut["VUL"]." ".$obj_ner;
	}
	mysql_free_result($atu);
	if($zz!=0){
	$p.='<tr>
	<td align="center">'.$file.'</td>
	<td id="zal"><a href="earhiv.php?filter=spr_view&inv_spr='.$file.'">'.$adr.'</a></td>
    </tr>';
	}
	else{
	$p.='<tr>
	<td colspan="2">Не знайдено жодної справи!</td>
    </tr>';
	}
    } 
    }
        closedir($dh);
}


$p.='</table>';
echo $p; 
?>