<?php
header('Content-Type: text/html; charset=utf-8');
if($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest') {

//$p=mysql_query("SET NAMES CP866");
$db=mysql_connect("localhost","root","123456");
if(!$db) echo "�� �i��㫮�� �󤭠��� � ����� �����"; 
 if(!@mysql_select_db(bti,$db))
  {echo("�� �����⠦��� ⠡����");
   exit();}

$vkod=$_GET['q'];
$nom=strlen($vkod);
 if($vkod){
	$ath=mysql_query("SELECT IDK FROM SPR_KOD WHERE '$vkod'=LEFT(IDK,$nom)");
				if($ath){
					while($aut=mysql_fetch_array($ath))
					{
					$pr=$aut['IDK'];
					print $pr."\n";
					}
						}
				mysql_free_result($ath);
	}
if(mysql_close($db))
{}
else
    {echo("�� ������� ������� ������� ����");}   
}
?>