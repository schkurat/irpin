<?php
session_start();
$lg=$_SESSION['LG'];
$pas=$_SESSION['PAS'];
$kodp=$_SESSION['KODP'];

include("../function.php");

$v_zm=$_POST['vud_zam'];
$pdv=$_POST['pdv'];
$term=$_POST['term'];
if(isset($_POST['kod'])) $idn=$_POST['kod']; else $idn="";
//$v_rob
$id_vr=$_POST['vud_rob'];
$pr=trim($_POST['priz']);
$im=trim($_POST['imya']);
$pb=trim($_POST['pobat']);
$prim=trim($_POST['prim']);
$dn=$_POST['dnar'];
$pasport=trim($_POST['pasport']);
//$plos=$_POST['plos'];
$dod_rob=$_POST['dodat'];
$edrpou=$_POST['edrpou'];
$ipn=$_POST['ipn'];
$svid=$_POST['svid'];
$dover=$_POST['doruch'];
$tl=trim($_POST['tel']);
if(isset($_POST['email'])) $email=$_POST['email']; else $email="";
$rn=$_POST['rajon'];
$ns=$_POST['nsp'];
$vl=$_POST['vyl'];
$bd=trim($_POST['bud']);
$kva=trim($_POST['kvar']);
$sm=$_POST['sum'];
$datav=date_bd($_POST['datav']);
$dg=$_POST['datag'];
$priyom=$_POST['pr_osob'];


$db=mysql_connect("localhost",$lg,$pas);
if(!$db) echo "Не вiдбулося зєднання з базою даних";
  
 if(!@mysql_select_db(kpbti,$db))
  {
   echo("Не завантажена таблиця");
   exit(); 
   }
$id_sz="";

$error=0;
$text_error='';

if($v_zm=="2"){
if(!ctype_digit($edrpou)){
$error++;
$text_error.='Не вірний формат поля ЄДРПОУ!!!<br>';
}
$kl_edrpou=strlen($edrpou);
if($kl_edrpou<8){
$error++;
$text_error.='Не вірно вказана кількість символів поля ЄДРПОУ!!!<br>';
}
if($pdv=="1"){
if(!ctype_digit($ipn)){
$error++;
$text_error.='Не вірний формат поля ІПН!!!<br>';
}
if(!ctype_digit($svid)){
$error++;
$text_error.='Не вірний формат поля Свідоцтво!!!<br>';
}
$kl_ipn=strlen($ipn);
$kl_svid=strlen($svid);
if($kl_ipn<8){
$error++;
$text_error.='Не вірно вказана кількість символів поля ІПН!!!<br>';
}
if($kl_svid<8){
$error++;
$text_error.='Не вірно вказана кількість символів поля Свідоцтво!!!<br>';
}
}
}

