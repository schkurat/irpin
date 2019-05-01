<?php
session_start();
$lg=$_SESSION['LG'];
$pas=$_SESSION['PAS'];
//$kod_zm=$_SESSION['KOD_ZM'];
//$kodp=$_SESSION['KODP'];
//$kod_rn=$_SESSION['NR'];
include_once "../function.php";
$kl=$_GET['kl'];
/* if($kod_zm=="") $kod_zak="";
else $kod_zak="-".$kod_zm; */

//--------------------vstavka----------------------
 $b_stroka='<Row ss:AutoFitHeight="0" ss:Height="12" ss:StyleID="s207">
    <Cell ss:StyleID="s219"><NamedCell ss:Name="Print_Area"/></Cell>
    <Cell ss:StyleID="s412"><NamedCell ss:Name="Print_Area"/></Cell>
    <Cell ss:StyleID="s413"><NamedCell ss:Name="Print_Area"/></Cell>
    <Cell ss:StyleID="s413"><NamedCell ss:Name="Print_Area"/></Cell>
    <Cell ss:StyleID="s221"><NamedCell ss:Name="Print_Area"/></Cell>
    <Cell ss:StyleID="s221"><NamedCell ss:Name="Print_Area"/></Cell>
    <Cell ss:StyleID="s221"><NamedCell ss:Name="Print_Area"/></Cell>
    <Cell ss:StyleID="s221"><NamedCell ss:Name="Print_Area"/></Cell>
    <Cell ss:StyleID="s222"><NamedCell ss:Name="Print_Area"/></Cell>
    <Cell ss:MergeAcross="13" ss:StyleID="m22041374"><Data ss:Type="String">';
 $e_stroka='</Data><NamedCell
      ss:Name="Print_Area"/></Cell>
    <Cell ss:MergeAcross="2" ss:StyleID="m22041384"><NamedCell ss:Name="Print_Area"/></Cell>
    <Cell ss:MergeAcross="1" ss:StyleID="m22041394"><NamedCell ss:Name="Print_Area"/></Cell>
    <Cell ss:MergeAcross="2" ss:StyleID="m22041404"><NamedCell ss:Name="Print_Area"/></Cell>
    <Cell ss:MergeAcross="2" ss:StyleID="m22041414"><NamedCell ss:Name="Print_Area"/></Cell>
    <Cell ss:MergeAcross="2" ss:StyleID="m22041424"><NamedCell ss:Name="Print_Area"/></Cell>
    <Cell ss:MergeAcross="1" ss:StyleID="m22041434"><NamedCell ss:Name="Print_Area"/></Cell>
    <Cell ss:MergeAcross="1" ss:StyleID="m22057484"><NamedCell ss:Name="Print_Area"/></Cell>
    <Cell ss:MergeAcross="2" ss:StyleID="m22057494"><NamedCell ss:Name="Print_Area"/></Cell>
    <Cell ss:MergeAcross="2" ss:StyleID="m22057504"><NamedCell ss:Name="Print_Area"/></Cell>
    <Cell ss:Index="49" ss:StyleID="s77"/>
   </Row>';
//-------------------------------------------------
$db=mysql_connect("localhost",$lg,$pas);
if(!$db) echo "Не вiдбулося зєднання з базою даних";
  
 if(!@mysql_select_db(kpbti,$db))
  {
   echo("Не завантажена таблиця");
   exit(); 
   }

