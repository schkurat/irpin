<?php
session_start();
$lg=$_SESSION['LG'];
$pas=$_SESSION['PAS'];

include_once "../function.php";
$kl=$_GET['kl'];
$tz=$_GET['tz'];

$db=mysql_connect("localhost",$lg,$pas);
if(!$db) echo "Не вiдбулося зєднання з базою даних";
  
 if(!@mysql_select_db(kpbti,$db))
  {
   echo("Не завантажена таблиця");
   exit(); 
   }
$zamena='<w:proofErr w:type="spellStart"/><w:tr wsp:rsidR="000E2E56" wsp:rsidRPr="00125377" wsp:rsidTr="00E56680"><w:trPr><w:cantSplit/><w:trHeight w:val="199"/></w:trPr><w:tc><w:tcPr><w:tcW w:w="355" w:type="dxa"/><w:vAlign w:val="center"/></w:tcPr><w:p wsp:rsidR="000E2E56" wsp:rsidRPr="000E2E56" wsp:rsidRDefault="000E2E56" wsp:rsidP="000E2E56"><w:pPr><w:rPr><w:sz w:val="20"/><w:sz-cs w:val="20"/><w:lang w:val="EN-US"/></w:rPr></w:pPr><w:r><w:rPr><w:sz w:val="20"/><w:sz-cs w:val="20"/><w:lang w:val="EN-US"/></w:rPr><w:t>nomer</w:t></w:r><w:proofErr w:type="spellEnd"/></w:p></w:tc><w:proofErr w:type="spellStart"/><w:tc><w:tcPr><w:tcW w:w="8820" w:type="dxa"/><w:vAlign w:val="center"/></w:tcPr><w:p wsp:rsidR="000E2E56" wsp:rsidRPr="000E2E56" wsp:rsidRDefault="000E2E56" wsp:rsidP="000E2E56"><w:pPr><w:rPr><w:sz w:val="20"/><w:sz-cs w:val="20"/><w:lang w:val="EN-US"/></w:rPr></w:pPr><w:r><w:rPr><w:sz w:val="20"/><w:sz-cs w:val="20"/><w:lang w:val="EN-US"/></w:rPr><w:t>adresa</w:t></w:r><w:proofErr w:type="spellEnd"/></w:p></w:tc><w:proofErr w:type="spellStart"/><w:tc><w:tcPr><w:tcW w:w="1440" w:type="dxa"/><w:vAlign w:val="center"/></w:tcPr><w:p wsp:rsidR="000E2E56" wsp:rsidRPr="000E2E56" wsp:rsidRDefault="000E2E56" wsp:rsidP="000E2E56"><w:pPr><w:jc w:val="right"/><w:rPr><w:sz w:val="20"/><w:sz-cs w:val="20"/><w:lang w:val="UK"/></w:rPr></w:pPr><w:r wsp:rsidRPr="00905240"><w:rPr><w:lang w:val="EN-US"/></w:rPr><w:t>sbpdv</w:t></w:r><w:proofErr w:type="spellEnd"/></w:p></w:tc></w:tr>';
$zamena_new='';
$vstavka='<w:p wsp:rsidR="00187487" wsp:rsidRPr="00C52EBC" wsp:rsidRDefault="00C52EBC" wsp:rsidP="00C52EBC"><w:pPr><w:rPr><w:sz w:val="20"/><w:sz-cs w:val="20"/><w:lang w:val="UK"/></w:rPr></w:pPr><w:r><w:rPr><w:sz w:val="20"/><w:sz-cs w:val="20"/><w:lang w:val="UK"/></w:rPr><w:t>     </w:t></w:r><w:proofErr w:type="spellStart"/><w:r wsp:rsidR="00187487" wsp:rsidRPr="00C52EBC"><w:rPr><w:sz w:val="20"/><w:sz-cs w:val="20"/></w:rPr><w:t>adresa</w:t></w:r><w:proofErr w:type="spellEnd"/></w:p>';
$vstavka_new='';
if($tz==2){

$sql = "SELECT zamovlennya.*,dlya_oformlennya.document,rayonu.RAYON,nas_punktu.NSP, tup_nsp.TIP_NSP,
		yur_kl.ADRES,dlya_oformlennya.id_oform,vulutsi.VUL,tup_vul.TIP_VUL,
		zamovlennya.SZ,zamovlennya.NZ,yur_kl.PILGA 
		FROM zamovlennya,rayonu,nas_punktu, vulutsi, tup_nsp, tup_vul, dlya_oformlennya,yur_kl 
		WHERE 
			zamovlennya.KEY='$kl' AND zamovlennya.EDRPOU=yur_kl.EDRPOU 
			AND zamovlennya.DL='1' AND dlya_oformlennya.id_oform=zamovlennya.VUD_ROB
			AND rayonu.ID_RAYONA=RN AND nas_punktu.ID_NSP=NS AND vulutsi.ID_VUL=VL
			AND tup_nsp.ID_TIP_NSP=nas_punktu.ID_TIP_NSP
			AND tup_vul.ID_TIP_VUL=vulutsi.ID_TIP_VUL";
$patterns1[0] = "[nomer]";
$patterns1[1] = "[adresa]";
$patterns1[2] = "[sbpdv]";				
}
else{
$sql = "SELECT zamovlennya.*,dlya_oformlennya.document,rayonu.RAYON,nas_punktu.NSP, tup_nsp.TIP_NSP,
		dlya_oformlennya.id_oform,vulutsi.VUL,tup_vul.TIP_VUL,zamovlennya.SZ,zamovlennya.NZ
		FROM zamovlennya, rayonu,nas_punktu, vulutsi, tup_nsp, tup_vul, dlya_oformlennya
		WHERE 
		zamovlennya.KEY='$kl' 
		AND zamovlennya.DL='1' AND dlya_oformlennya.id_oform=zamovlennya.VUD_ROB
		AND rayonu.ID_RAYONA=RN AND nas_punktu.ID_NSP=NS AND vulutsi.ID_VUL=VL
		AND tup_nsp.ID_TIP_NSP=nas_punktu.ID_TIP_NSP
		AND tup_vul.ID_TIP_VUL=vulutsi.ID_TIP_VUL";
}

