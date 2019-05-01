<?
/*
    Перенос таблиц баз данных из DBF'ок в mySQL
    Автор: Шеин Алексей Николаевич
    Дата:  Август, 2006 год
    Мыло:  lexx918@mail.ru
    Ася:   203820969
*/

// время с точностью до миллисекунд
function getMicroTime(){
    list($usec, $sec) = explode(" ", microtime());
    return ((float)$usec + (float)$sec);
}

// Функция импорта таблицы из *.DBF в mySQL
// аргументы:  f     - полное имя файла, который надо импортировать
// Возвращает: arRet - ассоц. массив с итогом по импорту
// Для работы необходим иметь уже открытое соединение с БД mySQL
function DBF2mySQL($f){

    // инициализация и настройка
    $arRet = array();    // итоговый массив
    $arRet['timeStart'] = getMicroTime(); // старт функции
    $opisanie = '';       // таблица со сводной статистикой и итогом работы
    $debugMode = 1;       // режим отладки для отображения таблицы сведений
    $nn = "\r\n";         // новая строка
    ini_set('mysql.connect_timeout', 3600); // таймаут соединения с БД (сек.)
    ini_set('max_execution_time', 3600);    // таймаут php-скрипта

    // проверяем наличие указанного файла базы данных
    if(!file_exists($f)){
        $arRet['itog'] = 'false';
        $arRet['error'] = 'нет такого файла';
        echo "q1";
        return $arRet;
    }


    /*
    *
    *   mySQL
    *                        удаляем старую таблицу
    */
    // извлекаем имя для таблицы (например E:/MAKC2005/BASES/NSI/REFER.DBF -> REFER)
    if(!preg_match_all('/(\/\w{1,10}\/(\w+)\.DBF)$/si', $f, $temp, PREG_SET_ORDER)){
        $arRet['itog'] = 'false';
        $arRet['error'] = 'в имени файла не удалось найти имя для таблицы';
	return $arRet;
    }else{
        $arRet['tableName'] = $temp[0][2];
        //echo '<pre>'; print_r($temp); exit();
        UnSet($temp);
    }
//    $arRet['tableName']="BR";
    // удаляем таблицу с таким именем если она уже есть
    if(mysql_query("DROP TABLE IF EXISTS ".$arRet['tableName'])){
        $arRet['oldTable'] = 'если таблица была - её удалили перед работой';
    }else{
        $arRet['itog'] = 'false';
        $arRet['error'] = 'во время попытки удалить таблицу перед работой произошла ошибка mySQL: '.mysql_error();
echo "q2";        
        return $arRet;
    }
    // конец удаления старой таблицы


    // размер файла
    clearstatcache();
    $arRet['fileSize'] = filesize($f);
    $opisanie .= 'File: <b>'.$f.'</b><br />';
    $opisanie .= 'Размер DBF\'ки = '.$arRet['fileSize'].' байт<br />';

    // Определяем число полей
    $DBF = fopen($f, 'r');                               // открыли файл ДБФ для чтения
    $i = 0;                                              // счётчик байтов
    while(!feof($DBF)){                                  // читаем побайтно
        $b = fread($DBF, 1);                             // один бит - символ
        if(($i>31) && ($i%32 == 0) && (ord($b) == 13)){  // если встретили символ с кодом 13
            $arRet['poleCount'] = $i/32-1;               // .. значит заголовок кончился
            $opisanie .= 'Стоп в байте '.$i.'. Число полей: '.$arRet['poleCount'].'<br />';
            break;
        }
        $i++;
    }
    fclose($DBF);


    /*
    *
    *   З А Г О Л О В О К
    *
    */
    $arHeader0 = array( // массив описаний типов таблицы заголовка (байт 0)
        "3"   => "Простая таблица",
        "4"   => "Простая таблица",
        "5"   => "Простая таблица",
        "67"  => "С мемо-полем .dbv",
        "179" => "С мемо-полями .dbv .dbt",
        "131" => "С мемо-полем .dbt",
        "139" => "С мемо-полем .dbt формат D4",
        "142" => "SQL-таблица",
        "245" => "С мемо полем .fmp"
    );

    $arHeader14 = array( // транзакции (байт 14)
        "1" => "Начало транзакции",   "0" => "Конец транзакции / Игнорируется"
    );

    $arHeader15 = array( // кодировка-видимость (байт 15)
        "1" => "Закодировано",        "0" => "Нормальная видимость"
    );

    $arHeader28 = array( // использование индекса (байт 28)
        "1" => "Используется индекс", "0" => "Индекс не используется"
    );

    $arHeader29 = array( // кодовые страницы / драйвер (байт 29)
        "1"   => "Кодовая страница 437 DOS USA",
        "2"   => "Кодовая страница 850 DOS Multilang",
        "38"  => "Кодовая страница 866 DOS Russian",
        "87"  => "Кодовая страница 1251 Windows ANSI",
        "200" => "Кодовая страница 1250 Windows EE",
        "0"   => "игнорируется"
    );

    $DBF = fopen($f, 'r');         // открыли файл для чтения
    $HeaderDBF = fread($DBF, 32);  // считали первые 32 байта заголовка
    fclose($DBF);                  // закрываем файл и работаем далее со считанным заголовком

    $opisanie .= '<table border=1 width=80%>'.$nn.
    '<tr><td width=20%>байт</td><td width=80%>описание</td></tr>'.$nn.
    '<tr><td colspan=2><b>Заголовок</b></td></tr>';

    $arRet['typeDBF'] = $arHeader0[ord(substr($HeaderDBF, 0, 1))]; // 0
    $opisanie .= '<tr><td>0</td><td>Тип таблицы: '.$arRet['typeDBF'].'</td></tr>'.$nn;

    $arRet['UpdateYY'] = ord(substr($HeaderDBF, 1, 1)); // 1
    $opisanie .= '<tr><td>1</td><td>Год последнего обновления таблицы (ГГ): '.$arRet['UpdateYY'].'</td></tr>';

    $arRet['UpdateMM'] = ord(substr($HeaderDBF, 2, 1)); // 2
    $opisanie .= '<tr><td>2</td><td>Месяц последнего обновления таблицы (ММ): '.$arRet['UpdateMM'].'</td></tr>';

    $arRet['UpdateDD'] = ord(substr($HeaderDBF, 3, 1)); // 3
    $opisanie .= '<tr><td>3</td><td>День последнего обновления таблицы (ДД): '.$arRet['UpdateDD'].'</td></tr>';

    $arRet['RecordsCount'] = ord(substr($HeaderDBF, 4, 1))*1  // 4-7(4)
                           + ord(substr($HeaderDBF, 5, 1))*256
                           + ord(substr($HeaderDBF, 6, 1))*65536
                           + ord(substr($HeaderDBF, 7, 1))*16777216;
    $opisanie .= '<tr><td>4-7(4)</td><td>Количество записей в таблице: '.$arRet['RecordsCount'].'</td></tr>';

    $arRet['HeaderSize'] = ord(substr($HeaderDBF, 8, 1))*1 // 8-9(2)
                         + ord(substr($HeaderDBF, 9, 1))*256;
    $opisanie .= '<tr><td>8-9(2)</td><td>Размер заголовка в байтах: '.$arRet['HeaderSize'].'</td></tr>';

    $arRet['RecordSize'] = ord(substr($HeaderDBF, 10, 1))*1 // 10-11(2)
                         + ord(substr($HeaderDBF, 11, 1))*256;
    $opisanie .= '<tr><td>10-11(2)</td><td>Размер записи в байтах: '.$arRet['RecordSize'].'</td></tr>';

    $arRet['rezerv1213'] = ord(substr($HeaderDBF, 12, 1)) // 12-13(2)
                         + ord(substr($HeaderDBF, 13, 1));
    $opisanie .= '<tr><td>12-13(2)</td><td>Зарезервировано ('.$arRet['rezerv1213'].')</td></tr>';

    $arRet['tranzStatus'] = ord(substr($HeaderDBF, 14, 1)); // 14
    $opisanie .= '<tr><td>14</td><td>Транзакция: '.$arHeader14[$arRet['tranzStatus']].'</td></tr>';

    $arRet['vidimost'] = ord(substr($HeaderDBF, 15, 1)); // 15
    $opisanie .= '<tr><td>15</td><td>Видимость: '.$arHeader15[$arRet['vidimost']].'</td></tr>';

    $arRet['multiUser'] = ord(substr($HeaderDBF, 16, 1)) // 16-27(12)
                        + ord(substr($HeaderDBF, 17, 1))
                        + ord(substr($HeaderDBF, 18, 1))
                        + ord(substr($HeaderDBF, 19, 1))
                        + ord(substr($HeaderDBF, 20, 1))
                        + ord(substr($HeaderDBF, 21, 1))
                        + ord(substr($HeaderDBF, 22, 1))
                        + ord(substr($HeaderDBF, 23, 1))
                        + ord(substr($HeaderDBF, 24, 1))
                        + ord(substr($HeaderDBF, 25, 1))
                        + ord(substr($HeaderDBF, 26, 1))
                        + ord(substr($HeaderDBF, 27, 1));
    $opisanie .= '<tr><td>16-27(12)</td><td>Использование многопользовательского окружения ('.$arRet['multiUser'].')</td></tr>';

    $arRet['AppIndex'] = ord(substr($HeaderDBF, 28, 1)); // 28
    $opisanie .= '<tr><td>28</td><td>Индексация: '.$arHeader28[$arRet['AppIndex']].'</td></tr>';

    $arRet['Encode'] = ord(substr($HeaderDBF, 29, 1)); // 29
    if(!array_key_exists($arRet['Encode'], $arHeader29)){
        $arHeader29[$arRet['Encode']] = 'Номер драйвера языка: '.$arRet['Encode'];
    }
    $opisanie .= '<tr><td>29</td><td>Кодировка: '.$arHeader29[$arRet['Encode']].'</td></tr>';

    $arRet['rezerv3031'] = ord(substr($HeaderDBF, 30, 1)) // 30-31(2)
                         + ord(substr($HeaderDBF, 31, 1));
    $opisanie .= '<td>30-31(2)</td><td>Зарезервировано ('.$arRet['rezerv3031'].')</td>'.$nn;
    // конец описания заголовка


    /*
    *
    *   О П И С А Н И Е    П О Л Е Й
    *
    */
    $arHeaderType = array( // типы полей
        "C" => "Char",      "D" => "Date",        "F" => "Float",
        "N" => "Numeric",   "L" => "Logical",     "M" => "Memo",
        "V" => "Variable",  "P" => "Picture",     "B" => "Binary",
        "G" => "General",   "2" => "short int",   "4" => "long int",
        "8" => "double"
    );
    // читаем весь заголовок
    $DBF = fopen($f, 'r');
    $HeaderDBF = fread($DBF, 32*$arRet['poleCount'] + 32 + 1); // 32 - описание таблицы, 1 - завершающий бит
    fclose($DBF);

    // перебираем все поля и сохраняем их описания
    for($i=1; $i<=$arRet['poleCount']; $i++){

        $arRet['pole'.$i] = array(); // отдельный подМассив для поля
        $pole = substr($HeaderDBF, $i*32, 32); // все байты описания поля
        $opisanie .= '<tr><td colspan=2><b>Поле №'.$i.'</b></td></tr>';

        $arRet['pole'.$i]['name'] = trim(substr($pole, 0, 11)); // 0-10(11)
//        echo $arRet['pole'.$i]['name'];
        $opisanie .= '<tr><td>0-10(11)</td><td>Имя поля с 0x00 завершением: <b>'.$arRet['pole'.$i]['name'].'</b></td></tr>';

        $arRet['pole'.$i]['type'] = substr($pole, 11, 1); // 11
        $opisanie .= '<tr><td>11</td><td>Тип поля: '.$arHeaderType[$arRet['pole'.$i]['type']].'</td></tr>';

        $arRet['pole'.$i]['adress'] = ord(substr($pole, 12, 1)).','. // 12-15(4)
                                      ord(substr($pole, 13, 1)).','.
                                      ord(substr($pole, 14, 1)).','.
                                      ord(substr($pole, 15, 1));
        $opisanie .= '<tr><td>12-15(4)</td><td>n,n,n,n (адрес) / 0,0,n,n (смещение) / 0,0,0,0 (игнор) : '.$arRet['pole'.$i]['adress'].'</td></tr>';

        $arRet['pole'.$i]['size'] = ord(substr($pole, 16, 1)); // 16
        $opisanie .= '<tr><td>16</td><td>Размер поля: '.$arRet['pole'.$i]['size'].'</td></tr>';

        $arRet['pole'.$i]['znakov'] = ord(substr($pole, 17, 1)); // 17
        $opisanie .= '<tr><td>17</td><td>Кол-во знаков после запятой: '.$arRet['pole'.$i]['znakov'].'</td></tr>';

        $arRet['pole'.$i]['rezerv1819'] = ord(substr($pole, 18, 1)).','. // 18-19(2)
                                          ord(substr($pole, 19, 1));
        $opisanie .= '<tr><td>18-19(2)</td><td>Зарезервировано: '.$arRet['pole'.$i]['rezerv1819'].'</td></tr>';

        $arRet['pole'.$i]['idWork'] = ord(substr($pole, 20, 1)); // 20
        $opisanie .= '<tr><td>20</td><td>Идентификатор рабочей области (0 - не используется): '.$arRet['pole'.$i]['idWork'].'</td></tr>';

        $arRet['pole'.$i]['dBase'] = ord(substr($pole, 21, 1)).', '. // 21-22(2)
                                     ord(substr($pole, 22, 1));
        $opisanie .= '<tr><td>21-22(2)</td><td>Многопользовательский dBase (0,0 - не используется): '.$arRet['pole'.$i]['dBase'].'</td></tr>';

        $arRet['pole'.$i]['checkPole'] = ord(substr($pole, 23, 1)); // 23
        $opisanie .= '<tr><td>23</td><td>1 - Установленные поля, 0 - не используется: '.$arRet['pole'.$i]['checkPole'].'</td></tr>';

        $arRet['pole'.$i]['rezerv2430'] = ord(substr($pole, 24, 1)). // 24-30(7)
                                          ord(substr($pole, 25, 1)).
                                          ord(substr($pole, 26, 1)).
                                          ord(substr($pole, 27, 1)).
                                          ord(substr($pole, 28, 1)).
                                          ord(substr($pole, 29, 1)).
                                          ord(substr($pole, 30, 1));
        $opisanie .= '<tr><td>24-30(7)</td><td>0..0 Зарезервировано: '.$arRet['pole'.$i]['rezerv2430'].'</td></tr>';

        $arRet['pole'.$i]['mdxIn'] = ord(substr($pole, 31, 1)); // 31
        $opisanie .= '<tr><td>31</td><td>1 - Поле включено в .mdx индекс, 0 - игнорируется): '.$arRet['pole'.$i]['mdxIn'].'</td></tr>'.$nn;
    }
    $opisanie .= '<tr><td colspan=2><b>Завершающий символ 0x0D (13): '.ord(substr($HeaderDBF, -1)).'</b></td></tr>';
    $opisanie .= '</table><br /><hr><br />'.$nn;
    // конец разбора полей


    /*
    *
    *   mySQL
    *                        создаём новую таблицу
    */
    $arRet['query'] = 'CREATE TABLE '.$arRet['tableName'].'('.$nn;
    for($i=1; $i<=$arRet['poleCount']; $i++){
        // краткие названия
        $pName = $arRet['pole'.$i]['name'];                // имя поля
    if($pName == "KEY") $pName="`KEY`";
    if($pName == "AS") $pName="`AS`"; 
//     echo $pName;
      
//    echo "  ";    
        $pType = $arHeaderType[$arRet['pole'.$i]['type']]; // тип
        $pSize = $arRet['pole'.$i]['size'];                // размер
        // исключения не совместимые с mySQL
        if($pType == 'Logical') $pType = 'Char';           // T=true / F=false
        // пара имя-тип
        $arRet['query'] .= ' '.$pName.' '.$pType;
        // в зависимости от типа поля надо указать его длину или другие параметры
        switch($pType){
            case 'Char':
            case 'Numeric':
                $arRet['query'] .= '('.$pSize.')';
                break;
        }
        // для непоследнего поля - запятая
        if($i<$arRet['poleCount']){
            $arRet['query'] .= ','.$nn;
        }else{
            $arRet['query'] .= $nn;
        }
    }
    $arRet['query'] .=') TYPE=MyISAM'; //С„РѕСЂРјР°С‚ С…СЂР°РЅРµРЅРёСЏ С‚Р°Р±Р»РёС† РІ РїР°РјСЏС‚Рё
//    echo $arRet['query'];
    $opisanie .= '<pre>'.$arRet['query'].'</pre>';
    // запрос на создание таблицы
    if(mysql_query($arRet['query'])){
        $arRet['newTable'] = 'Успешно создана';
        $opisanie .= 'Новая таблица успешно создана';
    }else{
        $arRet['itog'] = 'false';
        $arRet['error'] = 'создать новую траблицу не удалось из-за ошибки mySQL: '.mysql_error();
        return $arRet;
    }
    // конец создания новой таблицы
    /*
    *
    *   mySQL
    *                        переносим все записи из DBF в новую mySQL-таблицу
    */
    $DBF = fopen($f, 'r');
    fseek($DBF, $arRet['HeaderSize'], SEEK_SET);   // пропускаем заголовок DBF
    for($i=1; $i<=$arRet['RecordsCount']; $i++){   // перебираем записи
        $rec = fread($DBF, $arRet['RecordSize']);  // читаем очередную запись
    //   $rec = iconv("CP866", "UTF-8", $rec);
        
      if (substr($rec,0,1)!="*")
{    
        
        $query = 'INSERT INTO '.$arRet['tableName'].' VALUES('.$nn;
        // разбираем запись по полям
        $start = 1;                                // смещенеи внутри записи
        for($p=1; $p<=$arRet['poleCount']; $p++){  // перебираем поля
            $str = trim(substr($rec, $start, $arRet['pole'.$p]['size'])); // вырезаем текст поля
            //$str = convert_cyr_string($str, 'w', 'a');                    // меняем кодировку
       //     $str = iconv("CP866","UTF-8",$str);
    //        echo $str;
            $str = addslashes($str);                                      // экранируем спецСимволы
            $query .= '\''.$str.'\'';
            if($p<$arRet['poleCount']){            // для непоследнего поля ставим запятую в конце
                $query .= ','.$nn;
            }else{
                $query .= $nn;
            }
            $start += $arRet['pole'.$p]['size'];   // смещаемся к следующему полю в записи
        }
        $query .= ')';
        // делаем запрос
        if(!mysql_query($query)){
            $arRet['itog'] = 'false';
            $arRet['error'] = 'ошибка mySQL при внесении записи №'.$i.';<br />'.$nn.
                              '<font color="red">'.mysql_error().'</font>;<br />запрос: '.$query;
            return $arRet;
        }
      }
    }
    fclose($DBF);
    // конец переноса записей
    // забираем с собой описание работы и, если надо, печатаем его
   $arRet['opisanie'] = $opisanie;
//    if($debugMode) echo $opisanie;

    $arRet['timeEnd'] = getMicroTime(); // финиш функции

    return $arRet;  // ГЫ!
}
function german_date($oldat)
{ 
   if($oldat=="") $vdat="-";
   else { 
   $oldat1=explode('-',$oldat);
	if($oldat1[1]>0)
	{
		$mdt=mktime(0,0,0,$oldat1[1],$oldat1[2],$oldat1[0]);	  
		$vdat=date("d.m.Y",$mdt);
	}
	else 
	$vdat="-";
	}
   return $vdat;
}

