<?php
include "../function.php";
include "../scriptu.php";
?>
<script type="text/javascript">
$(document).ready(function(){
		$('#idn').bind('blur',net_fokusa);
		$('#edrpou').bind('blur',vst_yur);
		$('#dl_ofor').change(s_vart);
		$('#bt1').click(ShowElement);
		$('#bt2').click(HideElement);
		$('input.bt').click(HideElement_cancel);
		$("input[ name='pdv']").change(nalog);
		$("input[ name='vud_zam']").change(radio_click).change(terminovist);
		$("input[ name='term']").change(terminovist).change(s_vart);
		$("input[ name='trrg']").change(terminovist).change(s_vart);
		/* $('#dodat').change(function(){ 
			var nsm=parseInt($("#sm").val())+parseInt($("#dodat").val());
			$("#sm").val(nsm);
		}); */
		$('#add_ns').click(add_nsp);
		$('#add_vl').click(add_vul);
	//	$('#yurok').click(add_yurok);
		}); 
function radio_click(){
	if($("input[name='vud_zam']:checked").val()=="1") {
	$("#idn").attr("disabled",false);
	$("#im").attr("disabled",false);
	$("#pb").attr("disabled",false);
	$("#dn").attr("disabled",false);
	$("#pasport").attr("disabled",false);
	$("#edrpou").attr("disabled","disabled");
	$("#ipn").attr("disabled","disabled");
	$("#svid").attr("disabled","disabled");
	$("#pdv1").attr("disabled","disabled");
	$("#pdv2").attr("disabled","disabled");
	$("#d_pr").attr("disabled","disabled");
/* 	$("#yurpl").fadeOut();
	$("#fizpl").fadeIn(); */
	}
	else {
	$("#idn").attr("disabled","disabled");
	$("#im").attr("disabled","disabled");
	$("#pb").attr("disabled","disabled");
	$("#dn").attr("disabled","disabled");
	$("#pasport").attr("disabled","disabled");
	$("#edrpou").attr("disabled",false);
	$("#ipn").attr("disabled","disabled");
	$("#svid").attr("disabled","disabled");
	$("#pdv1").attr("disabled",false);
	$("#pdv2").attr("disabled",false);
	$("#pdv1").attr("checked","checked");
	$("#ipn").attr("disabled",false);
	$("#svid").attr("disabled",false);
	$("#d_pr").attr("disabled",false);
/* 	$("#fizpl").fadeOut();
	$("#yurpl").fadeIn(); */
	}
} 

