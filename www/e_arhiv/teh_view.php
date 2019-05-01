<?php
include_once "../function.php";

$fl=$_GET['fl'];
if($fl=='id'){
$kl_zm=$_GET['kl_zm'];
$filter=" zamovlennya.KEY='$kl_zm' ";
}
if($fl=='zm'){
$szam=$_GET['szam'];
$nzam=$_GET['nzam'];
$filter=" zamovlennya.SZ='$szam' AND zamovlennya.NZ='$nzam' ";
}
if($fl=='adr'){
$ray=$_GET['rajon'];
$nsp=$_GET['nsp'];
$vyl=$_GET['vyl'];
$dud=$_GET['bud'];
$kvar=$_GET['kvar'];
$filter=" zamovlennya.RN='$ray' AND zamovlennya.NS='$nsp' AND zamovlennya.VL='$vyl' AND zamovlennya.BUD='$bud' 
AND zamovlennya.KVAR='$kvar' ";
}

$p_e.='';
$p_h.='';
$p_p.='';
$p_z.='';

 $sql = "SELECT zamovlennya.SZ,zamovlennya.NZ,zamovlennya.RN,zamovlennya.NS,zamovlennya.VL,zamovlennya.BUD,
				zamovlennya.KVAR,rayonu.RAYON,nas_punktu.NSP,tup_nsp.TIP_NSP,zamovlennya.OBJ, 
				vulutsi.VUL,tup_vul.TIP_VUL
			 FROM zamovlennya, rayonu, nas_punktu, vulutsi, tup_nsp, tup_vul
				WHERE 
					zamovlennya.DL='1' AND ".$filter."   
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

$p='<table align="center"><tr bgcolor="#B5B5B5"><th>'.$zakaz.'</th></tr>';
$p_e.='<tr bgcolor="#F4A460" align="center"><td>Експлікації</td></tr>';
$p_h.='<tr bgcolor="#F4A460" align="center"><td>Характеристики</td></tr>';
$p_p.='<tr bgcolor="#F4A460" align="center"><td>По поверхові плани</td></tr>';
$p_z.='<tr bgcolor="#F4A460" align="center"><td>Плани земельної ділянки</td></tr>';

$k_e=0;
$k_h=0;
$k_p=0;
$k_z=0;
$sql="SELECT EKS,HAR,POET,POET_BAK,ZEMLYA,ZEMLYA_BAK FROM tehnik WHERE tehnik.DL='1' AND tehnik.NR='$nr' AND tehnik.NS='$ns' 
	AND tehnik.VL='$vl' AND tehnik.BD='$bd' AND tehnik.KV='$kv'";
$atu=mysql_query($sql);
  while($aut=mysql_fetch_array($atu))
 {
if($aut["EKS"]!=""){
$poz=strpos($aut["EKS"],'EKS')+4;
$rez_obr=substr($aut["EKS"],$poz);
$p_e.='<tr bgcolor="#FFFAF0"><td id="zal" align="center"><a href="download_zm.php?hr='.$aut["EKS"].'">'.$rez_obr.'</a></td></tr>';
$k_e=1;}
if($aut["HAR"]!=""){
$poz=strpos($aut["HAR"],'HAR')+4;
$rez_obr=substr($aut["HAR"],$poz);
$p_h.='<tr bgcolor="#FFFAF0"><td id="zal" align="center"><a href="download_zm.php?hr='.$aut["HAR"].'">'.$rez_obr.'</a></td></tr>';
$k_h=1;}
if($aut["POET"]!=""){
$poz=strpos($aut["POET"],'POET')+5;
$rez_obr=substr($aut["POET"],$poz);
$p_p.='<tr bgcolor="#FFFAF0"><td id="zal" align="center"><a href="download_zm.php?hr='.$aut["POET"].'">'.$rez_obr.'</a></td></tr>';
$p_p.='<tr bgcolor="#FFFAF0"><td id="zal" align="center"><a href="download_zm.php?hr='.$aut["POET_BAK"].'">'.$rez_obr.' - допоміжний файл</a></td></tr>';
$k_p=1;}
if($aut["ZEMLYA"]!=""){
$poz=strpos($aut["ZEMLYA"],'ZEMLYA')+7;
$rez_obr=substr($aut["ZEMLYA"],$poz);
$p_z.='<tr bgcolor="#FFFAF0"><td id="zal" align="center"><a href="download_zm.php?hr='.$aut["ZEMLYA"].'">'.$rez_obr.'</a></td></tr>';
$p_z.='<tr bgcolor="#FFFAF0"><td id="zal" align="center"><a href="download_zm.php?hr='.$aut["ZEMLYA_BAK"].'">'.$rez_obr.' - допоміжний файл</a></td></tr>';
$k_z=1;}
}
mysql_free_result($atu);

if($k_e==0) $p_e.='<tr bgcolor="#FFFAF0"><td align="center">За даною адресою експлікації раніше не створювались!</td></tr>';
if($k_h==0) $p_h.='<tr bgcolor="#FFFAF0"><td align="center">За даною адресою характеристики раніше не створювались!</td></tr>';
if($k_p==0) $p_p.='<tr bgcolor="#FFFAF0"><td align="center">За даною адресою по поверхові плани раніше не створювались!</td></tr>';
if($k_z==0) $p_z.='<tr bgcolor="#FFFAF0"><td align="center">За даною адресою план земельної ділянки раніше не створювавсь!</td></tr>';

$p.=$p_e.$p_h.$p_p.$p_z;
$p.='</table>';
echo $p; 
?>