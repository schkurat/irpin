<?php
session_start();
$lg = $_SESSION['LG'];
$pas = $_SESSION['PAS'];

include("../function.php");

$url = $_POST['url'];
$parent_link = $_POST['parent_link'];
$adr = $_POST['adr'];

$katalog = 'ea/' . $url;

if (isset($_FILES)) {
    //пролистываем весь массив изображений по одному $_FILES['file']['name'] as $k=>$v
    foreach ($_FILES['file']['name'] as $k => $v) {
        //директория загрузки
        $uploaddir = $katalog . '/';

        //новое имя изображения
        $apend = str_replace(" ", "_", $_FILES["file"]["name"][$k]);
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


header("location: index.php?filter=storage&url=" . $url . "&parent_link=" . $parent_link . "&adr=" . $adr);
