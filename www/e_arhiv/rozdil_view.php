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
<table align="center" class="zmview">
<tr bgcolor="#B5B5B5">
<th>Перелік розділів</th>
</tr>';
$sql="SELECT * FROM rozdilu WHERE DL='1' ORDER BY NAME";
 $atu=mysql_query($sql);
  while($aut=mysql_fetch_array($atu))
 {	
$p.='<tr bgcolor="#FFFAF0"><td>'.$aut["NAME"].'</td></tr>';
}
mysql_free_result($atu);
$p.='</table>';
echo $p; 
?>