<?php
include "../function.php";
include "../scriptu.php";
?>
<style type="text/css">
   .povorot {
    -moz-transform: rotate(-90deg); /* Для Firefox */
    -ms-transform: rotate(-90deg); /* Для IE */
    -webkit-transform: rotate(-90deg); /* Для Safari, Chrome, iOS */
    -o-transform: rotate(-90deg); /* Для Opera */
    transform: rotate(-90deg);
   }
   .input_file {
        width: 24px;
        height: 24px;
        background: url('../images/plus_krug.png') no-repeat;
        cursor: pointer;
        overflow: hidden;
        padding: 0;
		float: right;
		
    }
	.input_style 
		{ 
		-moz-opacity:0; 
		cursor: pointer;
		filter:alpha(opacity=0); 
		opacity:0; 
		font-size:24px; 
		height:24px; 
		}
  </style>
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
		$("input[ name='vlasnik']").change(rdvl);
	//	$('#yurok').click(add_yurok);
	
	$('#tehpas').change(function() {
			$('#tehpas').each(function() {
				var name = this.value;
  				reWin = /.*\\(.*)/;
				var fileTitle = name.replace(reWin, "$1");
				reUnix = /.*\/(.*)/;
				fileTitle = fileTitle.replace(reUnix, "$1");
				$('#nametehpas').html(fileTitle);
			});
		});
	$('#budpas').change(function() {
			$('#budpas').each(function() {
				var name = this.value;
  				reWin = /.*\\(.*)/;
				var fileTitle = name.replace(reWin, "$1");
				reUnix = /.*\/(.*)/;
				fileTitle = fileTitle.replace(reUnix, "$1");
				$('#namebudpas').html(fileTitle);
			});
		});
	$('#prvlbud').change(function() {
			$('#prvlbud').each(function() {
				var name = this.value;
  				reWin = /.*\\(.*)/;
				var fileTitle = name.replace(reWin, "$1");
				reUnix = /.*\/(.*)/;
				fileTitle = fileTitle.replace(reUnix, "$1");
				$('#nameprvlbud').html(fileTitle);
			});
		});
	$('#homebook').change(function() {
			$('#homebook').each(function() {
				var name = this.value;
  				reWin = /.*\\(.*)/;
				var fileTitle = name.replace(reWin, "$1");
				reUnix = /.*\/(.*)/;
				fileTitle = fileTitle.replace(reUnix, "$1");
				$('#namehomebook').html(fileTitle);
			});
		});
	$('#prvlzm').change(function() {
			$('#prvlzm').each(function() {
				var name = this.value;
  				reWin = /.*\\(.*)/;
				var fileTitle = name.replace(reWin, "$1");
				reUnix = /.*\/(.*)/;
				fileTitle = fileTitle.replace(reUnix, "$1");
				$('#nameprvlzm').html(fileTitle);
			});
		});
	$('#dabi').change(function() {
			$('#dabi').each(function() {
				var name = this.value;
  				reWin = /.*\\(.*)/;
				var fileTitle = name.replace(reWin, "$1");
				reUnix = /.*\/(.*)/;
				fileTitle = fileTitle.replace(reUnix, "$1");
				$('#namedabi').html(fileTitle);
			});
		});
	$('#fizpas').change(function() {
			$('#fizpas').each(function() {
				var name = this.value;
  				reWin = /.*\\(.*)/;
				var fileTitle = name.replace(reWin, "$1");
				reUnix = /.*\/(.*)/;
				fileTitle = fileTitle.replace(reUnix, "$1");
				$('#namefizpas').html(fileTitle);
			});
		});
	$('#done').change(function() {
			$('#done').each(function() {
				var name = this.value;
  				reWin = /.*\\(.*)/;
				var fileTitle = name.replace(reWin, "$1");
				reUnix = /.*\/(.*)/;
				fileTitle = fileTitle.replace(reUnix, "$1");
				$('#namedone').html(fileTitle);
			});
		});
	$('#fizkod').change(function() {
			$('#fizkod').each(function() {
				var name = this.value;
  				reWin = /.*\\(.*)/;
				var fileTitle = name.replace(reWin, "$1");
				reUnix = /.*\/(.*)/;
				fileTitle = fileTitle.replace(reUnix, "$1");
				$('#namefizkod').html(fileTitle);
			});
		});
	$('#dtwo').change(function() {
			$('#dtwo').each(function() {
				var name = this.value;
  				reWin = /.*\\(.*)/;
				var fileTitle = name.replace(reWin, "$1");
				reUnix = /.*\/(.*)/;
				fileTitle = fileTitle.replace(reUnix, "$1");
				$('#namedtwo').html(fileTitle);
			});
		});
	$('#roms').change(function() {
			$('#roms').each(function() {
				var name = this.value;
  				reWin = /.*\\(.*)/;
				var fileTitle = name.replace(reWin, "$1");
				reUnix = /.*\/(.*)/;
				fileTitle = fileTitle.replace(reUnix, "$1");
				$('#nameroms').html(fileTitle);
			});
		});
	$('#djek').change(function() {
			$('#djek').each(function() {
				var name = this.value;
  				reWin = /.*\\(.*)/;
				var fileTitle = name.replace(reWin, "$1");
				reUnix = /.*\/(.*)/;
				fileTitle = fileTitle.replace(reUnix, "$1");
				$('#namedjek').html(fileTitle);
			});
		});
	
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

