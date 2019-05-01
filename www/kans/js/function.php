<?
/*
    ������� ������ ��� ������ �� DBF'�� � mySQL
    �����: ���� ������� ����������
    ����:  ������, 2006 ���
    ����:  lexx918@mail.ru
    ���:   203820969
*/

// ����� � ��������� �� �����������
function getMicroTime(){
    list($usec, $sec) = explode(" ", microtime());
    return ((float)$usec + (float)$sec);
}

// ������� ������� ������� �� *.DBF � mySQL
// ���������:  f     - ������ ��� �����, ������� ���� �������������
// ����������: arRet - �����. ������ � ������ �� �������
// ��� ������ ��������� ����� ��� �������� ���������� � �� mySQL
function DBF2mySQL($f){

    // ������������� � ���������
    $arRet = array();    // �������� ������
    $arRet['timeStart'] = getMicroTime(); // ����� �������
    $opisanie = '';       // ������� �� ������� ����������� � ������ ������
    $debugMode = 1;       // ����� ������� ��� ����������� ������� ��������
    $nn = "\r\n";         // ����� ������
    ini_set('mysql.connect_timeout', 3600); // ������� ���������� � �� (���.)
    ini_set('max_execution_time', 3600);    // ������� php-�������

    // ��������� ������� ���������� ����� ���� ������
    if(!file_exists($f)){
        $arRet['itog'] = 'false';
        $arRet['error'] = '��� ������ �����';
        echo "q1";
        return $arRet;
    }


    /*
    *
    *   mySQL
    *                        ������� ������ �������
    */
    // ��������� ��� ��� ������� (�������� E:/MAKC2005/BASES/NSI/REFER.DBF -> REFER)
    if(!preg_match_all('/(\/\w{1,10}\/(\w+)\.DBF)$/si', $f, $temp, PREG_SET_ORDER)){
        $arRet['itog'] = 'false';
        $arRet['error'] = '� ����� ����� �� ������� ����� ��� ��� �������';
	return $arRet;
    }else{
        $arRet['tableName'] = $temp[0][2];
        //echo '<pre>'; print_r($temp); exit();
        UnSet($temp);
    }
//    $arRet['tableName']="BR";
    // ������� ������� � ����� ������ ���� ��� ��� ����
    if(mysql_query("DROP TABLE IF EXISTS ".$arRet['tableName'])){
        $arRet['oldTable'] = '���� ������� ���� - � ������� ����� �������';
    }else{
        $arRet['itog'] = 'false';
        $arRet['error'] = '�� ����� ������� ������� ������� ����� ������� ��������� ������ mySQL: '.mysql_error();
echo "q2";        
        return $arRet;
    }
    // ����� �������� ������ �������


    // ������ �����
    clearstatcache();
    $arRet['fileSize'] = filesize($f);
    $opisanie .= 'File: <b>'.$f.'</b><br />';
    $opisanie .= '������ DBF\'�� = '.$arRet['fileSize'].' ����<br />';

    // ���������� ����� �����
    $DBF = fopen($f, 'r');                               // ������� ���� ��� ��� ������
    $i = 0;                                              // ������� ������
    while(!feof($DBF)){                                  // ������ ��������
        $b = fread($DBF, 1);                             // ���� ��� - ������
        if(($i>31) && ($i%32 == 0) && (ord($b) == 13)){  // ���� ��������� ������ � ����� 13
            $arRet['poleCount'] = $i/32-1;               // .. ������ ��������� ��������
            $opisanie .= '���� � ����� '.$i.'. ����� �����: '.$arRet['poleCount'].'<br />';
            break;
        }
        $i++;
    }
    fclose($DBF);


    /*
    *
    *   � � � � � � � � �
    *
    */
    $arHeader0 = array( // ������ �������� ����� ������� ��������� (���� 0)
        "3"   => "������� �������",
        "4"   => "������� �������",
        "5"   => "������� �������",
        "67"  => "� ����-����� .dbv",
        "179" => "� ����-������ .dbv .dbt",
        "131" => "� ����-����� .dbt",
        "139" => "� ����-����� .dbt ������ D4",
        "142" => "SQL-�������",
        "245" => "� ���� ����� .fmp"
    );

    $arHeader14 = array( // ���������� (���� 14)
        "1" => "������ ����������",   "0" => "����� ���������� / ������������"
    );

    $arHeader15 = array( // ���������-��������� (���� 15)
        "1" => "������������",        "0" => "���������� ���������"
    );

    $arHeader28 = array( // ������������� ������� (���� 28)
        "1" => "������������ ������", "0" => "������ �� ������������"
    );

    $arHeader29 = array( // ������� �������� / ������� (���� 29)
        "1"   => "������� �������� 437 DOS USA",
        "2"   => "������� �������� 850 DOS Multilang",
        "38"  => "������� �������� 866 DOS Russian",
        "87"  => "������� �������� 1251 Windows ANSI",
        "200" => "������� �������� 1250 Windows EE",
        "0"   => "������������"
    );

    $DBF = fopen($f, 'r');         // ������� ���� ��� ������
    $HeaderDBF = fread($DBF, 32);  // ������� ������ 32 ����� ���������
    fclose($DBF);                  // ��������� ���� � �������� ����� �� ��������� ����������

    $opisanie .= '<table border=1 width=80%>'.$nn.
    '<tr><td width=20%>����</td><td width=80%>��������</td></tr>'.$nn.
    '<tr><td colspan=2><b>���������</b></td></tr>';

    $arRet['typeDBF'] = $arHeader0[ord(substr($HeaderDBF, 0, 1))]; // 0
    $opisanie .= '<tr><td>0</td><td>��� �������: '.$arRet['typeDBF'].'</td></tr>'.$nn;

    $arRet['UpdateYY'] = ord(substr($HeaderDBF, 1, 1)); // 1
    $opisanie .= '<tr><td>1</td><td>��� ���������� ���������� ������� (��): '.$arRet['UpdateYY'].'</td></tr>';

    $arRet['UpdateMM'] = ord(substr($HeaderDBF, 2, 1)); // 2
    $opisanie .= '<tr><td>2</td><td>����� ���������� ���������� ������� (��): '.$arRet['UpdateMM'].'</td></tr>';

    $arRet['UpdateDD'] = ord(substr($HeaderDBF, 3, 1)); // 3
    $opisanie .= '<tr><td>3</td><td>���� ���������� ���������� ������� (��): '.$arRet['UpdateDD'].'</td></tr>';

    $arRet['RecordsCount'] = ord(substr($HeaderDBF, 4, 1))*1  // 4-7(4)
                           + ord(substr($HeaderDBF, 5, 1))*256
                           + ord(substr($HeaderDBF, 6, 1))*65536
                           + ord(substr($HeaderDBF, 7, 1))*16777216;
    $opisanie .= '<tr><td>4-7(4)</td><td>���������� ������� � �������: '.$arRet['RecordsCount'].'</td></tr>';

    $arRet['HeaderSize'] = ord(substr($HeaderDBF, 8, 1))*1 // 8-9(2)
                         + ord(substr($HeaderDBF, 9, 1))*256;
    $opisanie .= '<tr><td>8-9(2)</td><td>������ ��������� � ������: '.$arRet['HeaderSize'].'</td></tr>';

    $arRet['RecordSize'] = ord(substr($HeaderDBF, 10, 1))*1 // 10-11(2)
                         + ord(substr($HeaderDBF, 11, 1))*256;
    $opisanie .= '<tr><td>10-11(2)</td><td>������ ������ � ������: '.$arRet['RecordSize'].'</td></tr>';

    $arRet['rezerv1213'] = ord(substr($HeaderDBF, 12, 1)) // 12-13(2)
                         + ord(substr($HeaderDBF, 13, 1));
    $opisanie .= '<tr><td>12-13(2)</td><td>��������������� ('.$arRet['rezerv1213'].')</td></tr>';

    $arRet['tranzStatus'] = ord(substr($HeaderDBF, 14, 1)); // 14
    $opisanie .= '<tr><td>14</td><td>����������: '.$arHeader14[$arRet['tranzStatus']].'</td></tr>';

    $arRet['vidimost'] = ord(substr($HeaderDBF, 15, 1)); // 15
    $opisanie .= '<tr><td>15</td><td>���������: '.$arHeader15[$arRet['vidimost']].'</td></tr>';

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
    $opisanie .= '<tr><td>16-27(12)</td><td>������������� ���������������������� ��������� ('.$arRet['multiUser'].')</td></tr>';

    $arRet['AppIndex'] = ord(substr($HeaderDBF, 28, 1)); // 28
    $opisanie .= '<tr><td>28</td><td>����������: '.$arHeader28[$arRet['AppIndex']].'</td></tr>';

    $arRet['Encode'] = ord(substr($HeaderDBF, 29, 1)); // 29
    if(!array_key_exists($arRet['Encode'], $arHeader29)){
        $arHeader29[$arRet['Encode']] = '����� �������� �����: '.$arRet['Encode'];
    }
    $opisanie .= '<tr><td>29</td><td>���������: '.$arHeader29[$arRet['Encode']].'</td></tr>';

    $arRet['rezerv3031'] = ord(substr($HeaderDBF, 30, 1)) // 30-31(2)
                         + ord(substr($HeaderDBF, 31, 1));
    $opisanie .= '<td>30-31(2)</td><td>��������������� ('.$arRet['rezerv3031'].')</td>'.$nn;
    // ����� �������� ���������


    /*
    *
    *   � � � � � � � �    � � � � �
    *
    */
    $arHeaderType = array( // ���� �����
        "C" => "Char",      "D" => "Date",        "F" => "Float",
        "N" => "Numeric",   "L" => "Logical",     "M" => "Memo",
        "V" => "Variable",  "P" => "Picture",     "B" => "Binary",
        "G" => "General",   "2" => "short int",   "4" => "long int",
        "8" => "double"
    );
    // ������ ���� ���������
    $DBF = fopen($f, 'r');
    $HeaderDBF = fread($DBF, 32*$arRet['poleCount'] + 32 + 1); // 32 - �������� �������, 1 - ����������� ���
    fclose($DBF);

    // ���������� ��� ���� � ��������� �� ��������
    for($i=1; $i<=$arRet['poleCount']; $i++){

        $arRet['pole'.$i] = array(); // ��������� ��������� ��� ����
        $pole = substr($HeaderDBF, $i*32, 32); // ��� ����� �������� ����
        $opisanie .= '<tr><td colspan=2><b>���� �'.$i.'</b></td></tr>';

        $arRet['pole'.$i]['name'] = trim(substr($pole, 0, 11)); // 0-10(11)
//        echo $arRet['pole'.$i]['name'];
        $opisanie .= '<tr><td>0-10(11)</td><td>��� ���� � 0x00 �����������: <b>'.$arRet['pole'.$i]['name'].'</b></td></tr>';

        $arRet['pole'.$i]['type'] = substr($pole, 11, 1); // 11
        $opisanie .= '<tr><td>11</td><td>��� ����: '.$arHeaderType[$arRet['pole'.$i]['type']].'</td></tr>';

        $arRet['pole'.$i]['adress'] = ord(substr($pole, 12, 1)).','. // 12-15(4)
                                      ord(substr($pole, 13, 1)).','.
                                      ord(substr($pole, 14, 1)).','.
                                      ord(substr($pole, 15, 1));
        $opisanie .= '<tr><td>12-15(4)</td><td>n,n,n,n (�����) / 0,0,n,n (��������) / 0,0,0,0 (�����) : '.$arRet['pole'.$i]['adress'].'</td></tr>';

        $arRet['pole'.$i]['size'] = ord(substr($pole, 16, 1)); // 16
        $opisanie .= '<tr><td>16</td><td>������ ����: '.$arRet['pole'.$i]['size'].'</td></tr>';

        $arRet['pole'.$i]['znakov'] = ord(substr($pole, 17, 1)); // 17
        $opisanie .= '<tr><td>17</td><td>���-�� ������ ����� �������: '.$arRet['pole'.$i]['znakov'].'</td></tr>';

        $arRet['pole'.$i]['rezerv1819'] = ord(substr($pole, 18, 1)).','. // 18-19(2)
                                          ord(substr($pole, 19, 1));
        $opisanie .= '<tr><td>18-19(2)</td><td>���������������: '.$arRet['pole'.$i]['rezerv1819'].'</td></tr>';

        $arRet['pole'.$i]['idWork'] = ord(substr($pole, 20, 1)); // 20
        $opisanie .= '<tr><td>20</td><td>������������� ������� ������� (0 - �� ������������): '.$arRet['pole'.$i]['idWork'].'</td></tr>';

        $arRet['pole'.$i]['dBase'] = ord(substr($pole, 21, 1)).', '. // 21-22(2)
                                     ord(substr($pole, 22, 1));
        $opisanie .= '<tr><td>21-22(2)</td><td>��������������������� dBase (0,0 - �� ������������): '.$arRet['pole'.$i]['dBase'].'</td></tr>';

        $arRet['pole'.$i]['checkPole'] = ord(substr($pole, 23, 1)); // 23
        $opisanie .= '<tr><td>23</td><td>1 - ������������� ����, 0 - �� ������������: '.$arRet['pole'.$i]['checkPole'].'</td></tr>';

        $arRet['pole'.$i]['rezerv2430'] = ord(substr($pole, 24, 1)). // 24-30(7)
                                          ord(substr($pole, 25, 1)).
                                          ord(substr($pole, 26, 1)).
                                          ord(substr($pole, 27, 1)).
                                          ord(substr($pole, 28, 1)).
                                          ord(substr($pole, 29, 1)).
                                          ord(substr($pole, 30, 1));
        $opisanie .= '<tr><td>24-30(7)</td><td>0..0 ���������������: '.$arRet['pole'.$i]['rezerv2430'].'</td></tr>';

        $arRet['pole'.$i]['mdxIn'] = ord(substr($pole, 31, 1)); // 31
        $opisanie .= '<tr><td>31</td><td>1 - ���� �������� � .mdx ������, 0 - ������������): '.$arRet['pole'.$i]['mdxIn'].'</td></tr>'.$nn;
    }
    $opisanie .= '<tr><td colspan=2><b>����������� ������ 0x0D (13): '.ord(substr($HeaderDBF, -1)).'</b></td></tr>';
    $opisanie .= '</table><br /><hr><br />'.$nn;
    // ����� ������� �����


    /*
    *
    *   mySQL
    *                        ������ ����� �������
    */
    $arRet['query'] = 'CREATE TABLE '.$arRet['tableName'].'('.$nn;
    for($i=1; $i<=$arRet['poleCount']; $i++){
        // ������� ��������
        $pName = $arRet['pole'.$i]['name'];                // ��� ����
    if($pName == "KEY") $pName="`KEY`";
    if($pName == "AS") $pName="`AS`"; 
//     echo $pName;
      
//    echo "  ";    
        $pType = $arHeaderType[$arRet['pole'.$i]['type']]; // ���
        $pSize = $arRet['pole'.$i]['size'];                // ������
        // ���������� �� ����������� � mySQL
        if($pType == 'Logical') $pType = 'Char';           // T=true / F=false
        // ���� ���-���
        $arRet['query'] .= ' '.$pName.' '.$pType;
        // � ����������� �� ���� ���� ���� ������� ��� ����� ��� ������ ���������
        switch($pType){
            case 'Char':
            case 'Numeric':
                $arRet['query'] .= '('.$pSize.')';
                break;
        }
        // ��� ������������ ���� - �������
        if($i<$arRet['poleCount']){
            $arRet['query'] .= ','.$nn;
        }else{
            $arRet['query'] .= $nn;
        }
    }
    $arRet['query'] .=') TYPE=MyISAM'; //формат хранения таблиц в памяти
//    echo $arRet['query'];
    $opisanie .= '<pre>'.$arRet['query'].'</pre>';
    // ������ �� �������� �������
    if(mysql_query($arRet['query'])){
        $arRet['newTable'] = '������� �������';
        $opisanie .= '����� ������� ������� �������';
    }else{
        $arRet['itog'] = 'false';
        $arRet['error'] = '������� ����� �������� �� ������� ��-�� ������ mySQL: '.mysql_error();
        return $arRet;
    }
    // ����� �������� ����� �������
    /*
    *
    *   mySQL
    *                        ��������� ��� ������ �� DBF � ����� mySQL-�������
    */
    $DBF = fopen($f, 'r');
    fseek($DBF, $arRet['HeaderSize'], SEEK_SET);   // ���������� ��������� DBF
    for($i=1; $i<=$arRet['RecordsCount']; $i++){   // ���������� ������
        $rec = fread($DBF, $arRet['RecordSize']);  // ������ ��������� ������
    //   $rec = iconv("CP866", "UTF-8", $rec);
        
      if (substr($rec,0,1)!="*")
{    
        
        $query = 'INSERT INTO '.$arRet['tableName'].' VALUES('.$nn;
        // ��������� ������ �� �����
        $start = 1;                                // �������� ������ ������
        for($p=1; $p<=$arRet['poleCount']; $p++){  // ���������� ����
            $str = trim(substr($rec, $start, $arRet['pole'.$p]['size'])); // �������� ����� ����
            //$str = convert_cyr_string($str, 'w', 'a');                    // ������ ���������
       //     $str = iconv("CP866","UTF-8",$str);
    //        echo $str;
            $str = addslashes($str);                                      // ���������� �����������
            $query .= '\''.$str.'\'';
            if($p<$arRet['poleCount']){            // ��� ������������ ���� ������ ������� � �����
                $query .= ','.$nn;
            }else{
                $query .= $nn;
            }
            $start += $arRet['pole'.$p]['size'];   // ��������� � ���������� ���� � ������
        }
        $query .= ')';
        // ������ ������
        if(!mysql_query($query)){
            $arRet['itog'] = 'false';
            $arRet['error'] = '������ mySQL ��� �������� ������ �'.$i.';<br />'.$nn.
                              '<font color="red">'.mysql_error().'</font>;<br />������: '.$query;
            return $arRet;
        }
      }
    }
    fclose($DBF);
    // ����� �������� �������
    // �������� � ����� �������� ������ �, ���� ����, �������� ���
   $arRet['opisanie'] = $opisanie;
//    if($debugMode) echo $opisanie;

    $arRet['timeEnd'] = getMicroTime(); // ����� �������

    return $arRet;  // ��!
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
	  {$nkv=" ��. ".trim($kv).trim($ka);}
	  
	  if ($ns=="�����" or $ns=="�����" or $ns=="�����" or $ns=="�����" or $ns=="�����") 
	  {$adresa=trim($sns)." ".trim($ap)." ��. ".$nbud.$nkv; }
	  else
	  {$adresa=trim($pnr)." ".trim($sns)." ".trim($ap)." ��. ".$nbud.$nkv;}

	  return $adresa;  // ��!
}
function info_zak($text,$text1)
{ $info="-";
  $atf=mysql_query("SELECT SD,NZ,VK FROM ZM WHERE SD=$text AND NZ=$text1
  AND ZM.VR!='��' AND ZM.KF>0;");
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
   SD=$text AND NZ=$text1 AND ZM.VR!='��' AND ZM.KF>0 ORDER BY SD,NZ;");}
	else
	{$wpr=1;
	$ath=mysql_query("SELECT ZM.SD,ZM.NZ,ZM.PR,ZM.IM,ZM.PB,ZM.DT,ZM.D1,ZM.D2,ZM.PRVK,
   ZM.TEL,ZM.NR,ZM.NS,ZM.VL,ZM.BD,ZM.KR,ZM.KV,ZM.KA,BR.FIO,PRICE.VR,NRN.PNR,NSL.SNS,PGF.AP 
   FROM ZM,BR,PRICE,NRN,NSL,PGF 
   WHERE ZM.VK=BR.KOD AND ZM.VR=PRICE.KD AND ZM.NR=NRN.NR AND ZM.NR=NSL.CNR AND 
   ZM.NS=NSL.NS AND ZM.NR=PGF.NR AND ZM.NS=PGF.NS AND ZM.VL=PGF.VC AND
   SD=$text AND NZ=$text1 AND ZM.VR!='��' AND ZM.KF>0 ORDER BY SD,NZ;");}
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
if($aut['VR']!="������"){ 
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
	if ($m_vz=="�") $m_d3=$m_dn;
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
	if ($m_vz=="�") $m_d3=$m_dn;
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
	if ($m_vz=="�") $m_d3=$m_dn;
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
      $zmprvk="���"; 
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
	if ($m_vz=="�") $m_d3=$m_dn;
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
	if ($m_vz=="�") $m_d3=$m_dn;
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
	if ($m_vz=="�") $m_d3=$m_dn;
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
case "�":
        $txt=$txt."�";
        break;
case "�":
        $txt=$txt."�";
        break;
case "�":
        $txt=$txt."�";
        break;
case "�":
        $txt=$txt."�";
        break;
case "�":
        $txt=$txt."�";
        break;
case "�":
        $txt=$txt."�";
        break;
case "�":
        $txt=$txt."�";
        break;
case "�":
        $txt=$txt."�";
        break;
case "�":
        $txt=$txt."�";
        break;
case "i":
        $txt=$txt."I";
        break;
case "�":
        $txt=$txt."�";
        break;
case "�":
        $txt=$txt."�";
        break;
case "�":
        $txt=$txt."�";
        break;
case "�":
        $txt=$txt."�";
        break;
case "�":
        $txt=$txt."�";
        break;
case "�":
        $txt=$txt."�";
		break;
case "�":
        $txt=$txt."�";
		break;
case "�":
        $txt=$txt."�";
		break;
case "�":
        $txt=$txt."�";
		break;
case "�":
        $txt=$txt."�";
		break;
case "�":
        $txt=$txt."�";
		break;
case "�":
        $txt=$txt."�";
		break;
case "�":
        $txt=$txt."�";
		break;
case "�":
        $txt=$txt."�";
		break;
case "�":
        $txt=$txt."�";
		break;
case "�":
        $txt=$txt."�";
		break;
case "�":
        $txt=$txt."�";
		break;
case "�":
        $txt=$txt."�";
		break;
case "�":
        $txt=$txt."�";
		break;
case "�":
        $txt=$txt."�";
		break;
case "�":
        $txt=$txt."�";
		break;
case "�":
        $txt=$txt."�";
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
