<?php
session_start();
$log=$_SESSION['LG'];
$pas=$_SESSION['PAS'];
include_once "../function.php";
$fam=$_POST['priz'];
$im=$_POST['imya'];
$pb=$_POST['pobat'];
$br=$_POST['br'];
$dn=date_bd($_POST['dn']);
$sko=$_POST['sk'];
$flg=$_POST['flag'];

if($fam!="" and $im!="" and $pb!="" and $br!=0){

$db=mysql_connect("localhost",$log,$pas);
if(!$db) echo "Не вiдбулося зєднання з базою даних";
  
 if(!@mysql_select_db(kpbti,$db))
  {
   echo("Не завантажена таблиця");
   exit(); 
   }

$pib=$fam.' '.$im.' '.$pb;
if($flg=="new"){   
$ath1=mysql_query("INSERT INTO robitnuku(ROBITNUK,BRUGADA,ROBS,DN) VALUES ('$pib','$br','$sko','$dn');");
	if(!$ath1){echo "Користувач не внесений до БД";}  
}
if($flg=="red"){   
$poisk=$_POST['sach'];
$ath1=mysql_query("UPDATE robitnuku SET ROBITNUK='$pib',BRUGADA='$br',ROBS='$sko',DN='$dn' 
								WHERE ID_ROB='$poisk' AND DL='1'");
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
}
else{
echo "Ви не внесли дані або не обрали бригаду!";
}
		  		  
header("location: admin.php?filter=rob_view");
?>