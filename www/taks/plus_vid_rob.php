<?php
session_start();
$lg=$_SESSION['LG'];
$pas=$_SESSION['PAS'];
$docum=$_GET['doc'];
$id_price=$_GET['id_pr'];

$db=mysql_connect("localhost",$lg,$pas);
if(!$db) echo "Не вiдбулося зєднання з базою даних";
  
 if(!@mysql_select_db(kpbti,$db))
  {
   echo("Не завантажена таблиця");
   exit(); 
   }

$sql1 = "SELECT RB FROM dlya_oformlennya WHERE document='$docum'";
$atu1=mysql_query($sql1);
while($aut1=mysql_fetch_array($atu1))
{$rob=$aut1["RB"];}
mysql_free_result($atu1);

$kf=0;
$n=substr_count($rob,":");
$robota=explode(":",$rob);
for($i=0; $i<=$n; $i++){
if($robota[$i]==$id_price) $kf=1;
 /* echo "rob=".$robota[$i]."<br>";
echo "id=".$id_price; */
}
if($kf==0){
if($rob=="") $rob2=$id_price;
else $rob2=$rob.':'.$id_price; 
/* $pos = strpos($rob,$id_price);
*/

$ath2=mysql_query("UPDATE dlya_oformlennya SET RB='$rob2' WHERE document='$docum'");
	if(!$ath2){echo "До послуги не внесені види робіт до БД";}  

//Zakrutie bazu       
       if(mysql_close($db))
        {// echo("Закриття бази даних");
		}
         else
         {echo("Не можливо виконати закриття бази"); }
		 
header("location: taks.php?filter=edit_vid_rob&doc=$docum");
}
else echo "Цей вид робіт вже присутній в даній послузі";
?>