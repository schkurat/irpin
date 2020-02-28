<!--<script type="text/javascript">
$(document).ready(function(){
	$('#parol').bind('blur',net_fokusa);
}); 
function net_fokusa(eventObj)
	{
	$.ajax({
		type: "POST",
		url: "md.php",
		data: 'p='+ $("#parol").val(),
		dataType: "html",
		success: function(html){
			var reply=html;
			$("#prbd").val(reply);},
		error: function(html){alert(html.error);}
		});								
	}
</script>-->
<form action="add_user_db.php" name="myform" method="post">
<table align="center" class="zmview">
<tr><th colspan="4" align="center">Новий користувач</th></tr>

<tr><td colspan="4">Прізвище <input name="priz" type="text" />
Ім`я<input name="imya" type="text" />
По батькові<input name="pobat" type="text" /></td></tr>
<tr><td colspan="4">Логін &nbsp &nbsp &nbsp &nbsp<input name="log" type="text" /></td></tr>
<tr><td colspan="4">Пароль &nbsp &nbsp <input id="parol" name="pas" type="text" />
Пароль ще раз<input name="pas2" type="text" /></td></tr>
<tr><th colspan="4">Права доступу</th></tr>
<tr><td>
<input name="1" type="checkbox" value="pr1"/>Прийом замовлення
</td><td>
<input name="2" type="checkbox" value="pr2"/>Розподіл/контроль замовл.
</td><td>
<input name="3" type="checkbox" value="pr3"/>Адміністратор
</td><td>
<input name="4" type="checkbox" value="pr4"/>Таксування 
</td></tr>
<tr><td>
<input name="5" type="checkbox" value="pr5"/>Ще не існуючий блок
</td><td>
<input name="6" type="checkbox" value="pr6"/>Ще не існуючий блок
</td><td>
<input name="7" type="checkbox" value="pr7"/>Зведення нарядів
</td><td>
<input name="8" type="checkbox" value="pr8"/>Електронний архів
</td></tr>
<tr><td>
<input name="9" type="checkbox" value="pr9"/>Книга оліку самоч. буд.
</td><td>
<input name="10" type="checkbox" value="pr10"/>Архів
</td><td>
<input name="11" type="checkbox" value="pr11"/>Канцелярія
</td><td>
<input name="12" type="checkbox" value="pr12"/>Реєстрація
</td>
</tr>
<tr>
<td>
<input name="13" type="checkbox" value="pr13"/>Аналітика
</td><td>
<input name="14" type="checkbox" value="pr14"/>Ще не існуючий блок
</td>
<td colspan="2" align="center">
<input name="15" type="checkbox" value="pr15"/>Ще не існуючий блок
</td>
</tr>
<!--<tr><th colspan="4">Доступ до філій</th></tr>

-->
<?php
/* $kk=0;
$sql = "SELECT spr_nr.ID,spr_nr.NAS FROM spr_nr ORDER BY ID";
 $atu=mysql_query($sql);
  while($aut=mysql_fetch_array($atu))
 {$kk++;
 if($kk==4){
 $ss.='<td><input name="d'.$aut["ID"].'" type="checkbox" value="pz'.$aut["ID"].'"/>'.$aut["NAS"].'</td></tr>';
 $kk=0;
 }
 if($kk==1){
 $ss.='<tr><td><input name="d'.$aut["ID"].'" type="checkbox" value="pz'.$aut["ID"].'"/>'.$aut["NAS"].'</td>';
 }
 if($kk!=1 and $kk!=4 and $kk!=0){
 $ss.='<td><input name="d'.$aut["ID"].'" type="checkbox" value="pz'.$aut["ID"].'"/>'.$aut["NAS"].'</td>';
 }
 }
mysql_free_result($atu);
if($kk<=4){$ss.='<td>-</td></tr>';}
echo $ss; */
?>
<tr><th colspan="4">Розширені права доступу</th></tr>
<tr><td>
<input name="21" type="checkbox" value="pr21"/>Видалення замовлення
</td>
<td colspan="3">
<input name="25" type="checkbox" value="pr25"/>Підпис справ
</td>
</tr>

<!--<tr><th colspan="4" align="center">Пароль для бази даних</th></tr>
<tr><td colspan="4"><input  id="prbd" size="43" name="mdfunc" type="text" /></td></tr>-->
<tr><td colspan="2" align="center">
<input name="Ok" type="submit" value="Додати" /></td>
<td colspan="2" align="center">
<input name="reset" type="reset" value="Очистити" />
</td>
</tr>
</table>
</form>