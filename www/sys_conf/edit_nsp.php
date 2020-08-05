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
	$sql="UPDATE `nas_punktu` SET `NSP`='".$_POST['nsp']."', `ID_TIP_NSP`='".$_POST['type_nsp']."' WHERE ID_NSP=".$_POST['idNsp'];
	$atu=mysql_query($sql);
	echo mysql_errno($atu);
	mysql_free_result($atu);

?>