$sql = "SELECT * FROM podatkova WHERE podatkova.ID='$kl'";
$atu=mysql_query($sql);
while($aut=mysql_fetch_array($atu))
{
$k_kl=$aut["K_KL"];
$n_nal=$aut["N_NAL"];
$dt_nal=german_date($aut["DT_NAL"]);
$sm_opl=$aut["SM_OPL"];
$pr_pdv=$aut["PR_NDS"];
$rah=$aut["N_RAH"];
$dt_rah=german_date($aut["DT_RAH"]);
if($aut["TIP_OPL"]==1) $forma='Олата готівкою';
else $forma='Олата з поточного рахунку';
$d1=$dt_nal{0};
$d2=$dt_nal{1};
$d3=$dt_nal{3};
$d4=$dt_nal{4};
$d5=$dt_nal{6};
$d6=$dt_nal{7};
$d7=$dt_nal{8};
$d8=$dt_nal{9};
$cl_nnal=strlen($n_nal);
$p7=$n_nal{$cl_nnal-1};
$p6=$n_nal{$cl_nnal-2};
$p5=$n_nal{$cl_nnal-3};
$p4=$n_nal{$cl_nnal-4};
$p3=$n_nal{$cl_nnal-5};
$p2=$n_nal{$cl_nnal-6};
$p1=$n_nal{$cl_nnal-7};
if($k_kl==0){
$k1='';
$k2='';
$k3='X';
$k4=1;
$k5=1;
$k7='X';
$naim='кінцевий споживач';
$nl2=0; $n1=''; $n2=''; $n3=''; $n4=''; $n5=''; $n6=''; $n7=''; $n8=''; $n9=''; $nl0=''; $nl1='';
$gadr='';
$tl0=0; $t1=''; $t2=''; $t3=''; $t4=''; $t5=''; $t6=''; $t7=''; $t8=''; $t9='';
$ndog='Договір на виконання робіт';
$g1=$dt_nal{0};
$g2=$dt_nal{1};
$g3=$dt_nal{3};
$g4=$dt_nal{4};
$g5=$dt_nal{6};
$g6=$dt_nal{7};
$g7=$dt_nal{8};
$g8=$dt_nal{9};
//$stroka='';
//$stroka=$b_stroka.'ля-ля-ля'.$e_stroka;
$x3=1;
$text='';
$l10='-';
$tsbeznal=round(($sm_opl/1.2),2);
$stavka=$tsbeznal;
$pdv=round((($sm_opl*20)/120),2);
$summav=$sm_opl;
$sopl=$tsbeznal;
$sumvsya=$sm_opl;
$tszviln='';
$bezpod='';
$sumzvil='';
$smstav=$stavka;
$smzviln='';
}
else{
if($pr_pdv!=0){
$k1='X';
$k2='';
$k3='';
$k4='';
$k5='';
$k7='X';
$naim=$aut["NAME"];
$d1=$dt_nal{0};
$d2=$dt_nal{1};
$d3=$dt_nal{3};
$d4=$dt_nal{4};
$d5=$dt_nal{6};
$d6=$dt_nal{7};
$d7=$dt_nal{8};
$d8=$dt_nal{9};
$cl_nnal=strlen($n_nal);
$p7=$n_nal{$cl_nnal-1};
$p6=$n_nal{$cl_nnal-2};
$p5=$n_nal{$cl_nnal-3};
$p4=$n_nal{$cl_nnal-4};
$p3=$n_nal{$cl_nnal-5};
$p2=$n_nal{$cl_nnal-6};
$p1=$n_nal{$cl_nnal-7};
$sql1 = "SELECT * FROM yur_kl WHERE yur_kl.ID='$k_kl'";
$atu1=mysql_query($sql1);
while($aut1=mysql_fetch_array($atu1))
{
$ipn=$aut1["IPN"];
$adr_kl=$aut1["ADRES"];
$tel_kl=$aut1["TELEF"];
}
mysql_free_result($atu1);
if($ipn==''){
$k1='';
$k2='';
$k3='Х';
$k4='0';
$k5='2';
$k7='X';
$nl2=0; $n1=''; $n2=''; $n3=''; $n4=''; $n5=''; $n6=''; $n7=''; $n8=''; $n9=''; $nl0=''; $nl1='';
}
else{
$cl_ipn=strlen($ipn);
$nl2=$ipn{$cl_ipn-1}; 
$nl1=$ipn{$cl_ipn-2};
$nl0=$ipn{$cl_ipn-3};
$n9=$ipn{$cl_ipn-4};
$n8=$ipn{$cl_ipn-5};
$n7=$ipn{$cl_ipn-6};
$n6=$ipn{$cl_ipn-7};
$n5=$ipn{$cl_ipn-8};
$n4=$ipn{$cl_ipn-9};
$n3=$ipn{$cl_ipn-10};
$n2=$ipn{$cl_ipn-11};
$n1=$ipn{$cl_ipn-12};}
$gadr=$adr_kl;    
$cl_tel=strlen($tel_kl);
$tl0=$tel_kl{$cl_tel-1};
$t9=$tel_kl{$cl_tel-2};
$t8=$tel_kl{$cl_tel-3};
$t7=$tel_kl{$cl_tel-4};
$t6=$tel_kl{$cl_tel-5};
$t5=$tel_kl{$cl_tel-6};
$t4=$tel_kl{$cl_tel-7};
$t3=$tel_kl{$cl_tel-8};
$t2=$tel_kl{$cl_tel-9};
$t1=$tel_kl{$cl_tel-10};  
$ndog='Договір на виконання робіт'; 
$pieces = explode("*", $rah);
$sz=$pieces[0];
$pieces2 = explode("/", $pieces[1]);
$szu=$pieces2[0];
$nzu=$pieces2[1];

$sql1 = "SELECT zamovlennya.BUD,zamovlennya.KVAR,rayonu.RAYON,nas_punktu.NSP,tup_nsp.TIP_NSP,vulutsi.VUL,
		tup_vul.TIP_VUL FROM zamovlennya, rayonu, nas_punktu, vulutsi, tup_nsp, tup_vul 
		WHERE 
		zamovlennya.DL='1' AND zamovlennya.SZ='$sz' AND zamovlennya.SZU='$szu' AND zamovlennya.NZU='$nzu' 
		AND rayonu.ID_RAYONA=RN AND nas_punktu.ID_NSP=NS
		AND vulutsi.ID_VUL=VL AND tup_nsp.ID_TIP_NSP=nas_punktu.ID_TIP_NSP
		AND tup_vul.ID_TIP_VUL=vulutsi.ID_TIP_VUL";
$atu1=mysql_query($sql1);
while($aut1=mysql_fetch_array($atu1))
{
if($aut1["BUD"]!="") $bud="буд.".$aut1["BUD"]; else $bud="";
if($aut1["KVAR"]!="") $kvar="кв.".$aut1["KVAR"]; else $kvar="";
$adr_zak=$aut1["TIP_NSP"].$aut1["NSP"]." ".$aut1["TIP_VUL"].$aut1["VUL"]." ".$bud." ".$kvar;
}
mysql_free_result($atu1);  
$stroka=$b_stroka.$adr_zak.$e_stroka;
$g1=$dt_rah{0};
$g2=$dt_rah{1};
$g3=$dt_rah{3};
$g4=$dt_rah{4};
$g5=$dt_rah{6};
$g6=$dt_rah{7};
$g7=$dt_rah{8};
$g8=$dt_rah{9};
$x3='робота';
$text='';
$l10=$rah;
$tsbeznal=round(($sm_opl/1.2),2);
$stavka=$tsbeznal;
$pdv=round((($sm_opl*20)/120),2);
$summav=$sm_opl;
$sopl=$tsbeznal;
$sumvsya=$sm_opl;
$tszviln='';
$bezpod='';
$sumzvil='';
$smstav=$stavka;
$smzviln='';
}
else{
$k1='';
$k2='';
$k3='Х';
$k4='0';
$k5='9';
$k7='X';
$naim=$aut["NAME"];
$d1=$dt_nal{0};
$d2=$dt_nal{1};
$d3=$dt_nal{3};
$d4=$dt_nal{4};
$d5=$dt_nal{6};
$d6=$dt_nal{7};
$d7=$dt_nal{8};
$d8=$dt_nal{9};
$cl_nnal=strlen($n_nal);
$p7=$n_nal{$cl_nnal-1};
$p6=$n_nal{$cl_nnal-2};
$p5=$n_nal{$cl_nnal-3};
$p4=$n_nal{$cl_nnal-4};
$p3=$n_nal{$cl_nnal-5};
$p2=$n_nal{$cl_nnal-6};
$p1=$n_nal{$cl_nnal-7};
$sql1 = "SELECT * FROM yur_kl WHERE yur_kl.ID='$k_kl'";
$atu1=mysql_query($sql1);
while($aut1=mysql_fetch_array($atu1))
{
$ipn=$aut1["IPN"];
$adr_kl=$aut1["ADRES"];
$tel_kl=$aut1["TELEF"];
}
mysql_free_result($atu1);
$cl_ipn=strlen($ipn);
$nl2=$ipn{$cl_ipn-1}; 
$nl1=$ipn{$cl_ipn-2};
$nl0=$ipn{$cl_ipn-3};
$n9=$ipn{$cl_ipn-4};
$n8=$ipn{$cl_ipn-5};
$n7=$ipn{$cl_ipn-6};
$n6=$ipn{$cl_ipn-7};
$n5=$ipn{$cl_ipn-8};
$n4=$ipn{$cl_ipn-9};
$n3=$ipn{$cl_ipn-10};
$n2=$ipn{$cl_ipn-11};
$n1=$ipn{$cl_ipn-12};
$gadr=$adr_kl;    
$cl_tel=strlen($tel_kl);
$tl0=$tel_kl{$cl_tel-1};
$t9=$tel_kl{$cl_tel-2};
$t8=$tel_kl{$cl_tel-3};
$t7=$tel_kl{$cl_tel-4};
$t6=$tel_kl{$cl_tel-5};
$t5=$tel_kl{$cl_tel-6};
$t4=$tel_kl{$cl_tel-7};
$t3=$tel_kl{$cl_tel-8};
$t2=$tel_kl{$cl_tel-9};
$t1=$tel_kl{$cl_tel-10};  
$ndog='Договір на виконання робіт'; 
$pieces = explode("*", $rah);
$sz=$pieces[0];
$pieces2 = explode("/", $pieces[1]);
$szu=$pieces2[0];
$nzu=$pieces2[1];

$sql1 = "SELECT zamovlennya.BUD,zamovlennya.KVAR,rayonu.RAYON,nas_punktu.NSP,tup_nsp.TIP_NSP,vulutsi.VUL,
		tup_vul.TIP_VUL FROM zamovlennya, rayonu, nas_punktu, vulutsi, tup_nsp, tup_vul 
		WHERE 
		zamovlennya.DL='1' AND zamovlennya.SZ='$sz' AND zamovlennya.SZU='$szu' AND zamovlennya.NZU='$nzu' 
		AND rayonu.ID_RAYONA=RN AND nas_punktu.ID_NSP=NS
		AND vulutsi.ID_VUL=VL AND tup_nsp.ID_TIP_NSP=nas_punktu.ID_TIP_NSP
		AND tup_vul.ID_TIP_VUL=vulutsi.ID_TIP_VUL";
$atu1=mysql_query($sql1);
while($aut1=mysql_fetch_array($atu1))
{
if($aut1["BUD"]!="") $bud="буд.".$aut1["BUD"]; else $bud="";
if($aut1["KVAR"]!="") $kvar="кв.".$aut1["KVAR"]; else $kvar="";
$adr_zak=$aut1["TIP_NSP"].$aut1["NSP"]." ".$aut1["TIP_VUL"].$aut1["VUL"]." ".$bud." ".$kvar;
}
mysql_free_result($atu1);  
$stroka=$b_stroka.$adr_zak.$e_stroka;
$g1=$dt_rah{0};
$g2=$dt_rah{1};
$g3=$dt_rah{3};
$g4=$dt_rah{4};
$g5=$dt_rah{6};
$g6=$dt_rah{7};
$g7=$dt_rah{8};
$g8=$dt_rah{9};
$x3='робота';
$text='п.197.1.13';
$l10=$rah;
$tsbeznal=$sm_opl;
$stavka='';
$pdv='';
$summav='';
$sopl=$tsbeznal;
$sumvsya=$sm_opl;
$tszviln=$sm_opl;
$bezpod='Без ПДВ';
$sumzvil=$sm_opl;
$smstav=$stavka;
$smzviln=$sm_opl;
}
}
}
mysql_free_result($atu);   

