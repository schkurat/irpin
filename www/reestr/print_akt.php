<?php
session_start();
$lg=$_SESSION['LG'];
$pas=$_SESSION['PAS'];
include_once "../function.php";
$kl=$_GET['kl'];

$db=mysql_connect("localhost",$lg,$pas);
if(!$db) echo "Не вiдбулося зєднання з базою даних";
  
if(!@mysql_select_db(kpbti,$db))
  {
   echo("Не завантажена таблиця");
   exit(); 
   }

$sql = "SELECT zamovlennya.*,dlya_oformlennya.document,nas_punktu.NSP, tup_nsp.TIP_NSP,
			dlya_oformlennya.id_oform,vulutsi.VUL,tup_vul.TIP_VUL,zamovlennya.SZ,zamovlennya.NZ
				FROM zamovlennya, nas_punktu, vulutsi, tup_nsp, tup_vul, dlya_oformlennya
		WHERE 
		zamovlennya.KEY='$kl'
		AND zamovlennya.DL='1' AND dlya_oformlennya.id_oform=zamovlennya.VUD_ROB
		AND nas_punktu.ID_NSP=NS AND vulutsi.ID_VUL=VL
		AND tup_nsp.ID_TIP_NSP=nas_punktu.ID_TIP_NSP
		AND tup_vul.ID_TIP_VUL=vulutsi.ID_TIP_VUL";
$atu=mysql_query($sql);
while($aut=mysql_fetch_array($atu))
{
$tup_zam=$aut["TUP_ZAM"];
$ndog=$aut["SZ"].'/'.$aut["NZ"];
$dtzak=german_date($aut["D_PR"]);
$vidrob=$aut["document"];
$kod_rob=$aut["id_oform"];
$edrpou=$aut["EDRPOU"];
$idn=$aut["IDN"];
$passport=$aut["PASPORT"];
$zamovnuk=$aut["PR"].' '.$aut["IM"].' '.$aut["PB"];
$tel=$aut["TEL"];
if($aut["BUD"]!="") $bud="буд.".$aut["BUD"]; else $bud="";
if($aut["KVAR"]!="") $kvar="кв.".$aut["KVAR"]; else $kvar="";
$adresa=$aut["TIP_NSP"].' '.$aut["NSP"].' '.$aut["TIP_VUL"].' '.$aut["VUL"].' '.$bud.' '.$kvar;
if($aut["DOKVUT"]!='0000-00-00') $sma=$aut["SUM"];
if($aut["DODOP"]!='0000-00-00') $smd=$aut["SUM_D"];
$sum=number_format(($sma+$smd),2,'.',''); 
$dtpidp=german_date($aut["DATA_PS"]);
}
mysql_free_result($atu); 

/* $taks=0;
$nds=0;
 $sql = "SELECT taks.SUM,taks.SUM_OKR,taks.NDS FROM taks WHERE taks.IDZM='$kl' AND DL='1'"; 
 $atu=mysql_query($sql);
  while($aut=mysql_fetch_array($atu))
 {
 	$taks=$aut["SUM"]+$aut["SUM_OKR"];
	$nds=$aut["NDS"];
 	} 
mysql_free_result($atu);
if($taks!=0){
$sum=round((($nds+100)*$taks)/100,2);
} */

$grn=(int)$sum;
$kop=fract($sum);
$sumpr=in_str($grn);
$smpr=$sumpr.' грн. ';
if($kop!=0) $smpr.=$kop.' коп.';
/* $sbpdv=number_format(round($sum/1.2,2),2,'.','');
$spdv=number_format(round($sum/6,2),2,'.','');
$grnpdv=(int)$spdv;
$koppdv=fract($spdv);
$spdvpr=in_str($grnpdv);
$prpdv=$spdvpr.' грн. '.$koppdv.' коп.'; */

$file_fiz='dovidka.xml';
$file_fiz_new='akt_fiz_new.xml';
$file_ur='akt.xml';
$file_ur_new='dovidka_new.xml';

$rahunok="26002283741";

