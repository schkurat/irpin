<?php
session_start();
$lg = $_SESSION["LG"];
$pas = $_SESSION["PAS"];
$korespondent = $_POST["kores"];
$nom_koresp = $_POST["nkores"];
$dat_koresp = $_POST["datakor"];
$pib_kor = $_POST["pib"];
$tip = $_POST["tup"];
$zmi = $_POST["zmist"];
//$nom_vhid=$_POST["nvhid"];
$dat_vhid = $_POST["data_vhod"];
$chas = $_POST["vrem"];
$dat_vukon = $_POST["data_vuk"];
$vukonav1 = $_POST["vukon1"];
$vukonav2 = $_POST["vukon2"];
$vukonav3 = $_POST["vukon3"];
$vukonav4 = $_POST["vukon4"];

$rn = $_POST["rajon"];
$ns = $_POST["nsp"];
$vl = $_POST["vyl"];
$bd = trim($_POST["bud"]);
$kva = trim($_POST["kvar"]);
$id_el_arh = (int)$_POST["id_el_arh"];

$db = mysql_connect("localhost", $lg, $pas);
if (!$db) echo "Не вiдбулося зєднання з базою даних";

if (!@mysql_select_db(kpbti, $db)) {
    echo("Не завантажена таблиця");
    exit();
}

$dat_vhid = substr($dat_vhid, 6, 4) . "-" . substr($dat_vhid, 3, 2) . "-" . substr($dat_vhid, 0, 2);
$dat_koresp = substr($dat_koresp, 6, 4) . "-" . substr($dat_koresp, 3, 2) . "-" . substr($dat_koresp, 0, 2);
$dat_vukon = substr($dat_vukon, 6, 4) . "-" . substr($dat_vukon, 3, 2) . "-" . substr($dat_vukon, 0, 2);

//---------------nomer vhidn-------
$d1 = date("Y-m-d", mktime(0, 0, 0, 1, 1, date("Y")));
$nom_vhid == "";

$sql = "SELECT NV FROM kans WHERE DATAV>=\"$d1\" ORDER BY NV DESC LIMIT 1";
$atu = mysql_query($sql);
while ($aut = mysql_fetch_array($atu)) {
    $nom_vhid = $aut["NV"] + 1;
}
mysql_free_result($atu);

if ($nom_vhid == "") {
    $nom_vhid = 1;
}
//---------------------------------

if ($id_el_arh == 0) {
    if (!empty($rn) and !empty($ns) and !empty($vl) and !empty($bd)) {
        $search_id = 0;
        $sql = "SELECT arhiv.ID FROM arhiv WHERE RN=\"$rn\" AND NS=\"$ns\" AND VL=\"$vl\" AND BD=\"$bd\" AND KV=\"$kva\"";
        $atu = mysql_query($sql);
        while ($aut = mysql_fetch_array($atu)) {
            $search_id = $aut["ID"];
        }
        mysql_free_result($atu);
        if ($search_id == 0) {
            $ath3 = mysql_query("INSERT INTO arhiv (RN,NS,VL,BD,KV) VALUES(\"$rn\",\"$ns\",\"$vl\",\"$bd\",\"$kva\");");
            $id_el_arh = mysql_insert_id();
        } else {
            $id_el_arh = $search_id;
        }
    }
}

