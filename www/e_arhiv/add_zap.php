<?php
session_start();
$lg=$_SESSION['LG'];
$pas=$_SESSION['PAS'];
include("../function.php");
$rozdil=$_POST['rozdil'];
$katalog=$_POST['katalog'];

$db=mysql_connect("localhost",$lg,$pas);
if(!$db) echo "Не вiдбулося зєднання з базою даних";
  
 if(!@mysql_select_db(kpbti,$db))
  {
   echo("Не завантажена таблиця");
   exit(); 
   }
$fl=0;
for($i=1;$i<=16;$i++){
$file_name='filename'.$i;
if($_FILES[$file_name]["size"] > 1024*5*1024)
   {
     echo ("Размер файла превышает три мегабайта");
     exit;
   }
   // Проверяем загружен ли файл
   if(is_uploaded_file($_FILES[$file_name]["tmp_name"]))
   {
     // Если файл загружен успешно, перемещаем его
     // из временной директории в конечную /home/common/andrey/import
	 $path="/home/scanfiles/".$_FILES[$file_name]["name"];
	 $file=$_FILES[$file_name]["name"];
     move_uploaded_file($_FILES[$file_name]["tmp_name"], $path);
	//-------------Добавляем записи в БД----------------
	if($fl==0){
	$ath1=mysql_query("INSERT INTO earhiv (ID_ROZD,KATALOG) VALUES('$rozdil','$katalog');");
	$latest_id = mysql_insert_id();
	$fl++;
	}
	$ath1=mysql_query("INSERT INTO fails (ID_ARH,PATH,NAME) 
	VALUES('$latest_id','$path','$file');");
	//--------------------------------------------------
   } else {
      echo("Ошибка загрузки файла");
   }
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
		  
header("location: earhiv.php?filter=new_zap_info");
?>