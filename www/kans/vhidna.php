<?php
require("top.php");
include "function.php";
?>
    <script type="text/javascript">
        $(document).ready(
            function () {
                $(".zmview tr").mouseover(function () {
                    $(this).addClass("over");
                });

                $(".zmview tr").mouseout(function () {
                    $(this).removeClass("over");
                });
                $(".zmview tr:even").addClass("alt");
            }
        );
    </script>
    <table align="center" class="zmview">
        <tr>
            <th>Ел. арх.</th>
            <th>Дата вх. кор.</th>
            <th>Дата вх.</th>
            <th>№ вих.</th>
            <th>№ вх.</th>
            <th>№ вх. кор.</th>
            <th>Кореспонд.</th>
            <th>Дата вих.</th>
            <th>Змiст</th>
            <th>Тип</th>
            <th>П.I.Б</th>
            <th>Дата викон.</th>
        </tr>
        <?php
        $d1 = date("Y-m-d", mktime(0, 0, 0, 1, 1, date("Y")));
        $d2 = date("Y-m-d");


        $sql = "SELECT ID,EA,DATAKL,DATAV,NI,NV,NKL,NAIM,DATAI,ZMIST,TIP,BOSS,DATAVK FROM kans
		WHERE DATAV>=\"$d1\" AND DATAV<=\"$d2\" AND PR=\"1\" ORDER BY NV DESC";
        $atu = mysql_query($sql);
        while ($aut = mysql_fetch_array($atu)) {
            $url = ($aut["EA"] != 0)? $aut["EA"] . "/correspondence": "correspondence/" . $aut["ID"];
            ?>
            <tr>
                <td align="center"><a class="text-link" href="storage.php?url=<?= $url ?>&parent_link=&adr=">ЕА</a></td>
                <td align="center"><?= german_date($aut["DATAKL"]) ?></td>
                <td align="center"><?= german_date($aut["DATAV"]) ?></td>
                <td align="center"><?= $aut["NI"] ?></td>
                <td align="center" id="zal"><a
                            href="kor_info_get.php?perekl=vhid&nomer=<?= $aut["NV"] ?>"><?= $aut["NV"] ?></a></td>
                <td align="center"><?= $aut["NKL"] ?></td>
                <td align="center"><?= $aut["NAIM"] ?></td>
                <td align="center"><?= german_date($aut["DATAI"]) ?></td>
                <td align="center"><?= $aut["ZMIST"] ?></td>
                <td align="center"><?= $aut["TIP"] ?></td>
                <td align="center"><?= $aut["BOSS"] ?></td>
                <td align="center"><?= german_date($aut["DATAVK"]) ?></td>
            </tr>
            <?php
        }
        mysql_free_result($atu);
        ?>
    </table>
<?php
require("bottom.php");
