<?php
$id = $_GET["adr_id"];
$com = $_GET["com"];
$ok = $_GET["Ok"];
$pos = $_GET["posluga"];
$npr = $_GET["npr"];
$kpr = $_GET["kpr"];
if (!empty($com)){
	
	session_start();
	$lg="";
	$pas="";

	if (!empty($_SESSION['LG'])) {  $lg=$_SESSION['LG'];}
	if (!empty($_SESSION['PAS'])){ $pas=$_SESSION['PAS'];}

	$db=mysql_connect("localhost",$lg,$pas);
	if(!$db) echo "Не вiдбулося зєднання з базою даних";

	if(!@mysql_select_db(kpbti,$db)){
		echo "Не образа база даных";
	}
	
	$sql = "UPDATE `kpbti`.`arhiv_dop_adr` SET `status` = 2, `comment` = '".$com."' WHERE id = ".$id;
	echo $sql;
	$atu1 = mysql_query($sql);
	echo "<br>";
	echo mysql_affected_rows();
	echo "<br>";
	echo mysql_errno();
	echo "<br>";
	echo mysql_error();
	$nr = mysql_errno();
	if ($nr == 0) header("location:arhiv.php?npr=$npr&kpr=$kpr&filter=zm_view&posluga=$pos&Ok=$ok");
}
//echo $id."!";
$sql = "SELECT arhiv_dop_adr.rn, arhiv_dop_adr.ns, arhiv_dop_adr.vl, arhiv_dop_adr.bud, arhiv_dop_adr.kvar, arhiv_dop_adr.status,  rayonu.RAYON,  vulutsi.VUL,   nas_punktu.NSP,   tup_nsp.TIP_NSP,  tup_vul.TIP_VUL 
		FROM `arhiv_dop_adr`, `rayonu`,`vulutsi`,`nas_punktu` , `tup_nsp`, `tup_vul`
		WHERE arhiv_dop_adr.id = ".$id."
		AND arhiv_dop_adr.rn = rayonu.ID_RAYONA
		AND arhiv_dop_adr.ns = nas_punktu.ID_NSP
		AND arhiv_dop_adr.vl = vulutsi.ID_VUL
		AND vulutsi.ID_TIP_VUL = tup_vul.ID_TIP_VUL
		AND nas_punktu.ID_TIP_NSP = tup_nsp.ID_TIP_NSP ";

//echo $sql;

    $atu1 = mysql_query($sql);
    while ($aut1 = mysql_fetch_array($atu1)) {
        $id_rn = $aut1["rn"];
		$rn = $aut1["RAYON"];
		$id_nsp =  $aut1["ns"];
		$nsp =  $aut1["NSP"];
		$id_vl = $aut1["vl"];
		$vl = $aut1["VUL"];	
		$bd = $aut1["bud"];
		$kv = $aut1["kvar"];
		$tp_v = $aut1["TIP_VUL"];
		$tp_n = $aut1["TIP_NSP"];
		if (!empty($bd)){$bd = "буд. ".$bd;}
		if (!empty($kv)){$kv = "кв. ".$kv;}
		//var_dump($aut1);		
	}
?>
<form action="edit_status.php" metod="get" >
	<input id="npr" name="npr" type="hidden" value="<?php echo $npr;?>">
	<input id="kpr" name="kpr" type="hidden" value="<?php echo $kpr;?>">
	<input id="posluga" name="posluga" type="hidden" value="<?php echo $pos;?>">
	<input id="posluga" name="ok" type="hidden" value="<?php echo $ok;?>">
	<input id="adr_id" name="adr_id" type="hidden" value="<?php echo $id;?>">
	<?php echo $rn." ".$tp_n." ".$nsp." ".$tp_v." ".$vl." ".$bd." ".$kv." Відмовленно<br>";?>
	Додати примітку<br>
	<input type="text" name="com" value="">
	<input type="submit" value="Зберегти">
</form>