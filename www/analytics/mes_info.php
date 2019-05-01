<?php
$fl=$_GET["fl"];
$p='<form action="analytics.php" name="myform" method="get">
<table align="center" class="zmview">
<tr><th colspan="2"><b>Оберіть місяць для розрахунку</b></th></tr>
<tr>
<td>Місяць</td>
<td>
<select name="mis" required>
<option value="01">січень</option>
<option value="02">лютий</option>
<option value="03">березень</option>
<option value="04">квітень</option>
<option value="05">травень</option>
<option value="06">червень</option>
<option value="07">липень</option>
<option value="08">серпень</option>
<option value="09">вересень</option>
<option value="10">жовтень</option>
<option value="11">листопад</option>
<option value="12">грудень</option>
</select> 20<input type="text" name="rik" size="2" value="'.date("y").'"/> року
<input type="hidden" name="filter" value="graf_filiya"/>
<input type="hidden" name="fl" value="'.$fl.'"/>
</td>
</tr>
<tr>
<td align="center"><input type="submit" id="submit" value="Розрахунок"></td>
<td align="center"><input name="reset" type="reset" id="reset" value="Очистити"></td>
</tr>
</table>
</form>';
echo $p; 
?>