<?php
session_start();
$lg=$_SESSION['LG'];
$pas=$_SESSION['PAS'];
$nvr=$_POST['n_vr'];
$vid=$_POST['vid'];
$naimvr=$_POST['naim_vr'];
$odv=$_POST['odv'];
$vum=$_POST['vum'];
$vuk=$_POST['vuk'];
$kontr=$_POST['kontr'];
$buro=$_POST['buro'];

$db=mysql_connect("localhost",$lg,$pas);
if(!$db) echo "Не вiдбулося зєднання з базою даних";
  
 if(!@mysql_select_db(kpbti,$db))
  {
   echo("Не завантажена таблиця");
   exit(); 
   }

  $sql = "SELECT ID_PRICE FROM price ORDER BY ID_PRICE DESC LIMIT 1"; 
 $atu=mysql_query($sql);
  while($aut=mysql_fetch_array($atu))
 {
	$id=$aut["ID_PRICE"]+1;    
 }
 mysql_free_result($atu); 

 if ($id==''){
$id=1;
}	  

$ath1=mysql_query("INSERT INTO price (ID_PRICE,VUD,NOM,NAIM,ODV,VUM,VUK,KONTR,BURO) VALUES('$id','$vid','$nvr','$naimvr','$odv','$vum','$vuk','$kontr','$buro');");
	if(!$ath1){
	echo "Новий вид роботи не внесений до БД";} 

//Zakrutie bazu       
       if(mysql_close($db))
        {
        // echo("Закриття бази даних");
         }
         else
         {
          echo("Не можливо виконати закриття бази"); 
          }
		  
header("location: taks.php");
?>