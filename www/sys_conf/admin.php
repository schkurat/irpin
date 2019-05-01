<?php
session_start();
header('Content-Type: text/html; charset=utf-8');
$lg=$_SESSION['LG'];
$pas=$_SESSION['PAS'];
$pr_p=$_SESSION['PR'];
$im_p=$_SESSION['IM'];
$pb_p=$_SESSION['PB'];
//echo $pr_p;
?>
<html>
<head>
<title>
Автоматизована система інвентаризації об'єктів нерухомості
</title>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js"></script>
<script type="text/javascript" src="../js/autozap.js"></script>
<script type="text/javascript" src="../js/jquery.maskedinput-1.2.2.js"></script>
<link rel="stylesheet" type="text/css" href="../js/autozap.css" />
<link rel="stylesheet" type="text/css" href="../my.css" />
<link rel="stylesheet" type="text/css" href="../menu.css" />

<script type="text/javascript" src="../js/scriptbreaker-multiple-accordion-1.js"></script>
<script language="JavaScript">

$(document).ready(function() {
	$(".topnav").accordion({
		accordion:true,
		speed: 500,
		closedSign: '►',
		openedSign: '▼'
	});
});

</script>
</head>
<body>

<table width="100%" border="0" cellspacing=0>
<tr><td class=men>
<?php
$db=mysql_connect("localhost",$lg,$pas);
if(!$db) echo "Не вiдбулося зєднання з базою даних";
  
 if(!@mysql_select_db(kpbti,$db))
  {
   echo("Не завантажена таблиця");
   exit(); 
   }
?>

<ul class="topnav">
	<li><a href="#">Користувачі</a>
		<ul>
			 <li><a href="admin.php?filter=add_user">Додати</a></li>
			 <li><a href="admin.php?filter=user_view">Переглянути</a></li>
		</ul>
	</li>
	<li><a href="#">Робітники</a>
		<ul>
			 <li><a href="admin.php?filter=rob_view">Перегляд</a></li>
			 <li><a href="admin.php?filter=add_rob">Додати</a></li>
		</ul>
	</li>
	<li><a href="#">Електронний архів</a>
		<ul>
			 <li><a href="admin.php?filter=insert_spr">Надати доступ</a></li>
			 <li><a href="admin.php?filter=earh_view">Перегляд</a></li>
		</ul>
	</li>
<!--<li><a href="admin.php?filter=graf">Графіки</a></li>-->
<li><a href="../menu.php">Вихід</a></li>
</ul>
</td>
<td  class=fn>
<div class="gran">
<hr>
<?php
$temp=$_GET['filter'];
if($temp=="")
{$temp="user_view.php";
	require($temp);}
 else{
	require($temp.".php");}
?>
<hr></div>
</td></tr>
</table>
<?php
//Zakrutie bazu       
       if(mysql_close($db))
        {
        // echo("Закриття бази даних");
         }
         else
         {
          echo("Не можливо виконати закриття бази"); 
          }
?>
</body>
</html>