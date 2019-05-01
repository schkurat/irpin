<?php
include "../scriptu.php";

$docum=$_GET['doc'];

$p='<table class="zmview">
<tr><th colspan="8" style="font-size: 35px;"><b>'.$docum.'</b></th></tr>
<tr>
<th><a href="taks.php?filter=vid_rob_info&doc='.$docum.'"><img src="../images/b_plus.png"></a></th>
<th>Номер</th>
<th>Найменування робіт</th>
<th>Одиниці виміру</th>
<th>Норма<br>вим.</th>
<th>Норма<br>вик.</th>
<th>Норма<br>контр.</th>
<th>Норма<br>бюро</th>
</tr>';

$sql1 = "SELECT RB,id_oform FROM dlya_oformlennya WHERE document='$docum'";
$atu1=mysql_query($sql1);
while($aut1=mysql_fetch_array($atu1))
{$rob=$aut1["RB"];
$id_vid_rob=$aut1["id_oform"];}
mysql_free_result($atu1);

$n=substr_count($rob,":");
$robota=explode(":",$rob);

for($i=0; $i<=$n; $i++){
$sql = "SELECT * FROM price WHERE ID_PRICE='$robota[$i]'"; 
 $atu=mysql_query($sql);
  while($aut=mysql_fetch_array($atu))
 {	
$p.='<tr>
<td align="center"><a href="delete_vid_rob.php?docum='.$docum.'&idvr='.$id_vid_rob.'&id_pr='.$aut["ID_PRICE"].'"><img src="/images/b_drop.png"></a></td>
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
}
$p.='</table>';
echo $p; 
?>