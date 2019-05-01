<?php
session_start();
$lg=$_SESSION['LG'];
$pas=$_SESSION['PAS'];
$kodp=$_SESSION['KODP'];
header('Content-Type: text/html; charset=utf-8');
if($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest') {
$db=mysql_connect("localhost",$lg,$pas);
if(!$db) echo "Не вiдбулося зєднання з базою даних"; 
 if(!@mysql_select_db(kpbti,$db))
  {echo("Не завантажена таблиця");
   exit();}

$vbuk=$_GET['q'];
$nom=strlen($vbuk)-2;
/* if($kodp>=1400){ $flag=2;}
else{ $flag=1;} */
//AND ROB='$flag'
 if($vbuk){
	$ath=mysql_query("SELECT document FROM dlya_oformlennya WHERE '$vbuk'=LEFT(document,$nom)");
				if($ath){
					while($aut=mysql_fetch_array($ath))
					{
					$pr=$aut['document'];
					print $pr."\n";
					}
						}
				mysql_free_result($ath);
	}
if(mysql_close($db))
{}
else
    {echo("Не можливо виконати закриття бази");}   
}
?>