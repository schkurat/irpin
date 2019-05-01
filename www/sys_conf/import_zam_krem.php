<?php
include "../fun2.php";
echo "<h1>START TIME:".date("H:i s")."</h1>";
//include "scriptu.php";
ob_start();
/* $db=mysql_connect("localhost","root","123456");
if(!$db) echo "Не вiдбулося зєднання з базою даних";
  
 if(!@mysql_select_db(kpbti,$db))
  {
   echo("Не завантажена таблиця");
   exit(); 
   }  */
$i=0;
$sql_buf="";
$kodp=1010;
$f=1;
$pr_st=0;
$zm_r="/home/common/import/ZM.DBF";
if (file_exists($zm_r)) {
	$dbf_conn = dbase_open($zm_r, 2);
	dbase_pack ($dbf_conn);
	echo dbase_numrecords($dbf_conn);
while($dbf_rec=@dbase_get_record($dbf_conn, $f)) {
$f++;

$sz=trim(iconv("CP866","UTF-8",$dbf_rec[0]));
$nz=$dbf_rec[1];
$d_pr=$dbf_rec[2];
$vr=trim(iconv("CP866","UTF-8",$dbf_rec[7]));
$vud_rob='';
$idn=$dbf_rec[9];
$pr=str_replace("'","`",trim(iconv("CP866","UTF-8",$dbf_rec[10])));
$pr=str_replace("\\","",$pr);
$im=str_replace("'","`",trim(iconv("CP866","UTF-8",$dbf_rec[11])));
$im=str_replace("\\","",$im);
$pb=str_replace("'","`",trim(iconv("CP866","UTF-8",$dbf_rec[12])));
$pb=str_replace("\\","",$pb);
$d_nar=$dbf_rec[13];
$old_ad=str_replace("'","`",trim(iconv("CP866","UTF-8",$dbf_rec[18])));
$old_ad=str_replace("\\","",$old_ad);
$data_got=$dbf_rec[28];
$tel=$dbf_rec[37];
$sum=$dbf_rec[15];
$tup_zam=1;
$term=1;
$rn=1;
$ns=1;
$vl=1;
$bud=1;
$kvar=1;
//echo "sz=$sz nz=$nz kodp=$kodp <br>";
$sql1 = "SELECT n_ostatok.KODP FROM n_ostatok WHERE n_ostatok.KODP='$kodp' AND n_ostatok.SZ='$sz' 
		AND n_ostatok.NZ='$nz'"; 
$atu1=mysql_query($sql1);
$num_rows = mysql_num_rows($atu1);
if($num_rows!=0){
$i++;
$sql = "SELECT dl_of.id_oform FROM bti.PRICE AS price ON price.KD='$vr'
	INNER JOIN kpbti.dlya_oformlennya AS dl_of ON dl_of.document=price.VR"; 
$atu=mysql_query($sql);
while($aut=mysql_fetch_array($atu))
{
$vud_rob=$aut['id_oform'];
}
mysql_free_result($atu);
if($vud_rob=='') $vud_rob=1;

if($sql_buf==''){
$sql_buf="INSERT INTO zamovlennya (KODP,SZ,NZ,TUP_ZAM,TERM,VUD_ROB,IDN,PR,IM,PB,D_NAR,TEL,RN,NS,VL,BUD,
KVAR,OLD_AD,SUM,D_PR,DATA_GOT) VALUES ";
}
$sql_buf.="('$kodp','$sz','$nz','$tup_zam','$term','$vud_rob','$idn','$pr','$im','$pb','$d_nar','$tel',
'$rn','$ns','$vl','$bud','$kvar','$old_ad','$sum','$d_pr','$data_got')";
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
mysql_free_result($atu1);
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
/* //Zakrutie bazu       
       if(mysql_close($db))
        {
        // echo("Закриття бази даних");
         }
         else
         {
          echo("Не можливо виконати закриття бази"); 
          } */
		  echo "<h1>STOP TIME:".date("H:i s")."</h1>";
		  ob_flush();
ob_end_clean();
?>