$ath = mysql_query("INSERT INTO kans (EA,DATAV,NV,NKL,DATAKL,NAIM,BOSS,PR,DATAI,NI,ZMIST,TIP,DATAVK,TIME)
	VALUES(\"$id_el_arh\",DATE_FORMAT(\"$dat_vhid\",\"%Y-%m-%d\"),\"$nom_vhid\",\"$nom_koresp\",
	DATE_FORMAT(\"$dat_koresp\",\"%Y-%m-%d\"),\"$korespondent\",
	\"$pib_kor\",\"1\",\"\",\"\",\"$zmi\",\"$tip\",DATE_FORMAT(\"$dat_vukon\",\"%Y-%m-%d\"),\"$chas\");");
$kl = mysql_insert_id();
if ($ath) {
    if ($vukonav1 != "") {
        $ath1 = mysql_query("INSERT INTO kans_vuk (DATAV,NV,VK)
				VALUES(DATE_FORMAT(\"$dat_vhid\",\"%Y-%m-%d\"),\"$nom_vhid\",\"$vukonav1\");");
        if (!$ath1) {
            echo "Виконавець1 не внесений до БД";
        }
    }

    if ($vukonav2 != "") {
        $ath2 = mysql_query("INSERT INTO kans_vuk (DATAV,NV,VK)
				VALUES(DATE_FORMAT(\"$dat_vhid\",\"%Y-%m-%d\"),\"$nom_vhid\",\"$vukonav2\");");
        if (!$ath2) {
            echo "Виконавець2 не внесений до БД";
        }
    }

    if ($vukonav3 != "") {
        $ath3 = mysql_query("INSERT INTO kans_vuk (DATAV,NV,VK)
				VALUES(DATE_FORMAT(\"$dat_vhid\",\"%Y-%m-%d\"),\"$nom_vhid\",\"$vukonav3\");");
        if (!$ath3) {
            echo "Виконавець3 не внесений до БД";
        }
    }

    if ($vukonav4 != "") {
        $ath4 = mysql_query("INSERT INTO kans_vuk (DATAV,NV,VK)
				VALUES(DATE_FORMAT(\"$dat_vhid\",\"%Y-%m-%d\"),\"$nom_vhid\",\"$vukonav4\");");
        if (!$ath4) {
            echo "Виконавець4 не внесений до БД";
        }
    }

    //------------------------------------------------------------------------------------
    if ($id_el_arh != 0) {
        $katalog = "ea/" . $id_el_arh;
        if (!is_dir($katalog)) {
            mkdir($katalog);
            mkdir($katalog . "/document");
            mkdir($katalog . "/technical");
            mkdir($katalog . "/inventory");
            mkdir($katalog . "/correspondence");
            mkdir($katalog . "/keeper");
        }
        $katalog .= "/correspondence";
    } else {
        $katalog = "ea/correspondence/" . $kl;
    }
    if (!is_dir($katalog)) {
        mkdir($katalog);
    }
    if (isset($_FILES)) {
        //пролистываем весь массив изображений по одному $_FILES["file"]["name"] as $k=>$v
        foreach ($_FILES["file"]["name"] as $k => $v) {
            //директория загрузки
            $uploaddir = $katalog . "/";

            //новое имя изображения
            $apend = str_replace(" ", "_", $_FILES["file"]["name"][$k]);
            $apend = date("d_m_Y") . "_" . $apend;
            //путь к новому изображению
            $uploadfile = "$uploaddir$apend";

            //Проверка расширений загружаемых изображений
            if ($_FILES["file"]["type"][$k] == "image/gif" || $_FILES["file"]["type"][$k] == "image/png" ||
                $_FILES["file"]["type"][$k] == "image/jpg" || $_FILES["file"]["type"][$k] == "image/jpeg" ||
                $_FILES["file"]["type"][$k] == "application/pdf" || $_FILES["file"]["type"][$k] == "application/msword" ||
                $_FILES["file"]["type"][$k] == "application/excel" || $_FILES["file"]["type"][$k] == "application/x-excel" ||
                $_FILES["file"]["type"][$k] == "application/x-msexcel" || $_FILES["file"]["type"][$k] == "application/vnd.ms-excel") {
                //черный список типов файлов
                $blacklist = array(".php", ".phtml", ".php3", ".php4");
                foreach ($blacklist as $item) {
                    if (preg_match("/$item\$/i", $_FILES["file"]["name"][$k])) {
                        echo "Нельзя загружать скрипты.";
                        exit;
                    }
                }
                //перемещаем файл из временного хранилища
                if (move_uploaded_file($_FILES["file"]["tmp_name"][$k], $uploadfile)) {
                    //получаем размеры файла
                    $size = getimagesize($uploadfile);
                } else
                    echo "<center><br>Файл не загружен, вернитесь и попробуйте еще раз.</center>";
            } else
                echo "<center><br>Можно загружать только изображения в форматах jpg, jpeg, gif и png.</center>";
        }
    }

    //-------------------------------------------------------------------------

} else {
    echo "Документ не внесений до БД";
}

header("location: vhidna.php");

//Zakrutie bazu       
if (mysql_close($db)) {
    // echo("Закриття бази даних");
} else {
    echo("Не можливо виконати закриття бази");
}
