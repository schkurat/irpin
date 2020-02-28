<?php
include_once "../function.php";
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
<div class="container">
    <form method="post" action="add_ng.php" name="myform" class="form">
        <div class="row">
            <div class="col-md-6">
                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label for="ng">Нова норма</label>
                        <input type="text" class="form-control" id="ng" name="ng">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="dt-start">Дата дії</label>
                        <input type="text" class="form-control datepicker" id="dt-start" name="dt_start">
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <button type="submit" class="btn btn-primary">Додати</button>
            </div>
        </div>
    </form>
    <div class="row">
        <div class="col-md-4">
            <table class="table table-striped table-bordered table-sm ">
                <thead>
                <tr>
                    <th scope="col" class="success">Норма години</th>
                    <th scope="col" class="success">Дата старту</th>
                </tr>
                </thead>

                <tbody>
                <?php
                $sql = "SELECT * FROM ng WHERE dl='1' ORDER BY id DESC";
                $atu = mysql_query($sql);
                while ($aut = mysql_fetch_array($atu)) {
                    ?>
                    <tr>
                        <td><?= $aut["ng"] ?></td>
                        <td><?= german_date($aut["dtstart"]); ?></td>
                    </tr>
                    <?php
                }
                mysql_free_result($atu);
                ?>

                </tbody>
            </table>
        </div>
    </div>
</div>




