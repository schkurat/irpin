<?php
session_start();
$lg=$_SESSION['LG'];
$pas=$_SESSION['PAS'];

include "../function.php";

$bdat=date_bd($_POST['bdate']);
$edat=date_bd($_POST['edate']);

$db=mysql_connect("localhost",$lg,$pas);
if(!$db) echo "Не вiдбулося зєднання з базою даних";
  
 if(!@mysql_select_db(kpbti,$db))
  {
   echo("Не завантажена таблиця");
   exit(); 
   }
$ath=mysql_query("DELETE FROM zakruttya WHERE DT_ZAK>='$bdat' AND DT_ZAK<='$edat';");

$s_pr=0; 
$s_arh=0; 
$s_per=0; 
$s_pot=0; 
$s_cop=0; 
$s_taks=0;
$idzm2=0;
$vuk2=0;

$sql1="SELECT taks_detal.SUM AS SM,taks_detal.KF,taks_detal.NORM,taks_detal.KF_NAR,taks_detal.TR,dlya_oformlennya.TIP,price.VUD,
	zamovlennya.*,rayonu.RAYON,nas_punktu.NSP,tup_nsp.TIP_NSP,vulutsi.VUL,tup_vul.TIP_VUL,taks_detal.ID_ROB,taks_detal.ID_PRICE 
	FROM zamovlennya,taks_detal,dlya_oformlennya,price,rayonu, nas_punktu, vulutsi, tup_nsp, tup_vul  
	WHERE 
	zamovlennya.DATA_PS>='$bdat' AND zamovlennya.DATA_PS<='$edat' AND zamovlennya.PS='1' 
	AND zamovlennya.DL='1' AND zamovlennya.KEY=taks_detal.IDZM AND taks_detal.DL='1' 
	AND zamovlennya.VUD_ROB=dlya_oformlennya.id_oform  
	AND taks_detal.ID_PRICE=price.ID_PRICE
	AND rayonu.ID_RAYONA=zamovlennya.RN
	AND nas_punktu.ID_NSP=zamovlennya.NS
	AND vulutsi.ID_VUL=zamovlennya.VL
	AND tup_nsp.ID_TIP_NSP=nas_punktu.ID_TIP_NSP
	AND tup_vul.ID_TIP_VUL=vulutsi.ID_TIP_VUL
	ORDER BY taks_detal.KODP,taks_detal.IDZM,taks_detal.ID_ROB";			
