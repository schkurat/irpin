<?php
session_start();
$lg = $_SESSION['LG'];
$pas = $_SESSION['PAS'];
include '../classes/database.php';

//$tp=$_GET['tip'];
$kl = (int)$_GET['kl'];
$rn = $_GET['rn'];

//$db=mysql_connect("localhost",$lg,$pas);
//if(!$db) echo "Не вiдбулося зєднання з базою даних";
//
// if(!@mysql_select_db(kpbti,$db))
//  {
//   echo("Не завантажена таблиця");
//   exit();
//   }

$db = new Database($lg, $pas);

$ath = $db->db_link->query("UPDATE arhiv SET DL='0' WHERE arhiv.ID='$kl'");

$db->__destruct();

header("location: earhiv.php?filter=arh_view&rayon=" . $rn);

//if ($tp == 'katalog') {
//    $roz = $_GET['id_roz'];
//    $ath = mysql_query("UPDATE fails SET DL='0' WHERE fails.ID_ARH='$kl'");
//    if (!$ath) {
//        echo "Запис не видалений з БД";
//    }
//    $ath = mysql_query("UPDATE earhiv SET DL='0' WHERE earhiv.ID='$kl'");
//    if (!$ath) {
//        echo "Запис не видалений з БД";
//    }
//
//
//    header("location: earhiv.php?filter=arh_view&rejum=seach&rozdil=" . $roz);
//}
//if ($tp == 'file') {
//    $id_kat = $_GET['id_kat'];
//    $ath = mysql_query("UPDATE fails SET DL='0' WHERE fails.ID='$kl'");
//    if (!$ath) {
//        echo "Запис не видалений з БД";
//    }
//
//
//    header("location: earhiv.php?filter=file_view&id_kat=" . $id_kat);
//}
