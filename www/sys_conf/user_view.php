<?php
//include_once "../function.php";
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
<th>Логін</th>
<th>Прізвище</th>
<th>Ім`я</th>
<th>По батькові</th>
</tr>';

$sql = "SELECT LOG,PR,IM,PB FROM security WHERE DL!='0' AND LOG!='ans'"; 
				
 $atu=mysql_query($sql);
  while($aut=mysql_fetch_array($atu))
  {	

$p.='<tr bgcolor="#FFFAF0">
<td align="center"><a href="admin.php?filter=edit_user&name='.$aut["LOG"].'"><img src="/images/b_edit.png" border="0"></a></td>
<td align="center"><a href="delete_user.php?login='.$aut["LOG"].'"><img src="/images/b_drop.png" border="0"></a></td>
	<td align="center">'.$aut["LOG"].'</td>
    <td align="center">'.$aut["PR"].'</td>
	<td align="center">'.$aut["IM"].'</td>
	<td align="center">'.$aut["PB"].'</td>
    </tr>';
}
mysql_free_result($atu);
$p.='</table>';
echo $p; 


//$mail =& Mail::factory('smtp', array('host' => 'localhost', 'port' => 25)); 
//$mail->send('postmaster@localhost', $hdrs, $body); 

//$mail->send("bti_m@ukr.net", "test", "test"); 
?>