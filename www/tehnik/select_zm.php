<?php
session_start();
header('Content-Type: text/html; charset=utf-8');
$lg=$_SESSION['LG'];
$pas=$_SESSION['PAS'];
$pr=$_SESSION['PR'];
$im=$_SESSION['IM'];
$pb=$_SESSION['PB'];
include "../function.php";
$vuk=$pr.' '.p_buk($im).'.'.p_buk($pb).'.';
?>
<html>
<head>
<title>
Автоматизована система інвентаризації об'єктів нерухомості
</title>
<link rel="stylesheet" type="text/css" href="/my.css" />
</head>
<body>
<?php
$db=mysql_connect("localhost",$lg ,$pas);
if(!$db) echo "Не вiдбулося зєднання з базою даних";
 if(!@mysql_select_db(kpbti,$db))
  {
   echo("Не завантажена таблиця");
   exit(); 
   }
$p='<table align="center" border="1" cellspacing=0><tr><th>Оберіть замовлення для виконання</th></tr>';
$k=0;   
$sql = "SELECT zamovlennya.SZ,zamovlennya.NZ,rayonu.RAYON,nas_punktu.NSP,tup_nsp.TIP_NSP,zamovlennya.OBJ, 
				vulutsi.VUL,tup_vul.TIP_VUL,zamovlennya.KEY,zamovlennya.BUD,zamovlennya.KVAR 
			 FROM zamovlennya, rayonu, nas_punktu, vulutsi, tup_nsp, tup_vul
				WHERE 
					zamovlennya.DL='1' AND zamovlennya.VUD_ROB!=26 
					AND zamovlennya.D_PR>'2014-01-01' AND zamovlennya.PS='0'   
					AND rayonu.ID_RAYONA=zamovlennya.RN
					AND nas_punktu.ID_NSP=zamovlennya.NS
					AND vulutsi.ID_VUL=zamovlennya.VL
					AND tup_nsp.ID_TIP_NSP=nas_punktu.ID_TIP_NSP
					AND tup_vul.ID_TIP_VUL=vulutsi.ID_TIP_VUL
					ORDER BY SZ, NZ DESC";

 $atu=mysql_query($sql);
  while($aut=mysql_fetch_array($atu))
 {
$obj_ner=objekt_ner($aut["OBJ"],$aut["BUD"],$aut["KVAR"]);
$p.='<tr><td id="zal"><a href="select_zm_enter.php?kl='.$aut['KEY'].'&vuk='.$vuk.'
&vul='.$aut['TIP_VUL'].$aut['VUL'].'&nsp='.$aut['TIP_NSP'].$aut['NSP'].'&bud='.$aut["BUD"].'">'.
$aut['SZ'].'/'.$aut['NZ'].' '.$aut['RAYON'].' '.$aut['TIP_NSP'].$aut['NSP'].' '.
$aut['TIP_VUL'].$aut['VUL'].' '.$obj_ner.'</a></td></tr>';
$k++;
}
mysql_free_result($atu); 
$p.='</table>';
if($k!=0) echo $p;
else echo 'На виконавця '.$vuk.' не розподілено жодної заявки'; 

//Zakrutie bazu       
       if(mysql_close($db))
        {
        // echo("Закриття бази даних");
         }
         else
         {
          echo("Не можливо виконати закриття бази"); 
          }
?>
</body>
</html>