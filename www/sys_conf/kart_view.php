<script type="text/javascript">
$(document).ready(
  function()
  {
  	$(".zmview tr").mouseover(function() {
  		$(this).addClass("over");
  	});
  
  	$(".zmview tr").mouseout(function() {
  		$(this).removeClass("over");
  	});
	$(".zmview tr:even").addClass("alt");
  }
);
</script>
<?php
include_once "../function.php";
$flag="";
$rj_saech=$_GET['rj_saech'];
switch($rj_saech)
{
   case 'n_zm': 
		if(isset($_GET['zam'])) $zm=$_GET['zam'];
		$flag="ZM.NZ=".$zm;
   break;
   case 'kv':
		if(isset($_GET['kvut'])) $kvut=$_GET['kvut'];
		$flag="ZM.ND=".$kvut;
   break;
   case 'adr':
		if(isset($_GET['rajon'])) $rj=$_GET['rajon'];
		if(isset($_GET['nsp'])) $ns=$_GET['nsp'];
		if(isset($_GET['vyl'])) $vl=$_GET['vyl'];
		if(isset($_GET['bud'])) $bd=$_GET['bud'];
		if(isset($_GET['kor'])) {
		$kor=$_GET['kor'];
		if($kor!="")
		$fl2=" AND DM.KR='".$kor."'"; else $fl2="";
		}
		if(isset($_GET['kv'])) {
		$kv=$_GET['kv'];
		if($kv!="")
		$fl3=" AND DM.KV='".$kv."'"; else $fl3="";
		}
		if(isset($_GET['kim'])) {
		$kim=$_GET['kim'];
		if($kim!="")
		$fl4=" AND DM.KA='".$kim."'"; else $fl4="";
		}
		$flag="DM.NR='".$rj."' AND DM.NS='".$ns."' AND DM.VL='".$vl."' 
					AND DM.BD='".$bd."'".$fl2.$fl3.$fl4;			
					
   break;
   case 'sum': 
		if(isset($_GET['sm'])) $sm_p=$_GET['sm'];
		$flag="ZM.SUM=".$sm_p;
   break;
   case 'fio':
		if(isset($_GET['fio'])) $pr=$_GET['fio'];
		if(isset($_GET['im']) && $_GET['im']!='') {$im=$_GET['im']; $fl2=" AND LEFT(DM.IM,1)='$im'";} else $fl2="";
		if(isset($_GET['pb']) && $_GET['pb']!='') {$pb=$_GET['pb']; $fl3=" AND LEFT(DM.PB,1)='$pb'";} else $fl3="";
		$flag="LOCATE('$pr',DM.PR)!=0".$fl2.$fl3;
   break;
   default:		 
    break;
}

$p='<table class="zmview">
<tr>
<th>Прізвище</th>
<th>Ім`я</th>
<th>По батькові</th>
<th>Д.реєстр.</th>
<th>Найм.</th>
<th>Д.оформ.</th>
<th>ч1</th>
<th>ч2</th>
<th>Код<br>пр.</th>
<th>Д.лікв.</th>
<th>Код<br>лікв.</th>
<th>Д.пере.</th>
<th>Книга</th>
<th>Номер</th>
<th>Примітка</th>
<th>Д.нар.</th>
<th>Рн.</th>
<th>Нп.</th>
<th>Вул.</th>
<th>Буд</th>
<th>Кор.</th>
<th>Кв.</th>
<th>Кім.</th>
</tr>';

$sql = "SELECT * FROM DM WHERE ".$flag."";
 $atu=mysql_query($sql);
  while($aut=mysql_fetch_array($atu))
 {	
$p.='<tr>
	<td align="center">'.$aut["PR"].'</td>
	<td align="center">'.$aut["IM"].'</td>
    <td align="center">'.$aut["PB"].'</td>
    <td align="center">'.german_date($aut["DR"]).'</td>
    <td align="center">'.$aut["RN"].'</td>
    <td align="center">'.german_date($aut["DD"]).'</td>
    <td align="center">'.$aut["D1"].'</td>
	<td align="center">'.$aut["D2"].'</td>
	<td align="center">'.$aut["CR"].'</td>
	<td align="center">'.german_date($aut["DL"]).'</td>
	<td align="center">'.$aut["CL"].'</td>
	<td align="center">'.$aut["VK"].'</td>
	<td align="center">'.$aut["KN"].'</td>
	<td align="center">'.$aut["NM"].'</td>
	<td align="center">'.$aut["NG"].'</td>
	<td align="center">'.german_date($aut["DN"]).'</td>
	<td align="center">'.$aut["NR"].'</td>
	<td align="center">'.$aut["NS"].'</td>
	<td align="center">'.$aut["VL"].'</td>
	<td align="center">'.$aut["BD"].'</td>
	<td align="center">'.$aut["KR"].'</td>
	<td align="center">'.$aut["KV"].'</td>
	<td align="center">'.$aut["KA"].'</td>
    </tr>';
}
mysql_free_result($atu);
$p.='</table>';
echo $p; 
?>