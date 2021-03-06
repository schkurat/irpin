<?php
function nexArhNumber($serial)
{

    $num = 0;
    $sql = "SELECT NUM FROM arhiv WHERE SERIAL='$serial' AND DL='1' ORDER BY SERIAL,NUM DESC LIMIT 1";
    $atu = mysql_query($sql);
    while ($aut = mysql_fetch_array($atu)) {
        $num = $aut["NUM"] + 1;
    }
    mysql_free_result($atu);

    if ($num == 0) {
        $num = 1;
    }
    $num = str_pad($num, 7, '0', STR_PAD_LEFT);
    return $num;
}

function getSerial($idOrder)
{//определение серии для архивного номера
    $serial = false;
    $sql = "SELECT arhiv_zakaz.RN FROM arhiv_zakaz WHERE arhiv_zakaz.KEY='$idOrder'";
    $atu = mysql_query($sql);
    while ($aut = mysql_fetch_array($atu)) {
        $serial = str_pad($aut["RN"], 2, '0', STR_PAD_LEFT);
    }
    mysql_free_result($atu);
    return $serial;
//    $start = strtotime('2019-01-01');
//    $dt_now = date("Y-m-d");
//    $end = strtotime($dt_now);
//
//    $days_between = ceil(abs($end - $start) / 86400);
//    return $days_between;
}

function getArhNumber($idZak)
{
    $arhNumber = null;
    $sql = "SELECT arhiv.SERIAL, arhiv.NUM FROM arhiv_zakaz, arhiv 
            WHERE arhiv_zakaz.DL='1' AND arhiv_zakaz.KEY='$idZak' 
            AND arhiv.NS=arhiv_zakaz.NS
            AND arhiv.VL=arhiv_zakaz.VL
            AND arhiv.BD=arhiv_zakaz.BUD";
    $atu = mysql_query($sql);
    while ($aut = mysql_fetch_array($atu)) {
        $arhNumber = $aut["SERIAL"] . "." . $aut["NUM"];
    }
    mysql_free_result($atu);
    return $arhNumber;
}

function german_date($oldat)
{
    if ($oldat == "") $vdat = "-";
    else {
        $oldat1 = explode('-', $oldat);
        if ($oldat1[1] > 0) {
            $mdt = mktime(0, 0, 0, $oldat1[1], $oldat1[2], $oldat1[0]);
            $vdat = date("d.m.Y", $mdt);
        } else
            $vdat = "-";
    }
    return $vdat;
}

function date_bd($oldat)
{
    $new_dat = substr($oldat, 6, 4) . "-" . substr($oldat, 3, 2) . "-" . substr($oldat, 0, 2);
    return $new_dat;
}

function procherk($chislo)
{
    if ($chislo == 0) $rez = '-';
    else $rez = $chislo;
    return $rez;
}

function p_buk($slovo)
{
    $bukva = substr($slovo, 0, 2);
    return $bukva;
}

function dva($ch, $mas1, $mas2, $mas3)
{
    $strok = '';
    $str_ch = (string)($ch);
    if ($str_ch{0} == 1 && $str_ch{1} == 0) $strok = $mas3[1];
    if ($str_ch{0} == 1 && $str_ch{1} != 0) $strok = $mas2[$str_ch{1}];
    if ($str_ch{0} > 1 && $str_ch{1} == 0) $strok = $mas3[$str_ch{0}];
    if ($str_ch{0} > 1 && $str_ch{1} != 0) $strok = $mas3[$str_ch{0}] . " " . $mas1[$str_ch{1}];
    return $strok;
}

function tri($ch, $mas1, $mas2, $mas3, $mas4)
{
    $str_ch = (string)($ch);
    $strok = $mas4[$str_ch{0}] . " ";
    if ($str_ch{1} == 0 && $str_ch{2} != 0) $strok .= $mas1[$str_ch{2}];
    $dv = substr($str_ch, 1, 2);
    $strok .= dva($dv, $mas1, $mas2, $mas3);
    return $strok;
}