/* function add_yurok(eventObj){
$.ajax({
	type: "POST",
	url: "add_yurok.php",
	data: 'vud_zam='+ $("input[name='vud_zam']:checked").val()+
	'&pdv='+ $("input[name='pdv']:checked").val()+'&term='+ $("input[name='term']:checked").val()+
	'&kod='+ $("#idn").val()+'&vud_rob='+$("#dl_ofor option:selected").val()+
	'&priz='+ $("#pr").val()+
	'&imya='+ $("#im").val()+
	'&pobat='+ $("#pb").val()+
	'&prim='+ $("#prim").val()+
	'&dnar='+ $("#dn").val()+
	'&pasport='+ $("#pasport").val()+
	'&edrpou='+ $("#edrpou").val()+
	'&ipn='+ $("#ipn").val()+
	'&svid='+ $("#svid").val()+
	'&doruch='+ $("#doruch").val()+
	'&email='+ $("#email").val()+
	'&nsp='+ $("#nas_punkt option:selected").val()+
	'&vyl='+ $("#vulutsya option:selected").val()+
	'&bud='+ $("#bd").val()+
	'&kvar='+ $("#kv").val()+
	'&sum='+ $("#sm").val()+
	'&datav='+ $("#date").val()+
	'&datag='+ $("#date1").val()+
	'&pr_osob='+ $("#pr_osob").val()+
	'&d_pr='+ $("#d_pr").val(),
	dataType: "html",
	success: function(html){
		var msg=html;
		alert(msg);
	},
	error: function(html){alert(html.error);}
});								
} */
function terminovist(){
	if($("input[name='term']:checked").val()=="1") {
		$(".trreg").attr("disabled","disabled");
	$.ajax({
		type: "POST",
		url: "terminovist.php",
		data: 'ter='+1+'&vud='+$("input[name='vud_zam']:checked").val()+'&vr='+$("#dl_ofor").val(),
		dataType: "html",
		success: function(html){
			var dtg=html;
			$("#date1").val(dtg);
		},
		error: function(html){alert(html.error);}
	});	
	}
	else {
	if($("#dl_ofor option:selected").val()=="21") {$(".trreg").attr("disabled",false);}
	$.ajax({
		type: "POST",
		url: "terminovist.php",
		data: 'ter='+2+'&vud='+$("input[name='vud_zam']:checked").val()+'&terrg='+$("input[name='trrg']:checked").val(),
		dataType: "html",
		success: function(html){
			var dtg=html;
			$("#date1").val(dtg);
		},
		error: function(html){alert(html.error);}
	});	
	}
} 						
function net_fokusa(eventObj){
	$.ajax({
		type: "POST",
		url: "test_idn.php",
		data: 'kod='+ $("#idn").val(),
		dataType: "html",
		success: function(html){
			var reply=html.split(":",4);
			$("#pr").val(reply[0]);
			$("#im").val(reply[1]);
			$("#pb").val(reply[2]);
			$("#dn").val(reply[3]);
		},
		error: function(html){alert(html.error);}
	});								
}
function vst_yur(eventObj){
	$.ajax({
		type: "POST",
		url: "yur_kl.php",
		data: 'edrpou='+ $("#edrpou").val(),
		dataType: "html",
		success: function(html){
			var reply=html.split(":",5);
			$("#pr").val(reply[0]);
			$("#ipn").val(reply[1]);
			$("#svid").val(reply[2]);
			$("#tel").val(reply[3]);
			$("#email").val(reply[4]);
		},
		error: function(html){alert(html.error);}
	});								
}
function s_vart(eventObj){
	if($("#dl_ofor option:selected").val()=="21" && $("input[name='term']:checked").val()=="2") $(".trreg").attr("disabled",false);
	else $(".trreg").attr("disabled","disabled");
	$.ajax({
		type: "POST",
		url: "var_rob.php",
		data: 'vr='+ $("#dl_ofor").val()+'&ter='+$("input[name='term']:checked").val()+'&terrg='+$("input[name='trrg']:checked").val(),
		dataType: "html",
		success: function(html){
			var rep=html.split(":",3);
			$("#sm").val(rep[0]);
			if(rep[1]!='') $("#date1").val(rep[1]);
			$("#admzbir").val(rep[2]);
		},	
		error: function(html){alert(html.error);}
	});
}
function nalog(eventObj){
	if($("input[name='pdv']:checked").val()=="1"){
		$("#edrpou").attr("disabled",false);
		$("#ipn").attr("disabled",false);
		$("#svid").attr("disabled",false);
	}
	else {
		$("#edrpou").attr("disabled",false);
		$("#ipn").attr("disabled","disabled");
		$("#svid").attr("disabled","disabled");
	}
}
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

<body>
<div id="add_nas_punkt">
<table>
<tr><th colspan="2">Додавання нового нас. пункту</th></tr>
<tr><td colspan="2">
Назва населеного пункту<br><input type="text" id="nsp2" name="nsp2" value="" style="width:200px;"/><br>
Тип населеного пункту<br>
<select id ="tup2" name="tup2" class="sel_ad">
<option value="0">Оберіть тип</option>
<?php
$sql = "SELECT tup_nsp.ID_TIP_NSP,tup_nsp.TIP_NSP FROM tup_nsp ORDER BY tup_nsp.ID_TIP_NSP";
$atu=mysql_query($sql);
 while($aut=mysql_fetch_array($atu))
 {echo '<option value="'.$aut["ID_TIP_NSP"].'">'.$aut["TIP_NSP"].'</option>';}
mysql_free_result($atu);
?>
</select>
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
<option value="">Оберіть населений пункт</option>
<?php
$sql = "SELECT nas_punktu.ID_NSP,nas_punktu.NSP,tup_nsp.TIP_NSP 
		FROM nas_punktu,tup_nsp 
		WHERE nas_punktu.ID_TIP_NSP=tup_nsp.ID_TIP_NSP 
		ORDER BY nas_punktu.ID_NSP";
 $atu=mysql_query($sql);
 while($aut=mysql_fetch_array($atu))
 {
 echo '<option value="'.$aut["ID_NSP"].'">'.$aut["NSP"].' '.$aut["TIP_NSP"].'</option>';
 }
