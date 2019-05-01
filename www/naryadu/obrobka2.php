<?php
include("../function.php");
//if(isset($_GET['n_radio'])) $path=$_GET['n_radio']; else $path=$_GET['path'];
if(isset($_GET['path'])) $path=$_GET['path'];
//echo $path;
/*    if(isset($_GET["n_radio"])){
		$ath=mysql_query("TRUNCATE TABLE `temp_kasa`");
		if(!$ath){echo "temp_kasa не обнулилась!";}    
		if (file_exists($path)) {
			$dbf_conn = dbase_open($path, 0);
			for ($f = 1; $f <= dbase_numrecords($dbf_conn); $f++){
				$dbf_rec = dbase_get_record($dbf_conn, $f);	
				$dt=$dbf_rec[0];
				$nz=trim(iconv("CP866","UTF-8",$dbf_rec[1]));
				$sum=$dbf_rec[2];
				$prim=str_replace("'","`",trim(iconv("CP866","UTF-8",$dbf_rec[3])));
	$ath=mysql_query("INSERT INTO temp_kasa(DATE,SUM,NZ,PRIM) VALUES('$dt','$sum','$nz','$prim');");
	if(!$ath){echo "Запис не внесена до БД";} 
			}
			dbase_close($dbf_conn);
		}
		else	echo "Не можливо відкрити файл!";
	} */
	$p='<form action="naryadu.php" name="myform" method="get">
	<table align="center" class="bordur">
	<tr><th align="center" colspan="7">Візуальний контроль</th></tr>
	<tr><th align="center">#</th>
	<th align="center">Дата</th>
	<th align="center">Замовлення</th>
	<th align="center">Тип</th>
	<th align="center">Сума</th>
	<th align="center">Сума ком.</th>
	<th align="center">Примітка</th>';
	$sql="SELECT * FROM temp_kasa";
	$atu=mysql_query($sql);
	while($aut=mysql_fetch_array($atu)){
		$dt=german_date($aut["DATE"]);
		$nz=$aut["NZ"];
		$tp_zk=$aut["TIP"];
		$sum=$aut["SUM"];
		$sum_km=$aut["SUM_KM"];
		$prim=$aut["PRIM"];
		$p.='<tr><td align="center">
		<a href="naryadu.php?filter=edit_kasa&id='.$aut["ID"].'&path='.$path.'"><img src="/images/b_edit.png" border="0"></a></td>
		<td align="left">'.$dt.'</td>
		<td align="left">'.$nz.'</td>
		<td align="left">'.$tp_zk.'</td>
		<td align="left">'.$sum.'</td>
		<td align="left">'.$sum_km.'</td>
		<td align="left">'.$prim.'</td>
		</tr>';
	}
	mysql_free_result($atu);
	$p.='<tr bgcolor="#FFFAF0"><td align="center" colspan="7">
	<input name="filter" type="hidden" value="obrobka3">
	<input name="n_file" type="hidden" value="'.basename($path).'">
	<input name="put" type="hidden" value="'.$path.'">
	<input name="Ok" type="submit" value="Далі" />
	</form>
	<a href="naryadu.php?filter=logo" ><input name="Cancel" type="button" value="Відміна" /></a>
	</td>
	</tr>
	</table>';
	echo $p;
?>