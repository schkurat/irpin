<?php
session_start();
$lg=$_SESSION['LG'];
$pas=$_SESSION['PAS'];
$kl=$_POST['kl'];
$dopl=$_POST['dopl'];
$im=$_POST['imya'];
$pb=$_POST['pobat'];
$tel=$_POST['telefon'];
$dt_vd=date("Y-m-d");
include "../function.php";

$db=mysql_connect("localhost",$lg,$pas);
if(!$db) echo "Не вiдбулося зєднання з базою даних";
  
 if(!@mysql_select_db(kpbti,$db))
  {
   echo("Не завантажена таблиця");
   exit(); 
   }
   
$ath1=mysql_query("UPDATE zamovlennya SET VD='1',DATA_VD='$dt_vd',SUM_D='$dopl' WHERE zamovlennya.KEY='$kl'"); 
/* КП ``Ірпінське БТІ`` */
$text="КП ``Ірпінське БТІ`` ".$im." ".$pb.", ваше замовлення виконане! Доплата ".$dopl." грн.";
$tempfile="/var/spool/sms/outgoing/send_menu";
$SMSFILE = fopen($tempfile, "w");
$ucs2text=mb_convert_encoding($text, "UCS-2BE", "UTF-8");
fwrite($SMSFILE, "To: ".$tel."\nAlphabet: UCS2\nUDH: false");
fwrite($SMSFILE, "\n\n$ucs2text");
fclose($SMSFILE);

//**********************
//$zamena='<w:proofErr w:type="spellStart"/><w:tr wsp:rsidR="000E2E56" wsp:rsidRPr="00125377" wsp:rsidTr="00E56680"><w:trPr><w:cantSplit/><w:trHeight w:val="199"/></w:trPr><w:tc><w:tcPr><w:tcW w:w="355" w:type="dxa"/><w:vAlign w:val="center"/></w:tcPr><w:p wsp:rsidR="000E2E56" wsp:rsidRPr="000E2E56" wsp:rsidRDefault="000E2E56" wsp:rsidP="000E2E56"><w:pPr><w:rPr><w:sz w:val="20"/><w:sz-cs w:val="20"/><w:lang w:val="EN-US"/></w:rPr></w:pPr><w:r><w:rPr><w:sz w:val="20"/><w:sz-cs w:val="20"/><w:lang w:val="EN-US"/></w:rPr><w:t>nomer</w:t></w:r><w:proofErr w:type="spellEnd"/></w:p></w:tc><w:proofErr w:type="spellStart"/><w:tc><w:tcPr><w:tcW w:w="8820" w:type="dxa"/><w:vAlign w:val="center"/></w:tcPr><w:p wsp:rsidR="000E2E56" wsp:rsidRPr="000E2E56" wsp:rsidRDefault="000E2E56" wsp:rsidP="000E2E56"><w:pPr><w:rPr><w:sz w:val="20"/><w:sz-cs w:val="20"/><w:lang w:val="EN-US"/></w:rPr></w:pPr><w:r><w:rPr><w:sz w:val="20"/><w:sz-cs w:val="20"/><w:lang w:val="EN-US"/></w:rPr><w:t>adresa</w:t></w:r><w:proofErr w:type="spellEnd"/></w:p></w:tc><w:proofErr w:type="spellStart"/><w:tc><w:tcPr><w:tcW w:w="1440" w:type="dxa"/><w:vAlign w:val="center"/></w:tcPr><w:p wsp:rsidR="000E2E56" wsp:rsidRPr="000E2E56" wsp:rsidRDefault="000E2E56" wsp:rsidP="000E2E56"><w:pPr><w:jc w:val="right"/><w:rPr><w:sz w:val="20"/><w:sz-cs w:val="20"/><w:lang w:val="UK"/></w:rPr></w:pPr><w:r wsp:rsidRPr="00905240"><w:rPr><w:lang w:val="EN-US"/></w:rPr><w:t>sbpdv</w:t></w:r><w:proofErr w:type="spellEnd"/></w:p></w:tc></w:tr>';
//$zamena_new='';
//$vstavka='<w:p wsp:rsidR="00187487" wsp:rsidRPr="00C52EBC" wsp:rsidRDefault="00C52EBC" wsp:rsidP="00C52EBC"><w:pPr><w:rPr><w:sz w:val="20"/><w:sz-cs w:val="20"/><w:lang w:val="UK"/></w:rPr></w:pPr><w:r><w:rPr><w:sz w:val="20"/><w:sz-cs w:val="20"/><w:lang w:val="UK"/></w:rPr><w:t>     </w:t></w:r><w:proofErr w:type="spellStart"/><w:r wsp:rsidR="00187487" wsp:rsidRPr="00C52EBC"><w:rPr><w:sz w:val="20"/><w:sz-cs w:val="20"/></w:rPr><w:t>adresa</w:t></w:r><w:proofErr w:type="spellEnd"/></w:p>';
//$vstavka_new='';