if($error==0){
 $dn=date_bd($dn);
 $d_vh=date_bd($d_vh);
 $dg=date_bd($dg);
 $d_pr=date("Y-m-d");
 
$n_zm=''; 
$nzu='';
if($v_zm=="1"){
 $sql = "SELECT SZ FROM zamovlennya WHERE KODP='$kodp' AND DL='1' ORDER BY SZ DESC LIMIT 1"; 
 $atu=mysql_query($sql);
  while($aut=mysql_fetch_array($atu))
 {
	$id_sz=$aut["SZ"]; 
 }
 mysql_free_result($atu); 

 if ($id_sz==""){
$id_sz=date("y");
}	
$n_rik=date("y");
if($id_sz!=$n_rik){
$id_sz=$n_rik;
}

$sql = "SELECT NZ FROM zamovlennya WHERE KODP='$kodp' AND SZ='$id_sz' AND DL='1' ORDER BY SZ,NZ DESC LIMIT 1"; 
 $atu=mysql_query($sql);
  while($aut=mysql_fetch_array($atu))
 {
	$n_zm=$aut["NZ"]+1;    
 }
 mysql_free_result($atu); 

 if ($n_zm==''){
$n_zm=1;
}}
else{
$temp_dpr=$_POST['d_pr'];
$id_sz=$temp_dpr{8}.$temp_dpr{9};
$szu=$temp_dpr{0}.$temp_dpr{1}.$temp_dpr{3}.$temp_dpr{4};
$d_pr=date_bd($_POST['d_pr']);
  $sql2 = "SELECT NZU FROM zamovlennya WHERE KODP='$kodp' AND DL='1' AND SZU='$szu' AND D_PR='$d_pr' ORDER BY NZU DESC LIMIT 1"; 
 $atu2=mysql_query($sql2);
  while($aut2=mysql_fetch_array($atu2))
 {
	$nzu=$aut2["NZU"]; 
 }
 mysql_free_result($atu2); 

 if ($nzu=='')
$nzu=1;
else
$nzu=$nzu+1;	
}
if($id_vr!="" and $pr!="" and $rn!="" and $ns!="" and $vl!="" and $bd!="" and
	$sm!="" and $dg!=""){ 
 $ath1=mysql_query("INSERT INTO zamovlennya (KODP,SZ,NZ,SZU,NZU,TUP_ZAM,TERM,VUD_ROB,DOD_ROB,PR_OS,IDN,EDRPOU,
	IPN,SVID,PR,IM,PB,PRIM,D_NAR,PASPORT,TEL,EMAIL,DOR,RN,NS,VL,BUD,KVAR,SUM,D_PR,DATA_VUH,DATA_GOT)
	VALUES('$kodp','$id_sz','$n_zm','$szu','$nzu','$v_zm','$term','$id_vr','$dod_rob','$priyom','$idn','$edrpou','$ipn','$svid',
	'$pr','$im','$pb','$prim','$dn','$pasport','$tl','$email','$dover','$rn','$ns','$vl','$bd','$kva','$sm','$d_pr','$datav','$dg');");
	if(!$ath1){
	echo "Замовлення не внесене до БД";} 

if($v_zm=="1"){
$sql3 = "SELECT IDN FROM idn WHERE IDN='$idn'"; 
$atu3=mysql_query($sql3);
if(!mysql_fetch_array($atu3)){	
	$ath2=mysql_query("INSERT INTO idn (IDN,PR,IM,PB,DATA_NAR) VALUES('$idn','$pr','$im','$pb','$dn');");
	if(!$ath2){ echo "Код особи не внесений до БД";} 
	}
mysql_free_result($atu3);
}
else{

 if($svid!='') $ed_pod='0';
 else $ed_pod='1';
$sql5 = "SELECT EDRPOU FROM yur_kl WHERE EDRPOU='$edrpou'"; 
$atu5=mysql_query($sql5);
if(!mysql_fetch_array($atu5)){	
 $ath5=mysql_query("INSERT INTO yur_kl (`NAME`,`EDRPOU`,`SVID`,`IPN`,`TELEF`,`EMAIL`,`ED_POD`)
	VALUES('$pr','$edrpou','$svid','$ipn','$tl','$email','$ed_pod');");
	if(!$ath5){ echo "Клієнт не внесений до БД";} 
	}
mysql_free_result($atu5);
}
if($v_zm=="1"){
header("location: zamovlennya.php?filter=drugi_vlasnuku&sz=".$id_sz."&nz=".$n_zm."&kodp=".$kodp."");
}
else{
echo "Замовлення: ".$id_sz."*".$szu."/".$nzu." успішно додане до БД!";
}
}
else
{
if($id_vr=="") echo "Не заповнено поле Вид робіт<br>";
if($pr=="") echo "Не заповнено поле Прізвище<br>";
if($rn=="") echo "Не заповнено поле Район<br>";
if($ns=="") echo "Не заповнено поле Населений пункт<br>";
if($vl=="") echo "Не заповнено поле Вулиця<br>";
if($bd=="") echo "Не заповнено поле Будинок<br>";
if($sm=="") echo "Не заповнено поле Сума<br>";
if($dg=="") echo "Не заповнено поле Дата готовності<br>";
}
}
else{
echo "Кількість помилок: ".$error."<br>".$text_error;
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