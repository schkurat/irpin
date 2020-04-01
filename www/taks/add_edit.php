<?php
session_start();
$lg = $_SESSION['LG'];
$pas = $_SESSION['PAS'];

$idzm = $_POST['idzm'];
$idtaks = $_POST['idtaks'];
$sz = $_POST['szam'];
$nz = $_POST['nzam'];

/* if(isset($_POST['szu'])) $szu=$_POST['szu']; else $szu='';
if($szu!='') {
$nzu=$_POST['nzam'];
$nz=0;
}
else {

$nzu=0;
} */
$n_god = $_POST['nch'];
$tp_zm = $_POST['t_zm'];
$pdv = $_POST['pdv'];
$okr = $_POST['okr'];
$zmi_yur = $_POST['zmi_yur'];
$kf_nar = 0;

/* if($tp_zm==2 and $szu!=''){
if($zmi_yur=='yes'){
$kf_nar=1.5;
}
else{
$kf_nar=1.2;
}
} */

if ($tp_zm == 2) {
    $kf_nar = 1.5;
}

if ($tp_zm == 1) {
    $kf_nar = 1;
}

$s_teh = 0;
$s_arh = 0;
$s_pr = 0;
$s_vum = 0;
$s_kontr = 0;
$s_tak = 0;
$ss_bti = 0;

$dt = date("Y-m-d");

$db = mysql_connect("localhost", $lg, $pas);
if (!$db) echo "Не вiдбулося зєднання з базою даних";

if (!@mysql_select_db(kpbti, $db)) {
    echo("Не завантажена таблиця");
    exit();
}
//-----------polychaem kodu ispolniteley-------------------------------   
if (!$tehnik = $_POST['tehnik']) $teh = 0;
else {
    $sql2 = "SELECT ID_ROB FROM robitnuku WHERE ROBS='$tehnik' AND DL='1'";
    $atu2 = mysql_query($sql2);
    if ($atu2) $teh = mysql_result($atu2, 0);
    mysql_free_result($atu2);
}

if (!$priem = $_POST['priem']) $pruyom = 0;
else {
    $sql3 = "SELECT ID_ROB FROM robitnuku WHERE ROBS='$priem' AND DL='1'";
    $atu3 = mysql_query($sql3);
    if ($atu3) $pruyom = mysql_result($atu3, 0);
    mysql_free_result($atu3);
}

if (!$arhiv = $_POST['arhiv']) $arhv = 0;
else {
    $sql4 = "SELECT ID_ROB FROM robitnuku WHERE ROBS='$arhiv' AND DL='1'";
    $atu4 = mysql_query($sql4);
    if ($atu4) $arhv = mysql_result($atu4, 0);
    mysql_free_result($atu4);
}

if (!$vm = $_POST['vum']) $vum = 0;
else {
    $sql5 = "SELECT ID_ROB FROM robitnuku WHERE ROBS='$vm' AND DL='1'";
    $atu5 = mysql_query($sql5);
    if ($atu5) $vum = mysql_result($atu5, 0);
    mysql_free_result($atu5);
}

if (!$taksir = $_POST['taksir']) $tks = 0;
else {
    $sql6 = "SELECT ID_ROB FROM robitnuku WHERE ROBS='$taksir' AND DL='1'";
    $atu6 = mysql_query($sql6);
    if ($atu6) $tks = mysql_result($atu6, 0);
    mysql_free_result($atu6);
}

if (!$brugadur = $_POST['brug']) $brug = 0;
else {
    $sql7 = "SELECT ID_ROB FROM robitnuku WHERE ROBS='$brugadur' AND DL='1'";
    $atu7 = mysql_query($sql7);
    if ($atu7) $brug = mysql_result($atu7, 0);
    mysql_free_result($atu7);
}
//---------------------------------------------------------------------------

$ath = mysql_query("DELETE FROM taks_detal WHERE ID_TAKS='$idtaks'");
if (!$ath) {
    echo "Таксировка не видалена з БД";
}

/* $sql = "SELECT COUNT(*) FROM price";   
$atu=mysql_query($sql);   
if($atu) $cn=mysql_result($atu,0);
mysql_free_result($atu); */