mysql_free_result($atu);
?>
</select>
</td></tr>
<tr><td colspan="2">
Назва<br><input type="text" size="25" id="vul3" name="vul3" value="" style="width:200px"/>
</td></tr>
<tr><td colspan="2">
Тип<br>
<select id="tup3" name="tup3" class="sel_ad">
<option value="0">Оберіть тип</option>
<?php
$sql = "SELECT tup_vul.ID_TIP_VUL,tup_vul.TIP_VUL FROM tup_vul ORDER BY tup_vul.ID_TIP_VUL";
$atu=mysql_query($sql);
 while($aut=mysql_fetch_array($atu))
 {echo '<option value="'.$aut["ID_TIP_VUL"].'">'.$aut["TIP_VUL"].'</option>';}
mysql_free_result($atu);
?>
</select>
</td></tr>
<tr><td align="center">
<input type="button" id="add_vl" name="ok" style="width:80px;margin-top:15px;" value="Ок">
</td><td align="center">
<input type="button" class="bt" style="width:80px;margin-top:15px;" value="Вiдмiна">
</td></tr>
</table>
</div>
<form action="add_zm.php" name="myform" method="post">
<table align="" class="zmview">
<tr><th colspan="4" style="font-size: 35px;"><b>Нове замовлення</b></th></tr>
<tr>
<td>Тип замовлення</td>
<td>
<input id="r1" type="radio" name="vud_zam" value="1" checked/><label for="r1">Фізичне</label><br>
<input id="r2" type="radio" name="vud_zam" value="2" /><label for="r2">Юридичне</label></td>
<td align="center">ПДВ</td>
<td>
<input id="pdv1" type="radio" name="pdv" value="1" checked disabled/><label for="pdv1">платник ПДВ</label><br>
<input id="pdv2" type="radio" name="pdv" value="2" disabled/><label for="pdv2">не платник ПДВ</label>
</td>
</tr>
<tr>
<td>ІДН замовника: </td>
<td><input type="text" id="idn" size="12" maxlength="12" name="kod" value=""/></td>
<td>ЄДРПОУ:</td>
<td><input type="text" id="edrpou" size="10" maxlength="10" name="edrpou" value="" disabled/></td>
</tr>
<tr>
<td>ІПН:</td>
<td><input type="text" id="ipn" size="12" maxlength="12" name="ipn" value="" disabled/></td>
<td>Св-тво:</td>
<td><input type="text" id="svid" size="9" maxlength="9" name="svid" value="" disabled/></td>
</tr>
<tr>
<td>Для оформлення: </td>
<td colspan="3">
<select id="dl_ofor" name="vud_rob" required>
<option value="">Оберіть вид робіт</option>
<?php
$sql = "SELECT id_oform,document FROM dlya_oformlennya WHERE ROB=1 AND id_oform>20 ORDER BY document";
 $atu=mysql_query($sql);
 while($aut=mysql_fetch_array($atu))
 {
 echo '<option value="'.$aut["id_oform"].'">'.$aut["document"].'</option>';
 }
mysql_free_result($atu);
?>
</select>
</td>
</tr>
<tr>
<td>Терміновість</td>
<td colspan="3">
<input id="ter1" type="radio" name="term" value="1" checked/><label for="ter1">Звичайне</label>
<input id="ter2" type="radio" name="term" value="2" /><label for="ter2">Термінове</label>

