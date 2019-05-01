<?php
include "../scriptu.php";
include "../function.php";
?>
<script type="text/javascript">

$(document).ready(function(){
//	$('#idn').bind('blur',net_fokusa);
	$('#dl_ofor').bind('blur',s_vart);
	$('#bt1').click(ShowElement);
	$('#bt2').click(HideElement);
	$('#add_ns').click(add_nsp);
	$('#add_vl').click(add_vul);
	$('input.bt').click(HideElement_cancel);							
	}); 
//	function net_fokusa(eventObj){
//	$.ajax({
//		type: "POST",
//		url: "test_idn.php",
//		data: 'kod='+ $("#idn").val(),
//		dataType: "html",
//		success: function(html){
//		var reply=html.split(":",4);
//		$("#pr").val(reply[0]);
//		$("#im").val(reply[1]);
//		$("#pb").val(reply[2]);
//		$("#dn").val(reply[3]);},
//		error: function(html){alert(html.error);}
//		});
//	}
function s_vart(eventObj){
	$.ajax({
		type: "POST",
		url: "var_rob.php",
		data: 'vr='+ $("#dl_ofor").val(),
		dataType: "html",
		success: function(html){
			var rep=html.split(":",2);
			$("#sm").val(rep[0]);
			if(rep[1]!='') $("#date1").val(rep[1]);
		},	
		error: function(html){alert(html.error);}
	});
}
//	function sum_vart(eventObj){
//		$.ajax({
//		type: "POST",
//		url: "var_rob2.php",
//		data: 'kl='+$("#idpr").val()+'&sm='+$("#sumt").val()+'&pl='+$("#plos").val(),
//		dataType: "html",
//		success: function(html){
//			var rp=html;
//			$("#sm").val(rp);
//		},	
//		error: function(html){alert(html.error);}
//		});
//	}
	function ShowElement(){
		$("#add_vul").fadeOut();
		$("#add_nas_punkt").fadeIn(3000);
	}
	function HideElement(){
		$("#add_nas_punkt").fadeOut();
		$("#add_vul").fadeIn(3000);
	}
	function HideElement_cancel(){
		$("#add_nas_punkt").fadeOut();
		$("#add_vul").fadeOut();
	}
function add_nsp(eventObj){
	$.ajax({
		type: "POST",
		url: "nspadd.php",
		data: 'nsp2='+$("#nsp2").val()+'&tup2='+$("#tup2").val(),
		dataType: "html",
		success: function(html){
			var rp=html;
			if(rp=='1'){
			$("#nas_punkt :nth-child(1)").attr("selected", "selected");
			$("#vulutsya").empty();
			$("#nas_punkt").attr("disabled",false);
			$("#vulutsya").attr("disabled","disabled");
			HideElement_cancel();
			}
		},	
		error: function(html){alert(html.error);}
	});
}
function add_vul(eventObj){
	$.ajax({
		type: "POST",
		url: "vladd.php",
		data: 'nsp3='+$("#nas_punkt3").val()+'&vul3='+$("#vul3").val()+'&tup3='+$("#tup3").val(),
		dataType: "html",
		success: function(html){
			var rp=html;
			if(rp=='1'){
			$("#nas_punkt :nth-child(1)").attr("selected", "selected");
			$("#vulutsya").empty();
			$("#nas_punkt").attr("disabled",false);
			$("#vulutsya").attr("disabled","disabled");
			HideElement_cancel();
			}
		},	
		error: function(html){alert(html.error);}
	});
}
</script>

<?php
$pr='<body>
<div id="add_nas_punkt">
<table>
<tr><th colspan="2">Додавання нового нас. пункту</th></tr>
<tr><td colspan="2">
Назва населеного пункту<br><input type="text" id="nsp2" name="nsp2" value="" style="width:200px;"/><br>
Тип населеного пункту<br>
<select id ="tup2" name="tup2" class="sel_ad">
<option value="0">Оберіть тип</option>';
$sql = "SELECT tup_nsp.ID_TIP_NSP,tup_nsp.TIP_NSP FROM tup_nsp ORDER BY tup_nsp.ID_TIP_NSP";
$atu=mysql_query($sql);
 while($aut=mysql_fetch_array($atu))
 {$pr.='<option value="'.$aut["ID_TIP_NSP"].'">'.$aut["TIP_NSP"].'</option>';}