$sql = "SELECT zamovlennya.*,dlya_oformlennya.document,nas_punktu.NSP, tup_nsp.TIP_NSP,zamovlennya.EMAIL,
		dlya_oformlennya.id_oform,vulutsi.VUL,tup_vul.TIP_VUL 
		FROM zamovlennya, nas_punktu, vulutsi, tup_nsp, tup_vul, dlya_oformlennya
		WHERE 
		zamovlennya.KEY='$kl'  
		AND zamovlennya.DL='1' AND dlya_oformlennya.id_oform=zamovlennya.VUD_ROB
		AND nas_punktu.ID_NSP=NS AND vulutsi.ID_VUL=VL
		AND tup_nsp.ID_TIP_NSP=nas_punktu.ID_TIP_NSP
		AND tup_vul.ID_TIP_VUL=vulutsi.ID_TIP_VUL";
$i=1;
$pilga=0;
$atu=mysql_query($sql);
while($aut=mysql_fetch_array($atu))
{
$s_rah1=0;
$s_rah2=0;
$dtzak=german_date($aut["D_PR"]);
$dtk=$dtzak;
$vidrob=$aut["document"];
$kod_rob=$aut["id_oform"];
$email=$aut["EMAIL"];
$namerob='Виконання робіт з технічної інвентаризації об`єктів нерухомого майна:';
if($aut["BUD"]!="") $bud="буд.".$aut["BUD"]; else $bud="";
if($aut["KVAR"]!="") $kvar="кв.".$aut["KVAR"]; else $kvar="";
$adresa=$aut["TIP_NSP"].' '.$aut["NSP"].' '.$aut["TIP_VUL"].' '.$aut["VUL"].' '.$bud.' '.$kvar;
if($aut["DOKVUT"]=='0000-00-00' AND $aut["SUM_D"]==0) $s_rah1=$aut["SUM"];
if($aut["SUM_D"]!=0) $s_rah2=$aut["SUM_D"];
$sum=number_format(($s_rah1+$s_rah2),2,'.','');

$zamovnuk=$aut["PR"].' '.p_buk($aut["IM"]).'.'.p_buk($aut["PB"]).'.';
$zakaz=$aut["SZ"].'/'.$aut["NZ"];
$datavuh=german_date($aut["DATA_VUH"]);
$datagot=german_date($aut["DATA_GOT"]);

$i++;
}
mysql_free_result($atu);   

$grn=(int)$sum;
$kop=fract($sum);
$sumpr=in_str($grn);
$pilga=1;
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

//$file_fiz='raxfak_vudacha.xml';
//$file_fiz_new='kvit_new.xml';
//
//$rahunok="26002283741";
//
//$file = fopen($file_fiz, 'r');
//$text_kvut = fread($file, filesize($file_fiz));
//fclose($file);
//
//$patterns[0] = "[zakaz]";
//$patterns[1] = "[dtk]";
//$patterns[2] = "[kvut]";
//$patterns[3] = "[zamovnuk]";
//$patterns[4] = "[vidrob]";
//$patterns[5] = "[dodat]";
//$patterns[6] = "[adresa]";
//$patterns[7] = "[sum]";
//$patterns[8] = "[smpr]";
//$patterns[9] = "[rahunok]";
//$patterns[10] = "[datavuh]";
//$patterns[11] = "[datagot]";
//
//$replacements[0] = $zakaz;
//$replacements[1] = $dtk;
//$replacements[2] = $kvut;
//$replacements[3] = $zamovnuk;
//$replacements[4] = $vidrob;
//$replacements[5] = $dodat;
//$replacements[6] = $adresa;
//$replacements[7] = $sum;
//$replacements[8] = $smpr;
//$replacements[9] = $rahunok;
//$replacements[10] = $datavuh;
//$replacements[11] = $datagot;
//
//$text_kvut_new=preg_replace($patterns, $replacements,$text_kvut);
//
//$filez = fopen($file_fiz_new, 'w+');
//fwrite($filez,$text_kvut_new);
//fclose($filez);

/* $download_size = filesize($file_fiz_new);
header("Content-type: application/msexcel");
header("Content-Disposition: attachment; filename=".$file_fiz_new.";");
header("Accept-Ranges: bytes");
header("Content-Length: " . $download_size );
readfile($file_fiz_new); */

//***********************

$tema='Замовлення в КП Ірпінське БТІ';
$povidomlennya2='Доброго дня! Ваше замовлення виконане. 
Запрошуємо отримати документи. Доплатна сума становить '.$dopl.' грн. 
В дадатку міститься рахунок-фактура для оплати замовлення.
Дякуємо, що звернулися!';
//send_mail($email,$tema,$povidomlennya2,"kvit_new.xml");
/* echo "Замовлення: ".$sz."/".$nz." успішно додане до БД!
На вашу поштову скриньку ".$email." надіслано листа з договором та рахунком фактурою!"; */


//Zakrutie bazu       
       if(mysql_close($db))
        {
        // echo("Закриття бази даних");
         }
         else
         {
          echo("Не можливо виконати закриття бази"); 
          }
		  
header("location: index.php?filter=vudacha_view");

?>