<?php
session_start();
$lg = $_SESSION['LG'];
$pas = $_SESSION['PAS'];

include("../function.php");

$v_zm = $_POST['vud_zam'];
$pdv = $_POST['pdv'];
$term = $_POST['term'];
if (isset($_POST['kod'])) $idn = $_POST['kod']; else $idn = "";

$id_vr = $_POST['vud_rob'];
$pr = trim($_POST['priz']);
$im = trim($_POST['imya']);
$pb = trim($_POST['pobat']);
for ($zz = 1; $zz <= 12; $zz++) {
    $doci .= $_POST['d' . $zz] . ' ';
}
$prim = $doci . $_POST['prim'];
$dn = $_POST['dnar'];
$pasport = trim($_POST['pasport']);
$prvl = trim($_POST['prizvl']);
$imvl = trim($_POST['imyavl']);
$pbvl = trim($_POST['pobatvl']);
$dnvl = $_POST['dnarvl'];
$pasportvl = trim($_POST['pasportvl']);

$edrpou = $_POST['edrpou'];
$ipn = $_POST['ipn'];
$svid = $_POST['svid'];
$dover = $_POST['doruch'];
$tl = trim($_POST['tel']);
if (isset($_POST['email'])) $email = $_POST['email']; else $email = "";
$rn = $_POST['rajon'];
$ns = $_POST['nsp'];
$vl = $_POST['vyl'];
$bd = trim($_POST['bud']);
$kva = trim($_POST['kvar']);
$id_el_arh = (int)$_POST['id_el_arh'];

$sm = $_POST['sum'];
$datav = date_bd($_POST['datav']);
$dg = $_POST['datag'];
$priyom = $_POST['pr_osob'];

$db = mysql_connect("localhost", $lg, $pas);
if (!$db) echo "Не вiдбулося зєднання з базою даних";

if (!@mysql_select_db(kpbti, $db)) {
    echo("Не завантажена таблиця");
    exit();
}

$error = 0;
$text_error = '';

if ($v_zm == "2") {
    if (!ctype_digit($edrpou)) {
        $error++;
        $text_error .= 'Не вірний формат поля ЄДРПОУ!!!<br>';
    }
    $kl_edrpou = strlen($edrpou);
    if ($kl_edrpou < 8) {
        $error++;
        $text_error .= 'Не вірно вказана кількість символів поля ЄДРПОУ!!!<br>';
    }
    if ($pdv == "1") {
        if (!ctype_digit($ipn)) {
            $error++;
            $text_error .= 'Не вірний формат поля ІПН!!!<br>';
        }
        if (!ctype_digit($svid)) {
            $error++;
            $text_error .= 'Не вірний формат поля Свідоцтво!!!<br>';
        }
        $kl_ipn = strlen($ipn);
        $kl_svid = strlen($svid);
        if ($kl_ipn < 8) {
            $error++;
            $text_error .= 'Не вірно вказана кількість символів поля ІПН!!!<br>';
        }
        if ($kl_svid < 8) {
            $error++;
            $text_error .= 'Не вірно вказана кількість символів поля Свідоцтво!!!<br>';
        }
    }
}

