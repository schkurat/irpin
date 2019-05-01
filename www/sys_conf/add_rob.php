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
<tr><th colspan="4" align="center">Новий робітник</th></tr>

<tr><td>Прізвище</td><td><input id="pr" name="priz" type="text" /></td></tr>
<tr><td>Ім`я</td><td><input id="im" name="imya" type="text" /></td></tr>
<tr><td>По батькові</td><td><input id="pb" name="pobat" type="text" /></td></tr>
<tr><td>Бригада</td>
<td>
<select name="br">
<option value="0">Оберіть бригаду</option>
<option value="1">1 бригада</option>
<option value="2">2 бригада</option>
<option value="3">3 бригада</option>
<option value="4">4 бригада</option>
<option value="5">5 бригада</option>
<option value="6">Приймальник</option>
<option value="7">Архіваріус</option>
<option value="8">Бригадир</option>
<option value="9">Адміністрація</option>
</select>
</td></tr>
<tr><td>Скорочено</td><td><input id="sko" name="sk" type="text" />
<input type="hidden" name="flag" value="new"/>
</td></tr>
<tr><td>Дата нар.</td><td><input name="dn" type="text"/></td></tr>
<tr><td align="center">
<input name="Ok" type="submit" value="Додати" /></td>
<td align="center">
<input name="reset" type="reset" value="Очистити" />
</td>
</tr>
</table>
</form>