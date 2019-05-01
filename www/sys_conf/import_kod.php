<?php
include "../fun2.php";
echo "<h1>START TIME:".date("H:i s")."</h1>";
//include "scriptu.php";
ob_start();

$i=0;
$sql_buf="";
$f=1;
$zm_r="/home/common/import/SPR_KOD.DBF";
if (file_exists($zm_r)) {
	$dbf_conn = dbase_open($zm_r, 2);
	dbase_pack ($dbf_conn);
	echo dbase_numrecords($dbf_conn);
while($dbf_rec=@dbase_get_record($dbf_conn, $f)) {
$f++;
$pr=str_replace("'","`",trim(iconv("CP866","UTF-8",$dbf_rec[0])));
$pr=trim(str_replace("\\","",$pr));
$im=str_replace("'","`",trim(iconv("CP866","UTF-8",$dbf_rec[1])));
$im=trim(str_replace("\\","",$im));
$pb=str_replace("'","`",trim(iconv("CP866","UTF-8",$dbf_rec[2])));
$pb=trim(str_replace("\\","",$pb));
$d_nar=$dbf_rec[3];
$idn=trim($dbf_rec[4]);
$i++;
if($sql_buf==''){
$sql_buf="INSERT INTO idn (IDN,PR,IM,PB,DATA_NAR) VALUES ";
}
$sql_buf.="('$idn','$pr','$im','$pb','$d_nar')";
if($i==500) {
echo "+500:$f<br>";
$i=0;
$sql_buf.=";";
mysql_query($sql_buf);
$sql_buf='';
ob_flush();
}else $sql_buf.=",";
	}
	dbase_close($dbf_conn);
	}
	else
	echo "net takogo faila";
if($sql_buf!=''){
$len=mb_strlen($sql_buf);
$sql_buf=mb_substr($sql_buf,0,$len-1);
$sql_buf.=";";
mysql_query($sql_buf);
}
//-------vstavka s ray bazu--------------
$sql = "SELECT tb1.* FROM bti.SPR_KOD AS tb1"; 
$atu=mysql_query($sql);
while($aut=mysql_fetch_array($atu))
{
$idn=$aut['IDK'];
$pr=$aut['PR'];
$im=$aut['IM'];
$pb=$aut['PB'];
$d_nar=$aut['DN'];
$sql1 = "SELECT tb2.* FROM kpbti.IDN AS tb2 WHERE idn='$idn'"; 
$atu1=mysql_query($sql1);
$num_rows = mysql_num_rows($atu1);
if($num_rows==0){
$sql_buf="INSERT INTO idn (IDN,PR,IM,PB,DATA_NAR) VALUES ('$idn','$pr','$im','$pb','$d_nar');";
mysql_query($sql_buf);
}
mysql_free_result($atu1); 
}
mysql_free_result($atu); 
//---------------------------------------

		  echo "<h1>STOP TIME:".date("H:i s")."</h1>";
		  ob_flush();
ob_end_clean();
?>