if ($error == 0) {
    $dn = date_bd($dn);
    $dnvl = date_bd($dnvl);
    $d_vh = date_bd($d_vh);
    $dg = date_bd($dg);
    $d_pr = date("Y-m-d");

    $sz = date("dmy");
    $nz = '';

    $sql = "SELECT NZ FROM zamovlennya WHERE SZ='$sz' AND DL='1' ORDER BY SZ,NZ DESC LIMIT 1";
    $atu = mysql_query($sql);
    while ($aut = mysql_fetch_array($atu)) {
        $nz = $aut["NZ"] + 1;
    }
    mysql_free_result($atu);

    if ($nz == '') {
        $nz = 1;
    }

    if ($id_el_arh == 0) {
        $ath3 = mysql_query("INSERT INTO arhiv (RN,NS,VL,BD,KV) VALUES('$rn','$ns','$vl','$bd','$kva');");
        $id_el_arh = mysql_insert_id();
    }

    if ($id_vr != "" and $pr != "" and $rn != "" and $ns != "" and $vl != "" and $bd != "" and $sm != "" and $dg != "") {
        $ath1 = mysql_query("INSERT INTO zamovlennya (EA,SZ,NZ,TUP_ZAM,TERM,VUD_ROB,PR_OS,IDN,EDRPOU,IPN,SVID,PR,IM,PB,PRIM,
	D_NAR,PASPORT,TEL,EMAIL,PRVL,IMVL,PBVL,D_NARVL,PASPORTVL,DOR,RN,NS,VL,BUD,KVAR,SUM,D_PR,DATA_VUH,DATA_GOT)
	VALUES('$id_el_arh','$sz','$nz','$v_zm','$term','$id_vr','$priyom','$idn','$edrpou','$ipn','$svid','$pr','$im','$pb','$prim',
	'$dn','$pasport','$tl','$email','$prvl','$imvl','$pbvl','$dnvl','$pasportvl','$dover','$rn','$ns','$vl','$bd','$kva','$sm','$d_pr','$datav','$dg');");
        if (!$ath1) {
            echo "Замовлення не внесене до БД";
        }

        if ($v_zm == "1") {
            $sql3 = "SELECT IDN FROM idn WHERE IDN='$idn'";
            $atu3 = mysql_query($sql3);
            if (!mysql_fetch_array($atu3)) {
                $ath2 = mysql_query("INSERT INTO idn (IDN,PR,IM,PB,DATA_NAR) VALUES('$idn','$pr','$im','$pb','$dn');");
                if (!$ath2) {
                    echo "Код особи не внесений до БД";
                }
            }
            mysql_free_result($atu3);
        } else {

            if ($svid != '') $ed_pod = '0';
            else $ed_pod = '1';
            $sql5 = "SELECT EDRPOU FROM yur_kl WHERE EDRPOU='$edrpou'";
            $atu5 = mysql_query($sql5);
            if (!mysql_fetch_array($atu5)) {
                $ath5 = mysql_query("INSERT INTO yur_kl (`NAME`,`EDRPOU`,`SVID`,`IPN`,`TELEF`,`EMAIL`,`ED_POD`)
	VALUES('$pr','$edrpou','$svid','$ipn','$tl','$email','$ed_pod');");
                if (!$ath5) {
                    echo "Клієнт не внесений до БД";
                }
            }
            mysql_free_result($atu5);
        }

        //------------------------------------------------------------------------------------
        if ($id_el_arh == 0) {
            $ath3 = mysql_query("INSERT INTO arhiv (RN,NS,VL,BD,KV) VALUES('$rn','$ns','$vl','$bd','$kva');");
            $id_el_arh = mysql_insert_id();
        }
        $katalog = 'ea/' . $id_el_arh;
        if (!is_dir($katalog)) {
            mkdir($katalog);
            mkdir($katalog . '/document');
            mkdir($katalog . '/technical');
            mkdir($katalog . '/inventory');
            mkdir($katalog . '/correspondence');
            mkdir($katalog . '/keeper');
        }
        $katalog .= '/document';

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
        //-------------------------------------------------------------------------
        if ($v_zm == "1") {
            header("location: index.php?filter=drugi_vlasnuku&sz=" . $sz . "&nz=" . $nz . "");
        } else {
            header("location: index.php?filter=zm_view");
        }
    } else {
        if ($id_vr == "") echo "Не заповнено поле Вид робіт<br>";
        if ($pr == "") echo "Не заповнено поле Прізвище<br>";
        if ($rn == "") echo "Не заповнено поле Район<br>";
        if ($ns == "") echo "Не заповнено поле Населений пункт<br>";
        if ($vl == "") echo "Не заповнено поле Вулиця<br>";
        if ($bd == "") echo "Не заповнено поле Будинок<br>";
        if ($sm == "") echo "Не заповнено поле Сума<br>";
        if ($dg == "") echo "Не заповнено поле Дата готовності<br>";
    }
} else {
    echo "Кількість помилок: " . $error . "<br>";
    echo $text_error;
}
//Zakrutie bazu       
if (mysql_close($db)) {
    // echo("Закриття бази даних");
} else {
    echo("Не можливо виконати закриття бази");
}
