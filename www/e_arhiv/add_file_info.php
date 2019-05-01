<?php
//include "../function.php";
include "../scriptu.php";
$id_kat=$_GET['id_kat'];
?>
<form action="add_file.php" name="myform" method="post" enctype="multipart/form-data">
<table align="center" class=bordur>
<tr><th colspan="4"><b>Додавання нових файлів</b></th></tr>
<tr>
<td>Файл1
<input name="id_kat" type="hidden" value="<?php echo $id_kat; ?>" />
</td>
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
<td colspan="2" align="center"><input type="submit" id="submit" value="Додати"></td>
<td colspan="2" align="center"><input name="reset" type="reset" id="reset" value="Очистити"></td>
</tr>
</table>
</form>