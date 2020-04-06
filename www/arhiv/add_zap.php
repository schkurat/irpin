<?php
session_start();
$lg = $_SESSION['LG'];
$pas = $_SESSION['PAS'];
include("../function.php");
$id = $_POST['id'];
$inv_n = $_POST['inv_number'];
$ns = $_POST['nsp'];
$vl = $_POST['vyl'];
$bd = $_POST['bud'];
if (isset($_POST['kv'])) $kv = $_POST['kv'];
else $kv = "";
$prim = addslashes($_POST['prum']);
$pr_dt = "";
$nameobj = addslashes($_POST['nameobj']);
$vlasn = addslashes($_POST['vlasn']);
$skl_chast = addslashes($_POST['skl_chast']);
$kad_nom = addslashes($_POST['kad_nom']);
$plzem = str_replace(",", ".", $_POST['plzem']);
$plzag = str_replace(",", ".", $_POST['plzag']);
$pljit = str_replace(",", ".", $_POST['pljit']);
$pldop = str_replace(",", ".", $_POST['pldop']);
$dt_perv = date_bd($_POST['dt_perv']);
$vk_perv = addslashes($_POST['vk_perv']);
$numb_obl = $_POST['numb_obl'];
$dt_obl = date_bd($_POST['dt_obl']);


if ($kv != "") $flag = " AND KV='" . $kv . "'";
else $flag = "";
$db = mysql_connect("localhost", $lg, $pas);
if (!$db) echo "Не вiдбулося зєднання з базою даних";

if (!@mysql_select_db(kpbti, $db)) {
    echo("Не завантажена таблиця");
    exit();
}

$sql = "UPDATE arhiv SET 
PRIM = '$prim',N_SPR = '$inv_n',FIRST_DT_INV = '$dt_perv',FIRST_VUK = '$vk_perv',NUMB_OBL = '$numb_obl', DT_OBL = '$dt_obl',NAME = '$nameobj',
VLASN = '$vlasn',PL_ZEM = '$plzem',PL_ZAG = '$plzag',PL_JIT = '$pljit', PL_DOP = '$pldop', SKL_CHAST = '$skl_chast', KAD_NOM = '$kad_nom' 
WHERE id = $id";
//echo $sql;
$ath1 = mysql_query($sql);

if (!$ath1) {
    echo "Запис не внесений до БД";
}

echo "<br>";
echo mysql_affected_rows();
echo "<br>";
echo "Номер помилки " . mysql_errno();
echo "<br>";
echo "Пормилка " . mysql_error();

$nr = mysql_errno();
if ($nr == 0) header("location: arhiv.php?filter=arh_view&rejum=view&srt=N_SPR");

//Zakrutie bazu       
if (mysql_close($db)) {
    // echo("Закриття бази даних");
} else {
    echo("Не можливо виконати закриття бази");
}
