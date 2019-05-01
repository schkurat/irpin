<?php
include_once "../function.php";

$p='<table class="zmview">
<tr bgcolor="#B5B5B5">
<th>#</th>
<th>№</th>
<th>Назва</th>
<th>ЄДРПОУ</th>
<th>Свідоцтво</th>
<th>ІПН</th>
<th>Адреса</th>
<th>Телефон</th>
<th>Рахунок</th>
<th>Банк</th>
<th>МФО</th>
<th>E-mail</th>
<th>Пл.ПДВ</th>
</tr>';

$sql = "SELECT * FROM yur_kl WHERE yur_kl.DL='1' ORDER BY NAME";
$atu=mysql_query($sql);
  while($aut=mysql_fetch_array($atu))
 {		
if($aut["ED_POD"]=='0') $pdv='так';
else $pdv='ні'; 
$p.='<tr bgcolor="#FFFAF0">    
<td align="center"><a href="naryadu.php?filter=edit_yur&kl='.$aut["ID"].'"><img src="../images/b_edit.png" border="0"></a></td>	
	<td align="center">'.$aut["ID"].'</td>
      <td>'.$aut["NAME"].'</td>
      <td align="center">'.$aut["EDRPOU"].'</td>
	  <td align="center">'.$aut["SVID"].'</td>
      <td align="center">'.$aut["IPN"].'</td>
	  <td align="center">'.$aut["ADRES"].'</td>
      <td align="center">'.$aut["TELEF"].'</td>
      <td align="center">'.$aut["RR"].'</td>
      <td align="center">'.$aut["BANK"].'</td>
	  <td align="center">'.$aut["MFO"].'</td>
	  <td align="center">'.$aut["EMAIL"].'</td>
      <td align="center">'.$pdv.'</td> 
      </tr>';
}
mysql_free_result($atu);
$p.='</table>';
echo $p; 
?>