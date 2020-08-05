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
	$sql="SELECT * FROM `nas_punktu`,`tup_nsp` WHERE ID_RN=".$_POST['rayon'] ." and `nas_punktu`.`ID_TIP_NSP` = `tup_nsp`.`ID_TIP_NSP`";
	$atu=mysql_query($sql);
	if (mysql_num_fields($atu)==0)
		{echo "У обраному районі населеніх пунктів не знайденно";
		echo mysql_num_fields($atu);
		}
	else
	{while($aut=mysql_fetch_array($atu))
		{
			$nsp = str_replace("\"", "'", $aut["NSP"] );
			$nsp1 = str_replace("'", "\'", $nsp );
			echo "
			<div>
				<div onclick=\"showWindEditNsp('".$aut["ID_NSP"]."','".$nsp1."');\" class=\"edit_img\"></div>
				<div id=\"nsp".$aut["ID_NSP"]."\" style=\"cursor:pointer; \" onclick=\"sendAjaxForm2('list_vul', '".$aut["ID_NSP"]."','get_vl.php');\">".$aut["TIP_NSP"]." ".$nsp."</div>
				<input type=\"hidden\" name=\"nsp_".$aut["ID_NSP"]."\" id=\"nsp_".$aut["ID_NSP"]."\" value=\"".$aut["ID_TIP_NSP"]."\">
			</div>
				";
			

		}
	}
	mysql_free_result($atu);

?>