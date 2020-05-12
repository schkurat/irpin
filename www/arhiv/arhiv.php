<?php
session_start();
$lg = $_SESSION['LG'];
$pas = $_SESSION['PAS'];
//$br=$_SESSION['BR'];
$pr_prie = $_SESSION['PR'];
$im_prie = $_SESSION['IM'];
$pb_prie = $_SESSION['PB'];
$ddl = $_SESSION['DDL'];
header('Content-Type: text/html; charset=utf-8');
$dt_now = date("d.m.Y");
?>
<html>
<head>
    <title>
        Автоматизована система інвентаризації об'єктів нерухомості
    </title>
    <!--<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js"></script>-->
    <script src="../datp/external/jquery/jquery.js"></script>
    <script src="../datp/jquery-ui.js"></script>
    <script type="text/javascript" src="../js/autozap.js"></script>
    <script type="text/javascript" src="../js/bti.js"></script>
    <script type="text/javascript" src="../js/fix_table.js"></script>
    <!--<script type="text/javascript" src="../js/jquery.maskedinput-1.2.2.js"></script>-->
    <link rel="stylesheet" type="text/css" href="../datp/jquery-ui.css"/>
    <link rel="stylesheet" type="text/css" href="../js/autozap.css"/>
    <link rel="stylesheet" type="text/css" href="../my.css"/>
    <link rel="stylesheet" type="text/css" href="../menu.css"/>
    <link href="../fontawesome/css/all.css" rel="stylesheet">
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
        $(function () {
            let dtp = $(".datepicker");
            dtp.datepicker();
            dtp.datepicker("option", "dateFormat", "dd.mm.yy");
            dtp.datepicker("option", "monthNames", ["Січень", "Лютий", "Березень", "Квітень", "Травень", "Червень", "Липень", "Серпень", "Вересень", "Жовтень", "Листопад", "Грудень"]);
            dtp.datepicker("option", "dayNamesMin", ["Нд", "Пн", "Вт", "Ср", "Чт", "Пт", "Сб"]);
            dtp.datepicker("option", "firstDay", 1);
            dtp.datepicker("setDate",'<?= $dt_now ?>');
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
                <li><a href="#">Замовлення</a>
                    <ul>
                        <li><a href="arhiv.php?filter=zam_new">Створити</a></li>
                        <li><a href="arhiv.php?filter=zm_view">За день</a></li>
                        <li><a href="arhiv.php?filter=seach_zm_pr">За період</a></li>
                        <li><a href="arhiv.php?filter=seach_zm_info">Пошук</a></li>
                    </ul>
                </li>
                <li><a href="arhiv.php?filter=history_info">Історія по суб'єкту</a></li>
<!--                <li><a href="arhiv.php?filter=vozvrat_view">Повернення справи</a></li>-->
                <!--   <li><a href="#">Повернення</a>
                   <ul>
                           <li><a href="arhiv.php?filter=">Створити</a></li>
                           <li><a href="arhiv.php?filter=">За день</a></li>
                           <li><a href="arhiv.php?filter=">За період</a></li>
                           <li><a href="arhiv.php?filter=">Пошук</a></li>
                   </ul>
                   </li>-->
                <li><a href="#">Обробка каси</a>
                    <ul>
                        <li><a href="arhiv.php?filter=oplata_info">Ручна розноска</a></li>
                        <li><a href="arhiv.php?filter=kasa_view_info">Перегляд</a></li>
                        <li><a href="arhiv.php?filter=protokol_info">Протокол обробки</a></li>
                        <li><a href="arhiv.php?filter=pov_info">Повернення коштів</a></li>
                    </ul>
                </li>
                <li><a href="#">Юридичні клієнти</a>
                    <ul>
                        <li><a href="arhiv.php?filter=yur_view">Перегляд</a></li>
                        <li><a href="arhiv.php?filter=new_yur_info">Додати</a></li>
                    </ul>
                </li>
                <li><a href="#">Архів інвентарний</a>
                    <ul>
<!--                        <li><a href="arhiv.php?filter=new_zap_info">Створити запис</a></li>-->
                        <li><a href="arhiv.php?filter=arh_view&rejum=view&srt=NUMB_OBL">Перегляд</a></li>
                        <li><a href="arhiv.php?filter=seach_info">Пошук</a></li>
                    </ul>
                </li>
                <!--<li><a href="#">Електронний архів</a>
                <ul>
                        <li><a href="arhiv.php?filter=enew_zap_info">Створити/редагувати</br>справу</a></li>
                        <li><a href="arhiv.php?filter=earh_view">Перегляд</a></li>
                        <li><a href="arhiv.php?filter=eseach_info">Пошук</a></li>
                </ul>
                </li>-->
                <li><a href="../menu.php">Вихід</a></li>
            </ul>
        </td>
        <td class=fn>
            <div class="gran">
                <hr>
                <?php
                $temp = $_GET['filter'];
                if ($temp == "") {
                    $temp = "fon.php";
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