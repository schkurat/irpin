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
		zamovlennya.KEY='$kl' AND zamovlennya.DL='1' 
		AND dlya_oformlennya.id_oform=zamovlennya.VUD_ROB
		AND nas_punktu.ID_NSP=NS AND vulutsi.ID_VUL=VL
		AND tup_nsp.ID_TIP_NSP=nas_punktu.ID_TIP_NSP
		AND tup_vul.ID_TIP_VUL=vulutsi.ID_TIP_VUL";
$atu=mysql_query($sql);
while($aut=mysql_fetch_array($atu))
{
$zakaz=$aut["SZ"].'/'.$aut["NZ"];
$dtk=german_date($aut["DATA_VD"]);
$vidrob=$aut["document"];
$kod_rob=$aut["id_oform"];
if($aut["BUD"]!="") $bud="буд.".$aut["BUD"]; else $bud="";
if($aut["KVAR"]!="") $kvar="кв.".$aut["KVAR"]; else $kvar="";
$adresa=$aut["TIP_NSP"].' '.$aut["NSP"].' '.$aut["TIP_VUL"].' '.$aut["VUL"].' '.$bud.' '.$kvar;
$sum=$aut["SUM_D"];
$prim=$aut["PRIM"];
if($vidrob=='інвентаризація житла, що приватизується') {
$zamovnuk='Замовник: '.$aut["PR"].' '.p_buk($aut["IM"]).'.'.p_buk($aut["PB"]).'.';
$platnuk='Платник: '.$prim;}
else {
$zamovnuk='';
$platnuk='Платник: '.$aut["PR"].' '.p_buk($aut["IM"]).'.'.p_buk($aut["PB"]).'.';}
}
mysql_free_result($atu);   

$grn=(int)$sum;
$kop=fract($sum);
$sumpr=in_str($grn);
$smpr=$sumpr.' грн. '.$kop.' коп.';


$file_fiz='kvit.xml';
$file_fiz_new='kvit_new.xml';


$rahunok="26002283741";


$file = fopen($file_fiz, 'r');
$text_kvut = fread($file, filesize($file_fiz));
fclose($file);

$patterns[0] = "[zakaz]";
$patterns[1] = "[dtk]";
$patterns[2] = "[zamovnuk]";
$patterns[3] = "[vidrob]";
$patterns[4] = "[dodat]";
$patterns[5] = "[adresa]";
$patterns[6] = "[sum]";
$patterns[7] = "[smpr]";
$patterns[8] = "[rahunok]";
$patterns[9] = "[platnuk]";

$replacements[0] = $zakaz;
$replacements[1] = $dtk;
$replacements[2] = $zamovnuk;
$replacements[3] = $vidrob;
$replacements[4] = $dodat;
$replacements[5] = $adresa;
$replacements[6] = $sum;
$replacements[7] = $smpr;
$replacements[8] = $rahunok;
$replacements[9] = $platnuk;

$text_kvut_new=preg_replace($patterns, $replacements,$text_kvut);

$filez = fopen($file_fiz_new, 'w+');
fwrite($filez,$text_kvut_new);
fclose($filez);

$download_size = filesize($file_fiz_new);
header("Content-type: application/msword");
//header("Content-type: application/msexcel");
header("Content-Disposition: attachment; filename=".$file_fiz_new.";");
header("Accept-Ranges: bytes");
header("Content-Length: " . $download_size );
readfile($file_fiz_new);

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