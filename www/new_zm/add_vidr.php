<?php
session_start();
$lg=$_SESSION['LG'];
$pas=$_SESSION['PAS'];

$tup=$_POST['tip'];
$vr=$_POST['v_rob'];
$vart=$_POST['vart'];

$db=mysql_connect("localhost",$lg,$pas);
if(!$db) echo "Не вiдбулося зєднання з базою даних";
  
 if(!@mysql_select_db(kpbti,$db))
  {
   echo("Не завантажена таблиця");
   exit(); 
   }

$sql = "SELECT id_oform FROM dlya_oformlennya ORDER BY id_oform DESC LIMIT 1"; 
 $atu=mysql_query($sql);
  while($aut=mysql_fetch_array($atu))
 {
	$id=$aut["id_oform"]+1;    
 }
 mysql_free_result($atu); 

 if ($id==''){
$id=1;
}	

$ath1=mysql_query("INSERT INTO dlya_oformlennya (id_oform,TIP,document,VART) VALUES('$id','$tup','$vr','$vart');");
	if(!$ath1){
	echo "Вулиця не внесена до БД";} 

//Zakrutie bazu       
       if(mysql_close($db))
        {
        // echo("Закриття бази даних");
         }
         else
         {
          echo("Не можливо виконати закриття бази"); 
          }
		  
header("location: index.php");
?>