if($tup_zam==2){
$sql = "SELECT * FROM yur_kl WHERE yur_kl.DL='1' AND yur_kl.EDRPOU='$edrpou'";
$atu=mysql_query($sql);
while($aut=mysql_fetch_array($atu))
{
$zamovnuk=$aut["NAME"];
$adrzamovn=$aut["ADRES"];
$tel=$aut["TELEF"];
$bank=$aut["BANK"];
$mfo=$aut["MFO"];
$rahzamovn=$aut["RR"];
$svzamovn=$aut["SVID"];
$pnzamovn=$aut["IPN"];
}
mysql_free_result($atu); 

$file = fopen($file_ur, 'r');
$text_rah = fread($file, filesize($file_ur));
fclose($file);

$patterns[0] = "[zamovnuk]";
$patterns[1] = "[adrzamovn]";
$patterns[2] = "[tel]";
$patterns[3] = "[edrpou]";
$patterns[4] = "[vidrob]";
$patterns[5] = "[dodat]";
$patterns[6] = "[adresa]";
$patterns[7] = "[sum]";
$patterns[8] = "[smpr]";
$patterns[9] = "[dtzak]";
$patterns[10] = "[ndog]";
$patterns[11] = "[rahunok]";
$patterns[12] = "[sbpdv]";
$patterns[13] = "[spdv]";
$patterns[14] = "[dtpidp]";
$patterns[15] = "[bank]";
$patterns[16] = "[mfo]";
$patterns[17] = "[rahzamovn]";
$patterns[18] = "[svzamovn]";
$patterns[19] = "[pnzamovn]";

$replacements[0] = $zamovnuk;
$replacements[1] = $adrzamovn;
$replacements[2] = $tel;
$replacements[3] = $edrpou;
$replacements[4] = $vidrob;
$replacements[5] = $dodat;
$replacements[6] = $adresa;
$replacements[7] = $sum;
$replacements[8] = $smpr;
$replacements[9] = $dtzak;
$replacements[10] = $ndog;
$replacements[11] = $rahunok;
$replacements[12] = $sbpdv;
$replacements[13] = $spdv;
$replacements[14] = $dtpidp;
$replacements[15] = $bank;
$replacements[16] = $mfo;
$replacements[17] = $rahzamovn;
$replacements[18] = $svzamovn;
$replacements[19] = $pnzamovn;

$text_rah_new=preg_replace($patterns, $replacements,$text_rah);

$filez = fopen($file_ur_new, 'w+');
fwrite($filez,$text_rah_new);
fclose($filez);

$download_size = filesize($file_ur_new);
header("Content-type: application/msword");
//header("Content-type: application/msexcel");
header("Content-Disposition: attachment; filename=".$file_ur_new.";");
header("Accept-Ranges: bytes");
header("Content-Length: ". $download_size );
readfile($file_ur_new);
}
else{
$file = fopen($file_fiz, 'r');
$text_rah = fread($file, filesize($file_fiz));
fclose($file);

$patterns[0] = "[zamovnuk]";
$patterns[1] = "[adrzamovn]";
$patterns[2] = "[passport]";
$patterns[3] = "[idn]";
$patterns[4] = "[tel]";
$patterns[5] = "[vidrob]";
$patterns[6] = "[adresa]";
$patterns[7] = "[sum]";
$patterns[8] = "[smpr]";
$patterns[9] = "[dtzak]";
$patterns[10] = "[ndog]";
$patterns[11] = "[rahunok]";
$patterns[12] = "[dtpidp]";

$replacements[0] = $zamovnuk;
$replacements[1] = $adrzamovn;
$replacements[2] = $passport;
$replacements[3] = $idn;
$replacements[4] = $tel;
$replacements[5] = $vidrob;
$replacements[6] = $adresa;
$replacements[7] = $sum;
$replacements[8] = $smpr;
$replacements[9] = $dtzak;
$replacements[10] = $ndog;
$replacements[11] = $rahunok;
$replacements[12] = $dtpidp;

$text_rah_new=preg_replace($patterns, $replacements,$text_rah);

$filez = fopen($file_fiz_new, 'w+');
fwrite($filez,$text_rah_new);
fclose($filez);

$download_size = filesize($file_fiz_new);
header("Content-type: application/msword");
//header("Content-type: application/msexcel");
header("Content-Disposition: attachment; filename=".$file_fiz_new.";");
header("Accept-Ranges: bytes");
header("Content-Length: ". $download_size );
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