$i=1;
$pilga=0;
$atu=mysql_query($sql);
while($aut=mysql_fetch_array($atu))
{
$s_rah=0;
$b_rn=p_buk($aut["RAYON"]);
$t_zak=$aut["TUP_ZAM"];
$dtzak=german_date($aut["D_PR"]);
$dtk=$dtzak;//date("d.m.Y");
$vidrob=$aut["document"];
$kod_rob=$aut["id_oform"];
$namerob='Виконання робіт з технічної інвентаризації об`єктів нерухомого майна:';
if($aut["BUD"]!="") $bud="буд.".$aut["BUD"]; else $bud="";
if($aut["KVAR"]!="") $kvar="кв.".$aut["KVAR"]; else $kvar="";
$adresa=$aut["TIP_NSP"].' '.$aut["NSP"].' '.$aut["TIP_VUL"].' '.$aut["VUL"].' '.$bud.' '.$kvar;
if($aut["DOKVUT"]=='0000-00-00' AND $aut["SUM_D"]==0) $s_rah=$aut["SUM"];
if($aut["SUM_D"]!=0) $s_rah=$aut["SUM_D"];
$sum=number_format(($sum+$s_rah),2,'.','');
if($t_zak==1){
$zamovnuk=$aut["PR"].' '.p_buk($aut["IM"]).'.'.p_buk($aut["PB"]).'.';
$zakaz=$aut["SZ"].'/'.$aut["NZ"].'/'.$b_rn;
$datavuh=german_date($aut["DATA_VUH"]);
$datagot=german_date($aut["DATA_GOT"]);
}
else {
$zakaz=$aut["SZ"].'/'.$aut["NZ"].'/'.$b_rn;
$nrah=$aut["SZ"].'/'.$aut["NZ"].'/'.$b_rn;
$zamovnuk=$aut["PR"];
$adr_reestr=$aut["ADRES"];
$edrpou=$aut["EDRPOU"];
$platnuk=$aut["PRIM"];
$pilga=$aut["PILGA"];
$replacements1[0] = $i;
$replacements1[1] = $adresa;
$replacements1[2] = number_format(round($s_rah/1.2,2),2,'.','');
$zamena_new.=preg_replace($patterns1, $replacements1,$zamena);
$vstavka_new.=preg_replace($patterns1, $replacements1,$vstavka);
}
$i++;
}
mysql_free_result($atu);   

$grn=(int)$sum;
$kop=fract($sum);
$sumpr=in_str($grn);

if($pilga==0){
$sbpdv=number_format(round($sum/1.2,2),2,'.','');
$spdv=number_format(round($sum/6,2),2,'.','');
$smpr=$sumpr.' грн. '.$kop.' коп. в т.ч. ПДВ – 20%';

$grnpdv=(int)$spdv;
$koppdv=fract($spdv);
$spdvpr=in_str($grnpdv);
$prpdv=$spdvpr.' грн. '.$koppdv.' коп.';
}
else{
$sbpdv=number_format($sum,2,'.','');
$spdv=number_format(0,2,'.','');
$smpr=$sumpr.' грн. '.$kop.' коп.';
$prpdv='';
}


