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
   $pr2='{"value":"","text":"Виберiть населений пункт"}';
   $pr3='';
   $pr4=']';

   $rn=$_GET['rayon'];
  // $ns=$_GET['nsp'];
   if($rn!=""){
				$ath=mysql_query("SELECT nas_punktu.ID_NSP,nas_punktu.NSP, nas_punktu.ID_TIP_NSP,tup_nsp.TIP_NSP 
						FROM nas_punktu,tup_nsp WHERE nas_punktu.ID_RN='$rn' AND nas_punktu.ID_TIP_NSP=tup_nsp.ID_TIP_NSP ORDER BY NSP");
				if($ath)
					{
					while($aut=mysql_fetch_array($ath))
						{
						$pr3.=',{"value":"'.$aut['ID_NSP'].'","text":"'.htmlspecialchars($aut['NSP'],ENT_QUOTES).' '.$aut['TIP_NSP'].'"}';
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