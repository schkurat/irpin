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
<form action="naryadu.php" name="myform" method="get">
<table align="center" class="zmview">
<tr><th  align="center">Оберіть файл для обробки</th></tr>
<?php
if ($handle = opendir('/home/common/andrey/import')) {
    while (false !== ($file = readdir($handle))) { 
        if ($file != "." && $file != "..") { 
echo '<tr><td><input name="n_radio" type="radio" value="/home/common/andrey/import/'.$file.'"/>'.$file.'</td></tr>'; 
        } 
    }
    closedir($handle); 
}
?>
<tr><td align="center" colspan="2">
<input name="filter" type="hidden" value="obrobka">
<input name="fl" type="hidden" value="pib">
<input name="Ok" type="submit" value="Обробка" />
</form>
<!--<form action="zamovlennya.php?filter=logo" name="myform" method="post">-->
<a href="naryadu.php" ><input name="Cancel" type="button" value="Відміна" /></a>
<!--</form>-->
</td>
</tr>
</table>