<?php
//include_once "../function.php";

 $id_kat=$_GET['id_kat'];


$p='<table align="center" class="zmview">
<tr bgcolor="#B5B5B5">
<th colspan="2"><a href="earhiv.php?filter=add_file_info&id_kat='.$id_kat.'"><img src="../images/plus.png" border="0"></a></th>
<th>Назва файлу</th>
</tr>';

 $sql="SELECT fails.ID,fails.NAME,fails.PATH FROM fails 
	WHERE 
	fails.DL='1' AND fails.ID_ARH='$id_kat' ORDER BY fails.NAME";

 $atu=mysql_query($sql);
  while($aut=mysql_fetch_array($atu))
 {	
$p.='<tr bgcolor="#FFFAF0">
<td align="center"><a href="earhiv.php?filter=edit_file&id_zp='.$aut["ID"].'&id_kat='.$id_kat.'"><img src="../images/b_edit.png" border="0"></a></td>
<td align="center"><a href="earhiv.php?filter=delete_info&kl='.$aut["ID"].'&tip=file"><img src="../images/b_drop.png" border="0"></a></td>
      <td id="zal"><a href="download_img.php?url='.$aut["PATH"].'">'.$aut["NAME"].'</a></td>
      </tr>';

}
mysql_free_result($atu); 
$p.='</table>';
echo $p; 
?>