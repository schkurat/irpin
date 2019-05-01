<?php
session_start();
$lg=$_SESSION['LG'];
$pas=$_SESSION['PAS'];
$br=$_SESSION['BR'];
$pr_prie=$_SESSION['PR'];
$im_prie=$_SESSION['IM'];
$pb_prie=$_SESSION['PB'];
header('Content-Type: text/html; charset=utf-8');
?>
<html>
<head>
<title>
Автоматизована система інвентаризації об'єктів нерухомості
</title>

<script src="datp/external/jquery/jquery.js"></script>
<script src="datp/jquery-ui.js"></script>
<script type="text/javascript" src="../js/autozap.js"></script>
<script type="text/javascript" src="../js/jquery.maskedinput-1.2.2.js"></script>
<link rel="stylesheet" type="text/css" href="../js/autozap.css" />
<link rel="stylesheet" type="text/css" href="../my.css" />
<link rel="stylesheet" type="text/css" href="datp/jquery-ui.css" />
<link rel="stylesheet" type="text/css" href="../menu.css" />

<script>
	$(function() {
	$( ".datepicker" ).datepicker();
	$( ".datepicker" ).datepicker( "option", "dateFormat", "dd.mm.yy" );
	$( ".datepicker" ).datepicker( "option", "monthNames", ["Січень","Лютий","Березень","Квітень","Травень","Червень","Липень","Серпень","Вересень","Жовтень","Листопад","Грудень"]);
	$( ".datepicker" ).datepicker( "option", "dayNamesMin", [ "Нд", "Пн", "Вт", "Ср", "Чт", "Пт", "Сб" ] );
	$( ".datepicker" ).datepicker( "option", "firstDay", 1 );
	});
	</script>
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
	<li><a href="#">Замовлення</a>
		<ul>
			<li><a href="reestr.php?filter=nove_zamovlennya">Нове замовлення</a></li>
			<li><a href="reestr.php?filter=reestr_view&fl=injob">В роботі</a></li>
			<li><a href="reestr.php?filter=reestr_view&fl=compl">Виконані</a></li>
		</ul>
	</li>
	<li><a href="#">Пошук</a>
		<ul>
			<li><a href="reestr.php?filter=seach&krit=zm">Замовлення</a></li>
			<li><a href="reestr.php?filter=seach&krit=nree">Реєстраційний №</a></li>
			<li><a href="reestr.php?filter=seach&krit=adr">Адреса</a></li>
			<li><a href="reestr.php?filter=seach&krit=kont">Власник (Назва)</a></li>
		</ul>
	</li>
	<li><a href="#">Звіти</a>
		<ul>
			<li><a href="reestr.php?filter=print_info&krit=reestr">По реєстратору</a></li>
			<li><a href="reestr.php?filter=print_info&krit=vid_rob">По виду робіт</a></li>
			<li><a href="reestr.php?filter=print_info&krit=vukon">Виконані за період</a></li>
			<li><a href="reestr.php?filter=print_info&krit=nespl">Не сплачені</a></li>
		</ul>
	</li>
<li><a href="../menu.php">Вихід</a></li>
</ul>
</td>
<td  class=fn>
<div class="gran">
<hr>
<?php
$temp=$_GET['filter'];
if($temp=="")
{$temp="fon.php";
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