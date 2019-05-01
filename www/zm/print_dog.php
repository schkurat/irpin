<?php
session_start();
$lg=$_SESSION['LG'];
$pas=$_SESSION['PAS'];

include_once "../function.php";

$kl=$_GET['kl'];
/* if(isset($_GET['tip'])) $tip=$_GET['tip'];
else $tip='';
if($tip=='10') $file_ur='dog_ur_10.xml';
if($tip=='30') $file_ur='dog_ur_30.xml';
if($tip=='b') $file_ur='dog_ur_b.xml';
if($tip=='3h') $file_ur='dog_ur_3h.xml';
if($tip=='r') $file_ur='dog_ur_r.xml'; */

$db=mysql_connect("localhost",$lg,$pas);
if(!$db) echo "Не вiдбулося зєднання з базою даних";
  
 if(!@mysql_select_db(kpbti,$db))
  {
   echo("Не завантажена таблиця");
   exit(); 
   }

$sql = "SELECT zamovlennya.*,dlya_oformlennya.document,rayonu.RAYON,nas_punktu.NSP,
				tup_nsp.TIP_NSP,dlya_oformlennya.id_oform,
				vulutsi.VUL,tup_vul.TIP_VUL,zamovlennya.SZ,zamovlennya.NZ 
				FROM zamovlennya,rayonu,nas_punktu, vulutsi, tup_nsp, tup_vul, dlya_oformlennya
				WHERE 
					zamovlennya.KEY='$kl'
					AND zamovlennya.DL='1' AND dlya_oformlennya.id_oform=zamovlennya.VUD_ROB
					AND rayonu.ID_RAYONA=RN AND nas_punktu.ID_NSP=NS AND vulutsi.ID_VUL=VL
					AND tup_nsp.ID_TIP_NSP=nas_punktu.ID_TIP_NSP
					AND tup_vul.ID_TIP_VUL=vulutsi.ID_TIP_VUL";
$atu=mysql_query($sql);
while($aut=mysql_fetch_array($atu))
{
$t_zak=$aut["TUP_ZAM"];
$b_rn=p_buk($aut["RAYON"]);
$ndog=$aut["SZ"].'/'.$aut["NZ"].'/'.$b_rn;
$dtdog=german_date($aut["D_PR"]);
$datavuh=german_date($aut["DATA_VUH"]);
$datagot=german_date($aut["DATA_GOT"]);
$pruymalnuk=$aut["PR_OS"];
$idn=$aut["IDN"];
$vidrob=$aut["document"];
$kod_rob=$aut["id_oform"];
$zamovnuk=$aut["PR"].' '.$aut["IM"].' '.$aut["PB"];
$zayavnuk=$aut["PR"].' '.p_buk($aut["IM"]).'.'.p_buk($aut["PB"]).'.';
$pasport=$aut["PASPORT"];
$primitka=$aut["PRIM"];

if($aut["BUD"]!="") $bud="буд.".$aut["BUD"]; else $bud="";
if($aut["KVAR"]!="") $kvar=", кв.".$aut["KVAR"]; else $kvar="";
$adresa=$aut["TIP_NSP"].' '.$aut["NSP"].', '.$aut["TIP_VUL"].' '.$aut["VUL"].', '.$bud.$kvar;
$vart=$aut["SUM"];/* +$aut["SUM_D"] */
$tel=$aut["TEL"];
$term=$aut["TERM"];
}
mysql_free_result($atu); 

$dodvl='';
$sql = "SELECT PR,IM,PB	FROM zm_dod WHERE IDZM='$kl'";
$atu=mysql_query($sql);
while($aut=mysql_fetch_array($atu))
{
$dodvl.=', '.$aut["PR"].' '.$aut["IM"].' '.$aut["PB"];
}
mysql_free_result($atu); 

$grn=(int)$vart;
$kop=fract($vart);
$sumpr=in_str($grn);
if($kop!=0) $smpr=$sumpr.' грн. '.$kop.' коп.';
else $smpr=$sumpr.' грн. ';

$file_fiz='dog_fiz.xml';

$file_fiz_new='dog_fiz_new.xml';
//$file_ur_new='dog_ur_new.xml';

$rahunok="26002283741";

/* if($t_zak==2){
$file = fopen($file_ur, 'r');
$text_dog = fread($file, filesize($file_ur));
fclose($file);

$patterns[0] = "[ndog]";
$patterns[1] = "[dtdog]";
$patterns[2] = "[zamovnuk]";
$patterns[3] = "[vidrob]";
$patterns[4] = "[adresa]";
$patterns[5] = "[vart]";
$patterns[6] = "[smpr]";
$patterns[7] = "[tel]";
$patterns[8] = "[rahunok]";
$patterns[9] = "[phone]";
$patterns[10] = "[primitka]";

$replacements[0] = $ndog;
$replacements[1] = $dt_dog;
$replacements[2] = $zamovnuk;
$replacements[3] = $vidrob;
$replacements[4] = $adresa;
$replacements[5] = $vart;
$replacements[6] = $smpr;
$replacements[7] = $tel;
$replacements[8] = $rahunok;
$replacements[9] = $phone;
$replacements[10] = $primitka;

$text_dog_new=preg_replace($patterns, $replacements,$text_dog);

$filez = fopen($file_ur_new, 'w+');
fwrite($filez,$text_dog_new);
fclose($filez);

$download_size = filesize($file_ur_new);
header("Content-type: application/msword");
header("Content-Disposition: attachment; filename=".$file_ur_new.";");
header("Accept-Ranges: bytes");
header("Content-Length: " . $download_size );
readfile($file_ur_new);
} */
if($t_zak==1){
$file = fopen($file_fiz, 'r');
$text_dog = fread($file, filesize($file_fiz));
fclose($file);

$patterns[0] = "[ndog]";
$patterns[1] = "[dtdog]";
$patterns[2] = "[zamovnuk]";
$patterns[3] = "[vidrob]";
$patterns[4] = "[datavuh]";
$patterns[5] = "[adresa]";
$patterns[6] = "[vart]";
$patterns[7] = "[tel]";
$patterns[8] = "[datagot]";
$patterns[9] = "[pasport]";
$patterns[10] = "[pruymalnuk]";
$patterns[11] = "[phone]";
$patterns[12] = "[idn]";
$patterns[13] = "[rahunok]";
$patterns[14] = "[smpr]";
$patterns[15] = "[dodvl]";
$patterns[16] = "[primitka]";

$replacements[0] = $ndog;
$replacements[1] = $dtdog;
$replacements[2] = $zamovnuk;
$replacements[3] = $vidrob;
$replacements[4] = $datavuh;
$replacements[5] = $adresa;
$replacements[6] = $vart;
$replacements[7] = $tel;
$replacements[8] = $datagot;
$replacements[9] = $pasport;
$replacements[10] = $pruymalnuk;
$replacements[11] = $phone;
$replacements[12] = $idn;
$replacements[13] = $rahunok;
$replacements[14] = $smpr;
$replacements[15] = $dodvl;
$replacements[16] = $primitka;

$text_dog_new=preg_replace($patterns, $replacements,$text_dog);

$filez = fopen($file_fiz_new, 'w+');
fwrite($filez,$text_dog_new);
fclose($filez);

$download_size = filesize($file_fiz_new);
header("Content-type: application/msword");
//header("Content-type: application/msexcel");
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