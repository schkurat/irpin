<?php
session_start();
$lg=$_SESSION['LG'];
$pas=$_SESSION['PAS'];
$kodp=$_SESSION['KODP'];
$kod_rn=$_SESSION['NR'];
$br=$_SESSION['BR'];
header('Content-Type: text/html; charset=utf-8');
?>
<html>
<head>
<title>
Бюро технiчної iнвентаризацiї
</title>
<script type="text/javascript" src="../js/jquery.min.js"></script>
<script type="text/javascript" src="../js/autozap.js"></script>
<script type="text/javascript" src="../js/jquery.maskedinput-1.2.2.js"></script>
<script type="text/javascript" src="../js/jquery.jqplot.min.js"></script>
<script type="text/javascript" src="../js/excanvas.js"></script>
<script type="text/javascript" src="../js/plugins/jqplot.dateAxisRenderer.min.js"></script>
<script type="text/javascript" src="../js/plugins/jqplot.pieRenderer.min.js"></script>
<script type="text/javascript" src="../js/plugins/jqplot.donutRenderer.min.js"></script>
<script type="text/javascript" src="../js/plugins/jqplot.pointLabels.min.js"></script>
<link rel="stylesheet" type="text/css" href="../js/jquery.jqplot.css" />
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
  
 if(!@mysql_select_db(kpbti,$db))
  {
   echo("Не завантажена таблиця");
   exit(); 
   }
?>
<div style="float: left" id="my_menu" class="sdmenu"> 
  <div> 
  <span>Графіки</span> 
  <a href="analytics.php?filter=kol_za_per">Фіз. та Юр. замовлення</a>
  <a href="analytics.php?filter=kol_po_vidam">По видам робіт</a>
  <a href="analytics.php?filter=val_buro">Вал бюро</a>
  <a href="analytics.php?filter=samovol">Самочинне будівництво</a>
  <a href="analytics.php?filter=mes_info&fl=kil">Кількість замовлень по філіям</a>
  <a href="analytics.php?filter=mes_info&fl=val">Вал по філіям</a>
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