function triada($ch, $mas1, $mas2, $mas3, $mas4)
{
    $len_do_z = (int)strlen($ch);
    switch ($len_do_z) {
        case 1:
            $strok = $mas1[$ch];
            break;
        case 2:
            $strok = dva($ch, $mas1, $mas2, $mas3);
            break;
        case 3:
            $strok = tri($ch, $mas1, $mas2, $mas3, $mas4);
            break;
    }
    return $strok;
}


function in_str($sum)
{
    $mas_m = array("", "один", "два", "три", "чотири", "п'ять", "шість", "сім", "вісім", "дев'ять");
    $mas1 = array("", "одна", "дві", "три", "чотири", "п'ять", "шість", "сім", "вісім", "дев'ять");
    $mas2 = array("", "одинадцять", "дванадцять", "тринадцять", "чотирнадцять", "п'ятнадцять",
        "шістнадцять", "сімнадцять", "вісімнадцять", "дев'ятнадцять");
    $mas3 = array("", "десять", "двадцять", "тридцять", "сорок", "п'ятдесят", "шістдесят",
        "сімдесят", "вісімдесят", "дев'яносто");
    $mas4 = array("", "сто", "двісті", "триста", "чотириста", "п'ятсот", "шістсот", "сімсот",
        "вісімсот", "дев'ятсот");
    $mas5 = array("тисяч", "тисяча", "тисячі", "тисячі", "тисячі", "тисяч", "тисяч", "тисяч", "тисяч", "тисяч");
    $mas6 = array("мільйонів", "мільйон", "мільйона", "мільйона", "мільйона", "мільйонів", "мільйонів", "мільйонів", "мільйонів", "мільйонів");
    $tr1 = '';
    $tr2 = '';
    $tr3 = '';

    $do_z = (int)$sum;
    $len_do_z = (int)strlen($do_z);
    if ($len_do_z <= 3) $tr1 = triada($do_z, $mas1, $mas2, $mas3, $mas4);
    if ($len_do_z > 3 && $len_do_z <= 6) {
        $ch1 = substr($do_z, -3, 3);
        $ch2 = substr($do_z, -6, $len_do_z - 3);
        $tr2 = triada($ch1, $mas1, $mas2, $mas3, $mas4);
        if (strlen($ch2) == 1) $tr1 = triada($ch2, $mas1, $mas2, $mas3, $mas4) . " " . $mas5[$ch2] . " ";
        if (strlen($ch2) == 2 && $ch2{0} == 1) $tr1 = triada($ch2, $mas1, $mas2, $mas3, $mas4) . " " . $mas5[5] . " ";
        if (strlen($ch2) == 2 && $ch2{0} != 1) $tr1 = triada($ch2, $mas1, $mas2, $mas3, $mas4) . " " . $mas5[$ch2{1}] . " ";
        if (strlen($ch2) == 3 && $ch2{1} == 1) $tr1 = triada($ch2, $mas1, $mas2, $mas3, $mas4) . " " . $mas5[5] . " ";
        if (strlen($ch2) == 3 && $ch2{1} != 1) $tr1 = triada($ch2, $mas1, $mas2, $mas3, $mas4) . " " . $mas5[$ch2{2}] . " ";
//$strok=$tr1.$tr2;
    }

    if ($len_do_z > 6 && $len_do_z <= 9) {
        $ch1 = substr($do_z, -3, 3);
        $ch2 = substr($do_z, -6, 3);
        $ch3 = substr($do_z, -9, $len_do_z - 6);
        $tr3 = triada($ch1, $mas1, $mas2, $mas3, $mas4);
        if (strlen($ch2) == 1) $tr2 = triada($ch2, $mas1, $mas2, $mas3, $mas4) . " " . $mas5[$ch2] . " ";
        if (strlen($ch2) == 2 && $ch2{0} == 1) $tr2 = triada($ch2, $mas1, $mas2, $mas3, $mas4) . " " . $mas5[5] . " ";
        if (strlen($ch2) == 2 && $ch2{0} != 1) $tr2 = triada($ch2, $mas1, $mas2, $mas3, $mas4) . " " . $mas5[$ch2{1}] . " ";
        if (strlen($ch2) == 3 && $ch2{1} == 1) $tr2 = triada($ch2, $mas1, $mas2, $mas3, $mas4) . " " . $mas5[5] . " ";
        if (strlen($ch2) == 3 && $ch2{1} != 1) $tr2 = triada($ch2, $mas1, $mas2, $mas3, $mas4) . " " . $mas5[$ch2{2}] . " ";

        if (strlen($ch3) == 1) $tr1 = triada($ch3, $mas_m, $mas2, $mas3, $mas4) . " " . $mas6[$ch3] . " ";
        if (strlen($ch3) == 2 && $ch3{0} == 1) $tr1 = triada($ch3, $mas_m, $mas2, $mas3, $mas4) . " " . $mas6[5] . " ";
        if (strlen($ch3) == 2 && $ch3{0} != 1) $tr1 = triada($ch3, $mas_m, $mas2, $mas3, $mas4) . " " . $mas6[$ch3{1}] . " ";
        if (strlen($ch3) == 3 && $ch3{1} == 1) $tr1 = triada($ch3, $mas_m, $mas2, $mas3, $mas4) . " " . $mas6[5] . " ";
        if (strlen($ch3) == 3 && $ch3{1} != 1) $tr1 = triada($ch3, $mas_m, $mas2, $mas3, $mas4) . " " . $mas6[$ch3{2}] . " ";

//$strok=$tr1.$tr2.$tr3;
    }
    $strok = $tr1 . $tr2 . $tr3;
    return $strok;
}