echo $sql1;
 $atu1=mysql_query($sql1);  
  while($aut1=mysql_fetch_array($atu1))
 {
	$idzm=$aut1["KEY"];
	$vuk=$aut1["ID_ROB"];
	if(($idzm2!=$idzm && $idzm2!=0) || (/* $vuk2!=1 &&  */$vuk2!=0 && $vuk2!=$vuk)){
	$v1=0; $v2=0; $v3=0; $v4=0; $v5=0; $v6=0; $v7=0; $v8=0; $v9=0; $v10=0; $v11=0; $v12=0;
	
	//контроль кто и в каком городе делал прийом и архив
	if(($rn==1 && $ns==1)||($vuk2==15)||($rn==3 && $ns==11 && $vuk2==2)||($rn==5 && $ns==23 && $vuk2==8)
	||($rn==5 && $ns==23 && $vuk2==23)||($rn==5 && $ns==23 && $vuk2==28)||($rn==3 && $ns==11 && $vuk2==25)){
	if($vud_rob==26){
	$v11=$s_per+$s_pot+$s_cop;
	if($v11==51.74) $v11=25.87;
	$v9=$s_pr;
	$v10=$s_arh;
	$v12=$s_taks;
	}
	else{
	$v3=$s_per;
	$v5=$s_pot;
	$v7=$s_cop;
	$v9=$s_pr;
	$v10=$s_arh;
	$v12=$s_taks;
	}
	}
	else{
	if($vud_rob==26){
	$v11=$s_per+$s_pot+$s_cop;
	if($v11==51.74) $v11=25.87;
	$v1=$s_pr;
	$v2=$s_arh;
	$v12=$s_taks;
	}
	else{
	$v1=$s_pr;
	$v2=$s_arh;
	$v4=$s_per;
	$v6=$s_pot;
	$v8=$s_cop;
	$v12=$s_taks;
	}
	}
	$s_pr=0; $s_arh=0; $s_per=0; $s_pot=0; $s_cop=0; $s_taks=0;
	$ath=mysql_query("INSERT INTO zakruttya (`DT_ZAK`,`ID_ZAK`,`SZ`,`SZU`,`NZ`,`KODP`,`VK`,`ADRES`,`1`,`2`,`3`,`4`,
	`5`,`6`,`7`,`8`,`9`,`10`,`11`,`12`) VALUES('$data_ps','$idzm2','$sz','$szu','$nz','$kodp','$vuk2','$adresa','$v1','$v2','$v3','$v4',
	'$v5','$v6','$v7','$v8','$v9','$v10','$v11','$v12');");
	}
	//------------blok danuh dlya fayla zakr-------------
	$data_ps=$aut1["DATA_PS"];
	if($aut1["TUP_ZAM"]==1){
	$sz=$aut1["SZ"];
	$szu=$aut1["SZU"];
	$nz=$aut1["NZ"];
	}
	else{
	$sz=$aut1["SZ"];
	$szu=$aut1["SZU"];
	$nz=$aut1["NZU"];
	}
	$kodp=$aut1["KODP"];
	$vud_rob=$aut1["VUD_ROB"];
	$obj_ner=objekt_ner($aut1["OBJ"],$aut1["BUD"],$aut1["KVAR"]);
	$adresa=/* $aut1["RAYON"]." ". */$aut1["TIP_NSP"].$aut1["NSP"]." ".$aut1["TIP_VUL"].$aut1["VUL"]." ".$obj_ner;
	$rn=$aut1["RN"];
	$ns=$aut1["NS"];
	$id_price=$aut1["ID_PRICE"];
	//---------------------------------------------------
	$tip=0;
	$tr=$aut1["TR"];
	$kf=$aut1["KF"];
	$kf_nar=$aut1["KF_NAR"];
	$tip=$aut1["TIP"];
	$vud=$aut1["VUD"];
	$norm=$aut1["NORM"];
	/* if($kf==2){
	if($aut1["TUP_ZAM"]==1) {$sum=round(($aut1["SM"]*1.5),2);}
	if($aut1["TUP_ZAM"]==2) {$sum=round(($aut1["SM"]*1.2),2);}
	}
	else */ 
	$sum=round(($aut1["SM"]*$kf_nar),2);
	$sum_st=round($aut1["SM"],2);

switch($tr)
{
case 1: 
		$s_pr=$s_pr+$sum_st; //$sum;
		$vk_pr=$vuk;
	break;
case 2: 	
	$s_arh=$s_arh+$sum_st; //$sum;
	$vk_arh=$vuk;
	break;
case 3: 	
	if($tip==1) {
		if($vud==5) {$s_cop=$s_cop+$sum;}
		else {$s_per=$s_per+$sum;}}
	if($tip==2) {
		if($vud==5) {$s_cop=$s_cop+$sum;}
		else {$s_pot=$s_pot+$sum;}}
			break;
case 4: 	
	if($tip==1) {
		if($vud==5) {$s_cop=$s_cop+$sum;}
		else {
		if(/*$norm!=0.190*/$id_price!=83 and $id_price!=144) $s_per=$s_per+$sum;
		else $s_taks=$s_taks+$sum;
		}}
	if($tip==2) {
		if($vud==5) {$s_cop=$s_cop+$sum;}
		else {
		if(/*$norm!=0.190*/$id_price!=83 and $id_price!=144) $s_pot=$s_pot+$sum;
		else $s_taks=$s_taks+$sum;
		}}
			break;
case 5: 	
	if($tip==1) {
		if($vud==5) {$s_cop=$s_cop+$sum;}
		else {$s_per=$s_per+$sum;}}
	if($tip==2) {
		if($vud==5) {$s_cop=$s_cop+$sum;}
		else {$s_pot=$s_pot+$sum;}}
			break;

default:
			break;
}
$idzm2=$idzm;
$vuk2=$vuk;
 } 
 mysql_free_result($atu1);  
$v1=0; $v2=0; $v3=0; $v4=0; $v5=0; $v6=0; $v7=0; $v8=0; $v9=0; $v10=0; $v11=0; $v12=0;
	
	//if($rn==1 && $ns==1){
	if(($rn==1 && $ns==1)||($rn==3 && $ns==11 && $vuk2==2)||($rn==5 && $ns==23 && $vuk2==8)
	||($rn==5 && $ns==23 && $vuk2==23)||($rn==5 && $ns==23 && $vuk2==28)||($rn==3 && $ns==11 && $vuk2==25)){
	if($vud_rob==26){
	$v11=$s_per+$s_pot+$s_cop;
	if($v11==51.74) $v11=25.87;
	$v9=$s_pr;
	$v10=$s_arh;
	$v12=$s_taks;
	}
	else{
	$v3=$s_per;
	$v5=$s_pot;
	$v7=$s_cop;
	$v9=$s_pr;
	$v10=$s_arh;
	$v12=$s_taks;
	}
	}
	else{
	if($vud_rob==26){
	$v11=$s_per+$s_pot+$s_cop;
	if($v11==51.74) $v11=25.87;
	$v1=$s_pr;
	$v2=$s_arh;
	$v12=$s_taks;
	}
	else{
	$v1=$s_pr;
	$v2=$s_arh;
	$v4=$s_per;
	$v6=$s_pot;
	$v8=$s_cop;
	$v12=$s_taks;
	}
	}
	$ath=mysql_query("INSERT INTO zakruttya (`DT_ZAK`,`ID_ZAK`,`SZ`,`SZU`,`NZ`,`KODP`,`VK`,`ADRES`,`1`,`2`,`3`,`4`,
	`5`,`6`,`7`,`8`,`9`,`10`,`11`,`12`) VALUES('$data_ps','$idzm','$sz','$szu','$nz','$kodp','$vuk','$adresa','$v1','$v2','$v3','$v4',
	'$v5','$v6','$v7','$v8','$v9','$v10','$v11','$v12');");	

if(mysql_close($db))
        {
        // echo("Закриття бази даних");
         }
         else
         {
          echo("Не можливо виконати закриття бази"); 
          }		
header("location: naryadu.php");		  
?>