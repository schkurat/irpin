<form action="add_yur.php" name="myform" method="get">
    <table align="center" class="zmview">
        <tr>
            <th colspan="4" align="center">Внесення нового юридичного клієнта</th>
        </tr>
        <tr>
            <td>Скорочена назва:</td>
            <td colspan="3"><input name="name" type="text" size="60" value=""/></td>
        </tr>
        <tr>
            <td>Повна назва:</td>
            <td colspan="3"><input name="namef" type="text" size="60" value=""/></td>
        </tr>
        <tr>
            <td>Адреса:</td>
            <td colspan="3"><input name="adres" type="text" size="60" value=""/></td>
        </tr>
        <tr>
            <td>Телефон:</td>
            <td><input name="telef" type="text" size="20" value=""/></td>
            <td>E-mail:</td>
            <td><input name="email" type="text" size="20" value=""/></td>
        </tr>
        <tr>
            <td>Платник ПДВ:</td>
            <td>
                <input id="r1" type="radio" name="pdv" value="0" checked/><label for="r1">Так</label>
                <input id="r2" type="radio" name="pdv" value="1"/><label for="r2">Ні</label>
            </td>
            <td>ЄДРПОУ:</td>
            <td><input name="edrpou" type="text" size="20" value=""/></td>
        </tr>
        <tr>
            <td>Свідоцтво:</td>
            <td><input name="svid" type="text" size="20" value=""/></td>
            <td>ІПН:</td>
            <td><input name="ipn" type="text" size="20" value=""/></td>
        </tr>
        <tr>
            <td>Банк:</td>
            <td colspan="3"><input name="bank" type="text" size="60" value=""/></td>
        </tr>
        <tr>
            <td>МФО:</td>
            <td><input name="mfo" type="text" size="20" value=""/></td>
            <td>Рахунок:</td>
            <td><input name="rr" type="text" size="20" value=""/>
            </td>
        </tr>
        <tr>
            <td>Прилад:</td>
            <td colspan="3"><input name="prilad" type="text" size="60" value=""/></td>
            </td>
        </tr>
        <tr>
            <td>Сертифікат:</td>
            <td colspan="3">
                <input type="text" id="ser_sert" size="2" maxlength="2" name="ser_sert" value=""/>
                <input type="text" id="numb_sert" size="18" maxlength="30" name="numb_sert" value=""/>
            </td>
            </td>
        </tr>
        <tr><th colspan="4">Сертифікована особа</th></tr>
        <tr>
            <td>ІПН:</td>
            <td colspan="3">
                <input type="text" id="so_ipn" size="60" name="so_ipn" value=""/>
            </td>
            </td>
        </tr>
        <tr>
            <td>Прізвище:</td>
            <td colspan="3">
                <input type="text" id="so_pr" size="60" name="so_pr" value=""/>
            </td>
            </td>
        </tr>
        <tr>
            <td>Ім'я:</td>
            <td colspan="3">
                <input type="text" id="so_im" size="60" name="so_im" value=""/>
            </td>
            </td>
        </tr>
        <tr>
            <td>По батькові:</td>
            <td colspan="3">
                <input type="text" id="so_pb" size="60" name="so_pb" value=""/>
            </td>
            </td>
        </tr>
        <tr>
            <th colspan="4">Договір</th>
        </tr>
        <tr>
            <td>Номер:</td>
            <td><input name="ndog" type="text" size="20" value=""/></td>
            <td>Дата:</td>
            <td><input name="dtdog" type="text"  size="20" class="datepicker" value=""/></td>
        </tr>
        <tr>
            <td align="center" colspan="4">
                <input name="Ok" type="submit" style="width:80px" value="Додати"/></td>
        </tr>
    </table>
</form>