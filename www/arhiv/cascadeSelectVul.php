<?php
session_start();
$lg=$_SESSION['LG'];
$pas=$_SESSION['PAS'];
header('Content-Type: text/html; charset=utf-8');
if($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest') {
	
	$db=mysql_connect("localhost",$lg,$pas);
	if(!$db) echo "Не вiдбулося зєднання з базою даних";
	
	if(!@mysql_select_db(kpbti,$db))
	{
	echo("Не завантажена таблиця");
	exit(); 
	}
   $pr1='[';
   $pr2='{"value":"","text":"Виберiть вулицю"}';
   $pr3='';
   $pr4=']';
   
  $rn=$_GET['rayon']; 
  $np=$_GET['nsp'];
  
  
if($rn!=""){
				$ath=mysql_query("SELECT vulutsi.ID_VUL, vulutsi.VUL, tup_vul.TIP_VUL  
				FROM vulutsi,tup_vul WHERE vulutsi.ID_RN='$rn' AND vulutsi.ID_NSP='$np' AND  tup_vul.ID_TIP_VUL=vulutsi.ID_TIP_VUL ORDER BY vulutsi.VUL");
				if($ath)
					{
					while($aut=mysql_fetch_array($ath))
						{
						$pr3.=',{"value":"'.$aut['ID_VUL'].'","text":"'.htmlspecialchars($aut['VUL'],ENT_QUOTES).' '.$aut['TIP_VUL'].'"}';
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