<?php
session_start();
header('Content-Type: text/html; charset=utf-8');
$lg=$_SESSION['LG'];
$pas=$_SESSION['PAS'];
?>
<html>
<head>
<title>
Автоматизована система інвентаризації об'єктів нерухомості
</title>
<script type="text/javascript" src="../js/jquery-1.4.2.js"></script>
<link rel="stylesheet" type="text/css" href="../my.css" />
</head>
<body>
<script type="text/javascript">
$(document).ready(
  function()
  {
  	$(".zmview tr").mouseover(function() {
  		$(this).addClass("over");
  	});
  
  	$(".zmview tr").mouseout(function() {
  		$(this).removeClass("over");
  	});
	$(".zmview tr:even").addClass("alt");
  }
);
</script>
<?php
$db=mysql_connect("localhost",$lg ,$pas);
if(!$db) echo "Не вiдбулося зєднання з базою даних";
 if(!@mysql_select_db(kpbti,$db))
  {
   echo("Не завантажена таблиця");
   exit(); 
   }

 $ath=mysql_query("SELECT DZM FROM security WHERE LOG='$lg';");
  if($ath)
  {while($aut=mysql_fetch_array($ath))
   {$dzm=$aut['DZM'];
   }
mysql_free_result($ath);}  

$k=0;
for($i=1; $i<46; $i++){
if($dzm{$i-1}==1){
$k++;
 $ath1=mysql_query("SELECT NAS FROM spr_nr WHERE ID='$i';");
  if($ath1)
  {while($aut1=mysql_fetch_array($ath1))
   {
   $nas[$k]=$aut1['NAS'];
   }
mysql_free_result($ath1);}  
}
}
if($k>1){
$p='<table align="center" class="zmview"><tr><th>Оберіть район</th></tr>';
for($i=1; $i<=$k; $i++){
$p.='<tr><td id="zal"><a href="select_nr_enter_zm.php?nsp='.$nas[$i].'">'.$nas[$i].'</a></td></tr>';
}
$p.='</table>';
echo $p;
}
else
{
if($k==1) header("location: select_nr_enter_zm.php?nsp=".$nas[1].""); 
if($k==0) echo "net dostupa";
}

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