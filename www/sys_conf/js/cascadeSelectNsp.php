<?php
session_start();
$lg=$_SESSION['LG'];
$pas=$_SESSION['PAS'];
header('Content-Type: text/html; charset=utf-8');
if($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest') {
//$p=mysql_query("SET NAMES CP866");
    
	$db=mysql_connect("localhost",$lg,$pas);
	if(!$db) echo "Не вiдбулося зєднання з базою даних";
	
	if(!@mysql_select_db(kpbti,$db))
	{
	echo("Не завантажена таблиця");
	exit(); 
	}
	$vst="Виберiть населений пункт";
//	$vst = iconv("UTF-8", "CP866", $vst);
	
   $pr1='[';
   $pr2='{"value":"","text":"'.$vst.'"}';
   $pr3='';
   $pr4=']';

   $rn=$_GET['rayon'];
  // $rn = iconv("UTF-8", "CP866", $rn);
   if($rn!=""){
				$ath=mysql_query("SELECT PNS, NS FROM NSL WHERE CNR='$rn'");
				if($ath)
					{
					while($aut=mysql_fetch_array($ath))
						{
						$pr3.=',{"value":"'.$aut['NS'].'","text":"'.$aut['PNS'].'"}';
						}
					}
					
				 print $pr1.$pr2.$pr3.$pr4;
				mysql_free_result($ath);
				}
	else{
	print $pr1.$pr2.$pr4;
	}
		if(mysql_close($db))
        {
        //  echo("Закриття бази даних");
         }
         else
         {
          echo("Не можливо виконати закриття бази");
          }   
}
?>