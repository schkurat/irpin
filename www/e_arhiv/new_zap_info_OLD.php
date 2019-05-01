<?php
//include "../function.php";
include "../scriptu.php";
?>
<body>
<form action="add_zap.php" name="myform" method="post" enctype="multipart/form-data">
<table align="center" class="zmview">
<tr><th colspan="4"><b>Внесення інформації в архів</b></th></tr>
<tr>
<td colspan="2">Оберіть розділ архіву</td>
<td colspan="2">
<select name="rozdil" required>
<option value=""></option>
<?
$p='';
$sql = "SELECT ID,NAME FROM rozdilu WHERE DL='1' ORDER BY NAME";
$atu=mysql_query($sql);
  while($aut=mysql_fetch_array($atu))
 {	$p.='<option value="'.$aut["ID"].'">'.$aut["NAME"].'</option>';}
mysql_free_result($atu);
$p.='</select>';
echo $p;
?>
</td>
</tr>
<tr>
<td colspan="2">Введіть назву каталогу для файлів</td>
<td colspan="2">
<input type="text" size="30" name="katalog" value="" required/>
</td>
</tr>
<tr><th colspan="4">Вкажіть файли для завантаження</th><tr>
<tr>
<td>Файл1</td>
<td><input type="file" name="filename1" required></td>
<td>Файл2</td>
<td><input type="file" name="filename2"></td>
</tr>
<tr>
<td>Файл3</td>
<td><input type="file" name="filename3"></td>
<td>Файл4</td>
<td><input type="file" name="filename4"></td>
</tr>
<tr>
<td>Файл5</td>
<td><input type="file" name="filename5"></td>
<td>Файл6</td>
<td><input type="file" name="filename6"></td>
</tr>
<tr>
<td>Файл7</td>
<td><input type="file" name="filename7"></td>
<td>Файл8</td>
<td><input type="file" name="filename8"></td>
</tr>
<tr>
<td>Файл9</td>
<td><input type="file" name="filename9"></td>
<td>Файл10</td>
<td><input type="file" name="filename10"></td>
</tr>
<tr>
<td>Файл11</td>
<td><input type="file" name="filename11"></td>
<td>Файл12</td>
<td><input type="file" name="filename12"></td>
</tr>
<tr>
<td>Файл13</td>
<td><input type="file" name="filename13"></td>
<td>Файл14</td>
<td><input type="file" name="filename14"></td>
</tr>
<tr>
<td>Файл15</td>
<td><input type="file" name="filename15"></td>
<td>Файл16</td>
<td><input type="file" name="filename16"></td>
</tr>
<tr>
<td colspan="2" align="center"><input type="submit" id="submit" value="Створити"></td>
<td colspan="2" align="center"><input name="reset" type="reset" id="reset" value="Очистити"></td>
</tr>
</table>
</form>