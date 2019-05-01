<?php
$p='
<script type="text/javascript">
$(document).ready(
  function()
  {
  	$(".zmview tr").mouseover(function() {
  		$(this).addClass("over");
  	});
  
  	$(".zmview tr").mouseout(function() {
  		$(this).removeClass("over");
  	});
	$(".zmview tr:even").addClass("alt");
  }
);
</script>
<table class="zmview" align="center">
<tr bgcolor="#B5B5B5">
<th>#</th>
<th>Вид</th>
<th>№</th>
<th>Найменування робіт</th>
<th>Одиниця виміру</th>
<th>Норма вим.</th>
<th>Норма викон.</th>
<th>Норма контр.</th>
<th>Норма бюро</th>
</tr>';

$sql = "SELECT * FROM price ORDER BY NOM,NAIM";
			
 $atu=mysql_query($sql);
  while($aut=mysql_fetch_array($atu))
 {	
$p.='<tr bgcolor="#FFFAF0">
<td align="center"><a href="taks.php?filter=zmina_rob&id_pr='.$aut["ID_PRICE"].'"><img src="/images/b_edit.png"></a></td>	
	<td align="center">'.$aut["VUD"].'</td>
	<td align="center">'.$aut["NOM"].'</td>
      <td align="left">'.$aut["NAIM"].'</td>
      <td align="center">'.$aut["ODV"].'</td>
	  <td align="center">'.$aut["VUM"].'</td>
	  <td align="center">'.$aut["VUK"].'</td>
	  <td align="center">'.$aut["KONTR"].'</td>
	  <td align="center">'.$aut["BURO"].'</td>
      </tr>';
}
mysql_free_result($atu);
$p.='</table>';
echo $p; 
?>