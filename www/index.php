<?php
session_start();
$lg="";
$pas="";

if (!empty($_SESSION['LG'])) {  $lg=$_SESSION['LG'];}
if (!empty($_SESSION['PAS'])){ $pas=$_SESSION['PAS'];}

#echo $lg;
#echo $pas;
#var_dump($_SESSION);

if(!empty($lg))
{

$db=mysql_connect("localhost",$lg,$pas);
if(!$db) echo "Не вiдбулося зєднання з базою даних";

 if(!@mysql_select_db(kpbti,$db))
  {
   echo("Не завантажена таблиця");
   exit();
   }
  header("location: menu.php");
}
header('Content-Type: text/html; charset=utf-8');
?>
<html>
<head>
<title>
Автоматизована система інвентаризації об'єктів нерухомості
</title>
</head>
<body>
<table align="center" border="0" style="padding-top: 15px;">
<tr><td align="center"><img src="images/1.gif"/></td></tr>
  </table>
<form action="identy.php" name="myform" method="post">
   <table align="center" border="0" style="padding: 10px;">
   <tr>
   <td><input type="text" size="15" name="login"
    style="text-align:center;" VALUE="Логiн" onfocus="if (this.value=='Логiн') this.value=''"/></td>
   <td><input type="password" size="15" name="parol"
    style="text-align:center;" VALUE="Пароль" onfocus="if (this.value=='Пароль') this.value=''"/></td>
   <td><input type="submit" name="vhid" style="width:60px;height:25px" value="Вхiд"></td>
   </tr>
   <tr><td COLSPAN="2" align="center">Введiть <b>Логiн та Пароль</b></td></tr>
  </table>
<!--<table align="center" border="0">
<tr><td>
<img src="images/2.gif">
</td>
</tr>
</table>-->
<!--onzar-->
</form>
</body>
</html>
