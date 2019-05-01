<?php
session_start();
$lg=$_SESSION['LG'];
$pas=$_SESSION['PAS'];
$idvr=$_GET['idvr'];
$id_price=$_GET['id_pr'];
$docm=$_GET['docum'];

$db=mysql_connect("localhost",$lg,$pas);
if(!$db) echo "Не вiдбулося зєднання з базою даних";
  
 if(!@mysql_select_db(kpbti,$db))
  {
   echo("Не завантажена таблиця");
   exit(); 
   }
 
$sql1 = "SELECT RB FROM dlya_oformlennya WHERE id_oform='$idvr'";
$atu1=mysql_query($sql1);
while($aut1=mysql_fetch_array($atu1))
{$rb=$aut1["RB"];}
mysql_free_result($atu1);

$n=substr_count($rb,":");
$robota=explode(":",$rb);
 
for($i=0; $i<=$n; $i++){
if($robota[$i]==$id_price) $robota[$i]="";
}
$rob2="";
for($i=0; $i<=$n; $i++){
if($robota[$i]!="") $rob2.=':'.$robota[$i];
}
$rob3=substr($rob2,1); 
 
$ath2=mysql_query("UPDATE dlya_oformlennya SET RB='$rob3' WHERE id_oform='$idvr'");
	if(!$ath2){echo "Сума не внесена до БД";}  
	
//Zakrutie bazu       
       if(mysql_close($db))
        {
        // echo("Закриття бази даних");
         }
         else
         {
          echo("Не можливо виконати закриття бази"); 
          }		  
header("location: taks.php?filter=edit_vid_rob&doc=$docm");
?>