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
	$sql="SELECT * FROM `arhiv_dop_adr` WHERE vl=".$_POST['id'];
	$atu=mysql_query($sql);
	if (mysql_num_fields($atu)==0)
		{echo "У обраному районі населеніх пунктів не знайденно ".$sql;
		echo mysql_num_fields($atu);
		}
	else
	{while($aut=mysql_fetch_array($atu))
		{
			echo "
			<div>
				<form>
					<div onclick=\"showWindEditNsp('".$aut["ID"]."','".$aut["NSP"]."');\" class=\"save_img\"></div>
					<div>
						<input type=\"text\" name=\"bd\" value=\"".$aut["bud"]."\" >
						<input type=\"text\" name=\"kv\" value=\"".$aut["kvar"]."\" >
					</div>
				</form>
			</div>
				";
			

		}
	}
	mysql_free_result($atu);


?>