<?php
session_start();
$lg=$_SESSION['LG'];
$pas=$_SESSION['PAS'];
$rn=$_POST['rajon2'];
$ns=$_POST['nsp2'];
$tip=$_POST['tup2'];

$db=mysql_connect("localhost",$lg,$pas);
if(!$db) echo "Не вiдбулося зєднання з базою даних";
  
 if(!@mysql_select_db(kpbti,$db))
  {
   echo("Не завантажена таблиця");
   exit(); 
   }
 
 $sqll = "SELECT NSP FROM nas_punktu WHERE '$ns'=NSP AND ID_TIP_NSP='$tip' AND ID_RN='$rn'"; 
 $atuu=mysql_query($sqll);
  while($autt=mysql_fetch_array($atuu))
 {
	$nsp1=$autt["NSP"];   
 }
 mysql_free_result($atuu);    
 if($nsp1==""){

$id='';

$sql = "SELECT ID_NSP FROM nas_punktu ORDER BY ID_NSP DESC LIMIT 1"; 
 $atu=mysql_query($sql);
  while($aut=mysql_fetch_array($atu))
 {
	$id=$aut["ID_NSP"]+1;    
 }
 mysql_free_result($atu); 

 if ($id==''){
$id=1;
}	

 $ath1=mysql_query("INSERT INTO nas_punktu (ID_RN,ID_NSP,NSP,ID_TIP_NSP) VALUES('$rn', '$id', '$ns','$tip');");
	if(!$ath1){
	echo "Населений пункт не внесений до БД";} 
	
	
//header("location: zamovlennya.php");
echo '1';
	}
//else{echo "Такий населений пункт вже існує в базі";} 
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