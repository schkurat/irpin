<?php
session_start();
$lg=$_SESSION['LG'];
$pas=$_SESSION['PAS'];

include "../function.php";

$bdat=date_bd($_POST['date1']);
$edat=date_bd($_POST['date2']);

$db=mysql_connect("localhost",$lg,$pas);
if(!$db) echo "Не вiдбулося зєднання з базою даних";
  
 if(!@mysql_select_db(kpbti,$db))
  {
   echo("Не завантажена таблиця");
   exit(); 
   }

$p='<b>Період: з  '.german_date($bdat).' по '.german_date($edat).'</b>
	<table border="1" cellpadding="0" cellspacing="0"><tr>
	<th align="center"><font size="2">#</font></th>
	<th align="center"><font size="2">Кременчучький район</font></th>
	<th align="center"><font size="2">Козельщинський район</font></th>
	<th align="center"><font size="2">Комсомольський район</font></th>
	<th align="center"><font size="2">Кобеляцький район</font></th>
	<th align="center"><font size="2">Глобинський район</font></th>
	<th align="center"><font size="2">Всього</font></th>
	</tr>
	';
$sum[][]="";
$sql1="SELECT dlya_oformlennya.id_oform,dlya_oformlennya.document FROM dlya_oformlennya
		WHERE dlya_oformlennya.ROB=1";	

$atu1=mysql_query($sql1);  
while($aut1=mysql_fetch_array($atu1))
{
$v_rob=$aut1["id_oform"];
$robota=$aut1["document"];
 $p.='<tr><td><font size="2"><b>'.$robota.'</b></font></td>';
 
$sql2="SELECT ID_RAYONA,RAYON FROM rayonu";			
$atu2=mysql_query($sql2);  
  while($aut2=mysql_fetch_array($atu2))
 {
$n_rayon=$aut2["RAYON"];
$id_rayon=$aut2["ID_RAYONA"];
 
$sql3="SELECT COUNT(*) AS SM FROM zamovlennya WHERE zamovlennya.DL='1' AND zamovlennya.VUD_ROB='$v_rob'
		AND zamovlennya.RN='$id_rayon' AND D_PR>='$bdat' AND D_PR<='$edat'";			
 $atu3=mysql_query($sql3);  
  while($aut3=mysql_fetch_array($atu3))
 {

$sum[$n_rayon][$robota]=$aut3["SM"];
$p.='<td align="center"><font size="2">'.$sum[$n_rayon][$robota].'</td>';
$zag_sum=$zag_sum+$sum[$n_rayon][$robota];
 } 
 mysql_free_result($atu3);  
 } 
 mysql_free_result($atu2); 
 
 $p.='<th align="center"><font size="2">'.$zag_sum.'</font></th></tr>';	
 $zag_sum=0;
  } 
 mysql_free_result($atu1); 
 $p.='</table>';
 echo $p;
if(mysql_close($db))
        {
        // echo("Закриття бази даних");
         }
         else
         {
          echo("Не можливо виконати закриття бази"); 
          }		  
?>