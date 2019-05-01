<?php
session_start();
$log=$_SESSION['LG'];
$pas=$_SESSION['PAS'];

$inv_spr=$_POST["inv_spr"];
if(isset($_POST["1"])) $title='1'; else $title='0';
if(isset($_POST["2"])) $opis='1'; else $opis='0';
/* if(isset($_POST["3"])) $zvakt='1'; else $zvakt='0'; */
if(isset($_POST["4"])) $planzem='1'; else $planzem='0';
if(isset($_POST["5"])) $planbud='1'; else $planbud='0';
if(isset($_POST["6"])) $jurcost='1'; else $jurcost='0';
/* if(isset($_POST["7"])) $jplbudvbud='1'; else $jplbudvbud='0';
if(isset($_POST["8"])) $jzobm='1'; else $jzobm='0'; 
if(isset($_POST["9"])) $jpldil='1'; else $jpldil='0';
if(isset($_POST["10"])) $oaktbud='1'; else $oaktbud='0';
if(isset($_POST["11"])) $oaktgos='1'; else $oaktgos='0'; */
if(isset($_POST["12"])) $eskiz='1'; else $eskiz='0';
if(isset($_POST["13"])) $abris='1'; else $abris='0';
if(isset($_POST["14"])) $kamer='1'; else $kamer='0';
if(isset($_POST["15"])) $zamovl='1'; else $zamovl='0';
if(isset($_POST["16"])) $inshi='1'; else $inshi='0';

$db=mysql_connect("localhost",$log,$pas);
if(!$db) echo "Не вiдбулося зєднання з базою даних";
  
 if(!@mysql_select_db(kpbti,$db))
  {
   echo("Не завантажена таблиця");
   exit(); 
   }
$kl=0;
$sql1 = "SELECT arh_sec.ID FROM arh_sec WHERE arh_sec.N_SPR='$inv_spr' AND arh_sec.DL='1'"; 
$atu1=mysql_query($sql1);
while($aut1=mysql_fetch_array($atu1))
{
	$kl++;
}
mysql_free_result($atu1);

if($kl==0){
	$ath1=mysql_query("INSERT INTO arh_sec(N_SPR,TITLE,OPIS,PLANZEM,PLANBUD,JURCOST,ESKIZ,ABRIS,KAMER,ZAMOVL,INSHI)
	VALUES ('$inv_spr','$title','$opis','$planzem','$planbud','$jurcost','$eskiz','$abris','$kamer','$zamovl','$inshi');");
}
else{
	$ath1=mysql_query("UPDATE arh_sec SET TITLE='$title',OPIS='$opis',PLANZEM='$planzem',
	PLANBUD='$planbud',JURCOST='$jurcost',ESKIZ='$eskiz',ABRIS='$abris',KAMER='$kamer',ZAMOVL='$zamovl',INSHI='$inshi' 
	WHERE N_SPR='$inv_spr' AND DL='1'");
	if(!$ath1){echo "Користувач не внесений до БД";}  
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

		  		  
//header("location: admin.php?filter=sprava_info&inv_spr=".$inv_spr);
header("location: admin.php?filter=earh_view");
?>