$file_p='podatkova.xml';
$file_p_new='podatkova_new.xml';

$file = fopen($file_p, 'r');
$text_pod = fread($file, filesize($file_p));
fclose($file);

$patterns[0] = "[k1]";
$patterns[1] = "[k2]";
$patterns[2] = "[k3]";
$patterns[3] = "[k4]";
$patterns[4] = "[k5]";
$patterns[5] = "[k7]";
$patterns[6] = "[naim]";
$patterns[7] = "[d1]";
$patterns[8] = "[d2]";
$patterns[9] = "[d3]";
$patterns[10] = "[d4]";
$patterns[11] = "[d5]";
$patterns[12] = "[d6]";
$patterns[13] = "[d7]";
$patterns[14] = "[d8]";
$patterns[15] = "[p1]";
$patterns[16] = "[p2]";
$patterns[17] = "[p3]";
$patterns[18] = "[p4]";
$patterns[19] = "[p5]";
$patterns[20] = "[p6]";
$patterns[21] = "[p7]";
$patterns[22] = "[n1]";
$patterns[23] = "[n2]";
$patterns[24] = "[n3]";
$patterns[25] = "[n4]";
$patterns[26] = "[n5]";
$patterns[27] = "[n6]";
$patterns[28] = "[n7]";
$patterns[29] = "[n8]";
$patterns[30] = "[n9]";
$patterns[31] = "[nl0]";
$patterns[32] = "[nl1]";
$patterns[33] = "[nl2]";
$patterns[34] = "[gadr]";
$patterns[35] = "[t1]";
$patterns[36] = "[t2]";
$patterns[37] = "[t3]";
$patterns[38] = "[t4]";
$patterns[39] = "[t5]";
$patterns[40] = "[t6]";
$patterns[41] = "[t7]";
$patterns[42] = "[t8]";
$patterns[43] = "[t9]";
$patterns[44] = "[tl0]";
$patterns[45] = "[ndog]";
$patterns[46] = "[g1]";
$patterns[47] = "[g2]";
$patterns[48] = "[g3]";
$patterns[49] = "[g4]";
$patterns[50] = "[g5]";
$patterns[51] = "[g6]";
$patterns[52] = "[g7]";
$patterns[53] = "[g8]";
$patterns[54] = "[forma]";
$patterns[55] = "[stroka]";
$patterns[56] = "[x3]";
$patterns[57] = "[text]";
$patterns[58] = "[l10]";
$patterns[59] = "[tsbeznal]";
$patterns[60] = "[stavka]";
$patterns[61] = "[pdv]";
$patterns[62] = "[summav]";
$patterns[63] = "[sopl]";
$patterns[64] = "[sumvsya]";
$patterns[65] = "[tszviln]";
$patterns[66] = "[bezpod]";
$patterns[67] = "[sumzvil]";
$patterns[68] = "[smstav]";
$patterns[69] = "[smzviln]";

