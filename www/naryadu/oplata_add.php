<?php
include("../function.php");
$dt_opl=date_bd($_GET["dopl"]);
$sz=$_GET["szam"];
$nz=$_GET["nzam"];
$sum=$_GET["sum"];
$sum_km=$_GET["kom"];
$ssum=$sum+$sum_km;

$dt_obr=date("Y-m-d");//дата обр. файла
$vr_obr=date("H:i:s");//время обр. файла
$i=0;
$fl_s=0;

$sql="SELECT SUM,SUM_D FROM zamovlennya WHERE SZ='$sz' AND NZ='$nz' AND DL='1'";
$atu=mysql_query($sql);
	while($aut=mysql_fetch_array($atu))
	{	
		$sum_zak=$aut["SUM"];
		$sumd_zak=$aut["SUM_D"];
		if($sum_zak==$ssum OR $sumd_zak==$ssum){$fl_s=1;}
	}
mysql_free_result($atu);
if($fl_s==1){
		//vtavka v kasu
		$ath=mysql_query("INSERT INTO kasa(SZ,NZ,DT,SM,SM_KM) 
		VALUES('$sz','$nz','$dt_opl','$sum','$sum_km')");
		$i++;
		//obnovl v bd zakazov pole datu oplatu 
		if($sum_zak==$ssum){
		$ath=mysql_query("UPDATE zamovlennya SET DOKVUT='$dt_opl' 
		WHERE DL='1' AND SZ='$sz' AND NZ='$nz'");
		if(!$ath){echo "Запис не змінився";} 
		}
		if($sumd_zak==$ssum){
		$ath=mysql_query("UPDATE zamovlennya SET DODOP='$dt_opl' 
		WHERE DL='1' AND SZ='$sz' AND NZ='$nz'");
		if(!$ath){echo "Запис не змінився";} 
		}
		$pr_v=0;
		$sql1="SELECT SUM(SM) AS SM,SUM(SM_KM) AS SM_KM FROM s_obr WHERE DL='1' AND D_OBR='$dt_obr'";
					$atu1=mysql_query($sql1);
					while($aut1=mysql_fetch_array($atu1))
					{
						$sm=$aut1["SM"];
						$sm_km=$aut1["SM_KM"];
						if($sm!="") $pr_v=1;
					}
					mysql_free_result($atu1);
					if($pr_v==1){
						$sm=$sm+$sum;
						$sm_km=$sm_km+$sum_km;
						$ath=mysql_query("UPDATE s_obr SET SM='$sm',SM_KM='$sm_km'
						WHERE s_obr.DL='1' AND s_obr.D_OBR='$dt_obr'");
					}
					else{
						$sm=$sum;
						$sm_km=$sum_km;
						$ath=mysql_query("INSERT INTO s_obr(D_OBR,T_OBR,SM,SM_KM) 
						VALUES('$dt_obr','$vr_obr','$sm','$sm_km')");
					}
				mysql_free_result($atu);
			}
			else{
			echo "Помилка!<br> Замовлення $sz/$nz суми не співпадають<br>";
			}
		
if($i!=0) echo "Сума $ssum по замовленню $sz/$nz успішно внесена в касу!";
echo '<a href="naryadu.php?filter=oplata_info"><input type="button" name="next" value="Наступний"></a>';
?>