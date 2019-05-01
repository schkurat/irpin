<?php
include "../scriptu.php";

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
<tr>
<th>Послуги</th>
</tr>';

$sql = "SELECT document FROM dlya_oformlennya WHERE ROB=1 ORDER BY document";
			
 $atu=mysql_query($sql);
  while($aut=mysql_fetch_array($atu))
 {	
$p.='<tr>
	<td id="zal"><a href="taks.php?filter=edit_vid_rob&doc='.$aut["document"].'">'.$aut["document"].'</a></td>
      </tr>';
}
mysql_free_result($atu);
$p.='</table>';
echo $p; 
?>