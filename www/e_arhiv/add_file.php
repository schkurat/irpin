<?php
session_start();
$lg = $_SESSION['LG'];
$pas = $_SESSION['PAS'];
include("../function.php");
$katalog = $_POST['id_kat'];
$inv = $_POST['inv'];
//$adres = $_POST['adres'];
$page = (isset($_POST['page'])) ? $_POST['page'] : 0;
$o_file = ($page > 0) ? $_POST['old_file'] : '';

$db = mysql_connect("localhost", $lg, $pas);
if (!$db) echo "Не вiдбулося зєднання з базою даних";

if (!@mysql_select_db(kpbti, $db)) {
    echo("Не завантажена таблиця");
    exit();
}

//------------------------------------------------------------------------------------
if (isset($_FILES)) {
    //пролистываем весь массив изображений по одному $_FILES['file']['name'] as $k=>$v
    foreach ($_FILES['file']['name'] as $k => $v) {
        //директория загрузки
        $uploaddir = $katalog . '/'; //"/home/sc_zm/$firma$n_zm/";

        //новое имя изображения
        /* $poz=strrpos($_FILES["file"]["name"][$k],'.');
        $rez_obr=substr($_FILES["file"]["name"][$k],$poz);
        $apend=date('YmdHis').rand(100,1000).$rez_obr; */
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
            // mkdir("/home/sc_zm/$firma$n_zm");
            if (move_uploaded_file($_FILES['file']['tmp_name'][$k], $uploadfile)) {
                //получаем размеры файла
                $size = getimagesize($uploadfile);
                if ($page > 0) {
                    require('../fpdf18/fpdf.php');
                    require('../FPDI-1.5.3/fpdi.php');

                    if ($o_file != '') {
                        $pdf = new FPDI();
                        $pdf2 = new FPDI();

                        $first_file_name = $katalog . '/' . $o_file;

                        $pageCount = $pdf->setSourceFile($first_file_name);
                        $skipPages = $page;

                        for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
                            if ($pageNo == $skipPages) {
                                $pdf->setSourceFile($uploadfile);
                                $templateID2 = $pdf->importPage(1);
                                $pdf->getTemplateSize($templateID2);
                                $pdf->addPage();
                                $pdf->useTemplate($templateID2);
                                $pdf->setSourceFile($first_file_name);
                            }else{
                                $templateID = $pdf->importPage($pageNo);
                                $pdf->getTemplateSize($templateID);
                                $pdf->addPage();
                                $pdf->useTemplate($templateID);
                            }
                        }

                        unlink($uploadfile);
                        $pdf->Output('F', $first_file_name);

                    }
                }
            } else
                echo "<center><br>Файл не загружен, вернитесь и попробуйте еще раз.</center>";
        } else
            echo "<center><br>Можно загружать только изображения в форматах jpg, jpeg, gif и png.</center>";
    }
}
//-------------------------------------------------------------------------

//Zakrutie bazu       
if (mysql_close($db)) {
    // echo("Закриття бази даних");
} else {
    echo("Не можливо виконати закриття бази");
}

header("location: earhiv.php?filter=spr_view&inv_spr=" . $inv);
?>