<?php
session_start();
$log = $_SESSION['LG'];
$pas = $_SESSION['PAS'];
$fam = $_POST['priz'];
$im = $_POST['imya'];
$pb = $_POST['pobat'];
$lg = $_POST['log'];
$ps = $_POST['pas'];
$ps2 = $_POST['pas2'];
$prava = "";
$d_zm = "";
$d_ps = "";
$d_rn = "";
$prava_del = "";


if ($fam != "" and $im != "" and $pb != "" and $lg != "" and $ps == $ps2) {
    for ($i = 1; $i <= 15; $i++) {
        $temp = $_POST[$i];
        if ($temp == "pr" . $i) {
            $prava .= 1;
        } else {
            $prava .= 0;
        }
    }
    for ($i = 1; $i <= 43; $i++) {
        $zz = 'drn' . $i;
        $temp = (isset($_POST[$zz]))? $_POST[$zz]: '';
        if ($temp == $i) {
            if(empty($d_rn)){
                $d_rn .= $temp;
            }else{
                $d_rn .= ';' . $temp;
            }
        }
    }

    if (isset($_POST["21"])) $prava_del = 1; else $prava_del = 0;
    if (isset($_POST["25"])) $d_ps = 1; else $d_ps = 0;
//if(isset($_POST["22"])) $prava_spl=1; else $prava_spl=0;

    $db = mysql_connect("localhost", $log, $pas);
    if (!$db) echo "Не вiдбулося зєднання з базою даних";

    if (!@mysql_select_db(kpbti, $db)) {
        echo("Не завантажена таблиця");
        exit();
    }

//$parol=md5($ps);
    $parol = $ps;

    $ath1 = mysql_query("INSERT INTO security(PR ,IM ,PB ,LOG ,PRD,DRN,DPS,DTL)
	VALUES ('$fam','$im','$pb','$lg','$prava','$d_rn','$d_ps','$prava_del');");
    if (!$ath1) {
        echo "Користувач не внесений до БД";
    }

    $ath2 = mysql_query("CREATE USER '" . $lg . "'@'localhost' IDENTIFIED BY '" . $parol . "';");
    if (!$ath2) {
        echo "Користувач не внесений до MYSQL";
    }

    $ath3 = mysql_query("GRANT SELECT,INSERT,UPDATE ,DELETE,FILE ON * . * TO '" . $lg . "'@'localhost' IDENTIFIED BY '" . $parol . "' 
		WITH MAX_QUERIES_PER_HOUR 0 MAX_CONNECTIONS_PER_HOUR 0 MAX_UPDATES_PER_HOUR 0 
		MAX_USER_CONNECTIONS 0 ;");
    if (!$ath3) {
        echo "Користувачу на назначені права MYSQL";
    }

    //Zakrutie bazu
    if (mysql_close($db)) {
        // echo("Закриття бази даних");
    } else {
        echo("Не можливо виконати закриття бази");
    }
} else {
    echo "Ви не внесли дані або паролі не співпадають!";
}

header("location: admin.php");
