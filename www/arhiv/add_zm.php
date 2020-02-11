<?php
session_start();
$lg = $_SESSION['LG'];
$pas = $_SESSION['PAS'];
//$kodp=$_SESSION['KODP'];

include("../function.php");

//$v_zm=$_POST['vud_zam'];
//$pdv=$_POST['pdv'];
//$term=$_POST['term'];
//if(isset($_POST['kod'])) $idn=$_POST['kod']; else $idn="";

$id_vr = $_POST['vud_rob']; //вид робіт
$pr = addslashes(trim($_POST['priz']));
$im = addslashes(trim($_POST['imya']));
$pb = addslashes(trim($_POST['pobat']));
//for($zz=1;$zz<=12;$zz++){
//$doci.=$_POST['d'.$zz].' ';
//}
$prim = addslashes($_POST['prim']);
//$dn=$_POST['dnar'];
$sert = trim($_POST['ser_sert']) . ' ' . trim($_POST['numb_sert']);

$subj = addslashes(trim($_POST['subj']));
$adrs_subj = addslashes(trim($_POST['adrs_subj']));
//$pbvl=trim($_POST['pobatvl']);
//$dnvl=$_POST['dnarvl'];
//$pasportvl=trim($_POST['pasportvl']);

$edrpou = $_POST['edrpou'];
$ipn = $_POST['ipn'];
$svid = $_POST['svid'];
$prilad = addslashes($_POST['prilad']);
$dover = addslashes($_POST['doruch']);
$tl = trim($_POST['tel']);
if (isset($_POST['email'])) $email = $_POST['email']; else $email = "";
$rn = $_POST['rajon'];
$ns = $_POST['nsp'];
$vl = $_POST['vyl'];
$bd = trim($_POST['bud']);
$kva = trim($_POST['kvar']);
$sm = $_POST['sum'];
$d_pr = date_bd($_POST['d_pr']);
//$dg=$_POST['datag'];
//$priyom=$_POST['pr_osob'];


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

//if(!ctype_digit($ipn)){
//$error++;
//$text_error.='Не вірний формат поля ІПН!!!<br>';
//}
//if(!ctype_digit($svid)){
//$error++;
//$text_error.='Не вірний формат поля Свідоцтво!!!<br>';
//}
//$kl_ipn=strlen($ipn);
//$kl_svid=strlen($svid);
//if($kl_ipn<8){
//$error++;
//$text_error.='Не вірно вказана кількість символів поля ІПН!!!<br>';
//}
//if($kl_svid<8){
//$error++;
//$text_error.='Не вірно вказана кількість символів поля Свідоцтво!!!<br>';
//}

}

if ($error == 0) {
// $dn=date_bd($dn);
// $dnvl=date_bd($dnvl);
// $d_vh=date_bd($d_vh);
// $dg=date_bd($dg);
// $d_pr=date("Y-m-d");

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
	SERT,TEL,EMAIL,DOR,RN,NS,VL,BUD,KVAR,SUM,D_PR)
	VALUES('$sz','$nz','$id_vr','$edrpou','$ipn','$svid','$subj','$adrs_subj','$prilad','$pr','$im','$pb','$prim',
	'$sert','$tl','$email','$dover','$rn','$ns','$vl','$bd','$kva','$sm','$d_pr');");
        if (!$ath1) {
            echo "Замовлення не внесене до БД";
        }

        if ($svid != '') $ed_pod = '0';
        else $ed_pod = '1';
        $sql5 = "SELECT EDRPOU FROM yur_kl WHERE EDRPOU='$edrpou'";
        $atu5 = mysql_query($sql5);
        if (!mysql_fetch_array($atu5)) {
            $ath5 = mysql_query("INSERT INTO yur_kl (`NAME`,`ADRES`,`EDRPOU`,`SVID`,`IPN`,`TELEF`,`EMAIL`,`ED_POD`)
	VALUES('$subj','$adrs_subj','$edrpou','$svid','$ipn','$tl','$email','$ed_pod');");
            if (!$ath5) {
                echo "Клієнт не внесений до БД";
            }
        }
        mysql_free_result($atu5);


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
?>