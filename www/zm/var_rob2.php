<?php
session_start();
$lg=$_SESSION['LG'];
$pas=$_SESSION['PAS'];
header('Content-Type: text/html; charset=utf-8');

include "../function.php";
$cena=0;
$kl=$_POST['kl'];
$smt=$_POST['sm'];
$pl=$_POST['pl'];
$db=mysql_connect("localhost",$lg,$pas);
if(!$db) echo "Не вiдбулося зєднання з базою даних"; 
 if(!@mysql_select_db(kpbti,$db))
  {echo("Не завантажена таблиця");
   exit();}
if($pl!=""){

  $ath=mysql_query("SELECT SUM FROM price2 WHERE PL_B<='$pl' AND PL_E>='$pl' AND ID_PRICE='$kl';");
  if($ath)
  {
   while($aut=mysql_fetch_array($ath))
   {
   $cena=$aut['SUM'];
   }
mysql_free_result($ath);} 
}
if($cena==0) $cena=$pl*$smt;
echo $cena;

 //echo 'Текст:вася:петя';
 if(mysql_close($db))
{}
else
    {echo("Не можливо виконати закриття бази");}   

//header("location: nove_zamovlennya.php");		
?>