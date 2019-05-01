<?php
session_start();
$log=$_SESSION['LG'];
$pas=$_SESSION['PAS'];
$fam=$_POST['priz'];
$im=$_POST['imya'];
$pb=$_POST['pobat'];
$lg=$_POST['id_us'];
$pravam="";
$prava_tl="";
$d_zm="";
$d_ps="";

if($fam!="" and $im!="" and $pb!=""){
for($i=1; $i<=15; $i++){
$temp=$_POST[$i];
if($temp=="pr".$i){$pravam.=1;}
else
{$pravam.=0;}
}
//echo $pravam;
/* for($i=1; $i<=43; $i++){
$zz='d'.$i;
$temp=$_POST[$zz];
if($temp=="pz".$i){$d_zm.=1;}
else
{$d_zm.=0;}
} */
//echo $d_zm;
if(isset($_POST["21"])) $prava_tl=1; else $prava_tl=0;
if(isset($_POST["25"])) $d_ps=1; else $d_ps=0;

$db=mysql_connect("localhost",$log,$pas);
if(!$db) echo "Не вiдбулося зєднання з базою даних";
  
 if(!@mysql_select_db(kpbti,$db))
  {
   echo("Не завантажена таблиця");
   exit(); 
   }
   
$ath1=mysql_query("UPDATE security SET PR='$fam',IM='$im',PB='$pb',PRD='$pravam',DPS='$d_ps',
	DTL='$prava_tl'	WHERE LOG='$lg' AND DL='1'");
	if(!$ath1){echo "Користувач не внесений до БД";}  

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
echo "Ви не внесли дані або паролі не співпадають!";
}
		  		  
header("location: admin.php");
?>