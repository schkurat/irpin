<?php
session_start();
$lg=$_SESSION['LG'];
$pas=$_SESSION['PAS'];
$kl_zm=$_SESSION['KL_ZM'];
$vuk=$_SESSION['VUK'];
header('Content-Type: text/html; charset=utf-8');

include("../function.php");

$db=mysql_connect("localhost",$lg,$pas);
if(!$db) echo "Не вiдбулося зєднання з базою даних";
  
 if(!@mysql_select_db(klmbti,$db))
  {
   echo("Не завантажена таблиця");
   exit(); 
   } 

$k=0;
$sql = "SELECT ID,SZ,NZ,NR,NS,VL,BD,KV,ZEMLYA,ZEMLYA_BAK FROM tehnik WHERE tehnik.DL='1' AND tehnik.ID_ZAK='$kl_zm'";
$atu=mysql_query($sql);
  while($aut=mysql_fetch_array($atu))
 {		
$id=$aut["ID"];
$sz=$aut["SZ"];
$nz=$aut["NZ"];
$nr=$aut["NR"];
$ns=$aut["NS"];
$vl=$aut["VL"];
$bd=$aut["BD"];
$kv=$aut["KV"];
$zemlya=$aut["ZEMLYA"];
$zemlya_bak=$aut["ZEMLYA_BAK"];

$k=1;
}
mysql_free_result($atu);

if($k==1){
if($kv!="") $put='/home/tehnik/'.$nr.'_'.$ns.'_'.$vl.'_'.$bd.'_'.$kv;
else $put='/home/tehnik/'.$nr.'_'.$ns.'_'.$vl.'_'.$bd;
unlink($zemlya);
unlink($zemlya_bak);
if($zemlya==""){mkdir($put.'/ZEMLYA',0777);}
}
else{
$sql = "SELECT SZ,KODP,NZ,RN,NS,VL,BUD,KVAR FROM zamovlennya WHERE zamovlennya.DL='1' AND zamovlennya.KEY='$kl_zm'";
$atu=mysql_query($sql);
  while($aut=mysql_fetch_array($atu))
 {		
$sz=$aut["SZ"];
$nz=$aut["NZ"];
$kodp=$aut["KODP"];
$nr=$aut["RN"];
$ns=$aut["NS"];
$vl=$aut["VL"];
$bd=$aut["BUD"];
$kv=$aut["KVAR"];
}
mysql_free_result($atu);

if($kv!="") $put='/home/tehnik/'.$nr.'_'.$ns.'_'.$vl.'_'.$bd.'_'.$kv;
else $put='/home/tehnik/'.$nr.'_'.$ns.'_'.$vl.'_'.$bd;
mkdir($put,0777);
mkdir($put.'/ZEMLYA',0777);
}

//---------------------dwg-------------------------------------
if($_FILES["filename"]["size"] > 1024*3*1024)
   {
     echo ("Размер файла превышает три мегабайта");
     exit;
   }
   // Проверяем загружен ли файл
   if(is_uploaded_file($_FILES["filename"]["tmp_name"]))
   {
     // Если файл загружен успешно, перемещаем его
     // из временной директории в конечную /home/common/andrey/import
	 $path=$put."/ZEMLYA/".$sz."_".$nz."_".$_FILES["filename"]["name"];
     move_uploaded_file($_FILES["filename"]["tmp_name"], $path);
   } else {
      echo("Ошибка загрузки файла");
   }
//--------------------------------------------------------------
//--------------------bak---------------------------------------
if($_FILES["filename2"]["size"] > 1024*3*1024)
   {
     echo ("Размер файла превышает три мегабайта");
     exit;
   }
   // Проверяем загружен ли файл
   if(is_uploaded_file($_FILES["filename2"]["tmp_name"]))
   {
     // Если файл загружен успешно, перемещаем его
     // из временной директории в конечную /home/common/andrey/import
	 $path2=$put."/ZEMLYA/".$sz."_".$nz."_".$_FILES["filename2"]["name"];
     move_uploaded_file($_FILES["filename2"]["tmp_name"], $path2);
   } else {
      echo("Ошибка загрузки файла");
   }
//----------------------------------------------------------------
   
if($k==1){$ath1=mysql_query("UPDATE tehnik SET ZEMLYA='$path',ZEMLYA_BAK='$path2' WHERE tehnik.ID='$id' AND tehnik.DL='1'");}
else{
$ath1=mysql_query("INSERT INTO tehnik(ID_ZAK,SZ,NZ,KODP,NR,NS,VL,BD,KV,ZEMLYA,ZEMLYA_BAK,VUK)
VALUES('$kl_zm','$sz','$nz','$kodp','$nr','$ns','$vl','$bd','$kv','$path','$path2','$vuk')");
}		
	
if(mysql_close($db))
   {
    // echo("Закриття бази даних");
    }
    else
    {
    echo("Не можливо виконати закриття бази"); 
    }
header("location: tehnik.php?filter=zemlya");
?>