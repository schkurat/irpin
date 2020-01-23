<?php
session_start();
$lg = $_SESSION['LG'];
$pas = $_SESSION['PAS'];
/* $kodp=$_SESSION['KODP'];
$kod_rn=$_SESSION['NR']; */

header('Content-Type: text/html; charset=utf-8');
?>
<html>
<head>
    <title>
        Автоматизована система інвентаризації об'єктів нерухомості
    </title>

    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js"></script>
    <script type="text/javascript" src="../js/autozap.js"></script>
    <script type="text/javascript" src="../js/jquery.maskedinput-1.2.2.js"></script>
    <link rel="stylesheet" type="text/css" href="../js/autozap.css"/>
    <link rel="stylesheet" type="text/css" href="../my.css"/>
    <link rel="stylesheet" type="text/css" href="../menu.css"/>

    <script type="text/javascript" src="../js/scriptbreaker-multiple-accordion-1.js"></script>
    <script language="JavaScript">
        $(document).ready(function () {
            $(".topnav").accordion({
                accordion: true,
                speed: 500,
                closedSign: '►',
                openedSign: '▼'
            });
        });
    </script>
</head>
<body>

<table width="100%" border="0" cellspacing=0>
    <tr>
        <td class=men>
            <?php
            $db = mysql_connect("localhost", $lg, $pas);
            if (!$db) echo "Не вiдбулося зєднання з базою даних";

            if (!@mysql_select_db(kpbti, $db)) {
                echo("Не завантажена таблиця");
                exit();
            }
            ?>

            <ul class="topnav">
                <li><a href="#">Таксування</a>
                    <ul>
                        <li><a href="taks.php?filter=new_taks">Нове</a></li>
                        <li><a href="taks.php?filter=taks_view">Таксовані сьогодні</a></li>
                    </ul>
                </li>
                <li><a href="#">Пошук</a>
                    <ul>
                        <li><a href="taks.php?filter=seach_taks&krit=zm">Замовлення</a></li>
                        <li><a href="taks.php?filter=seach_taks&krit=adr">Адреса</a></li>
                        <li><a href="taks.php?filter=taks_zm_pr">Таксовані за період</a></li>
                    </ul>
                </li>
                <li><a href="#">Настройка</a>
                    <ul>
                        <li><a href="taks.php?filter=new_vid_rob">Новий вид робіт</a></li>
                        <li><a href="taks.php?filter=vsi_rob_view">Перегляд всіх робіт</a></li>
                        <li><a href="taks.php?filter=select_vid_rob">Перегляд робіт по послугам</a></li>
                    </ul>
                </li>
                <li><a href="taks.php?filter=proezd_info">Проїзд звіт</a></li>
                <li><a href="taks.php?filter=zm_for_ea">Електронний архів</a></li>
                <li><a href="../menu.php">Вихід</a></li>
            </ul>
        </td>
        <td class=fn>
            <div class="gran">
                <hr>
                <?php
                $temp = $_GET['filter'];
                if ($temp == "") {
                    $temp = "taks_view.php";
                    require($temp);
                } else {
                    require($temp . ".php");
                }
                ?>
                <hr>
            </div>
        </td>
    </tr>
</table>
<?php
//Zakrutie bazu       
if (mysql_close($db)) {
    // echo("Закриття бази даних");
} else {
    echo("Не можливо виконати закриття бази");
}
?>
</body>
</html>