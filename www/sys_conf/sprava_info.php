<?php
include "../function.php";

$inv_spr=$_GET['inv_spr'];
$zz=0;
$title=''; $opis=''; /* $zvakt=''; */ $planzem=''; $planbud=''; $jurcost=''; /* $jplbudvbud='';
$jzobm=''; $jpldil=''; $oaktbud=''; $oaktgos=''; */ $eskiz=''; $abris=''; $kamer='';
$zamovl=''; $inshi='';

$sql = "SELECT nas_punktu.NSP,tup_nsp.TIP_NSP,vulutsi.VUL,tup_vul.TIP_VUL,arhiv.BD,
	arhiv.KV FROM arhiv,nas_punktu,vulutsi,tup_nsp,tup_vul 
	WHERE arhiv.N_SPR='$inv_spr' AND arhiv.DL='1' 
	AND nas_punktu.ID_NSP=arhiv.NS AND vulutsi.ID_VUL=arhiv.VL 
	AND tup_nsp.ID_TIP_NSP=nas_punktu.ID_TIP_NSP 
	AND tup_vul.ID_TIP_VUL=vulutsi.ID_TIP_VUL "; 
//echo $sql;
$atu=mysql_query($sql);
while($aut=mysql_fetch_array($atu))
{
$zz++;
$obj_ner=objekt_ner(0,$aut["BD"],$aut["KV"]);
$adr=$aut["TIP_NSP"].$aut["NSP"]." ".$aut["TIP_VUL"].$aut["VUL"]." ".$obj_ner;

$sql1 = "SELECT arh_sec.* FROM arh_sec WHERE arh_sec.N_SPR='$inv_spr' AND arh_sec.DL='1'"; 
$atu1=mysql_query($sql1);
while($aut1=mysql_fetch_array($atu1))
{	
if($aut1['TITLE']=='1') $title='checked';
if($aut1['OPIS']=='1') $opis='checked';
/* if($aut1['ZVAKT']=='1') $zvakt='checked'; */
if($aut1['PLANZEM']=='1') $planzem='checked';
if($aut1['PLANBUD']=='1') $planbud='checked';
if($aut1['JURCOST']=='1') $jurcost='checked';
/* if($aut1['JPLBUDVBUD']=='1') $jplbudvbud='checked';
if($aut1['JZOBM']=='1') $jzobm='checked';
if($aut1['JPLDIL']=='1') $jpldil='checked';
if($aut1['OAKTBUD']=='1') $oaktbud='checked';
if($aut1['OAKTGOS']=='1') $oaktgos='checked'; */
if($aut1['ESKIZ']=='1') $eskiz='checked';
if($aut1['ABRIS']=='1') $abris='checked';
if($aut1['KAMER']=='1') $kamer='checked';
if($aut1['ZAMOVL']=='1') $zamovl='checked';
if($aut1['INSHI']=='1') $inshi='checked';
}
mysql_free_result($atu1);
}
mysql_free_result($atu);
if($zz!=0){
?>
<form action="spr_prava_save.php" name="myform" method="post">
<table align="center" class="zmview">
<tr><th><?php echo $adr; ?></th></tr>
<tr><td><input name="1" type="checkbox" value="pr1" <?php echo $title; ?> />Обкладинка</td></tr>
<tr><td><input name="2" type="checkbox" value="pr2" <?php echo $opis; ?> />Опис інвентарної справи</td></tr>
<!--<tr><td><input name="3" type="checkbox" value="pr3" <?php echo $zvakt; ?> />Зведений акт вартості об`єктів</td></tr>-->
<tr><td><input name="4" type="checkbox" value="pr4" <?php echo $planzem; ?> />План земельної ділянки</td></tr>
<tr><td><input name="5" type="checkbox" value="pr5" <?php echo $planbud; ?> />План будинку</td></tr>
<tr><td><input name="6" type="checkbox" value="pr6" <?php echo $jurcost; ?> />Журнали обмірів та площ. Оцінка об`єкту</td></tr>
<!--<tr><td><input name="7" type="checkbox" value="pr7" <?php echo $jplbudvbud; ?> />Журнал площ будинку з вбудованими приміщеннями</td></tr>
<tr><td><input name="8" type="checkbox" value="pr8" <?php echo $jzobm; ?> />Журнал зовнішніх обмірів</td></tr>
<tr><td><input name="9" type="checkbox" value="pr9" <?php echo $jpldil; ?> />Журнал розрахунку площі присадибної ділянки</td></tr>
<tr><td><input name="10" type="checkbox" value="pr10" <?php echo $oaktbud; ?> />Оцінювальний акт на будинок</td></tr>
<tr><td><input name="11" type="checkbox" value="pr11" <?php echo $oaktgos; ?> />Оцінювальний акт на господарські будівлі та споруди</td></tr>-->
<tr><td><input name="12" type="checkbox" value="pr12" <?php echo $eskiz; ?> />Ескіз планів поверхів будинку</td></tr>
<tr><td><input name="13" type="checkbox" value="pr13" <?php echo $abris; ?> />Абрис земельної ділянки</td></tr>
<tr><td><input name="14" type="checkbox" value="pr14" <?php echo $kamer; ?> />Акт польової і камеральної перевірки</td></tr>
<tr><td><input name="15" type="checkbox" value="pr15" <?php echo $zamovl; ?> />Заява (замовлення)</td></tr>
<tr><td><input name="16" type="checkbox" value="pr16" <?php echo $inshi; ?> />Інші документи
<input type="hidden" name="inv_spr" value="<?php echo $inv_spr; ?>"/>
</td></tr>

<tr><td align="center">
<input name="Ok" type="submit" value="Встановити" /></td>
</tr>
</table>
</form>
<?php
}
else{
	echo 'Інвентарної справи під номером '.$inv_spr.' не існує!';
}
?>