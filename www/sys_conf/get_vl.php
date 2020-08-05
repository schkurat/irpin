<?php

	session_start();
	header('Content-Type: text/html; charset=utf-8');
	$lg = $_SESSION['LG'];
	$pas = $_SESSION['PAS'];
	$pr_p = $_SESSION['PR'];
	$im_p = $_SESSION['IM'];
	$pb_p = $_SESSION['PB'];

   $db = mysql_connect("localhost", $lg, $pas);
   if (!$db) echo "Не вiдбулося зєднання з базою даних";
      if (!@mysql_select_db(kpbti, $db)) {
             echo("Не завантажена таблиця");
             exit();
	 }
	$sql="SELECT * FROM `vulutsi`,`tup_vul` WHERE ID_NSP=".$_POST['nsp'] ." and `vulutsi`.`ID_TIP_VUL`=`tup_vul`.`ID_TIP_VUL`";
//echo $sql;
	$atu=mysql_query($sql);
	while($aut=mysql_fetch_array($atu))
	{
		$vl = str_replace("\"", "'", $aut["VUL"] );
		$vl1 = str_replace("'", "\'", $vl );
		echo "
			<div>
				<div onclick=\"showWindEditVul('".$aut["ID_VUL"]."','".$vl1."');\" class=\"edit_img\"></div>
				<div id=\"vul".$aut["ID_VUL"]."\">".$aut["TIP_VUL"]." ".$vl."</div>
				<input type=\"hidden\" name=\"vul_".$aut["ID_VUL"]."\" id=\"vul_".$aut["ID_VUL"]."\" value=\"".$aut["ID_TIP_VUL"]."\">
			</div>
		";

	}
	mysql_free_result($atu);

?>