function adresa($ns,$bd,$kr,$kv,$ka,$pnr,$sns,$ap)
{
	  if (trim($kr==""))
	  $nbud=trim($bd);
	  else
	  {
	    if (ctype_digit($kr))
	    $nbud=trim($bd)."/".trim($kr);
	    else
		{if (intval($kr)>0) $nbud=trim($bd)."/".trim($kr);
		 else $nbud=trim($bd).trim($kr);}
	   }

	  if (intval($kv)==0)
	  {$nkv="";}
	  else
	  {$nkv=" Єў. ".trim($kv).trim($ka);}
	  
	  if ($ns=="Љђ…Њ…" or $ns=="ѓ‹ЋЃ€" or $ns=="ЉЋ‡…‹" or $ns=="ЉЋЊ‘Ћ" or $ns=="ѓђЂ„€") 
	  {$adresa=trim($sns)." ".trim($ap)." Ўг¤. ".$nbud.$nkv; }
	  else
	  {$adresa=trim($pnr)." ".trim($sns)." ".trim($ap)." Ўг¤. ".$nbud.$nkv;}

	  return $adresa;  // ГЫ!
}
function info_zak($text,$text1)
{ $info="-";
  $atf=mysql_query("SELECT SD,NZ,VK FROM ZM WHERE SD=$text AND NZ=$text1
  AND ZM.VR!='„Џ' AND ZM.KF>0;");
  if ($atf)
  {
   $auf=mysql_fetch_array($atf);
	if ($auf['VK']=='')
{$wpr=0;
  $ath=mysql_query("SELECT ZM.SD,ZM.NZ,ZM.PR,ZM.IM,ZM.PB,ZM.DT,ZM.D1,ZM.D2,ZM.PRVK,
   ZM.TEL,ZM.NR,ZM.NS,ZM.VL,ZM.BD,ZM.KR,ZM.KV,ZM.KA,PRICE.VR,NRN.PNR,NSL.SNS,PGF.AP 
   FROM ZM,PRICE,NRN,NSL,PGF 
   WHERE ZM.VR=PRICE.KD AND ZM.NR=NRN.NR AND ZM.NR=NSL.CNR AND 
   ZM.NS=NSL.NS AND ZM.NR=PGF.NR AND ZM.NS=PGF.NS AND ZM.VL=PGF.VC AND
   SD=$text AND NZ=$text1 AND ZM.VR!='„Џ' AND ZM.KF>0 ORDER BY SD,NZ;");}
	else
	{$wpr=1;
	$ath=mysql_query("SELECT ZM.SD,ZM.NZ,ZM.PR,ZM.IM,ZM.PB,ZM.DT,ZM.D1,ZM.D2,ZM.PRVK,
   ZM.TEL,ZM.NR,ZM.NS,ZM.VL,ZM.BD,ZM.KR,ZM.KV,ZM.KA,BR.FIO,PRICE.VR,NRN.PNR,NSL.SNS,PGF.AP 
   FROM ZM,BR,PRICE,NRN,NSL,PGF 
   WHERE ZM.VK=BR.KOD AND ZM.VR=PRICE.KD AND ZM.NR=NRN.NR AND ZM.NR=NSL.CNR AND 
   ZM.NS=NSL.NS AND ZM.NR=PGF.NR AND ZM.NS=PGF.NS AND ZM.VL=PGF.VC AND
   SD=$text AND NZ=$text1 AND ZM.VR!='„Џ' AND ZM.KF>0 ORDER BY SD,NZ;");}
   if($ath)
    { 
     while($aut=mysql_fetch_array($ath))
      {
	  if ($aut['PR']=='  ') echo "NZ=".$aut['NZ'];
      $pib=trim($aut['PR'])." ".trim($aut['IM'])." ".trim($aut['PB']);
      $zmprvk=$aut['PRVK']; 
	  if($wpr==1) $vkrosp=$aut['FIO']; 
	  else $vkrosp="-";
	  $adres=adresa($aut['NS'],$aut['BD'],$aut['KR'],$aut['KV'],$aut['KA'],
	  $aut['PNR'],$aut['SNS'],$aut['AP']);
      if($vkrosp=="") $vkrosp="-";
      if($aut['TEL']=="") $aut['TEL']="-";	 
	 $ath1=mysql_query("SELECT FIO FROM BR WHERE KOD='$zmprvk';");
	  $aut1=mysql_fetch_array($ath1);
	  $pib_prvk=trim($aut1['FIO']);
	  mysql_free_result($ath1);
	  $m_nr=$aut['NR'];
	  $m_ns=$aut['NS'];
	  $m_kr=$aut['KR'];
	  switch (strlen($m_kr)) 
	  {
	  case 0:
	    $m_kr="   ";
            break;
	  case 1:
    	    $m_kr="  ".$m_kr;
	    break;
          case 2:
	    $m_kr=" ".$m_kr;
	    break;
          }
	  $m_vl=$aut['VL'];
	  $m_bd=intval($aut['BD']);
	  $m_kv=intval($aut['KV']);
	  $m_ka=$aut['KA'];
if($aut['VR']!="¤®Ї« в "){ 
$sql1 = "SELECT SD,NZ,ADRES,VK,VZ,DN,DF,VRU,BR.FIO FROM V_ZAK,BR 
WHERE V_ZAK.VK=BR.KOD AND V_ZAK.SD=$text AND V_ZAK.NZ=$text1 AND 
 left(V_ZAK.ADRES,2)='$m_nr' and SUBSTRING(V_ZAK.ADRES,3,5)='$m_ns'
 and SUBSTRING(V_ZAK.ADRES,8,5)='$m_vl'
 and SUBSTRING(V_ZAK.ADRES,13,3)=$m_bd
 and SUBSTRING(V_ZAK.ADRES,16,3)='$m_kr'
 and SUBSTRING(V_ZAK.ADRES,19,3)=$m_kv
 and SUBSTRING(V_ZAK.ADRES,22,1)='$m_ka'
 ORDER BY SD,NZ"; 
$sql2 = "SELECT SD,NZ,ADRES,VK,VZ,DN,DF,VRU,BR.FIO FROM V_ZAKT,BR 
WHERE V_ZAKT.VK=BR.KOD AND V_ZAKT.SD=$text AND V_ZAKT.NZ=$text1 AND 
 left(V_ZAKT.ADRES,2)='$m_nr' and SUBSTRING(V_ZAKT.ADRES,3,5)='$m_ns'
 and SUBSTRING(V_ZAKT.ADRES,8,5)='$m_vl'
 and SUBSTRING(V_ZAKT.ADRES,13,3)=$m_bd
 and SUBSTRING(V_ZAKT.ADRES,16,3)='$m_kr'
 and SUBSTRING(V_ZAKT.ADRES,19,3)=$m_kv
 and SUBSTRING(V_ZAKT.ADRES,22,1)='$m_ka'
 ORDER BY SD,NZ"; 

$rst = mysql_query($sql1);
$temp=0; 
$i=0;
if(mysql_num_rows($rst)>0){
$temp=1;
while($row = mysql_fetch_row($rst)){
$result[$i]=$row;
$i=$i+1;}}
mysql_free_result($rst); 
$rst1 = mysql_query($sql2); 
if(mysql_num_rows($rst1)>0){
$temp=1;
while($row1 = mysql_fetch_row($rst1)){ 
$result[$i]=$row1;
$i=$i+1;}}
mysql_free_result($rst1); 
}
$vk_isp=".";
$m_ciklv=0;
$m_d3="-";
if($temp==1){
foreach($result as $key =>$type){
	$i=1; 
  foreach($type as $resu){
	if ($i==5) $m_vz=$resu;
	if ($i==6) $m_dn=$resu;
	if ($i==7) $m_df=$resu;
	if ($i==8) $m_vru=$resu;
	if ($i==9) $m_vkfio=$resu;
	$i=$i+1;
	}
	if ($m_vz=="ћ") $m_d3=$m_dn;
	else $m_d3=$m_df;
	$m_cikl=0;
	$vk_isp=".";
	switch ($m_vru) 
	{
	case "11":
	    $vk_isp=$m_vkfio;
		$m_cikl=1;
        break;
	case "12":
	    $vk_isp=$m_vkfio;
		$m_cikl=1;
        break;
	case "71":
	    $vk_isp=$m_vkfio;
		$m_cikl=1;
        break;
	case "72":
	    $vk_isp=$m_vkfio;
		$m_cikl=1;
        break;
    }
	if ($m_cikl==1) { $m_ciklv=1; break; }
	}
if ($m_ciklv==0)
{
foreach($result as $key =>$type){
	$i=1; 
  foreach($type as $resu){
	if ($i==5) $m_vz=$resu;
	if ($i==6) $m_dn=$resu;
	if ($i==7) $m_df=$resu;
	if ($i==8) $m_vru=$resu;
	if ($i==9) $m_vkfio=$resu;
	$i=$i+1;
	}
	if ($m_vz=="ћ") $m_d3=$m_dn;
	else $m_d3=$m_df;
	$m_cikl=0;
	$vk_isp=".";
	switch ($m_vru) 
	{
	case "21":
	    $vk_isp=$m_vkfio;
		$m_cikl=1;
        break;
	case "22":
	    $vk_isp=$m_vkfio;
		$m_cikl=1;
        break;
	case "73":
	    $vk_isp=$m_vkfio;
		$m_cikl=1;
        break;
    }
	if ($m_cikl==1) { $m_ciklv=1; break; }
}
}
if ($m_ciklv==0)
{
foreach($result as $key =>$type){
	$i=1; 
  foreach($type as $resu){
	if ($i==5) $m_vz=$resu;
	if ($i==6) $m_dn=$resu;
	if ($i==7) $m_df=$resu;
	if ($i==8) $m_vru=$resu;
	if ($i==9) $m_vkfio=$resu;
	$i=$i+1;
	}
	if ($m_vz=="ћ") $m_d3=$m_dn;
	else $m_d3=$m_df;
	$m_cikl=0;
	$vk_isp=".";
	switch ($m_vru) 
	{
	case "51":
	    $vk_isp=$m_vkfio;
		$m_cikl=1;
        break;
	}
	if ($m_cikl==1) break; 
}}
}
$info=array("NZP"=>$aut['SD']."/".$aut['NZ'],"ADRES"=>$adres,
   "VR"=>$aut['VR'],"PIB"=>$pib,"DT"=>$aut['DT'],"D1"=>$aut['D1'],
   "D2"=>$aut['D2'],"D3"=>$m_d3,"VKROSP"=>$vkrosp,"VKISP"=>$vk_isp,
   "PIBPRVK"=>$pib_prvk,"TEL"=>$aut['TEL']);
	}
     }
     else
      {
       echo "<p><b>Error: ".mysql_error()."</b></p>";
       exit();
       }
      mysql_free_result($ath);  
	  mysql_free_result($atf);  
	  }
return $info;
}


function info_zaku($text,$text1)
{ $info="-";
   $ath=mysql_query("SELECT N_ZAK.SD,N_ZAK.NZ,N_ZAK.DT,N_ZAK.DATAD,N_ZAK.DVIK,
   BS07.TELEF,BS07.NAIMP,N_ZAK.NR,N_ZAK.NS,N_ZAK.VL,N_ZAK.BD,N_ZAK.KR,N_ZAK.KV,
   N_ZAK.KA,BR.FIO,PRICE2.VR,NRN.PNR,NSL.SNS,PGF.AP,N_ZAK.PEE,N_ZAK.NBR 
   FROM N_ZAK,BR,PRICE2,NRN,NSL,PGF,BS07 
   WHERE N_ZAK.PEE=BR.KOD AND N_ZAK.VR=PRICE2.KD AND N_ZAK.NR=NRN.NR AND 
   N_ZAK.NR=NSL.CNR AND N_ZAK.NS=NSL.NS AND N_ZAK.NR=PGF.NR AND N_ZAK.NS=PGF.NS AND 
   N_ZAK.VL=PGF.VC AND N_ZAK.KODP=BS07.KODP AND 
   SD=$text AND NZ=$text1 AND N_ZAK.DI='   ' ORDER BY SD,NZ;");
   if($ath)
    { 
     while($aut=mysql_fetch_array($ath))
      {
      $pib=trim($aut['NAIMP']);
      $zmprvk="Ѓоа®"; 
	  $vkrosp=$aut['FIO']; 
	  if ($vkrosp=="   ") $vkrosp=$aut['NBR'];
	  $adres=adresa($aut['NS'],$aut['BD'],$aut['KR'],$aut['KV'],$aut['KA'],
	  $aut['PNR'],$aut['SNS'],$aut['AP']);
      if($aut['TELEF']=="") $aut['TELEF']="-";	 
	  $m_nr=$aut['NR'];
	  $m_ns=$aut['NS'];
	  $m_kr=$aut['KR'];
	  switch (strlen($m_kr)) 
	  {
	  case 0:
	    $m_kr="   ";
		break;
	  case 1:
    	$m_kr=$m_kr."  ";
	    break;
      case 2:
		$m_kr=$m_kr." ";
	    break;
          }
	  $m_vl=$aut['VL'];
	  $m_bd=intval($aut['BD']);
	  $m_kv=intval($aut['KV']);
	  $m_ka=$aut['KA'];

$sql1 = "SELECT SD,NZ,ADRES,VK,VZ,DN,DF,VRU,BR.FIO FROM V_ZAK,BR 
WHERE V_ZAK.VK=BR.KOD AND V_ZAK.SD=$text AND V_ZAK.NZ=$text1 AND 
 left(V_ZAK.ADRES,2)='$m_nr' and SUBSTRING(V_ZAK.ADRES,3,5)='$m_ns'
 and SUBSTRING(V_ZAK.ADRES,8,5)='$m_vl'
 and SUBSTRING(V_ZAK.ADRES,13,3)=$m_bd
 and SUBSTRING(V_ZAK.ADRES,16,3)='$m_kr'
 and SUBSTRING(V_ZAK.ADRES,19,3)=$m_kv
 and SUBSTRING(V_ZAK.ADRES,22,1)='$m_ka'
 ORDER BY SD,NZ"; 

$rst = mysql_query($sql1);
$temp=0; 
$i=0;
if(mysql_num_rows($rst)>0){
$temp=1;
while($row = mysql_fetch_row($rst)){
$result[$i]=$row;
$i=$i+1;}}
mysql_free_result($rst); 

$vk_isp=".";
$m_ciklv=0;
$m_d3="-";
if($temp==1){
foreach($result as $key =>$type){
	$i=1; 
  foreach($type as $resu){
	if ($i==5) $m_vz=$resu;
	if ($i==6) $m_dn=$resu;
	if ($i==7) $m_df=$resu;
	if ($i==8) $m_vru=$resu;
	if ($i==9) $m_vkfio=$resu;
	$i=$i+1;
	}
	if ($m_vz=="ћ") $m_d3=$m_dn;
	else $m_d3=$m_df;
	$m_cikl=0;
	$vk_isp=".";
	switch ($m_vru) 
	{
	case "11":
	    $vk_isp=$m_vkfio;
		$m_cikl=1;
        break;
	case "12":
	    $vk_isp=$m_vkfio;
		$m_cikl=1;
        break;
	case "71":
	    $vk_isp=$m_vkfio;
		$m_cikl=1;
        break;
	case "72":
	    $vk_isp=$m_vkfio;
		$m_cikl=1;
        break;
    }
	if ($m_cikl==1) { $m_ciklv=1; break; }
	}
if ($m_ciklv==0)
{
foreach($result as $key =>$type){
	$i=1; 
  foreach($type as $resu){
	if ($i==5) $m_vz=$resu;
	if ($i==6) $m_dn=$resu;
	if ($i==7) $m_df=$resu;
	if ($i==8) $m_vru=$resu;
	if ($i==9) $m_vkfio=$resu;
	$i=$i+1;
	}
	if ($m_vz=="ћ") $m_d3=$m_dn;
	else $m_d3=$m_df;
	$m_cikl=0;
	$vk_isp=".";
	switch ($m_vru) 
	{
	case "21":
	    $vk_isp=$m_vkfio;
		$m_cikl=1;
        break;
	case "22":
	    $vk_isp=$m_vkfio;
		$m_cikl=1;
        break;
	case "73":
	    $vk_isp=$m_vkfio;
		$m_cikl=1;
        break;
    }
	if ($m_cikl==1) { $m_ciklv=1; break; }
}
}
if ($m_ciklv==0)
{
foreach($result as $key =>$type){
	$i=1; 
  foreach($type as $resu){
	if ($i==5) $m_vz=$resu;
	if ($i==6) $m_dn=$resu;
	if ($i==7) $m_df=$resu;
	if ($i==8) $m_vru=$resu;
	if ($i==9) $m_vkfio=$resu;
	$i=$i+1;
	}
	if ($m_vz=="ћ") $m_d3=$m_dn;
	else $m_d3=$m_df;
	$m_cikl=0;
	$vk_isp=".";
	switch ($m_vru) 
	{
	case "51":
	    $vk_isp=$m_vkfio;
		$m_cikl=1;
        break;
	}
	if ($m_cikl==1) break; 
}}
}
$info=array("NZP"=>$aut['SD']."/".$aut['NZ'],"ADRES"=>$adres,
   "VR"=>$aut['VR'],"PIB"=>$pib,"DT"=>$aut['DT'],"D1"=>$aut['DATAD'],
   "D2"=>$aut['DVIK'],"D3"=>$m_d3,"VKROSP"=>$vkrosp,"VKISP"=>$vk_isp,
   "PIBPRVK"=>$zmprvk,"TEL"=>$aut['TELEF']);
	}
     }
     else
      {
       echo "<p><b>Error: ".mysql_error()."</b></p>";
       exit();
       }
      mysql_free_result($ath);  
return $info;
}
function upstr($text)
{
$text=trim($text);
$mk=strlen($text);
$txt="";
for ($i = 0; $i <=$mk-1; $i++) {
 $bukva=substr($text,$i,1);
switch ($bukva)
{
case " ":
        $txt=$txt."Ђ";
        break;
case "Ў":
        $txt=$txt."Ѓ";
        break;
case "ў":
        $txt=$txt."‚";
        break;
case "Ј":
        $txt=$txt."ѓ";
        break;
case "¤":
        $txt=$txt."„";
        break;
case "Ґ":
        $txt=$txt."…";
        break;
case "у":
        $txt=$txt."т";
        break;
case "¦":
        $txt=$txt."Ђ";
        break;
case "§":
        $txt=$txt."‡";
        break;
case "i":
        $txt=$txt."I";
        break;
case "Є":
        $txt=$txt."Љ";
        break;
case "©":
        $txt=$txt."‰";
        break;
case "х":
        $txt=$txt."ф";
        break;
case "«":
        $txt=$txt."‹";
        break;
case "¬":
        $txt=$txt."Њ";
        break;
case "­":
        $txt=$txt."Ќ";
		break;
case "®":
        $txt=$txt."Ћ";
		break;
case "Ї":
        $txt=$txt."Џ";
		break;
case "а":
        $txt=$txt."ђ";
		break;
case "б":
        $txt=$txt."‘";
		break;
case "в":
        $txt=$txt."’";
		break;
case "г":
        $txt=$txt."“";
		break;
case "д":
        $txt=$txt."”";
		break;
case "е":
        $txt=$txt."•";
		break;
case "з":
        $txt=$txt."—";
		break;
case "ж":
        $txt=$txt."–";
		break;
case "Ё":
        $txt=$txt."€";
		break;
case "м":
        $txt=$txt."њ";
		break;
case "о":
        $txt=$txt."ћ";
		break;
case "п":
        $txt=$txt."џ";
		break;
case "и":
        $txt=$txt."";
		break;
case "й":
        $txt=$txt."™";
		break;
default:
        $txt=$txt.$bukva;
        break;
 } 
}

return $txt;
}
function buk_i($strok)
{$b_i="";
 $rest="";
$len=strlen($strok);
for ($i=0;$i<=$len-1;$i++)
	{
	$b_i=substr($strok,$i,1);
	if($b_i=='?'){
       $b_i='i';} 
	$rest.=$b_i;
		}
return $rest;
}

function clocd ($txt) {
$IMG_DIR_URL = "/images/digits/";
$html_result="";

	$digits = preg_split("//", $txt);

	while (list($key, $val) = each($digits)) {
		if ($val != "")  {
				if ($val == "-") $val = "dash";
				if ($val == ":") $val = "colon";
			$html_result.="<IMG SRC=\"$IMG_DIR_URL$val.gif\">";
		}
	}
	return $html_result;
}
?>
