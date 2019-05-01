<?php
session_start();
$lg=$_SESSION['LG'];
$pas=$_SESSION['PAS'];
header('Content-Type: text/html; charset=utf-8');

include("../function.php");

$db=mysql_connect("localhost",$lg,$pas);
if(!$db) echo "Не вiдбулося зєднання з базою даних";
  
 if(!@mysql_select_db(kpbti,$db))
  {
   echo("Не завантажена таблиця");
   exit(); 
   } 
$dn=date_bd($_GET['date1']);
$dk=date_bd($_GET['date2']);

// "name" Бд
$dbname = "/var/export.dbf";

// "definition/определение" БД
$def =
array(
array("NPP","C",8),
array("DATEV","D"),
array("NUM","C",50),
array("NAZP","C",200),
array("IPN","C",20),
array("ZAGSUM","N",16,2),
array("BAZOP20","N",16,2),
array("SUMPDV","N",16,2),
array("BAZOP0","N",16,2),
array("ZVILN","N",16,2),
array("EXPORT","N",16,2),
array("PZOB","N",3,0),
array("NREZ","N",2,0),
array("KOR","N",2,0),
array("WMDTYPE","N",2,0),
array("WMDTYPESTR","C",5),
array("UTOCH","N",2,0),
array("WMDTYPEXEC","C",2),
array("WMDTYPLIT","C",1),
array("DELIVERY","N",16,2),
array("MPREP7","N",1,0)
);
//Создем файл
$DBF=dbase_create($dbname, $def);
if(!$DBF) echo "Ошибка СОЗДАНИЯ";
for($i=1; $i<=dbase_numrecords($DBF); $i++){
if(!dbase_delete_record ($DBF,$i)) echo "Ошибка удаления";
}
//if(!dbase_pack($DBF)) echo "Ошибка упаковки";
$npp=0;
$sql = "SELECT * FROM podatkova WHERE DT_NAL>='$dn' AND DT_NAL<='$dk' ORDER BY N_NAL";
//echo $sql;
 $atu=mysql_query($sql);
  while($aut=mysql_fetch_array($atu))
 {	
	$npp++;
	$data_nal=explode("-",$aut["DT_NAL"]);
	$datev=$data_nal[0].$data_nal[1].$data_nal[2];
	$num=$aut["N_NAL"];
	$kod_kl=$aut["K_KL"];
	$wmdtypexec='';
	if($kod_kl!=0) $nazp=iconv("UTF-8","CP866",$aut["NAME"]);
	else {
	$nazp=iconv("UTF-8","CP866",'Кiнцевий споживач');
	$wmdtypexec='11';
	}
	if($aut["PR_NDS"]!=0){
	$zagsum=$aut["SM_OPL"];
	$bazop20=round(($zagsum/1.2),2);
	$sumpdv=round((($zagsum*20)/120),2);
	$bazop0=0;
	$zviln=0;
	}
	else{
	$zagsum=$aut["SM_OPL"];
	$bazop20=0;
	$sumpdv=0;
	$bazop0=$zagsum;
	$zviln=$bazop0;
	$wmdtypexec='09';
	}
	$export=0;
	$pzob=0;
	$nrez=0;
	$kor=0;
	$wmdtype=1;
	$wmdtypestr=iconv("UTF-8","CP866",'ПНП');
	$utoch=0;
	$wmdtyplit='';
	$delivery=0;
	$mprep7=0;
if($kod_kl!=0){
$sql1 = "SELECT * FROM yur_kl WHERE yur_kl.ID='$kod_kl'";
$atu1=mysql_query($sql1);
while($aut1=mysql_fetch_array($atu1))
{
$ipn=$aut1["IPN"];
}
mysql_free_result($atu1);
if($ipn=='') $wmdtypexec='02';
}
else{
$ipn='0';}
	
//Добавляем строку в файл dbf---
   dbase_add_record($DBF,array($npp,$datev,$num,$nazp,$ipn,$zagsum,$bazop20,$sumpdv,$bazop0,$zviln,
  $export,$pzob,$nrez,$kor,$wmdtype,$wmdtypestr,$utoch,$wmdtypexec,$wmdtyplit,$delivery,$mprep7));
 }
mysql_free_result($atu);

//Закрываем указатель на файл
dbase_close($DBF);

 if(mysql_close($db))
        {
        // echo("Закриття бази даних");
         }
         else
         {
          echo("Не можливо виконати закриття бази"); 
          }
		  
header("Content-type: application/x-download");
header("Content-Disposition: attachment; filename=".$dbname);
$x = fread(fopen($dbname, "rb"), filesize($dbname)); 
echo $x;
?>