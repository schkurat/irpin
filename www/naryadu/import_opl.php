<?php
session_start();
$lg=$_SESSION['LG'];
$pas=$_SESSION['PAS'];
include("../function.php");
   
$dtk=date_bd($_GET["date1"]);

$db=mysql_connect("localhost",$lg,$pas);
if(!$db) echo "Не вiдбулося зєднання з базою даних";
  
 if(!@mysql_select_db(kpbti,$db))
  {
   echo("Не завантажена таблиця");
   exit(); 
   }
   
$ath=mysql_query("DELETE FROM podatkova WHERE podatkova.DT_OPL='$dtk'");
$sum=0;
$sum_k=0;
$n_nal=0;
$mes=date('m');
$sql="SELECT podatkova.DT_NAL,podatkova.N_NAL FROM podatkova WHERE MONTH(DT_NAL)='$mes' ORDER BY ID DESC LIMIT 1";
$atu=mysql_query($sql);
while($aut=mysql_fetch_array($atu)){
$n_nal=$aut["N_NAL"]+1;
}
mysql_free_result($atu);
if($n_nal==0) $n_nal=1;

//vstavka 
$sql="SELECT zamovlennya.TUP_ZAM,zamovlennya.EDRPOU,zamovlennya.SUM_D,zamovlennya.SUM,kasa.KODP,kasa.DT,
	kasa.SM,kasa.SM_KM,kasa.SD,kasa.SZU,kasa.NZU,zamovlennya.D_PR FROM zamovlennya,kasa 
WHERE kasa.DT='$dtk' AND kasa.DL='1' AND zamovlennya.DL='1' AND zamovlennya.KODP=kasa.KODP 
	AND zamovlennya.SZ=kasa.SD AND zamovlennya.NZ=kasa.NZ 
	AND zamovlennya.SZU=kasa.SZU AND zamovlennya.NZU=kasa.NZU";
//echo $sql;
$atu=mysql_query($sql);
while($aut=mysql_fetch_array($atu)){
$edrpou=0;
$kodp=$aut["KODP"];
$rah=$aut["SD"].'*'.$aut["SZU"].'/'.$aut["NZU"];
$dt_opl=$aut["DT"];
$sm=$aut["SM"];
$sm_k=$aut["SM_KM"];
$t_z=$aut["TUP_ZAM"];
$edrpou=$aut["EDRPOU"];
$sum_a=$aut["SUM"];
$sum_d=$aut["SUM_D"];
$sum_d=$sum_d+$sum_a;
$dt_pr=$aut["D_PR"];
if($t_z==1){
$sum=$sum+$sm;
$sum_k=$sum_k+$sm_k; 
}
else{ 
$sql1="SELECT yur_kl.ID,yur_kl.NAME_F FROM yur_kl WHERE yur_kl.EDRPOU='$edrpou' AND yur_kl.DL='1'";
$atu1=mysql_query($sql1);
while($aut1=mysql_fetch_array($atu1)){
$k_kl=$aut1["ID"];
$name_f=$aut1["NAME_F"]; 
}
mysql_free_result($atu1); 
$ath1=mysql_query("INSERT INTO podatkova(K_KL,NAME,TIP_OPL,USL_B,DT_RAH,SM_RAH,DT_OPL,SM_OPL,N_RAH,PR_NDS,N_NAL,
DT_NAL,K_PLAT) VALUES('$k_kl','$name_f',2,'$sm_k','$dt_pr','$sum_d','$dt_opl','$sm','$rah','20','$n_nal',
'$dt_opl','$k_kl');");
$n_nal++;
}
}
mysql_free_result($atu);

if($sum!=0){
$ath1=mysql_query("INSERT INTO podatkova(K_KL,NAME,TIP_OPL,USL_B,DT_OPL,SM_OPL,PR_NDS,N_NAL,DT_NAL,K_PLAT) 
VALUES('0','Фізичні особи',1,'$sum_k','$dt_opl','$sum','20','$n_nal','$dt_opl','0');");
} 
//Zakrutie bazu--       
       if(mysql_close($db))
        {
        // echo("Закриття бази даних");
         }
         else
         {
          echo("Не можливо виконати закриття бази"); 
          } 
header("location: naryadu.php?filter=");
?>