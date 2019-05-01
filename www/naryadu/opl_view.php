<?php
include_once "../function.php";
$rik=$_GET["rik"];
$mis=$_GET["mis"];
$p='<table class="zmview">
<tr>
<th colspan="2">#</th>
<th>Код кл.</th>
<th>Назва</th>
<th>Спосіб<br>оплати</th>
<th>Дата<br>рахунку</th>
<th>Сума<br>рахунку</th>
<th>Дата<br>оплати</th>
<th>Сума<br>оплати</th>
<th>Послуги<br>банка</th>
<th>№ рах.</th>
<th>%ПДВ</th>
<th>№ податк.</th>
<th>Дата<br>подат.</th>
<th>Код<br>платн.</th>
</tr>';

$sql = "SELECT * FROM podatkova WHERE MONTH(DT_NAL)='$mis' AND YEAR(DT_NAL)='$rik' ORDER BY N_NAL";
$atu=mysql_query($sql);
  while($aut=mysql_fetch_array($atu))
 {
if($aut["TIP_OPL"]==1) $tp_op='<td align="center"><a href="naryadu.php?filter=edit_tip_opl&kl='.$aut["ID"].'&rik='.$rik.'&mis='.$mis.'&tip=2"><img src="../images/kasa.png" border="0"></a></td>';
else $tp_op='<td align="center"><a href="naryadu.php?filter=edit_tip_opl&kl='.$aut["ID"].'&rik='.$rik.'&mis='.$mis.'&tip=1"><img src="../images/bank.png" border="0"></a></td>';
$p.='<tr>    
<td align="center"><a href="naryadu.php?filter=edit_pod&kl='.$aut["ID"].'"><img src="../images/b_edit.png" border="0"></a></td>	
<td align="center"><a href="print_podatkova.php?kl='.$aut["ID"].'"><img src="../images/print.png" border="0"></a></td>	
	<td align="center">'.$aut["K_KL"].'</td>
      <td>'.$aut["NAME"].'</td>
	  '.$tp_op.'
	  <td align="center">'.german_date($aut["DT_RAH"]).'</td>
      <td align="center">'.$aut["SM_RAH"].'</td>
	  <td align="center">'.german_date($aut["DT_OPL"]).'</td>
      <td align="center">'.$aut["SM_OPL"].'</td>
	  <td align="center">'.$aut["USL_B"].'</td>
      <td align="center">'.$aut["N_RAH"].'</td>
      <td align="center">'.$aut["PR_NDS"].'</td>
	  <td align="center">'.$aut["N_NAL"].'</td>
	  <td align="center">'.german_date($aut["DT_NAL"]).'</td>
      <td align="center">'.$aut["K_PLAT"].'</td> 
      </tr>';
}
mysql_free_result($atu);
$p.='</table>';
echo $p; 
?>