/* $file_fiz='kvit.xml';
$file_fiz_new='kvit_new.xml'; */
$file_fiz='raxfak.xml';
$file_fiz_new='kvit_new.xml';
$file_ur='rah.xml';
$file_ur_new='rah_new.xml';

$rahunok="26002283741";

if($t_zak==2){
$file = fopen($file_ur, 'r');
$text_rah = fread($file, filesize($file_ur));
fclose($file);

$patterns[0] = "[zakaz]";
$patterns[1] = "[dtk]";
$patterns[2] = "[nrah]";
$patterns[3] = "[zamovnuk]";
$patterns[4] = "[vidrob]";
$patterns[5] = "[sum]";
$patterns[6] = "[smpr]";
$patterns[7] = "[dtzak]";
$patterns[8] = "[ndog]";
$patterns[9] = "[rahunok]";
$patterns[10] = "[sbpdv]";
$patterns[11] = "[spdv]";
$patterns[12] = "[prpdv]";
$patterns[13] = "[adr_reestr]";
$patterns[14] = "[edrpou]";
$patterns[15] = "[namerob]";
$patterns[16] = "[platnuk]";
$patterns[17] = "[adresa]";

$replacements[0] = $zakaz;
$replacements[1] = $dtk;
$replacements[2] = $nrah;
$replacements[3] = $zamovnuk;
$replacements[4] = $vidrob;
$replacements[5] = $sum;
$replacements[6] = $smpr;
$replacements[7] = $dtzak;
$replacements[8] = $ndog;
$replacements[9] = $rahunok;
$replacements[10] = $sbpdv;
$replacements[11] = $spdv;
$replacements[12] = $prpdv;
$replacements[13] = $adr_reestr;
$replacements[14] = $edrpou;
$replacements[15] = $namerob;
$replacements[16] = $platnuk;
$replacements[17] = $adresa;

$text_rah_new=preg_replace($patterns, $replacements,$text_rah);
$text_rah_new2=preg_replace("[STROKI]",$zamena_new,$text_rah_new);
$text_rah_new3=preg_replace("[VSTAVKA]",$vstavka_new,$text_rah_new2);

$filez = fopen($file_ur_new, 'w+');
fwrite($filez,$text_rah_new3);
fclose($filez);

$download_size = filesize($file_ur_new);
header("Content-type: application/msword");
//header("Content-type: application/msexcel");
header("Content-Disposition: attachment; filename=".$file_ur_new.";");
header("Accept-Ranges: bytes");
header("Content-Length: " . $download_size );
readfile($file_ur_new);
}
if($t_zak==1){
$file = fopen($file_fiz, 'r');
$text_kvut = fread($file, filesize($file_fiz));
fclose($file);

$patterns[0] = "[zakaz]";
$patterns[1] = "[dtk]";
$patterns[2] = "[kvut]";
$patterns[3] = "[zamovnuk]";
$patterns[4] = "[vidrob]";
$patterns[5] = "[dodat]";
$patterns[6] = "[adresa]";
$patterns[7] = "[sum]";
$patterns[8] = "[smpr]";
$patterns[9] = "[rahunok]";
$patterns[10] = "[datavuh]";
$patterns[11] = "[datagot]";
$patterns[12] = "[sbpdv]";
$patterns[13] = "[spdv]";

$replacements[0] = $zakaz;
$replacements[1] = $dtk;
$replacements[2] = $kvut;
$replacements[3] = $zamovnuk;
$replacements[4] = $vidrob;
$replacements[5] = $dodat;
$replacements[6] = $adresa;
$replacements[7] = $sum;
$replacements[8] = $smpr;
$replacements[9] = $rahunok;
$replacements[10] = $datavuh;
$replacements[11] = $datagot;
$replacements[12] = $sbpdv;
$replacements[13] = $spdv;

$text_kvut_new=preg_replace($patterns, $replacements,$text_kvut);

$filez = fopen($file_fiz_new, 'w+');
fwrite($filez,$text_kvut_new);
fclose($filez);

$download_size = filesize($file_fiz_new);
//header("Content-type: application/msword");
header("Content-type: application/msexcel");
header("Content-Disposition: attachment; filename=".$file_fiz_new.";");
header("Accept-Ranges: bytes");
header("Content-Length: " . $download_size );
readfile($file_fiz_new);
}
//Zakrutie bazu       
       if(mysql_close($db))
        {
        // echo("Закриття бази даних");
         }
         else
         {
          echo("Не можливо виконати закриття бази"); 
          }
?>