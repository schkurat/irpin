<?php
require("top.php");
include "function.php";

if(isset($_GET["kor"])) $kor=$_GET["kor"];
else $kor="";
if(isset($_GET["zmist"])) $zmist=$_GET["zmist"];
else $zmist="";

$d1=date("Y-m-d",mktime(0,0,0,1,1,date("Y")));

 $sql1 = "SELECT NI FROM kans WHERE DATAI>=\"$d1\" ORDER BY NI DESC LIMIT 1"; 
 $atu1=mysql_query($sql1);
  while($aut1=mysql_fetch_array($atu1))
 {
	$n_vuh=$aut1["NI"]+1; 
 }
 mysql_free_result($atu1); 
if ($n_vuh==""){
$n_vuh=1;
}

$pr="<form action=\"vuhid_add.php\" name=\"myform\" method=\"post\">
<table align=\"center\" class=\"zmview\">
<tr bgcolor=\"#B5B5B5\"><th colspan=\"5\" align=\"center\">Вихiдна документацiя</th></tr>
<tr bgcolor=\"#FFFAF0\">
<td>
Кореспондент
</td>
<td>
<input type=\"text\" size=\"20\" name=\"kores\" value=\"".$kor."\"/>
</td>
<td colspan=\"2\">
<input type=\"checkbox\" name=\"konvert\" value=\"1\">Конверт
</td>
</tr>
<tr bgcolor=\"#FFFAF0\">
<td>
Номер кореспондента
</td>
<td>
<input type=\"text\" readonly size=\"20\" maxlength=\"20\" name=\"nkores\" value=\"\"/>
</td>
<td>
Дата: 
</td>
<td colspan=\"2\">
<input type=\"text\" readonly size=\"10\" maxlength=\"10\" name=\"datkl\" value=\"".date("d.m.Y")."\"/>
</td>
</tr>
<tr bgcolor=\"#FFFAF0\">
<td>
П.I.Б. 
</td>
<td>
<input type=\"text\" readonly size=\"20\" maxlength=\"20\" name=\"pib\" value=\"\"/>
</td>
<td>
Тип: 
</td>
<td>
<input type=\"text\" readonly size=\"10\" maxlength=\"10\" name=\"tup\" value=\"\"/>
</td>
</tr>
<tr bgcolor=\"#FFFAF0\">
<td>
Змiст 
</td>
<td colspan=\"3\">
<textarea rows=\"3\" cols=\"42\" name=\"zauv\">".$zmist."</textarea>
</td>
</tr>
<tr bgcolor=\"#FFFAF0\">
<td>
Номер вхiдної кор. 
</td>
<td>
<input type=\"text\" readonly readonly size=\"10\" maxlength=\"10\" name=\"nvhid\" value=\"\"/>
</td>
<td>
Дата: 
</td>
<td>
<input type=\"text\" readonly size=\"10\" maxlength=\"10\" name=\"data_v\" value=\"\"/>
</td>
<tr bgcolor=\"#FFFAF0\">
<td>
Дата вихiдної кор. 
</td>
<td colspan=\"3\">
<input type=\"text\" size=\"10\" maxlength=\"10\" name=\"data_vuh\" value=\"".date("d.m.Y")."\"/>
</td>
</tr>
<tr bgcolor=\"#FFFAF0\"><td align=\"center\" colspan=\"2\">
<input type=\"submit\" name=\"ok\" style=\"width:70px;\" value=\"Ок\">
</form>
</td>
<form action=\"vhidna.php\" name=\"myform\" method=\"post\">
<td align=\"center\" colspan=\"2\">
<input type=\"submit\" name=\"cans\" style=\"width:70px;\" value=\"Вiдмiна\">
</td>
</form>
</tr>";

$pr.="</table>";
echo $pr;   
require("bottom.php");
?>