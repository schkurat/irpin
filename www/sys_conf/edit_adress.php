<?php

session_start();
	header("Content-Type: text/html; charset=utf-8");
	$lg = $_SESSION["LG"];
	$pas = $_SESSION["PAS"];
	$pr_p = $_SESSION["PR"];
	$im_p = $_SESSION["IM"];
	$pb_p = $_SESSION["PB"];

   $db = mysql_connect("localhost", $lg, $pas);
   if (!$db) echo "Не вiдбулося зєднання з базою даних";
      if (!@mysql_select_db(kpbti, $db)) {
             echo("Не завантажена таблиця");
             exit();
	 }
	$sql="UPDATE `vulutsi` SET `VUL`=\"".$_POST["vul"]."\" WHERE ID_VUL=".$_POST["idVul"];
	$atu=mysql_query($sql);
	echo mysql_errno($atu);
	mysql_free_result($atu);
?>