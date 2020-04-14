<?php
session_start();
$lg = $_SESSION['LG'];
$pas = $_SESSION['PAS'];
$nvh = $_POST['nvhid'];
$nvuh = $_POST['nvuh'];
$datav = $_POST['data_v'];
$nkl = $_POST['nkores'];
$dkl = $_POST['datkl'];
$naim = $_POST['kores'];
$boss = $_POST['pib'];
$zmist = $_POST['zauv'];
$tip = $_POST['tup'];


$db = mysql_connect("localhost", $lg, $pas);
if (!$db) echo "Не вiдбулося зєднання з базою даних";

if (!@mysql_select_db(kpbti, $db)) {
    echo("Не завантажена таблиця");
    exit();
}

//$chas=date("H:i:s");

$dkl = substr($dkl, 6, 4) . "-" . substr($dkl, 3, 2) . "-" . substr($dkl, 0, 2);
$datav = substr($datav, 6, 4) . "-" . substr($datav, 3, 2) . "-" . substr($datav, 0, 2);

$ath = mysql_query("UPDATE kans SET NAIM='$naim',NKL='$nkl',DATAKL=DATE_FORMAT('$dkl','%Y-%m-%d'),
					BOSS='$boss',TIP='$tip',ZMIST='$zmist'
				WHERE DATAV=DATE_FORMAT('$datav','%Y-%m-%d') AND NV='$nvh' AND PR='1'");
if (!$ath) {
    echo "Загальна інформація вхідної документації не змінена";
}

$ea_id = 0;
$sql = "SELECT kans.EA FROM kans WHERE DATAV=DATE_FORMAT('$datav','%Y-%m-%d') AND NV='$nvh' AND PR='1'";
//echo $sql;
$atu = mysql_query($sql);
while ($aut = mysql_fetch_array($atu)) {
    $ea_id = $aut["EA"];
}
mysql_free_result($atu);

//------------------------------------------------------------------------------------
//var_dump($ea_id);
if ($ea_id != 0) {
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
if (mysql_close($db)) {
    // echo("Закриття бази даних");
} else {
    echo("Не можливо виконати закриття бази");
}
