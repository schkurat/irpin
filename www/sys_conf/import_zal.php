<?php
include "../fun2.php";
echo "<h1>START TIME:".date("H:i s")."</h1>";
//include "scriptu.php";
ob_start();
$db=mysql_connect("localhost","root","123456");
if(!$db) echo "Не вiдбулося зєднання з базою даних";
  
 if(!@mysql_select_db(kpbti,$db))
  {
   echo("Не завантажена таблиця");
   exit(); 
   }

$ath=mysql_query("TRUNCATE TABLE `n_ostatok`");
if(!$ath){echo "n_ostatok не обнулился!";}    

$mis=$_POST['mis'];
$rik=$_POST['rik'];
$dt=$rik.'-'.$mis.'-01';
$i=0;
$sql_buf="";
$f=1;
$pr_st=0;
$snfiz_r="/home/common/import/SNFIZ.DBF";
if (file_exists($snfiz_r)) {
	$dbf_conn = dbase_open($snfiz_r, 2);
	dbase_pack ($dbf_conn);
	echo dbase_numrecords($dbf_conn);
while($dbf_rec=@dbase_get_record($dbf_conn, $f)) {
$f++;
$sz=trim(iconv("CP866","UTF-8",$dbf_rec[0]));
$nz=$dbf_rec[1];
$deb=$dbf_rec[3];
$kre=$dbf_rec[4];
$mes=$dbf_rec[5];
$god=$dbf_rec[6];
$kodp=$dbf_rec[7];
/* $fio=str_replace("'","`",trim(iconv("CP866","UTF-8",$dbf_rec[4])));
$fio=str_replace("\\","",$fio);
$adres=str_replace("'","`",trim(iconv("CP866","UTF-8",$dbf_rec[5])));
$adres=str_replace("\\","",$adres);
$sm=$dbf_rec[6];
$nr=str_replace("'","`",trim(iconv("CP866","UTF-8",$dbf_rec[7])));
$ns=str_replace("'","`",trim(iconv("CP866","UTF-8",$dbf_rec[8])));
$kodp=$dbf_rec[9]; */

if($mes==$mis and $god==$rik){
$i++;
if($sql_buf==''){
$sql_buf="INSERT INTO n_ostatok (KODP,SZ,NZ,DT,DEB,KRE) VALUES ";
}
$sql_buf.="('$kodp','$sz','$nz','$dt','$deb','$kre')";
if($i==500) {
echo "+500:$f<br>";
$i=0;
$sql_buf.=";";
mysql_query($sql_buf);
//die();
$sql_buf='';
ob_flush();
}else $sql_buf.=",";
}
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
//Zakrutie bazu       
       if(mysql_close($db))
        {
        // echo("Закриття бази даних");
         }
         else
         {
          echo("Не можливо виконати закриття бази"); 
          }
		  echo "<h1>STOP TIME:".date("H:i s")."</h1>";
		  ob_flush();
ob_end_clean();
?>