mysql_free_result($atu);
$pr.='</select>
</td></tr>
<tr><td align="center">
<input type="button" id="add_ns" name="ok" style="width:80px;margin-top:15px;" value="Ок">
</td><td align="center">
<input type="button" class="bt" style="width:80px;margin-top:15px;" value="Вiдмiна">
</td></tr>
</table>
</div>
<div id="add_vul">
<table>
<tr><th colspan="2">Додавання нової вулиці</th></tr>
<tr><td colspan="2">
Населений пункт: <br>
<select class="sel_ad" id="nas_punkt3" name="nsp3">
<option value="">Оберіть населений пункт</option>';
$sql = "SELECT nas_punktu.ID_NSP,nas_punktu.NSP,tup_nsp.TIP_NSP 
		FROM nas_punktu,tup_nsp 
		WHERE nas_punktu.ID_TIP_NSP=tup_nsp.ID_TIP_NSP 
		ORDER BY nas_punktu.ID_NSP";
 $atu=mysql_query($sql);
 while($aut=mysql_fetch_array($atu))
 {
 $pr.='<option value="'.$aut["ID_NSP"].'">'.$aut["NSP"].' '.$aut["TIP_NSP"].'</option>';
 }
mysql_free_result($atu);
$pr.='</select>
</td></tr>
<tr><td colspan="2">
Назва<br><input type="text" size="25" id="vul3" name="vul3" value=""/>
</td></tr>
<tr><td colspan="2">
Тип<br>
<select class="sel_ad" name="tup3" id="tup3">
<option value="0">Оберіть тип</option>';
$sql = "SELECT tup_vul.ID_TIP_VUL,tup_vul.TIP_VUL FROM tup_vul ORDER BY tup_vul.ID_TIP_VUL";
$atu=mysql_query($sql);
 while($aut=mysql_fetch_array($atu))
 {$pr.='<option value="'.$aut["ID_TIP_VUL"].'">'.$aut["TIP_VUL"].'</option>';}
mysql_free_result($atu);
$pr.='</select>
</td></tr>
<tr><td>
<input type="button" id="add_vl" name="ok" style="width:80px;margin-top:15px;" value="Ок">
</td><td>
<input type="button" class="bt" style="width:80px;margin-top:15px;" value="Вiдмiна">
</td></tr>
</table>
</div>';

$kl=$_GET['kl'];
$prav=$_GET['fl'];
$filter=array(
"zakaz"=>"readonly",
"edrpou"=>"readonly",
"ipn"=>"readonly",
"svid"=>"readonly",
"subj"=>"readonly",
"adr_subj"=>"readonly",
"prilad"=>"readonly",
"tup_spr"=>"readonly",
"prizv"=>"readonly",
"zvat"=>"readonly",
"otche"=>"readonly",
"sert"=>"readonly",
"pasp"=>"readonly",
"telefon"=>"readonly",
"email"=>"readonly",
"prim"=>"readonly",
"budunok"=>"readonly",
"kvartura"=>"readonly",
"vartist"=>"readonly");
if($prav=="subj"){
    $filter["edrpou"]="";
    $filter["ipn"]="";
    $filter["svid"]="";
    $filter["subj"]="";
    $filter["adr_subj"]="";
    $filter["prilad"]="";
}
if($prav=="prizv"){
    $filter[$prav]="";
    $filter["zvat"]="";
    $filter["otche"]="";
    $filter["sert"]="";
}
if($prav=="telefon"){
    $filter[$prav]="";
    $filter["email"]="";
}
if($prav=="tup_spr"){
    $filter[$prav]="";
    $filter["vartist"]="";
}
if($prav=="prim"){
$filter[$prav]="";
}
$filter[$prav]="";
if($prav=="adres"){$adr="123"; $filter["budunok"]=""; $filter["kvartura"]="";}
else
{$adr="";}

