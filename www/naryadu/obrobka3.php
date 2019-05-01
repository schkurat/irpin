<?php
include("../function.php");
$n_file=$_GET["n_file"];
$put1=$_GET["put"];
$put2="/home/rabota/kassa/KPBTI/".$n_file;

		$dt_obr=date("Y-m-d");//дата обр. файла
		$vr_obr=date("H:i:s");//время обр. файла
		$sm=0;
	//	$sm_km=0;
	//	$lich=0;
		/* $p='<form action="kasa.php" name="myform" method="get">
		<table border="1" class="bordur" align="center"><tr>
		<th colspan="11">Обробка юридичних замовлень</th>
		</tr>'; */
	$sql10="SELECT * FROM temp_kasa";
	$atu10=mysql_query($sql10);
	while($aut10=mysql_fetch_array($atu10)){
		$dt_opl=$aut10["DATE"];
		$zam=$aut10["NZ"];
		$tip=$aut10["TIP"];
		$sum=$aut10["SUM"];
		$sum_km=$aut10["SUM_KM"];
		$prim=$aut10["PRIM"];
		$ssum=$sum+$sum_km;
		
		//opred ser i nomer zakaza
			$sd=mb_substr($zam,0,2);
			$zm_rn=mb_substr($zam,3,15);
			if($tip=='ф'){
			if(mb_strpos($zm_rn,"-")){
			$ar_zmrn= explode("-",$zm_rn);
			$nz=$ar_zmrn[0];
			$kod_rn=$ar_zmrn[1];
			$t_pl=$ar_zmrn[2];//avans ili doplata
			$szu='';
			$nzu=0;
			}
			else
			{
				$nz=$zm_rn;
				$kod_rn="";
			}}
			else{
			$ar_zmrn= explode("/",$zm_rn);
			$szu=$ar_zmrn[0];
			$nzu=$ar_zmrn[1];
			$t_pl=$ar_zmrn[2];
			if($t_pl=='') $t_pl='д';
			$nz=0;
			$kod_rn='12';
			}
			
		//	$kodp=$kod_rn;
			$sql="SELECT KODP FROM spr_nr WHERE KOD_ZM='$kod_rn'";
			$atu=mysql_query($sql);
			while($aut=mysql_fetch_array($atu))
				{$kodp=$aut["KODP"];}
			mysql_free_result($atu);
			$fl_s=0;
			
			$sql="SELECT KODP FROM zamovlennya WHERE SZ='$sd' AND NZ='$nz' AND SZU='$szu' AND NZU='$nzu'   
			AND KODP='$kodp' AND (SUM='$ssum' OR SUM_D='$ssum') AND DL='1'";
			$atu=mysql_query($sql);
			while($aut=mysql_fetch_array($atu))
			{	$fl_s=1;
				$kodp=$aut["KODP"];
			}
			mysql_free_result($atu);
			if($fl_s==1 AND ($t_pl=='а' OR $t_pl=='А' OR $t_pl=='a' OR $t_pl=='A' OR $t_pl=='д' OR $t_pl=='Д')){
				$sql="SELECT KODP FROM kasa	WHERE DL='1' AND SD='$sd' AND NZ='$nz' AND SZU='$szu' AND NZU='$nzu' 
				AND KODP='$kodp' AND SM='$sum' AND SM_KM='$sum_km' AND DT='$dt_opl'"; 
				$atu=mysql_query($sql);
				$num_rows=mysql_num_rows($atu);
				if($num_rows==0){
					//vtavka v kasu
					$ath=mysql_query("INSERT INTO kasa(SD,NZ,SZU,NZU,DT,SM,SM_KM,PRIM,KODP) 
					VALUES('$sd','$nz','$szu','$nzu','$dt_opl','$sum','$sum_km','$prim','$kodp')");
					//obnovl v bd zakazov pole datu oplatu
					if($t_pl=='а' OR $t_pl=='А' OR $t_pl=='a' OR $t_pl=='A'){
					$ath=mysql_query("UPDATE zamovlennya SET DOKVUT='$dt_opl' 
					WHERE DL='1' AND SZ='$sd' AND NZ='$nz' AND SZU='$szu' AND NZU='$nzu' AND KODP='$kodp' AND SUM='$ssum'");
					if(!$ath){echo "Запис не змінився";} 
					}
					else{
					$ath=mysql_query("UPDATE zamovlennya SET DODOP='$dt_opl' 
					WHERE DL='1' AND SZ='$sd' AND NZ='$nz' AND SZU='$szu' AND NZU='$nzu' AND KODP='$kodp' AND SUM_D='$ssum'");
					if(!$ath){echo "Запис не змінився";} 
					}
					$pr_v=0;
					$sql1="SELECT SUM(SM) AS SM,SUM(SM_KM) AS SM_KM FROM s_obr 
					WHERE DL='1' AND KODP='$kodp' AND N_FILE='$n_file'";
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
						WHERE s_obr.DL='1' AND s_obr.KODP='$kodp' AND s_obr.N_FILE='$n_file'");
					}
					else{
						$sm=$sum;
						$sm_km=$sum_km;
						$ath=mysql_query("INSERT INTO s_obr(N_FILE,D_OBR,T_OBR,KODP,SM,SM_KM) 
						VALUES('$n_file','$dt_obr','$vr_obr','$kodp','$sm','$sm_km')");
					}
				}
				else{
					echo "Замовлення $sd*$nz вже присутнє в касі<br>";
				}
				mysql_free_result($atu);
			}
			else{
				$ath=mysql_query("INSERT INTO kasa_error(N_FILE,SD,NZ,SZU,NZU,DT,SM,SM_KM,PRIM,KODP) 
						VALUES('$n_file','$sd','$nz','$szu','$nzu','$dt_opl','$sum','$sum_km','$prim','1063')");
				$pr_v=0;
				$sql1="SELECT SUM(SM) AS SM,SUM(SM_KM) AS SM_KM FROM s_obr 
				WHERE DL='1' AND KODP='1063' AND N_FILE='$n_file'";
				$atu1=mysql_query($sql1);
				while($aut1=mysql_fetch_array($atu1))
				{
					$sm=$aut1["SM"];
					$sm_km=$aut1["SM_KM"];
					if($sm!="") $pr_v=1;
				}
					mysql_free_result($atu1);
				if($pr_v==0){
					$sm=$sum;
					$sm_km=$sum_km;
					$ath=mysql_query("INSERT INTO s_obr(N_FILE,D_OBR,T_OBR,KODP,SM,SM_KM) 
					VALUES('$n_file','$dt_obr','$vr_obr',1063,'$sm','$sm_km')");
				}
				else{
					$sm=$sm+$sum;
					$sm_km=$sm_km+$sum_km;
					$ath=mysql_query("UPDATE s_obr SET SM='$sm',SM_KM='$sm_km'
					WHERE s_obr.DL='1' AND s_obr.KODP=1063 AND s_obr.N_FILE='$n_file'");
				}
			}
		
	}
	mysql_free_result($atu10);
		/* $p.='<tr><td align="center" colspan="11">
				<input name="filter" type="hidden" value="obrobka4">
				<input name="Ok" type="submit" value="Далі" /></form>
				<a href="kasa.php?filter=logo" ><input name="Cancel" type="button" value="Відміна" /></a>
				</td></tr></table>';
		if($lich!=0) echo $p; */
		echo "Каса оброблена!";
	if(!rename($put1,$put2)) echo "Файл не перемістився в сховище!"
//header("location: kasa.php?filter=obrobka3&fl=".$fl."");
?>