function fract($nm /*  = 0  */)
{
//if(!is_double($nm)) return 0;
    $ot = explode('.', $nm);
    return $ot[1];
}

function work_date($v_date, $kl)
{
    $d_temp = $v_date;
    $k = 0;
    while ($k < $kl) {
        $date_mas = explode('-', (string)$d_temp);
        $d_temp = date("Y-m-d", mktime(0, 0, 0, $date_mas[1], $date_mas[2] + 1, $date_mas[0]));
        $hd = "";
        $sql = "SELECT HOLIDAY FROM holiday WHERE HOLIDAY='$d_temp'";
        $atu = mysql_query($sql);
        if ($atu)
            while ($aut = mysql_fetch_array($atu)) {
                $hd = $aut["HOLIDAY"];
            }
        mysql_free_result($atu);
        if ($hd == "") {
            $k++;
        }
    }
    $result = german_date($d_temp);
    return $result;
}

function mis_term($v_date, $kl)
{
    $d_temp = $v_date;
    $date_mas = explode('-', (string)$d_temp);
    $date_mas[1] = $date_mas[1] + $kl;
    $k = 0;
    $i = 0;
    while ($k == 0) {
        $d_temp = date("Y-m-d", mktime(0, 0, 0, $date_mas[1], $date_mas[2] + $i, $date_mas[0]));
        $hd = "";
        $sql = "SELECT HOLIDAY FROM holiday WHERE HOLIDAY='$d_temp'";
        $atu = mysql_query($sql);
        if ($atu)
            while ($aut = mysql_fetch_array($atu)) {
                $hd = $aut["HOLIDAY"];
            }
        mysql_free_result($atu);
        if ($hd == "") $k++;
        else $i++;
    }
    $result = german_date($d_temp);
    return $result;
}

