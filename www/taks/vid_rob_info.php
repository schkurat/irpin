<?php
include "../scriptu.php";

$docum=$_GET['doc'];
echo $docum;
$p='<table class="zmview">
<tr>
<th>#</th>
<th>Номер</th>
<th>Найменування робіт</th>
<th>Одиниці виміру</th>
<th>Норма<br>вим.</th>
<th>Норма<br>вик.</th>
<th>Норма<br>контр.</th>
<th>Норма<br>бюро</th>
</tr>';

$sql = "SELECT * FROM price ORDER BY NOM"; 
 $atu=mysql_query($sql);
  while($aut=mysql_fetch_array($atu))
 {	
$p.='<tr>
<td align="center"><a href="plus_vid_rob.php?id_pr='.$aut["ID_PRICE"].'&doc='.$docum.'"><img src="../images/plus.png"></a></td>
	<td>'.$aut["NOM"].'</td>
	<td>'.$aut["NAIM"].'</td>
	<td>'.$aut["ODV"].'</td>
	<td>'.$aut["VUM"].'</td>
	<td>'.$aut["VUK"].'</td>
	<td>'.$aut["KONTR"].'</td>
	<td>'.$aut["BURO"].'</td>
    </tr>';
}
mysql_free_result($atu);

$p.='</table>';
echo $p; 
?>