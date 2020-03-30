<?php
session_start();
$lg=$_SESSION['LG'];
$pas=$_SESSION['PAS'];
header('Content-Type: text/html; charset=utf-8');
?>
<html>
<head>
<title>
Автоматизована система інвентаризації об'єктів нерухомості
</title>
<script src="../datp/external/jquery/jquery.js"></script>
<script src="../datp/jquery-ui.js"></script>
<script type="text/javascript" src="../js/autozap.js"></script>
<script type="text/javascript" src="../js/jquery.stickytableheaders.js"></script>
<link rel="stylesheet" type="text/css" href="../datp/jquery-ui.css" />
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
$(function() {
	$( ".datepicker" ).datepicker();
	$( ".datepicker" ).datepicker( "option", "dateFormat", "dd.mm.yy" );
	$( ".datepicker" ).datepicker( "option", "monthNames", ["Січень","Лютий","Березень","Квітень","Травень","Червень","Липень","Серпень","Вересень","Жовтень","Листопад","Грудень"]);
	$( ".datepicker" ).datepicker( "option", "dayNamesMin", [ "Нд", "Пн", "Вт", "Ср", "Чт", "Пт", "Сб" ] );
	$( ".datepicker" ).datepicker( "option", "firstDay", 1 );
    $( ".datepicker" ).datepicker( "setDate", new Date() );
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
	<li><a href="#">Звіти</a>
		<ul>
			<!--<li><a href="naryadu.php?filter=vuborka&krit=form">Формування</a></li>
			<li><a href="naryadu.php?filter=vuborka&krit=naryad">Наряд по 1 особі</a></li>
			<li><a href="naryadu.php?filter=vuborka&krit=naryad_br">Наряд бригадира</a></li>
			<li><a href="naryadu.php?filter=vuborka&krit=all_t">Місячний звіт по всім технікам</a></li>-->
			<li><a href="naryadu.php?filter=vuborka&krit=buro">Надходження</a></li>
		</ul>
	</li>
	<li><a href="#">Контроль</a>
		<ul>
			<li><a href="naryadu.php?filter=print_info&krit=got">Готовність на:</a></li>
			<li><a href="naryadu.php?filter=print_info&krit=nevk">Невиконані</a></li>
			<li><a href="naryadu.php?filter=print_info&krit=nevk_vuk">Невиконані по виконавцю</a></li>
			<li><a href="naryadu.php?filter=print_info&krit=pr_per">Прийняті за період</a></li>
			<li><a href="naryadu.php?filter=print_info&krit=vk_d_got">По виконавцю та даті готовності</a></li>
			<!--<li><a href="naryadu.php?filter=print_info&krit=blanki">Використані бланки</a></li>-->
			<li><a href="naryadu.php?filter=print_info&krit=nespl">Несплачені замовлення</a></li>
			<li><a href="naryadu.php?filter=print_info&krit=proezd_info">Вихід на об`єкт</a></li>
		</ul>
	</li>
<li><a href="#">Обробка каси</a>
		<ul>
			<li><a href="naryadu.php?filter=oplata_info">Ручна розноска</a></li>
			<li><a href="naryadu.php?filter=kasa_view_info">Перегляд</a></li>
		<!--<li><a href="naryadu.php?filter=select_file">Імпорт файла</a></li>
			<li><a href="naryadu.php?filter=edit_error_info">Обробка помилок</a></li>-->
			<li><a href="naryadu.php?filter=protokol_info">Протокол обробки</a></li>
			<li><a href="naryadu.php?filter=vozvrat_info">Повернення коштів</a></li>
		</ul>
	</li>
<li><a href="#">Сальдо</a>
		<ul>
			<li><a href="naryadu.php?filter=saldo_info">Розрахунок</a></li>
			<li><a href="naryadu.php?filter=ostatki_info">Перенос залишків</a></li>
			<li><a href="naryadu.php?filter=71_info">Закриття на 71 рах</a></li>
		</ul>
	</li>
<li><a href="#">Юридичні клієнти</a>
		<ul>
			<li><a href="naryadu.php?filter=yur_view">Перегляд</a></li>
			<li><a href="naryadu.php?filter=new_yur_info">Додати</a></li>
		</ul>
	</li>
<li><a href="../menu.php">Вихід</a></li>
</ul>
</td>
<td  class=fn>
<hr>
<div class="gran">
<?php
$temp=$_GET['filter'];
if($temp=="")
{$temp="fon.php";
	require($temp);}
 else{
	require($temp.".php");}
?>
</div><hr>
</td></tr>
</table>
<?php
//Zakrutie bazu--       
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