for ($i = 1; $i <=500; $i++) {
    $t = "z" . $i;
    $kl[$i] = $_POST[$t];
    if ($kl[$i] != "") {
        $t_vm = "vum" . $i;
        $t_vk = "vuk" . $i;
        $t_kon = "kontr" . $i;
//------vstavka ispolnitelya---
        $t_isp = "s" . $i;
//---------------
        $t_price = "price" . $i;
//-----------------------------
        $n_vum[$i] = $_POST[$t_vm];
        $n_vuk[$i] = $_POST[$t_vk];
        $n_kontr[$i] = $_POST[$t_kon];
        $vd[$i] = $_POST['v' . $i];
        $skl[$i] = $_POST['skl' . $i];
//------vstavka ispolnitelya---
        $ispoln[$i] = $_POST[$t_isp];
//-----------------------
        $price[$i] = $_POST[$t_price];
//-----------------------------
        $rob = "";
        switch ($vd[$i]) {
            case 1:    //robotu pruymalnuk-1
                $s[$i] = round((round(($n_vuk[$i] * $n_god), 2) * $kl[$i] * $skl[$i]), 2);
                $s_pr = $s_pr + $s[$i];
                //$rob=$pruyom;
                $rob = $ispoln[$i];
                $t_rob = 1;
                break;
            case 2:        //robotu arhiv-2
                $s[$i] = round((round(($n_vuk[$i] * $n_god), 2) * $kl[$i] * $skl[$i]), 2);
                $s_arh = $s_arh + $s[$i];
                //$rob=$arhv;
                $rob = $ispoln[$i];
                $t_rob = 2;
                break;
            case 3:        //robotu robotu tehnika-4,vumiryuvacha-3,brigadira-5
                $s[$i] = round((round(($n_vuk[$i] * $n_god), 2) * $kl[$i] * $skl[$i]), 2);
                $svm[$i] = round((round(($n_vum[$i] * $n_god), 2) * $kl[$i] * $skl[$i]), 2);
                $skon[$i] = round((round(($n_kontr[$i] * $n_god), 2) * $kl[$i] * $skl[$i]), 2);
                $s_teh = $s_teh + $s[$i];
                $s_vum = $s_vum + $svm[$i];
                $s_kontr = $s_kontr + $skon[$i];
                //$rob=$teh;
                $rob = $ispoln[$i];
                $rob_vum = $vum; //$ispoln[$i];
                $rob_kont = $brug;
                $t_rob = 4;
                $t_rob_vm = 3;
                $t_rob_br = 5;
                break;
            case 4:        //robotu buro-6
                $s[$i] = round((round(($n_vuk[$i] * $n_god), 2) * $kl[$i] * $skl[$i]), 2);
                $s_buro = $s_buro + $s[$i];
                $rob = 1;
                $t_rob = 6;
                break;
            case 5:        //robotu без виходу на обєкт tehnika-4,vumiryuvacha-3,brigadira-5
                $s[$i] = round((round(($n_vuk[$i] * $n_god), 2) * $kl[$i] * $skl[$i]), 2);
                $svm[$i] = round((round(($n_vum[$i] * $n_god), 2) * $kl[$i] * $skl[$i]), 2);
                $skon[$i] = round((round(($n_kontr[$i] * $n_god), 2) * $kl[$i] * $skl[$i]), 2);
                $s_teh = $s_teh + $s[$i];
                $s_vum = $s_vum + $svm[$i];
                $s_kontr = $s_kontr + $skon[$i];
                //$rob=$teh;
                $rob = $ispoln[$i];
                $rob_vum = $vum; //$ispoln[$i];
                $rob_kont = $brug;
                $t_rob = 4;
                $t_rob_vm = 3;
                $t_rob_br = 5;
                break;
            default:
                break;
        }
//------------------------------------vukonavets--------------------------------------------------------
        if ($n_vuk[$i] != 0) {
            $ath1 = mysql_query("INSERT INTO taks_detal (ID_TAKS,IDZM,SZ,NZ,ID_ROB,ID_PRICE,TR,NORM,KL,KF_SKL,SUM,NDS,KF,KF_NAR) 
	VALUES('$idtaks','$idzm','$sz','$nz','$rob','$price[$i]','$t_rob','$n_vuk[$i]','$kl[$i]','$skl[$i]','$s[$i]','$pdv','$tp_zm','$kf_nar');");
        }
//------------------------------------------------------------------------------------------------------
//------------------------------------vumiruvach--------------------------------------------------------
        if ($n_vum[$i] != 0 and $vum != 0) {
            $ath1 = mysql_query("INSERT INTO taks_detal (ID_TAKS,IDZM,SZ,NZ,ID_ROB,ID_PRICE,TR,NORM,KL,KF_SKL,SUM,NDS,KF,KF_NAR) 
	VALUES('$idtaks','$idzm','$sz','$nz','$rob_vum','$price[$i]','$t_rob_vm','$n_vum[$i]','$kl[$i]','$skl[$i]','$svm[$i]','$pdv','$tp_zm','$kf_nar');");
        }
//------------------------------------------------------------------------------------------------------
//------------------------------------kontroler---------------------------------------------------------
        if ($n_kontr[$i] != 0 and $brug != 0) {
            $ath1 = mysql_query("INSERT INTO taks_detal (ID_TAKS,IDZM,SZ,NZ,ID_ROB,ID_PRICE,TR,NORM,KL,KF_SKL,SUM,NDS,KF,KF_NAR) 
	VALUES('$idtaks','$idzm','$sz','$nz','$rob_kont','$price[$i]','$t_rob_br','$n_kontr[$i]','$kl[$i]','$skl[$i]','$skon[$i]','$pdv','$tp_zm','$kf_nar');");
        }
//------------------------------------------------------------------------------------------------------
    }
}
if ($vum == 0) $s_vum = 0;
if ($brug == 0) $s_kontr = 0;
if ($tp_zm == 1) {
    $vart = $s_teh + $s_arh + $s_pr + $s_vum + $s_kontr + $s_buro;
}
if ($tp_zm == 2) {
    $vart = round((($s_teh + $s_arh + $s_pr + $s_vum + $s_kontr + $s_buro) * 2), 2);
}

//-----------okruglenie do 0---------------
if ($okr == 'yes') {
    if ($pdv == 20) {
        $vart_spdv = round(($vart * 1.2), 2);
        $sm_okr = ceil($vart_spdv);
        $vr_per = round(($sm_okr / 1.2), 7);
        $vr_per2 = round(($vr_per - $vart), 4);
    } else {
        $vart_spdv = round(($vart * 1), 2);
        $sm_okr = ceil($vart_spdv);
        $vr_per = round(($sm_okr / 1), 7);
        $vr_per2 = round(($vr_per - $vart), 4);
    }
} else $vr_per2 = 0;
//-----------------------------------------

$ath2 = mysql_query("UPDATE taks SET SUM='$vart',SUM_OKR='$vr_per2',DATE_T='$dt',NDS='$pdv',KF='$tp_zm' WHERE ID_TAKS='$idtaks'");
if (!$ath2) {
    echo "Сума не внесена до БД";
}

//Zakrutie bazu       
if (mysql_close($db)) {// echo("Закриття бази даних");
} else {
    echo("Не можливо виконати закриття бази");
}

header("location: taks.php");
