<?php
session_start();
$lg=$_SESSION['LG'];
$pas=$_SESSION['PAS'];
$pr_prie=$_SESSION['PR'];
$im_prie=$_SESSION['IM'];
$pb_prie=$_SESSION['PB'];
include "../function.php";
$nvh=$_POST['nvhid']; 
$nvuh=$_POST['nvuh'];
$datav=$_POST['data_v'];
$datavuh=$_POST['data_vuh'];
$nkl=$_POST['nkores'];
$dkl=$_POST['datkl'];
$naim=$_POST['kores'];
$boss=$_POST['pib'];
$zmist=$_POST['zauv'];
$tip=$_POST['tup'];
$sekr=$pr_prie.' '.p_buk($im_prie).'.'.p_buk($pb_prie);
if(isset($_POST['konvert'])) $konv=$_POST['konvert'];
else $konv='0'; 

$db=mysql_connect("localhost",$lg,$pas);
if(!$db) echo "Не вiдбулося зєднання з базою даних";
  
 if(!@mysql_select_db(kpbti,$db))
  {
   echo("Не завантажена таблиця");
   exit(); 
   }

$chas=date("H:i:s");
   
 $dkl=substr($dkl,6,4)."-".substr($dkl,3,2)."-".substr($dkl,0,2);
 $datav=substr($datav,6,4)."-".substr($datav,3,2)."-".substr($datav,0,2);
 $datavuh=substr($datavuh,6,4)."-".substr($datavuh,3,2)."-".substr($datavuh,0,2);
  
 $ath=mysql_query("UPDATE kans SET DATAI=DATE_FORMAT('$datavuh','%Y-%m-%d'),NI='$nvuh',KONVERT='$konv' 
	WHERE DATAV=DATE_FORMAT('$datav','%Y-%m-%d') AND NV='$nvh'");
if($ath){
	$ath1=mysql_query("INSERT INTO kans (DATAV,NV,KODP,NKL,DATAKL,NAIM,BOSS,PR,DATAI,NI,ZMIST,TIP,DATAVK,TIME,KONVERT,SEKR)
	VALUES(DATE_FORMAT('$datav','%Y-%m-%d'),'$nvh','','$nkl',
	DATE_FORMAT('$dkl','%Y-%m-%d'),'$naim',
	'$boss','2','$datavuh','$nvuh','$zmist','$tip','','$chas','$konv','$sekr');");
	if(!$ath1){
	echo "Вихідна інформація не внесена";}
}
else
	{
echo "Вхідній документації не присвоєно вихідний номер та дата";
}

	header("location: vhidna.php");

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