function objekt_ner($obj, $bud, $kv)
{
    $result = '';
    switch ($obj) {
        case 0:
            if ($bud != "") $budd = "буд. " . $bud; else $budd = "";
            if ($kv != "") $kvarr = "кв. " . $kv; else $kvarr = "";
            $result = $budd . ' ' . $kvarr;
            break;
        case 1:
            if ($bud != "") $budd = "буд. " . $bud; else $budd = "";
            if ($kv != "") $kvarr = "кв. " . $kv; else $kvarr = "";
            $result = $budd . ' ' . $kvarr;
            break;
        case 2:
            if ($bud != "") $budd = "буд. " . $bud; else $budd = "";
            if ($kv != "") $kvarr = "кв. " . $kv; else $kvarr = "";
            $result = $budd . ' ' . $kvarr;
            break;
        case 3:
            if ($bud != "") $budd = "буд. " . $bud; else $budd = "";
            if ($kv != "") $kvarr = "кв. " . $kv; else $kvarr = "";
            $result = $budd . ' ' . $kvarr;
            break;
        case 4:
            if ($bud != "") $budd = " Гараж № " . $bud; else $budd = " Гараж №";
            if ($kv != "") $kvarr = $kv; else $kvarr = "";
            $result = $budd . ' ' . $kvarr;
            break;
        case 5:
            if ($bud != "") $budd = "буд. " . $bud; else $budd = "";
            if ($kv != "") $kvarr = "кім. " . $kv; else $kvarr = "";
            $result = $budd . ' ' . $kvarr;
            break;
        case 6:
            if ($bud != "") $budd = $bud . " (ЦМК)"; else $budd = "";
            $result = $budd;
            break;
        case 7:
            if ($bud != "") $budd = $bud . " (нежитл. прим.)"; else $budd = "";
            $result = $budd;
            break;
        case 8:
            if ($bud != "") $budd = $bud . " (нежитл. будівля)"; else $budd = "";
            $result = $budd;
            break;
    }
    return $result;
}

function send_mail($to, $thm, $html, $path)

{

    $fp = fopen($path, "r");

    if (!$fp) {

        print "Файл $path не может быть прочитан";

        exit();

    }

    $file = fread($fp, filesize($path));

    fclose($fp);


    $boundary = "--" . md5(uniqid(time())); // генерируем разделитель

    $headers .= "MIME-Version: 1.0\n";

    $headers .= "Content-Type: multipart/mixed; boundary=\"$boundary\"\n";

    $multipart .= "--$boundary\n";

    $kod = 'UTF-8'; // или $kod = 'windows-1251'; 

    $multipart .= "Content-Type: text/html; charset=$kod\n";

    $multipart .= "Content-Transfer-Encoding: Quot-Printed\n\n";

    $multipart .= "$html\n\n";


    $message_part = "--$boundary\n";

    $message_part .= "Content-Type: application/octet-stream\n";

    $message_part .= "Content-Transfer-Encoding: base64\n";

    $message_part .= "Content-Disposition: attachment; filename = \"" . $path . "\"\n\n";

    $message_part .= chunk_split(base64_encode($file)) . "\n";

    $multipart .= $message_part . "--$boundary--\n";


    if (!mail($to, $thm, $multipart, $headers, "-f irpin.bti@gmail.com")) {

        echo "К сожалению, письмо не отправлено";

        exit();

    }

}

function open_dir($dir, $adr)
{
    $files = '<tr><th id="open_dir" colspan="2">' . $adr . '</th></tr>';
    if ($dh = opendir($dir)) {
        while (false !== ($file = readdir($dh))) {
            if ($file != "." && $file != "..") {
                $files .= '<tr><td style="text-align: center;">
                                    <img class="del-file" src="../images/b_drop.png" data-url="' . $dir . '/' . $file . '" border="0">
                               </td>
                               <td id="zal">
                                    <a href="download_file.php?url=' . $dir . '/' . $file . '">' . $file . '</a>
                               </td></tr>';
            }
        }
        closedir($dh);
    }
    return $files;
}