$sql = "SELECT arhiv_zakaz.*,arhiv_jobs.name,nas_punktu.NSP, tup_nsp.TIP_NSP,vulutsi.VUL,tup_vul.TIP_VUL,rayonu.* 
			 FROM arhiv_zakaz, nas_punktu, vulutsi, tup_nsp, tup_vul,rayonu, arhiv_jobs
				WHERE 
					arhiv_zakaz.KEY='$kl' AND arhiv_zakaz.DL='1'  
					AND arhiv_jobs.id=VUD_ROB
                                        AND rayonu.ID_RAYONA=RN
					AND nas_punktu.ID_NSP=NS
					AND vulutsi.ID_VUL=VL
					AND tup_nsp.ID_TIP_NSP=nas_punktu.ID_TIP_NSP
					AND tup_vul.ID_TIP_VUL=vulutsi.ID_TIP_VUL";
 $atu=mysql_query($sql);
  while($aut=mysql_fetch_array($atu))
 {
$priz=htmlspecialchars($aut["PR"],ENT_QUOTES);

if($aut["TUP_ZAM"]==1){
$fiz="checked";
$yur="";
}
else{
$fiz="";
$yur="checked";
} 
$zaka_z=$aut["SZ"].'/'.$aut["NZ"];

$vst_vr='<select id="dl_ofor" name="vud_rob" '.$filter["tup_spr"].'>
<option value="">Оберіть вид робіт</option>';

$sql1 = "SELECT * FROM arhiv_jobs WHERE dl='1' ORDER BY name";
 $atu1=mysql_query($sql1);
 while($aut1=mysql_fetch_array($atu1))
 {
 if($aut["name"]==$aut1["name"]) $vst_vr.='<option selected value="'.$aut1["id"].'">'.$aut1["name"].'</option>';
 else $vst_vr.='<option value="'.$aut1["id"].'">'.$aut1["name"].'</option>';
 }
mysql_free_result($atu1);
$vst_vr.='</select>';

$pr.='
<form action="update_zakaz.php" name="myform" method="post">
<table align="" class="zmview">
<tr><th colspan="4" style="font-size: 35px;"><b>Редагування замовлення</b></th></tr>
<tr>
<td>Номер замовлення</td>
<td><input type="text" size="10" name="nzam" value="'.$zaka_z.'"'.$filter["zakaz"].'/></td>
<td>ЄДРПОУ:</td>
<td>
    <input type="text" id="edrpou" size="10" maxlength="10" name="edrpou" value="'.$aut["EDRPOU"].'" '.$filter["edrpou"].'/>
    <input type="hidden" id="idpr" name="idpr" value="0"/>
    <input type="hidden" id="sumt" name="sumt" value="0"/>
    <input type="hidden" name="kll" value="'.$kl.'"/>
</td>
</tr>
<tr>
<td>ІПН:</td>
<td><input type="text" id="ipn" size="12" maxlength="12" name="ipn" value="'.$aut["IPN"].'" '.$filter["ipn"].'/></td>
<td>Св-тво:</td>
<td><input type="text" id="svid" size="9" maxlength="9" name="svid" value="'.$aut["SVID"].'" '.$filter["svid"].'/></td>
</tr>
<tr>
<td>Назва суб`єкта: </td>
<td colspan="3"><input type="text" id="subj" size="59" maxlength="150" name="subj" value="'.htmlspecialchars($aut["SUBJ"],ENT_QUOTES).'" '.$filter["subj"].' required/></td>
</tr>
<tr>
<td>Адреса суб`єкта: </td>
<td colspan="3"><input type="text" id="adrs_subj" size="59" maxlength="150" name="adrs_subj" value="'.htmlspecialchars($aut["ADR_SUBJ"],ENT_QUOTES).'" '.$filter["adr_subj"].' required/></td>
</tr>
<tr>
<td>Вимірювальний прилад: </td>
<td colspan="3"><input type="text" id="prilad" size="59" maxlength="150" name="prilad" value="'.htmlspecialchars($aut["PRILAD"],ENT_QUOTES).'" '.$filter["prilad"].' required/></td>
</tr>
<tr>
<td>Прізвище (назва):</td>
<td colspan="3"><input type="text" id="pr" size="59" maxlength="150" name="priz" value="'.$priz.'"'.$filter["prizv"].'/></td>
</tr>
<tr>
<td>Імя: </td>
<td colspan="3"><input type="text" id="im" size="20" maxlength="20" name="imya" value="'.htmlspecialchars($aut["IM"],ENT_QUOTES).'"'.$filter["zvat"].'/></td>
</tr>
<tr>
<td>Побатькові: </td>
<td colspan="3"><input type="text" id="pb" size="20" maxlength="20" name="pobat" value="'.htmlspecialchars($aut["PB"],ENT_QUOTES).'"'.$filter["otche"].'/></td>
</tr>
<tr>
<td>Сертифікат: </td>
<td colspan="3"><input type="text" id="ser_sert" size="20" name="sert" value="'.$aut["SERT"].'" '.$filter["sert"].'/>
</td>
</tr>
<tr>
<td>Телефон: </td>
<td colspan="3"><input type="text" size="25" maxlength="25" name="tel" value="'.$aut["TEL"].'"'.$filter["telefon"].'/>
E-mail:<input type="text" size="20" name="email" value="'.$aut["EMAIL"].'"'.$filter["email"].'/>
</td>
</tr>
<tr>
<td>Примітка: </td>
<td colspan="3"><input type="text" id="prim" size="59" name="prim" value="'.htmlspecialchars($aut["PRIM"],ENT_QUOTES).'"'.$filter["prim"].'/></td>
</tr>
<tr>
<td>Доручення: </td>
<td colspan="3"><input type="text" id="doruch" size="59" maxlength="150" name="doruch" value="'.htmlspecialchars($aut["DOR"],ENT_QUOTES).'"/></td>
</tr>
<tr>
<td>Тип справи: </td>
<td colspan="3">
'.$vst_vr.'
</td>
</tr>
';
if($adr==""){
$pr.='<tr>
        <td>Район: </td>
        <td colspan="3">
        <div class="border">
        <select class="sel_ad" id="rayon" name="rajon" required>
        <option value="">Оберіть район</option>';
        $id_rn=''; $rajn='';
        $sql1 = "SELECT rayonu.ID_RAYONA,rayonu.RAYON FROM rayonu ORDER BY rayonu.ID_RAYONA";
         $atu1=mysql_query($sql);
         while($aut1=mysql_fetch_array($atu1))
         {
         $dl_s=strlen($aut1["RAYON"])-10;
         $n_rjn=substr($aut1["RAYON"],0,$dl_s);
         if($aut1["ID_RAYONA"] == $aut["ID_RAYONA"]){
            $pr.='<option selected value="'.$aut1["ID_RAYONA"].'">'.$n_rjn.'</option>';
         }
         else{
             $pr.='<option value="'.$aut1["ID_RAYONA"].'">'.$n_rjn.'</option>';
         }
         }
        mysql_free_result($atu1);

        $pr.='</select>
        </div>
        </td>
        </tr>
	<tr>
	<td>Населений пункт: </td>
	<td colspan="3">
	<div class="border">
	<select class="sel_ad" name="nsp" readonly>
	<option value="'.$aut["NS"].'">'.$aut["NSP"].' '.$aut["TIP_NSP"].'</option>
	</select>
	<input type="button" id="bt1" value="Додати нас. пункт" disabled/>
	</div>
	</td>
	</tr>
	<tr>
	<td>Вулиця: </td>
	<td colspan="3">
	<div class="border">
	<select class="sel_ad" name="vyl" readonly>
	<option value="'.$aut["VL"].'">'.$aut["VUL"].' '.$aut["TIP_VUL"].'</option>
	</select>
	<input type="button" id="bt2" value="Додати вулицю" disabled/>
	</div>
	</td>
	</tr>';
				}
else{
$pr.='<tr>
        <td>Район: </td>
        <td colspan="3">
        <div class="border">
        <select class="sel_ad" id="rayon" name="rajon" required>
        <option value="">Оберіть район</option>';
        $id_rn=''; $rajn='';
        $sql1 = "SELECT rayonu.ID_RAYONA,rayonu.RAYON FROM rayonu ORDER BY rayonu.ID_RAYONA";
         $atu1=mysql_query($sql);
         while($aut1=mysql_fetch_array($atu1))
         {
         $dl_s=strlen($aut1["RAYON"])-10;
         $n_rjn=substr($aut1["RAYON"],0,$dl_s);
         if($aut1["ID_RAYONA"] == $aut["ID_RAYONA"]){
            $pr.='<option selected value="'.$aut1["ID_RAYONA"].'">'.$n_rjn.'</option>';
         }
         else{
             $pr.='<option value="'.$aut1["ID_RAYONA"].'">'.$n_rjn.'</option>';
         }
         }
        mysql_free_result($atu1);

        $pr.='</select>
        </div>
        </td>
        </tr>
<tr>
<td>Населений пункт: </td>
<td colspan="3">
<div class="border">
<select class="sel_ad" id="nas_punkt" name="nsp" required>
<option value="">Оберіть населений пункт</option>
</select>
<input type="button" id="bt1" value="Додати нас. пункт" style="width:125px;"/>
</div>
</td>
</tr>
<tr>
<td>Вулиця: </td>
<td colspan="3">
<div class="border">
<select class="sel_ad" id="vulutsya" name="vyl" disabled="disabled" required></select>
<input type="button" id="bt2" value="Додати вулицю" style="width:125px;"/>
</div>
</td>
</tr>';}
$pr.='
<tr>
<td>Будинок: </td>
<td><input type="text" size="10" maxlength="10" name="bud" value="'.$aut["BUD"].'"'.$filter["budunok"].'/></td>
<td>Квартира: </td>
<td><input type="text" size="3" maxlength="3" name="kvar" value="'.$aut["KVAR"].'"'.$filter["kvartura"].'/></td>
</tr>
<tr>
<td>Сума: </td>
<td><input type="text" id="sm" size="20" maxlength="20" name="sum" value="'.$aut["SUM"].'"'.$filter["vartist"].'/></td>
<td>Дата прийому: </td>
<td>
    <input type="text" id="d_pr" size="10" maxlength="10" name="d_pr" value="'. german_date($aut["D_PR"]).'" readonly />
</td>
</tr>
<tr>
<td colspan="4" align="center"><input type="submit" id="submit" value="Редагувати"></td>
</tr>
</table>
</form>';
 }
 mysql_free_result($atu);

echo $pr;
?>