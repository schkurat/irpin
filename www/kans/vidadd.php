<?php
session_start();
$lg=$_SESSION['LG'];
$pas=$_SESSION['PAS'];
$pr_prie=$_SESSION['PR'];
$im_prie=$_SESSION['IM'];
$pb_prie=$_SESSION['PB'];
include "../function.php";
$nvh=$_POST['nvhid']; 
$nvuh=$_POST['nvuh'];
$datav=$_POST['data_v'];
$datavuh=$_POST['data_vuh'];
$nkl=$_POST['nkores'];
$dkl=$_POST['datkl'];
$naim=$_POST['kores'];
$boss=$_POST['pib'];
$zmist=$_POST['zauv'];
$tip=$_POST['tup'];
$ea_id=$_POST['ea_id'];
$sekr=$pr_prie.' '.p_buk($im_prie).'.'.p_buk($pb_prie);
if(isset($_POST['konvert'])) $konv=$_POST['konvert'];
else $konv='0'; 

$db=mysql_connect("localhost",$lg,$pas);
if(!$db) echo "Не вiдбулося зєднання з базою даних";
  
 if(!@mysql_select_db(kpbti,$db))
  {
   echo("Не завантажена таблиця");
   exit(); 
   }

$chas=date("H:i:s");
   
 $dkl=substr($dkl,6,4)."-".substr($dkl,3,2)."-".substr($dkl,0,2);
 $datav=substr($datav,6,4)."-".substr($datav,3,2)."-".substr($datav,0,2);
 $datavuh=substr($datavuh,6,4)."-".substr($datavuh,3,2)."-".substr($datavuh,0,2);
  
 $ath=mysql_query("UPDATE kans SET DATAI=DATE_FORMAT('$datavuh','%Y-%m-%d'),NI='$nvuh',KONVERT='$konv' 
	WHERE DATAV=DATE_FORMAT('$datav','%Y-%m-%d') AND NV='$nvh'");
if($ath){
	$ath1=mysql_query("INSERT INTO kans (EA,DATAV,NV,NKL,DATAKL,NAIM,BOSS,PR,DATAI,NI,ZMIST,TIP,DATAVK,`TIME`,KONVERT,SEKR)
	VALUES('$ea_id',DATE_FORMAT('$datav','%Y-%m-%d'),'$nvh','$nkl',
	DATE_FORMAT('$dkl','%Y-%m-%d'),'$naim',
	'$boss','2','$datavuh','$nvuh','$zmist','$tip','','$chas','$konv','$sekr');");
	if(!$ath1){
	echo "Вихідна інформація не внесена";}
}
else
	{
echo "Вхідній документації не присвоєно вихідний номер та дата";
}

//------------------------------------------------------------------------------------
//var_dump($ea_id);
if (!empty($ea_id) && $ea_id != 0) {
    $katalog = 'ea/' . $ea_id;
    if (!is_dir($katalog)) {
        mkdir($katalog);
        mkdir($katalog . '/document');
        mkdir($katalog . '/technical');
        mkdir($katalog . '/inventory');
        mkdir($katalog . '/correspondence');
        mkdir($katalog . '/keeper');
    }
    $katalog .= '/correspondence';
    if (!is_dir($katalog)) {
        mkdir($katalog);
    }

    if (isset($_FILES)) {
        //пролистываем весь массив изображений по одному $_FILES['file']['name'] as $k=>$v
        foreach ($_FILES['file']['name'] as $k => $v) {
            //директория загрузки
            $uploaddir = $katalog . '/';

            //новое имя изображения
            $apend = str_replace(" ", "_", $_FILES["file"]["name"][$k]);
            $apend = date("d_m_Y") . '_' . $apend;
            //путь к новому изображению
            $uploadfile = "$uploaddir$apend";

            //Проверка расширений загружаемых изображений
            if ($_FILES['file']['type'][$k] == "image/gif" || $_FILES['file']['type'][$k] == "image/png" ||
                $_FILES['file']['type'][$k] == "image/jpg" || $_FILES['file']['type'][$k] == "image/jpeg" ||
                $_FILES['file']['type'][$k] == "application/pdf" || $_FILES['file']['type'][$k] == "application/msword" ||
                $_FILES['file']['type'][$k] == "application/excel" || $_FILES['file']['type'][$k] == "application/x-excel" ||
                $_FILES['file']['type'][$k] == "application/x-msexcel" || $_FILES['file']['type'][$k] == "application/vnd.ms-excel") {
                //черный список типов файлов
                $blacklist = array(".php", ".phtml", ".php3", ".php4");
                foreach ($blacklist as $item) {
                    if (preg_match("/$item\$/i", $_FILES['file']['name'][$k])) {
                        echo "Нельзя загружать скрипты.";
                        exit;
                    }
                }
                //перемещаем файл из временного хранилища
                if (move_uploaded_file($_FILES['file']['tmp_name'][$k], $uploadfile)) {
                    //получаем размеры файла
                    $size = getimagesize($uploadfile);
                } else
                    echo "<center><br>Файл не загружен, вернитесь и попробуйте еще раз.</center>";
            } else
                echo "<center><br>Можно загружать только изображения в форматах jpg, jpeg, gif и png.</center>";
        }
    }
}
//-------------------------------------------------------------------------

	header("location: vhidna.php");

//Zakrutie bazu       
       if(mysql_close($db))
        {
        // echo("Закриття бази даних");
         }
         else
         {
          echo("Не можливо виконати закриття бази"); 
          }
