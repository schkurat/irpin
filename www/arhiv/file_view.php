<?php
//include_once "../function.php";
$kat=$_GET['kat'];
$name=$_GET['name'];
$adr=$_GET['adr'];

$p='
<form action="add_file.php" name="myform" method="post" enctype="multipart/form-data">
<table align="center" class="zmview">
<tr><th colspan="2">'.$name.'</br>'.$adr.'</th></tr>
<tr>
<td>Оберіт файл</td>
<td>
<input type="file" name="file[]" multiple="true"><input type="submit" id="submit" value="Завантажити">
<input name="id_kat" type="hidden" value="'.$kat.'" />
<input name="nazv" type="hidden" value="'.$name.'" />
<input name="adres" type="hidden" value="'.$adr.'" />
</td>
</tr>
<tr><th colspan="2">Завантажені файли</th></tr>';

if ($dh = opendir($kat)) {
    while (false !== ($file = readdir($dh))) { 
		if ($file != "." && $file != "..") { 
		//$p.='<tr><td>'.$file.'</td></tr>';
		$p.='<tr>
		<td align="center"><a href="arhiv.php?filter=delete_file&url='.$kat.'/'.$file.'&kat='.$kat.'&name='.$name.'&adr='.$adr.'"><img src="../images/b_drop.png" border="0"></a></td>
		<td id="zal"><a href="download_file.php?url='.$kat.'/'.$file.'">'.$file.'</a></td>
		</tr>';
		} 
    }
    closedir($dh);
}
$p.='</table>
</form>';
echo $p; 
?>