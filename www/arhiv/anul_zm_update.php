<?php
session_start();
$lg = $_SESSION['LG'];
$pas = $_SESSION['PAS'];



if(isset($_GET)){
	
	$key=$_GET["key"];
	$url=$_GET["url"];
	$com=$_GET["pr"].' '.$_GET["im"].' '.$_GET["pb"].' '.date("d.m.Y").'
'.$_GET["comment"];
	$sql = "UPDATE `arhiv_zakaz`
			SET `ANUL` = '1', `ANUL_COMENT` = '$com'
			WHERE `KEY`=$key";
			
			
	//echo $sql;
	
	$db = mysql_connect("localhost", $lg, $pas);
if (!$db) echo "Не вiдбулося зєднання з базою даних";

if (!@mysql_select_db(kpbti, $db)) {
    echo("Не завантажена таблиця");
    exit();
}
$ath1 = mysql_query($sql);
if (!$ath1) {
    echo "Замовлення не внесене до БД";
}else{
	echo "Замовлення успішно анульовано.";
}
//Zakrutie bazu       
if (mysql_close($db)) {
    // echo("Закриття бази даних");
} else {
    echo("Не можливо виконати закриття бази");
}

header("location: ".$url);
//	header("location: arhiv.php?filter=zm_view");


}

?>