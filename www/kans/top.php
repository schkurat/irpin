<?php
session_start();
$lg = $_SESSION['LG'];
$pas = $_SESSION['PAS'];
header('Content-Type: text/html; charset=utf-8');
?>
<html>
<head>
    <title>
        Автоматизована система інвентаризації об'єктів нерухомості
    </title>

    <!--<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js"></script>-->
    <script type="text/javascript" src="../js/jquery.min.js"></script>
    <script type="text/javascript" src="../js/autozap.js"></script>
    <script type="text/javascript" src="../js/bti.js"></script>
<!--    <script type="text/javascript" src="../js/jquery.maskedinput-1.2.2.js"></script>-->
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
                <li><a href="#">Вхiдна</a>
                    <ul>
                        <li><a href="addvhid.php">Додати</a></li>
                        <li><a href="vid.php">Вiдповiдь</a></li>
                        <li><a href="vhidna.php">Вхідна (пергляд)</a></li>
                    </ul>
                </li>
                <li><a href="#">Вихiдна</a>
                    <ul>
                        <li><a href="vuhidna.php">Додати</a></li>
                        <li><a href="vuhid_view.php">Вихідна (пергляд)</a></li>
                        <li><a href="vuh_za_per.php">Вихідна за період</a></li>
                    </ul>
                </li>
                <li><a href="#">Змiнити</a>
                    <ul>
                        <li><a href="kor_zag_info.php">Загальну iнформацiю</a></li>
                        <li><a href="kor_vuk.php">Виконавцiв</a></li>
                    </ul>
                </li>
                <li><a href="#">Пошук</a>
                    <ul>
                        <li><a href="poisk1.php">Наш № вхiдної</a></li>
                        <li><a href="poisk2.php">№ вхiдної кореспондента</a></li>
                        <li><a href="poisk3.php">Кореспондент (контекст)</a></li>
                        <li><a href="poisk4.php">Змiст (контекст)</a></li>
                        <li><a href="poisk5.php">Наш № вихiдної</a></li>
                    </ul>
                </li>
                <li><a href="#">Друк</a>
                    <ul>
                        <li><a href="druk1.php">Список по виконавцям на пiдпис</a></li>
                        <li><a href="druk2.php">Журн. вхiдн. кореспонденції</a></li>
                        <li><a href="druk4.php">Список з виконавцями за номером</a></li>
                        <li><a href="druk5.php">Список без виконавцiв</a></li>
                        <li><a href="druk6.php">Журнал невиконаних запитiв по виконавцям</a></li>
                        <li><a href="druk7.php">Журнал вихідної</a></li>
                        <li><a href="druk8.php">Журнал вихідної за номером</a></li>
                    </ul>
                </li>
                <li><a href="../menu.php">Вихід</a></li>
            </ul>

        </td>
        <td class="fn">
            <div class="gran">
                <hr>