$replacements[0] = $k1;
$replacements[1] = $k2;
$replacements[2] = $k3;
$replacements[3] = $k4;
$replacements[4] = $k5;
$replacements[5] = $k7;
$replacements[6] = $naim;
$replacements[7] = $d1;
$replacements[8] = $d2;
$replacements[9] = $d3;
$replacements[10] = $d4;
$replacements[11] = $d5;
$replacements[12] = $d6;
$replacements[13] = $d7;
$replacements[14] = $d8;
$replacements[15] = $p1;
$replacements[16] = $p2;
$replacements[17] = $p3;
$replacements[18] = $p4;
$replacements[19] = $p5;
$replacements[20] = $p6;
$replacements[21] = $p7;
$replacements[22] = $n1;
$replacements[23] = $n2;
$replacements[24] = $n3;
$replacements[25] = $n4;
$replacements[26] = $n5;
$replacements[27] = $n6;
$replacements[28] = $n7;
$replacements[29] = $n8;
$replacements[30] = $n9;
$replacements[31] = $nl0;
$replacements[32] = $nl1;
$replacements[33] = $nl2;
$replacements[34] = $gadr;
$replacements[35] = $t1;
$replacements[36] = $t2;
$replacements[37] = $t3;
$replacements[38] = $t4;
$replacements[39] = $t5;
$replacements[40] = $t6;
$replacements[41] = $t7;
$replacements[42] = $t8;
$replacements[43] = $t9;
$replacements[44] = $tl0;
$replacements[45] = $ndog;
$replacements[46] = $g1;
$replacements[47] = $g2;
$replacements[48] = $g3;
$replacements[49] = $g4;
$replacements[50] = $g5;
$replacements[51] = $g6;
$replacements[52] = $g7;
$replacements[53] = $g8;
$replacements[54] = $forma;
$replacements[55] = $stroka;
$replacements[56] = $x3;
$replacements[57] = $text;
$replacements[58] = $l10;
$replacements[59] = $tsbeznal;
$replacements[60] = $stavka;
$replacements[61] = $pdv;
$replacements[62] = $summav;
$replacements[63] = $sopl;
$replacements[64] = $sumvsya;
$replacements[65] = $tszviln;
$replacements[66] = $bezpod;
$replacements[67] = $sumzvil;
$replacements[68] = $smstav;
$replacements[69] = $smzviln;

$text_pod_new=preg_replace($patterns, $replacements,$text_pod);

$filez = fopen($file_p_new, 'w+');
fwrite($filez,$text_pod_new);
fclose($filez);

$download_size = filesize($file_p_new);
//header("Content-type: application/msword");
header("Content-type: application/msexcel");
header("Content-Disposition: attachment; filename=".$file_p_new.";");
header("Accept-Ranges: bytes");
header("Content-Length: " . $download_size );
readfile($file_p_new);

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