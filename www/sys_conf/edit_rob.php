<?php
include_once "../function.php";
$kod=$_GET['kod'];
$sql = "SELECT ROBITNUK,BRUGADA,DN,ROBS FROM robitnuku WHERE ID_ROB='$kod' AND DL='1'"; 
$atu=mysql_query($sql);
while($aut=mysql_fetch_array($atu))
{	
$pib=$aut['ROBITNUK'];
$brug=$aut['BRUGADA'];
$dn=german_date($aut['DN']);
$pib_s=$aut['ROBS'];
}
mysql_free_result($atu);
$pib_m=explode(" ",$pib);
?>
<script type="text/javascript">
$(document).ready(function(){
													$('#sko').bind('focus',net_fokusa);
												}); 
		function net_fokusa(eventObj)
					{
						var pri=$("#pr").val(), ima=$("#im").val(), pba=$("#pb").val();
						var sok=pri+" "+ima[0]+"."+pba[0]+".";
						$("#sko").val(sok);				
					}
</script>
<form action="add_rob_db.php" name="myform" method="post">
<table align="center" class="zmview">
<tr><th colspan="4" align="center">Редагування робітника</th></tr>

<tr><td>Прізвище</td><td><input id="pr" name="priz" type="text" value="<?php echo $pib_m[0];?>"/></td></tr>
<tr><td>Ім`я</td><td><input id="im" name="imya" type="text" value="<?php echo $pib_m[1];?>"/></td></tr>
<tr><td>По батькові</td><td><input id="pb" name="pobat" type="text" value="<?php echo $pib_m[2];?>"/></td></tr>
<tr><td>Бригада</td>
<td>
<?php
$temp="";
for($i=1; $i<=9; $i++){
if($brug==$i)$temp{$i}="selected";
else $temp{$i}="";
}
?>
<select name="br">
<option value="0">Оберіть бригаду</option>
<option <?php echo $temp{1}; ?> value="1">1 бригада</option>
<option <?php echo $temp{2}; ?> value="2">2 бригада</option>
<option <?php echo $temp{3}; ?> value="3">3 бригада</option>
<option <?php echo $temp{4}; ?> value="4">4 бригада</option>
<option <?php echo $temp{5}; ?> value="5">5 бригада</option>
<option <?php echo $temp{6}; ?> value="6">Приймальник</option>
<option <?php echo $temp{7}; ?> value="7">Архіваріус</option>
<option <?php echo $temp{8}; ?> value="8">Бригадир</option>
<option <?php echo $temp{9}; ?> value="9">Адміністрація</option>
</select>
</td></tr>
<tr><td>Скорочено</td><td><input id="sko" name="sk" type="text" value="<?php echo $pib_s;?>"/>
<input type="hidden" name="flag" value="red"/>
<input type="hidden" name="sach" value="<?php echo $kod;?>"/>
</td></tr>
<tr><td>Дата нар.</td><td><input name="dn" type="text" value="<?php echo $dn;?>"/></td></tr>
<tr><td align="center">
<input name="Ok" type="submit" value="Змінити" /></td>
<td align="center">
<input name="reset" type="reset" value="Очистити" />
</td>
</tr>
</table>
</form>