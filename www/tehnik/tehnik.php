<?php
session_start();
$lg=$_SESSION['LG'];
$pas=$_SESSION['PAS'];
$kl_zm=$_SESSION['KL_ZM'];
$vuk=$_SESSION['VUK'];
header('Content-Type: text/html; charset=utf-8');
?>
<html>
<head>
<title>
Автоматизована система інвентаризації об'єктів нерухомості
</title>
<script type="text/javascript" src="../js/jquery-1.4.2.js"></script>
<script type="text/javascript" src="../js/jquery-1.3.1.js"></script>
<script type="text/javascript" src="../js/autozap.js"></script>
<script type="text/javascript" src="../js/jquery.maskedinput-1.2.2.js"></script>
<link rel="stylesheet" type="text/css" href="../js/autozap.css" />
<link rel="stylesheet" type="text/css" href="../my.css" />
<link rel="stylesheet" type="text/css" href="../sdmenu/sdmenu.css" /> 
  <script type="text/javascript" src="../sdmenu/sdmenu.js"></script> 
  <script type="text/javascript"> 
  // <![CDATA[ 
  var myMenu; 
  window.onload = function() { 
  myMenu = new SDMenu("my_menu"); 
  myMenu.init(); 
  }; 
  // ]]> 
  </script>
</head>
<body>

<table width="100%" border="0" cellspacing=0>
<tr><td class=men>
<?php
$db=mysql_connect("localhost",$lg,$pas);
if(!$db) echo "Не вiдбулося зєднання з базою даних";
  
 if(!@mysql_select_db(klmbti,$db))
  {
   echo("Не завантажена таблиця");
   exit(); 
   }
?>
<div style="float: left" id="my_menu" class="sdmenu"> 
  <div> 
  <span>Обміри</span> 
  <a href="print_eks.php">Ескіз</a>
  <a href="tehnik.php?filter=har">Абрис</a>
  <a href="tehnik.php?filter=zemlya">План земельної ділянки</a>
  <a href="tehnik.php?filter=poet">По поверховий план</a>
  </div> 
  <div> 
  <span>Журнал</span> 
  <a href="tehnik.php?filter=eks">Внутрішніх обмірів</a>
  <a href="tehnik.php?filter=har">Зовнішніх обмірів</a>
  </div> 
  <div> 
  <span>АКТ</span> 
  <a href="tehnik.php?filter=eks">Поточних змін</a>
  <a href="tehnik.php?filter=har">Польового та камерального контролю</a>
  </div> 
  <div> 
  <span>Загальні бланки</span> 
  <a href="tehnik.php?filter=eks">Титульна сторінка</a>
  <a href="tehnik.php?filter=har">Опис</a>
  <a href="tehnik.php?filter=poet">Технічний висновок</a>
  <a href="tehnik.php?filter=zemlya">Лист про самовіл</a>
  <a href="tehnik.php?filter=zemlya">Характеристика</a>
  <a href="tehnik.php?filter=zemlya">КС-16</a>
  </div> 
  <div> 
  <span>АРМ техніка</span> 
  <a href="tehnik.php?filter=eks">Експлікація</a>
  <a href="tehnik.php?filter=har">Характеристика</a>
  <a href="tehnik.php?filter=poet">По поверховий план</a>
  <a href="tehnik.php?filter=zemlya">План земельної ділянки</a>
  </div>   
  <div> 
  <span>Вихід</span> 
  <a href="../menu.php">Вихід</a> 
  </div> 
  </div> 
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