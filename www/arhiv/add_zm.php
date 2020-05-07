<?php
session_start();
$lg = $_SESSION['LG'];
$pas = $_SESSION['PAS'];
//$kodp=$_SESSION['KODP'];

include("../function.php");

$v_zm = (int)$_POST['vud_zam'];

if (isset($_POST['kod'])) $idn = $_POST['kod']; else $idn = "";

$id_vr = $_POST['vud_rob']; //вид робіт
$pr = strip_tags(addslashes(trim($_POST['priz'])));
$im = strip_tags(addslashes(trim($_POST['imya'])));
$pb = strip_tags(addslashes(trim($_POST['pobat'])));

$prim = addslashes($_POST['prim']);

$sert_s = strip_tags(addslashes(trim($_POST['ser_sert'])));
$sert_n = strip_tags(addslashes(trim($_POST['numb_sert'])));
$sert = $sert_s . ' ' . $sert_n;

$subj = strip_tags(addslashes(trim($_POST['subj'])));
$adrs_subj = strip_tags(addslashes(trim($_POST['adrs_subj'])));

$edrpou = strip_tags($_POST['edrpou']);
$ipn = strip_tags($_POST['ipn']);
$svid = strip_tags($_POST['svid']);
$prilad = strip_tags(addslashes($_POST['prilad']));
$dover = strip_tags(addslashes($_POST['doruch']));
$tl = strip_tags(trim($_POST['tel']));
if (isset($_POST['email'])) $email = strip_tags($_POST['email']); else $email = "";
$rn = $_POST['rajon'];
$ns = $_POST['nsp'];
$vl = $_POST['vyl'];
$bd = strip_tags(trim($_POST['bud']));
$kva = strip_tags(trim($_POST['kvar']));
$sm = strip_tags($_POST['sum']);
$d_pr = strip_tags(date_bd($_POST['d_pr']));


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

}

if ($error == 0) {
    $d_pr = date("Y-m-d");

    $sz = date("dmy");
    $nz = '';

    $sql = "SELECT NZ FROM arhiv_zakaz WHERE SZ='$sz' AND DL='1' ORDER BY SZ,NZ DESC LIMIT 1";
    $atu = mysql_query($sql);
    while ($aut = mysql_fetch_array($atu)) {
        $nz = $aut["NZ"] + 1;
    }
    mysql_free_result($atu);

    if ($nz == '') {
        $nz = 1;
    }

    if ($id_vr != "" and $pr != "" and $rn != "" and $ns != "" and $vl != "" and $bd != "" and $sm != "") {
        $ath1 = mysql_query("INSERT INTO arhiv_zakaz (SZ,NZ,VUD_ROB,EDRPOU,IPN,SVID,SUBJ,ADR_SUBJ,PRILAD,PR,IM,PB,PRIM,
	SERT,TEL,EMAIL,DOR,SUM,D_PR)
	VALUES('$sz','$nz','$id_vr','$edrpou','$ipn','$svid','$subj','$adrs_subj','$prilad','$pr','$im','$pb','$prim',
	'$sert','$tl','$email','$dover','$sm','$d_pr');");
        $l_id = mysql_insert_id();
        if (!$ath1) {
            echo "Замовлення не внесене до БД";
        } else {

            $id_el_arh = 0;
            $sql = "SELECT ID FROM arhiv WHERE RN='$rn' AND NS='$ns' AND VL='$vl' AND BD='$bd' AND KV='$kva' AND DL='1'";
            $atu = mysql_query($sql);
            while ($aut = mysql_fetch_array($atu)) {
                $id_el_arh = $aut["ID"];
            }
            mysql_free_result($atu);

            if ($id_el_arh == 0) {
                $ath3 = mysql_query("INSERT INTO arhiv (RN,NS,VL,BD,KV) VALUES('$rn','$ns','$vl','$bd','$kva');");
                $id_el_arh = mysql_insert_id();
            }

            $ath2 = mysql_query("INSERT INTO `arhiv_dop_adr` (`id_zm`,`id_arh`,`rn`,`ns`,`vl`,`bud`,`kvar`,`status`) 
	VALUES ('$l_id','$id_el_arh','$rn','$ns','$vl','$bd','$kva','0')");
        }

        if ($v_zm == 2) {
            $ed_pod = ($svid != '') ? '0' : '1';

            $sql5 = "SELECT EDRPOU FROM yur_kl WHERE EDRPOU='$edrpou'";
            $atu5 = mysql_query($sql5);
            if (!mysql_fetch_array($atu5)) {
                $ath5 = mysql_query("INSERT INTO yur_kl (`NAME`,`ADRES`,`EDRPOU`,`SVID`,`IPN`,`TELEF`,`EMAIL`,`ED_POD`,`PRILAD`,`SERT_S`,`SERT_N`,`SO_IPN`,`SO_PR`,`SO_IM`,`SO_PB`) 
    VALUES('$subj','$adrs_subj','$edrpou','$svid','$ipn','$tl','$email','$ed_pod','$prilad','$sert_s','$sert_n','$idn','$pr','$im','$pb');");
                if (!$ath5) {
                    echo "Клієнт не внесений до БД";
                }
            }
            mysql_free_result($atu5);
        }


        header("location: arhiv.php?filter=zm_view");

    } else {
        if ($id_vr == "") echo "Не заповнено поле Вид робіт<br>";
        if ($pr == "") echo "Не заповнено поле Прізвище<br>";
        if ($rn == "") echo "Не заповнено поле Район<br>";
        if ($ns == "") echo "Не заповнено поле Населений пункт<br>";
        if ($vl == "") echo "Не заповнено поле Вулиця<br>";
        if ($bd == "") echo "Не заповнено поле Будинок<br>";
        if ($sm == "") echo "Не заповнено поле Сума<br>";
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