function rdvl(){
	if($("input[name='vlasnik']:checked").val()=="1") {
	$("#prvl").val('');
	$("#imvl").val('');
	$("#pbvl").val('');
	$("#dnvl").val('');
	$("#pasportvl").val('');
	}
	else {
	$("#prvl").val($("#pr").val());
	$("#imvl").val($("#im").val());
	$("#pbvl").val($("#pb").val());
	$("#dnvl").val($("#dn").val());
	$("#pasportvl").val($("#pasport").val());
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
			var rep=html.split(":",2);
			$("#sm").val(rep[0]);
			if(rep[1]!='') $("#date1").val(rep[1]);
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
		data: 'rajon2='+$("#rayon2").val()+'&nsp2='+$("#nsp2").val()+'&tup2='+$("#tup2").val(),
		dataType: "html",
		success: function(html){
			var rp=html;
			if(rp=='1'){
			$("#rayon :nth-child(1)").attr("selected", "selected");
			$("#nas_punkt").empty();
			$("#vulutsya").empty();
			$("#nas_punkt").attr("disabled","disabled");
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
		data: 'rajon3='+$("#rayon3").val()+'&nsp3='+$("#nas_punkt3").val()+'&vul3='+$("#vul3").val()+'&tup3='+$("#tup3").val(),
		dataType: "html",
		success: function(html){
			var rp=html;
			if(rp=='1'){
			$("#rayon :nth-child(1)").attr("selected", "selected");
			$("#nas_punkt").empty();
			$("#vulutsya").empty();
			$("#nas_punkt").attr("disabled","disabled");
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
Район<br>
<select class="sel_ad" id="rayon2" name="rajon2">
<option value="0">Оберіть район</option>
<?php
$id_rn=''; $rajn='';
$sql = "SELECT rayonu.ID_RAYONA,rayonu.RAYON FROM rayonu ORDER BY rayonu.ID_RAYONA";
 $atu=mysql_query($sql);
 while($aut=mysql_fetch_array($atu))
 {
 $dl_s=strlen($aut["RAYON"])-10;
 $n_rjn=substr($aut["RAYON"],0,$dl_s);
 echo '<option '.$sl[$aut["ID_RAYONA"]].' value="'.$aut["ID_RAYONA"].'">'.$n_rjn.'</option>';
 }
mysql_free_result($atu);
?>
</select></td></tr>
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
Район<br>
<select class="sel_ad" id="rayon3" name="rajon3">
<option value="0">Оберіть район</option>
<?php
$id_rn=''; $rajn='';
$sql = "SELECT rayonu.ID_RAYONA,rayonu.RAYON FROM rayonu ORDER BY rayonu.ID_RAYONA";
 $atu=mysql_query($sql);
 while($aut=mysql_fetch_array($atu))
 {
 $dl_s=strlen($aut["RAYON"])-10;
 $n_rjn=substr($aut["RAYON"],0,$dl_s);
 echo '<option '.$sl[$aut["ID_RAYONA"]].' value="'.$aut["ID_RAYONA"].'">'.$n_rjn.'</option>';
 }
mysql_free_result($atu);
?>
</select>
</td></tr>
<tr><td colspan="2">
Населений пункт: <br><select class="sel_ad" id="nas_punkt3" name="nsp3" disabled="disabled"></select>
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
<form action="add_zm.php" name="myform" method="post" enctype="multipart/form-data">
<table align="" class="zmview">
<tr><th colspan="5" style="font-size: 35px;"><b>Нове замовлення</b></th></tr>
<tr>
<td colspan="2">Тип замовлення</td>
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
<td colspan="2">ІДН замовника: </td>
<td><input type="text" id="idn" size="12" maxlength="12" name="kod" value=""/></td>
<td>ЄДРПОУ:</td>
<td><input type="text" id="edrpou" size="10" maxlength="10" name="edrpou" value="" disabled/></td>
</tr>
<tr>
<td colspan="2">ІПН:</td>
<td><input type="text" id="ipn" size="12" maxlength="12" name="ipn" value="" disabled/></td>
<td>Св-тво:</td>
<td><input type="text" id="svid" size="9" maxlength="9" name="svid" value="" disabled/></td>
</tr>
<tr>
<td colspan="2">Для оформлення: </td>
<td colspan="3">
<select id="dl_ofor" name="vud_rob" required>
<option value="">Оберіть вид робіт</option>
<?php
$sql = "SELECT id_oform,document FROM dlya_oformlennya WHERE ROB=1 ORDER BY document";
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
<td colspan="2">Терміновість</td>
<td colspan="3">
<input id="ter1" type="radio" name="term" value="1" checked/><label for="ter1">Звичайне</label>
<input id="ter2" type="radio" name="term" value="2" /><label for="ter2">Термінове</label>

<input class="trreg" id="trreg1" type="radio" name="trrg" value="1" checked disabled /><label for="trreg1">5дн.</label>
<input class="trreg" id="trreg2" type="radio" name="trrg" value="2" disabled /><label for="trreg2">2дн.</label>
<input class="trreg" id="trreg3" type="radio" name="trrg" value="3" disabled /><label for="trreg3">1дн.</label>
<input class="trreg" id="trreg4" type="radio" name="trrg" value="4" disabled /><label for="trreg4">2год.</label>
</td>
</tr>
<tr><td rowspan="6"><div class="povorot">Замовник</div></td>
<td>Прізвище (назва): </td>
<td colspan="3"><input type="text" id="pr" size="59" maxlength="150" name="priz" value="" required/></td>
</tr>
<tr>
<td>Ім'я: </td>
<td colspan="3"><input type="text" id="im" size="25" maxlength="25" name="imya" value=""/></td>
</tr>
<tr>
<td>Побатькові: </td>
<td colspan="3"><input type="text" id="pb" size="25" maxlength="25" name="pobat" value=""/></td>
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
<td>Телефон: </td>
<td colspan="3"><input type="text" id="tel" size="25" maxlength="25" name="tel" value="380"/>
E-mail:<input type="text" id="email" size="20" name="email" value=""/>
</td>
</tr>
<!--##################################-->
<tr><td rowspan="6"><div class="povorot">Власник</div></td>
<td colspan="4">
<input id="v1" type="radio" name="vlasnik" value="1" checked/><label for="v1">Інший</label>
<input id="v2" type="radio" name="vlasnik" value="2" /><label for="v2">Той самий</label>
</td>
</tr>
<tr>
<td>Прізвище (назва): </td>
<td colspan="3"><input type="text" id="prvl" size="59" maxlength="150" name="prizvl" value="" required/></td>
</tr>
<tr>
<td>Ім'я: </td>
<td colspan="3"><input type="text" id="imvl" size="25" maxlength="25" name="imyavl" value=""/></td>
</tr>
<tr>
<td>Побатькові: </td>
<td colspan="3"><input type="text" id="pbvl" size="25" maxlength="25" name="pobatvl" value=""/></td>
</tr>
<tr>
<td>Дата народження: </td>
<td colspan="3"><input type="text" id="dnvl" size="10" maxlength="10" name="dnarvl" value=""/></td>
</tr>
<tr>
<td>Паспорт: </td>
<td colspan="3"><input type="text" id="pasportvl" size="30" maxlength="30" name="pasportvl" value=""/></td>
</tr>
<!--##################################-->
<tr>
<td rowspan="6"><div class="povorot">Документи</div></td>
<td colspan="2" style="height:44px;"><input name="d1" type="checkbox" value="технічний паспорт">технічний паспорт
<div class="input_file" style="margin-top: 3px; "><input type="file" name="tehpas" size="40" class="input_style" id="tehpas"></div>
<div id="nametehpas" style="padding: 0 5px;"></div>
</td>
<td colspan="2"><input name="d12" type="checkbox" value="будівельний паспорт">будівельний паспорт
<div class="input_file" style="margin-top: 3px; "><input type="file" name="budpas" size="40" class="input_style" id="budpas"></div>
<div id="namebudpas" style="padding: 0 5px;"></div>
</td>
</tr>
<tr>
<td colspan="2" style="height:44px;"><input name="d2" type="checkbox" value="право власності на будинок">право власності на будинок
<div class="input_file" style="margin-top: 3px; "><input type="file" name="prvlbud" size="40" class="input_style" id="prvlbud"></div>
<div id="nameprvlbud" style="padding: 0 5px;"></div>
</td>
<td colspan="2"><input name="d6" type="checkbox" value="будинкова книга">будинкова книга
<div class="input_file" style="margin-top: 3px; "><input type="file" name="homebook" size="40" class="input_style" id="homebook"></div>
<div id="namehomebook" style="padding: 0 5px;"></div>
</td>
</tr>
<tr>
<td colspan="2" style="height:44px;"><input name="d3" type="checkbox" value="право власності на землю">право власності на землю
<div class="input_file" style="margin-top: 3px; "><input type="file" name="prvlzm" size="40" class="input_style" id="prvlzm"></div>
<div id="nameprvlzm" style="padding: 0 5px;"></div>
</td>
<td colspan="2"><input name="d8" type="checkbox" value="повідомлення ДАБІ">повідомлення ДАБІ
<div class="input_file" style="margin-top: 3px; "><input type="file" name="dabi" size="40" class="input_style" id="dabi"></div>
<div id="namedabi" style="padding: 0 5px;"></div>
</td>
</tr>
<tr>
<td colspan="2" style="height:44px;"><input name="d4" type="checkbox" value="паспорт">паспорт
<div class="input_file" style="margin-top: 3px; "><input type="file" name="fizpas" size="40" class="input_style" id="fizpas"></div>
<div id="namefizpas" style="padding: 0 5px;"></div>
</td>
<td colspan="2"><input name="d9" type="checkbox" value="декларація Д1">декларація Д1
<div class="input_file" style="margin-top: 3px; "><input type="file" name="done" size="40" class="input_style" id="done"></div>
<div id="namedone" style="padding: 0 5px;"></div>
</td>
</tr>
<tr>
<td colspan="2" style="height:44px;"><input name="d5" type="checkbox" value="код">код
<div class="input_file" style="margin-top: 3px; "><input type="file" name="fizkod" size="40" class="input_style" id="fizkod"></div>
<div id="namefizkod" style="padding: 0 5px;"></div>
</td>
<td colspan="2"><input name="d10" type="checkbox" value="декларація Д2">декларація Д2
<div class="input_file" style="margin-top: 3px; "><input type="file" name="dtwo" size="40" class="input_style" id="dtwo"></div>
<div id="namedtwo" style="padding: 0 5px;"></div>
</td>
</tr>
<tr>
<td colspan="2" style="height:44px;"><input name="d7" type="checkbox" value="рішення органу місцевого самоврядування">рішення органу МС
<div class="input_file" style="margin-top: 3px; "><input type="file" name="roms" size="40" class="input_style" id="roms"></div>
<div id="nameroms" style="padding: 0 5px;"></div>
</td>
<td colspan="2"><input name="d11" type="checkbox" value="довідка з ЖЕКУ">довідка з ЖЕКУ
<div class="input_file" style="margin-top: 3px; "><input type="file" name="djek" size="40" class="input_style" id="djek"></div>
<div id="namedjek" style="padding: 0 5px;"></div>
</td>
</tr>
<tr>
<td colspan="2">Інші документи: </td>
<td colspan="3"><input type="text" id="prim" size="59" name="prim" value=""/></td>
</tr>
<tr>
<td colspan="2">Доручення: </td>
<td colspan="3"><input type="text" id="doruch" size="40" maxlength="40" name="doruch" value=""/></td>
</tr>
<tr>
<td colspan="2">Район: </td>
<td colspan="3">
<div class="border">
<select class="sel_ad" id="rayon" name="rajon" required>
<option value="">Оберіть район</option>
<?php
$id_rn=''; $rajn='';
$sql = "SELECT rayonu.ID_RAYONA,rayonu.RAYON FROM rayonu ORDER BY rayonu.ID_RAYONA";
 $atu=mysql_query($sql);
 while($aut=mysql_fetch_array($atu))
 {
 $dl_s=strlen($aut["RAYON"])-10;
 $n_rjn=substr($aut["RAYON"],0,$dl_s);
 echo '<option '.$sl[$aut["ID_RAYONA"]].' value="'.$aut["ID_RAYONA"].'">'.$n_rjn.'</option>';
 }
mysql_free_result($atu);
?>
</select>
</div>
</td>
</tr>
<tr>
<td colspan="2">Населений пункт: </td>
<td colspan="3">
<div class="border">
<select class="sel_ad" id="nas_punkt" name="nsp" required>
<!--<option value="">Оберіть населений пункт</option>-->
<?php
/* $sql = "SELECT nas_punktu.ID_NSP,nas_punktu.NSP,tup_nsp.TIP_NSP 
		FROM nas_punktu,tup_nsp 
		WHERE nas_punktu.ID_TIP_NSP=tup_nsp.ID_TIP_NSP 
		ORDER BY nas_punktu.ID_TIP_NSP,NSP";
 $atu=mysql_query($sql);
 while($aut=mysql_fetch_array($atu))
 {
 echo '<option value="'.$aut["ID_NSP"].'">'.$aut["NSP"].' '.$aut["TIP_NSP"].'</option>';
 }
mysql_free_result($atu); */
?>
</select>
<input type="button" id="bt1" value="Додати нас. пункт" style="width:125px;"/>
</div>
</td>
</tr>
<tr>
<td colspan="2">Вулиця: </td>
<td colspan="3">
<div class="border">
<select class="sel_ad" id="vulutsya" name="vyl" disabled="disabled" required></select>
<input type="button" id="bt2" value="Додати вулицю" style="width:125px;"/>
</div>
</td>
</tr>
<tr>
<td colspan="2">Будинок: </td>
<td><input type="text" id="bd" size="10" name="bud" value="" required/></td>
<td>Квартира: </td>
<td><input type="text" id="kv" size="3" maxlength="3" name="kvar" value=""/></td>
</tr>
<tr>
<td colspan="2">Сума: </td>
<td><input type="text" id="sm" size="10" name="sum" value="" required/></td>
<td colspan="2">
Дата виходу: <input type="text" id="date" size="10" maxlength="10" name="datav" value=""/></td>
</tr>
<tr>
<td colspan="2">Дата готовності: </td>
<?php //$wd=work_date(date("Y-m-d",mktime(0,0,0,date("m"),date("d")+14,date("Y"))));
$wd=mis_term(date("Y-m-d",mktime(0,0,0,date("m"),date("d")+1,date("Y"))),1);?>
<td><input type="text" id="date1" size="10" maxlength="10" name="datag" value="<?php echo $wd; ?>"/></td>
<td colspan="2">Приймає: 
<input type="text" size="20" id="pr_osob" maxlength="20" name="pr_osob" value="<?php echo $pr_prie.' '.p_buk($im_prie).'.'.p_buk($pb_prie).'.'; ?>" readonly/></td>
</tr>
<tr>
<td colspan="2">Дата прийому: </td>
<td colspan="3">
<input type="text" id="d_pr" size="10" maxlength="10" name="d_pr" value="<?php echo date("d.m.Y"); ?>" disabled /></td>
</tr>
<tr>
<td colspan="3" align="center">
<div id="fizpl"><input type="submit" id="submit" value="Створити"></div>
<!--<div id="yurpl" style="display: none;"><input type="button" id="yurok" value="Додати">--></div>
</td>
<td colspan="2" align="center"><input name="reset" type="reset" id="reset" value="Очистити"></td>
</tr>
</table>
</form>