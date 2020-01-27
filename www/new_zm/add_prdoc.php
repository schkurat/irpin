<?php
session_start();
$lg=$_SESSION['LG'];
$pas=$_SESSION['PAS'];
$db=mysql_connect("localhost",$lg,$pas);
if(!$db) echo "Не вiдбулося зєднання з базою даних";
  
 if(!@mysql_select_db(kpbti,$db))
  {
   echo("Не завантажена таблиця");
   exit(); 
   }
$sz=$_POST['szam']; 
$nz=$_POST['nzam'];
$kl=$_POST['kl'];
$sql = "SELECT COUNT(*) FROM pravo_doc";   
$atu=mysql_query($sql);   
if($atu) $cn=mysql_result($atu,0);
//echo $cn;
mysql_free_result($atu);
for($i=1; $i<=$cn; $i++){
$dc[$i]=$_POST[$i];
if($dc[$i]!=""){
$prd.=$i.":";}
}

if($prd!=""){
 $ath=mysql_query("UPDATE zamovlennya SET PRDOC='$prd'
								WHERE zamovlennya.KEY='$kl'");
if(!$ath){
echo "Загальна інформація про правові документи не змінена";
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
		  
header("location: index.php?filter=zm_view");
}
else
{
echo "Не вибрано жодного правового документу!";
}
?>