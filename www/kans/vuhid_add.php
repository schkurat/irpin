<?php
session_start();
$lg=$_SESSION["LG"];
$pas=$_SESSION["PAS"];
$pr_prie=$_SESSION["PR"];
$im_prie=$_SESSION["IM"];
$pb_prie=$_SESSION["PB"];
include_once "../function.php";
$kor=$_POST["kores"];
//$nvuh=$_POST["nvuh"];
$datavuh=$_POST["data_vuh"];
$zmist=$_POST["zauv"];
$sekr=$pr_prie." ".p_buk($im_prie).".".p_buk($pb_prie);
if(isset($_POST["konvert"])) $konv=$_POST["konvert"];
else $konv="0"; 

$db=mysql_connect("localhost",$lg,$pas);
if(!$db) echo "Не вiдбулося зєднання з базою даних";
  
 if(!@mysql_select_db(kpbti,$db))
  {
   echo("Не завантажена таблиця");
   exit(); 
   }

$nvuh=="";
$d1=date("Y-m-d",mktime(0,0,0,1,1,date("Y")));

 $sql1 = "SELECT NI FROM kans WHERE DATAI>=\"$d1\" ORDER BY NI DESC LIMIT 1"; 
 $atu1=mysql_query($sql1);
  while($aut1=mysql_fetch_array($atu1))
 {
	$nvuh=$aut1["NI"]+1; 
 }
 mysql_free_result($atu1); 
if ($nvuh==""){
$nvuh=1;
} 
 
 $datavuh=substr($datavuh,6,4)."-".substr($datavuh,3,2)."-".substr($datavuh,0,2);
  
$ath1=mysql_query("INSERT INTO kans (DATAV,NV,NKL,DATAKL,NAIM,BOSS,PR,DATAI,NI,ZMIST,TIP,
	DATAVK,TIME,KONVERT,SEKR) VALUES(\"\",\"\",\"\",DATE_FORMAT(\"$datavuh\",\"%Y-%m-%d\"),\"$kor\",
	\"\",\"2\",DATE_FORMAT(\"$datavuh\",\"%Y-%m-%d\"),\"$nvuh\",\"$zmist\",\"\",\"\",\"\",\"$konv\",\"$sekr\");");
	if(!$ath1){
	echo "Вихідна інформація не внесена";}

	header("location: vuhidna.php?kor=".$kor."&zmist=".$zmist."");

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