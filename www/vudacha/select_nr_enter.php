<?php
session_start();
header('Content-Type: text/html; charset=utf-8');
$lg=$_SESSION['LG'];
$pas=$_SESSION['PAS'];

$nas=$_GET['nsp'];
$db=mysql_connect("localhost",$lg ,$pas);
if(!$db) echo "Не вiдбулося зєднання з базою даних";
 if(!@mysql_select_db(kpbti,$db))
  {
   echo("Не завантажена таблиця");
   exit(); 
   }

 $ath=mysql_query("SELECT * FROM spr_nr WHERE NAS='$nas';");
  if($ath)
  {while($aut=mysql_fetch_array($ath))
   {
   $nr=$aut['NR'];
  /* $ns=$aut['NS'];
   $vl=$aut['VL']; */
   $kodp=$aut['KODP'];
   $kod_zm=$aut['KOD_ZM'];
   }
mysql_free_result($ath);}  

$_SESSION['NR']=$nr;
/*$_SESSION['NS']=$ns;
$_SESSION['VL']=$vl; */
$_SESSION['KODP']=$kodp;
$_SESSION['KOD_ZM']=$kod_zm;
$_SESSION['NAS']=$nas;

//Zakrutie bazu       
       if(mysql_close($db))
        {
        // echo("Закриття бази даних");
         }
         else
         {
          echo("Не можливо виконати закриття бази"); 
          }
 header("location: vudacha.php?filter=vudacha_view");
?>