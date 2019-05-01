<?php
include_once "../function.php";
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
<table align="center" class="zmview">
<tr>
<th colspan="2">#</th>
<th>ПІБ</th>
<th>Бригада</th>
<th>Скорочено</th>
<th>Дата нар.</th>
<th>Статус</th>
</tr>';

$sql = "SELECT ID_ROB,ROBITNUK,BRUGADA,ROBS,DN,DL FROM robitnuku WHERE robitnuku.ID_ROB!=1 ORDER BY ROBITNUK"; 
 $atu=mysql_query($sql);
  while($aut=mysql_fetch_array($atu))
  {	
	if($aut["DL"]=="1") {$prop="active.gif";}
		else{$prop="not_active.gif";}
		
$p.='<tr bgcolor="#FFFAF0">
<td align="center"><a href="admin.php?filter=edit_rob&kod='.$aut["ID_ROB"].'"><img src="/images/b_edit.png" border="0"></a></td>
<td align="center"><a href="del_rob.php?pib='.$aut["ROBITNUK"].'"><img src="/images/b_drop.png" border="0"></a></td>
	<td>'.$aut["ROBITNUK"].'</td>
    <td align="center">'.$aut["BRUGADA"].'</td>
	<td>'.$aut["ROBS"].'</td>
	<td>'.german_date($aut["DN"]).'</td>
	<td align="center"><img src="/images/'.$prop.'"></td>
    </tr>';
}
mysql_free_result($atu);
$p.='</table>';
echo $p; 
?>