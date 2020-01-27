<?php
session_start();
header('Content-Type: text/html; charset=utf-8');
$lg=$_SESSION['LG'];
$pas=$_SESSION['PAS'];
$pr_prie=$_SESSION['PR'];
$im_prie=$_SESSION['IM'];
$pb_prie=$_SESSION['PB'];
//$kodp=$_SESSION['KODP'];
//$nas_s=$_SESSION['NAS'];
//$kod_zm=$_SESSION['KOD_ZM'];
//$kod_rn=$_SESSION['NR'];
$ddl=$_SESSION['DDL'];
//echo $pr_p;
?>
<html>
<head>
<title>
Автоматизована система інвентаризації об'єктів нерухомості
</title>
<!--<script type="text/javascript" src="../js/jquery-1.4.2.js"></script>-->
<script type="text/javascript" src="../js/jquery.min.js"></script>
<!--<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js"></script>-->
<script type="text/javascript" src="../js/autozap.js"></script>
<!--<script type="text/javascript" src="../js/jquery.maskedinput-1.2.2.js"></script>-->
<script type="text/javascript" src="../js/bti.js"></script>
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
	<li><a href="#">Замовлення</a>
		<ul>
			 <li><a href="index.php">Нове</a></li>
			 <li><a href="index.php?filter=zm_view">Замовлення за день</a></li>
			 <li><a href="index.php?filter=seach_zm_pr">Замовлення за період</a></li>
			 <li><a href="index.php?filter=opl_info">Перевірка оплати</a></li>
		</ul>
	</li>
  <li><a href="#">Видача</a>
    <ul>
      <li><a href="index.php?filter=vudacha_view">Видані за сьогодні</a></li>
      <li><a href="index.php?filter=seach_vud_pr">Видані за період</a></li>
    </ul>
  </li>
  <li><a href="#">Пошук нове замовлення</a>
		<ul>
			<li><a href="index.php?filter=seach_zm">Замовлення</a></li>
			<li><a href="index.php?filter=seach_adres">Адреса</a></li>
			<li><a href="index.php?filter=seach_kod">Код</a></li>
			<li><a href="index.php?filter=seach_pr">Прiзвище (Назва)</a></li>
		</ul>
	</li>
  <li><a href="#">Пошук видача</a>
		<ul>
			<li><a href="index.php?filter=seach&krit=zm">Замовлення</a></li>
			<li><a href="index.php?filter=seach&krit=adr">Адреса</a></li>
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
{$temp="nove_zamovlennya.php";
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