<input class="trreg" id="trreg1" type="radio" name="trrg" value="1" checked disabled /><label for="trreg1">5дн.</label>
<input class="trreg" id="trreg2" type="radio" name="trrg" value="2" disabled /><label for="trreg2">2дн.</label>
<input class="trreg" id="trreg3" type="radio" name="trrg" value="3" disabled /><label for="trreg3">1дн.</label>
<input class="trreg" id="trreg4" type="radio" name="trrg" value="4" disabled /><label for="trreg4">2год.</label>
</td>
</tr>
<tr>
<td>Прізвище (назва): </td>
<td colspan="3"><input type="text" id="pr" size="59" maxlength="150" name="priz" value="" required/></td>
</tr>
<tr>
<td>Ім'я: </td>
<td colspan="3"><input type="text" id="im" size="25" name="imya" value=""/></td>
</tr>
<tr>
<td>Побатькові: </td>
<td colspan="3"><input type="text" id="pb" size="25" name="pobat" value=""/></td>
</tr>
<tr>
<td>Назва об'єкту: </td>
<td colspan="3"><input type="text" id="nobj" size="59" name="nobj" value=""/></td>
</tr>
<tr>
<td>Примітка: </td>
<td colspan="3"><input type="text" id="prim" size="59" name="prim" value=""/></td>
</tr>
<tr>
<td>Дата народження: </td>
<td colspan="3"><input type="text" id="dn" size="10" maxlength="10" name="dnar" value=""/></td>
</tr>
<tr>
<td>Паспорт: </td>
<td colspan="3"><input type="text" id="pasport" size="30" maxlength="30" name="pasport" value=""/></td>
</tr>
<tr>
<td>Доручення: </td>
<td colspan="3"><input type="text" id="doruch" size="59" name="doruch" value=""/></td>
</tr>
<tr>
<td>Телефон: </td>
<td colspan="3"><input type="text" id="tel" size="25" maxlength="25" name="tel" value="380"/>
E-mail:<input type="text" id="email" size="20" name="email" value=""/>
</td>
</tr>
<tr>
<td>Населений пункт: </td>
<td colspan="3">
<div class="border">
<select class="sel_ad" id="nas_punkt" name="nsp" required>
<option value="">Оберіть населений пункт</option>
<?php
$sql = "SELECT nas_punktu.ID_NSP,nas_punktu.NSP,tup_nsp.TIP_NSP 
		FROM nas_punktu,tup_nsp 
		WHERE nas_punktu.ID_TIP_NSP=tup_nsp.ID_TIP_NSP 
		ORDER BY nas_punktu.ID_TIP_NSP,NSP";
 $atu=mysql_query($sql);
 while($aut=mysql_fetch_array($atu))
 {
 echo '<option value="'.$aut["ID_NSP"].'">'.$aut["NSP"].' '.$aut["TIP_NSP"].'</option>';
 }
mysql_free_result($atu);
?>
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
</tr>
<tr>
<td>Будинок: </td>
<td><input type="text" id="bd" size="10" name="bud" value="" required/></td>
<td>Квартира: </td>
<td><input type="text" id="kv" size="3" maxlength="3" name="kvar" value=""/></td>
</tr>
<tr>
<td>Сума: </td>
<td><input type="text" id="sm" size="10" name="sum" value="" required/></td>
<td>Адмін збір:</td>
<td><input type="text" id="admzbir" size="10" name="admzbir" value="" radonly/></td>
</tr>
<tr>
<td>Дата готовності: </td>
<?php //$wd=work_date(date("Y-m-d",mktime(0,0,0,date("m"),date("d")+14,date("Y"))));
$wd=mis_term(date("Y-m-d",mktime(0,0,0,date("m"),date("d")+1,date("Y"))),1);?>
<td><input type="text" id="date1" size="10" maxlength="10" name="datag" value="<?php echo $wd; ?>"/></td>
<td>Приймає:</td> 
<td><input type="text" size="20" id="pr_osob" maxlength="20" name="pr_osob" value="<?php echo $pr_prie.' '.p_buk($im_prie).'.'.p_buk($pb_prie).'.'; ?>" readonly/></td>
</tr>
<tr>
<td>Дата прийому: </td>
<td>
<input type="text" id="d_pr" size="10" maxlength="10" name="d_pr" value="<?php echo date("d.m.Y"); ?>" /></td>
<td colspan="2">
Реєстраційний №
<input type="text" id="nree" size="8" maxlength="8" name="nree" value="" required /></td>
</tr>
<tr>
<td colspan="2" align="center">
<div id="fizpl"><input type="submit" id="submit" value="Створити"></div>
<!--<div id="yurpl" style="display: none;"><input type="button" id="yurok" value="Додати">--></div>
</td>
<td colspan="2" align="center"><input name="reset" type="reset" id="reset" value="Очистити"></td>
</tr>
</table>
</form>