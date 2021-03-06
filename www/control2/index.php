<?php
session_start();
$lg = $_SESSION['LG'];
$pas = $_SESSION['PAS'];
$drn=$_SESSION['DRN'];
//$kodp=$_SESSION['KODP'];
//$kod_rn=$_SESSION['NR'];
//$br=$_SESSION['BR'];
header('Content-Type: text/html; charset=utf-8');
?>
<html>
<head>
    <title>
        Автоматизована система інвентаризації об'єктів нерухомості
    </title>

    <script src="datp/external/jquery/jquery.js"></script>
    <script src="datp/jquery-ui.js"></script>
    <script type="text/javascript" src="../js/autozap.js"></script>
    <script type="text/javascript" src="../js/bti.js"></script>
    <link rel="stylesheet" type="text/css" href="../js/autozap.css"/>
    <link rel="stylesheet" type="text/css" href="../my.css"/>
    <link rel="stylesheet" type="text/css" href="datp/jquery-ui.css"/>
    <link rel="stylesheet" type="text/css" href="../menu.css"/>

    <script>
        $(function () {
            let datepicker = $(".datepicker");
            datepicker.datepicker();
            datepicker.datepicker("option", "dateFormat", "dd.mm.yy");
            datepicker.datepicker("option", "monthNames", ["Січень", "Лютий", "Березень", "Квітень", "Травень", "Червень", "Липень", "Серпень", "Вересень", "Жовтень", "Листопад", "Грудень"]);
            datepicker.datepicker("option", "dayNamesMin", ["Нд", "Пн", "Вт", "Ср", "Чт", "Пт", "Сб"]);
            datepicker.datepicker("option", "firstDay", 1);
        });
    </script>
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
                <li><a href="index.php?filter=ros_view">Замовлення на розподіл</a></li>
                <li><a href="#">Підпис</a>
                    <ul>
                        <li><a href="index.php?filter=pidpus_view&flag=first">Перегляд</a></li>
                        <li><a href="index.php?filter=pidpus_view&flag=nap">Справи на підпис</a></li>
                        <li><a href="index.php?filter=pidpus_view&flag=pid">Підписані справи</a></li>
                        <li><a href="#">Пошук</a>
                            <ul>
                                <li><a href="index.php?filter=seach_pidpus&krit=zm">Замовлення</a></li>
                                <li><a href="index.php?filter=seach_pidpus&krit=vuk">Виконавець</a></li>
                                <li><a href="index.php?filter=seach_pidpus&krit=adr">Адреса</a></li>
                            </ul>
                        </li>
                    </ul>
                </li>
                <li><a href="#">Контроль</a>
                    <ul>
                        <li><a href="#">Пошук</a>
                            <ul>
                                <li><a href="index.php?filter=seach_kontrol&krit=zm">Замовлення</a></li>
                                <li><a href="index.php?filter=seach_kontrol&krit=adr">Адреса</a></li>
                                <li><a href="index.php?filter=seach_kontrol&krit=kont">Власник (Назва)</a></li>
                            </ul>
                        </li>
                        <li><a href="#">Друк</a>
                            <ul>
                                <li><a href="index.php?filter=print_info&krit=vuhodu">Проїзди:</a></li>
                                <li><a href="index.php?filter=print_info&krit=got">Готовність на:</a></li>
                                <li><a href="index.php?filter=print_info&krit=nevk">Невиконані</a></li>
                                <li><a href="index.php?filter=print_info&krit=nevk_vuk">Невиконані по виконавцю</a></li>
                                <li><a href="index.php?filter=print_info&krit=pr_per">Прийняті за період</a></li>
                                <li><a href="index.php?filter=print_info&krit=vk_d_got">По виконавцю та даті готовності</a></li>
                                <li><a href="index.php?filter=print_info&krit=nespl">Не сплачені замовлення</a></li>
                            </ul>
                        </li>
                    </ul>
                </li>
                <li><a href="../menu.php">Вихід</a></li>
            </ul>
        </td>
        <td class=fn>
            <div class="gran">
                <hr>
                <?php
                $temp = (isset($_GET['filter']))? $_GET['filter'] : '';
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
