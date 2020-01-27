<?php
session_start();
$lg=$_SESSION['LG'];
$pas=$_SESSION['PAS'];
$rn=$_POST['rajon3'];
$ns=$_POST['nsp3'];
$vl=$_POST['vul3'];
$tip=$_POST['tup3'];

$db=mysql_connect("localhost",$lg,$pas);
if(!$db) echo "Не вiдбулося зєднання з базою даних";
  
 if(!@mysql_select_db(kpbti,$db))
  {
   echo("Не завантажена таблиця");
   exit(); 
   }

$sqll = "SELECT VUL FROM vulutsi WHERE '$vl'=VUL AND ID_TIP_VUL='$tip' AND ID_RN='$rn' AND ID_NSP='$ns'"; 
 $atuu=mysql_query($sqll);
  while($autt=mysql_fetch_array($atuu))
 {
	$v1=$autt["VUL"];   
 }
 mysql_free_result($atuu);    
 if($v1=="" and $tip!=0 and $rn!="" and $ns!=""){
 
$id='';

$sql = "SELECT ID_VUL FROM vulutsi ORDER BY ID_VUL DESC LIMIT 1"; 
 $atu=mysql_query($sql);
  while($aut=mysql_fetch_array($atu))
 {
	$id=$aut["ID_VUL"]+1;    
 }
 mysql_free_result($atu); 

 if ($id==''){
$id=1;
}	

 $ath1=mysql_query("INSERT INTO vulutsi (ID_RN,ID_NSP,ID_VUL,VUL,ID_TIP_VUL) VALUES('$rn','$ns','$id','$vl','$tip');");
	if(!$ath1){
	echo "Вулиця не внесена до БД";} 
	
//header("location: index.php");
echo '1';
	}
//else{echo "Така вулиця чи провулок вже існує в базі";} 
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