function check_open_dir($dir, $adr)
{
	$i=0;
    if ($dh = opendir($dir)) {
        while (false !== ($file = readdir($dh))) {
            if ($file != "." && $file != "..") {
                $i++;
            }
        }
        closedir($dh);
    }
    return $i;
}

function check_kasa($sz,$nz,$sum)
{
    $sql_k = "SELECT * FROM `arhiv_kasa`  WHERE `SZ`=$sz AND `NZ`=$nz";
    $atu_k = mysql_query($sql_k);
	if(mysql_affected_rows()==1)
	{
		while ($aut_k = mysql_fetch_array($atu_k)) 
		{
			$s=floatval($aut_k["SM"]);
		}
	}
	else
	{
		$s=0;
	}
	
	
	if($s<floatval($sum)){
		return $sum;
	}
	else
	{
		return '<span style="color:rgb(10,205,5);">'.$sum.'</span>';
	}

    mysql_free_result($atu_k);
}



function get_num_order($rn,$dt_order,$nz){
   return str_pad($rn, 2, 0, STR_PAD_LEFT) . $dt_order . str_pad($nz,2,'0',STR_PAD_LEFT);
}

function zm_for_bd($zm){
    $response = "";
    if (!empty($zm)){
        $s = trim($zm);
        if (strlen($s) == 10) {
            $sz = mb_substr($s, 2, 6);
            $nz = mb_substr($s, 8, 2);
            $response = " AND zamovlennya.SZ='$sz' AND zamovlennya.nz='$nz' ";
        }
    }
    return $response;
}

function get_adr($url,$lg,$pas){
    $id_ea = array_shift(explode('/',$url));
    $address ='';

    $db = mysql_connect("localhost", $lg, $pas);
    if (!$db) echo "Не вiдбулося зєднання з базою даних";

    if (!@mysql_select_db(kpbti, $db)) {
        echo("Не завантажена таблиця");
        exit();
    }

    $sql = "SELECT rayonu.RAYON,arhiv.BD,arhiv.KV,nas_punktu.NSP,tup_nsp.TIP_NSP,vulutsi.VUL,tup_vul.TIP_VUL    
	FROM arhiv,rayonu,nas_punktu,vulutsi,tup_nsp,tup_vul  
	WHERE 
		arhiv.DL='1' AND arhiv.ID='$id_ea'
		AND rayonu.ID_RAYONA=arhiv.RN 
		AND nas_punktu.ID_NSP=arhiv.NS
		AND vulutsi.ID_VUL=arhiv.VL
		AND tup_nsp.ID_TIP_NSP=nas_punktu.ID_TIP_NSP
		AND tup_vul.ID_TIP_VUL=vulutsi.ID_TIP_VUL";
    $atu = mysql_query($sql);
    while ($aut = mysql_fetch_array($atu)) {
        $obj_ner = objekt_ner(0, $aut["BD"], $aut["KV"]);
        $address = $aut["TIP_NSP"] . $aut["NSP"] . " " . $aut["TIP_VUL"] . $aut["VUL"] . " " . $obj_ner;
    }
    mysql_free_result($atu);

    return $address;
}

function get_filter_for_rn($drn,$table,$col_name){
    $drn = explode(';', $drn);
    $filter = '';
    foreach ($drn as $dr){
        if(empty($filter)){
            $filter .= $table . "." . $col_name . "=" . $dr . " ";
        }else{
            $filter .= " OR " . $table . "." . $col_name . "=" . $dr;
        }
    }
    return $filter;
}

function check_or_create_folder($main_dir){
    if(!is_dir($main_dir . '/document')) mkdir($main_dir . '/document');
    if(!is_dir($main_dir . '/keeper')) mkdir($main_dir . '/keeper');
    if(!is_dir($main_dir . '/technical')) mkdir($main_dir . '/technical');
    if(!is_dir($main_dir . '/correspondence')) mkdir($main_dir . '/correspondence');
    if(!is_dir($main_dir . '/inventory')) mkdir($main_dir . '/inventory');
}