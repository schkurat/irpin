<?php
	echo "<div id=\"list_ray\" class=\"conteiner_list\" >";
	//$content = "<form name=\"ajax_form\" id=\"ajax_form\" >";
	//$content .= "<select name=\"rayon\" onchange=\"sendAjaxForm('list_nsp','ajax_form','get_nsp.php');\">";
	//$content .= "<option value=\"0\">Оберіть район</option>";
	$content = "";
	$sql="SELECT * FROM `rayonu` ";
	$atu=mysql_query($sql);
	while($aut=mysql_fetch_array($atu))
	{
		//$content .= "<option value=\"".$aut["ID_RAYONA"]."\">".$aut["RAYON"]."</option>";
		$content .= "<div style=\"cursor:pointer; \" onclick=\"sendAjaxForm('list_nsp', '".$aut["ID_RAYONA"]."','get_nsp.php');\">".$aut["RAYON"]."</div>";

	}
	mysql_free_result($atu);
	$content .= "</select></form>";
	echo $content;
	echo "</div>";
	echo "<div id=\"list_nsp\"   class=\"conteiner_list\" ></div>";
	echo "<div id=\"list_vul\"   class=\"conteiner_list\" ></div>";
	/*echo "<div id=\"list_bdkv\"  class=\"conteiner_list\" ></div>";*/
?>

 <script>

		function sendAjaxForm(result_form, val, url) {
          jQuery.ajax({
            url:     url, 
            type:     "POST", 
            dataType: "html", 
            //data: jQuery("#"+ajax_form).serialize(),  
			 data: {"rayon":val}, 
            success:  function(response) { 
            	document.getElementById(result_form).innerHTML = response;//document.getElementById(result_form).innerHTML.replace(',', ', '+result.name+', ');
				document.getElementById("list_vul").innerHTML = "";
        	},
        	error: function(response) { 
        		document.getElementById(result_form).innerHTML = "Ошибка.";
        	}
		})
	};
	
	function sendAjaxForm2(result_form, val, url) {
			//alert(val);
          jQuery.ajax({
            url:     url, 
            type:     "POST", 
            dataType: "html", 
            data: {"nsp":val},  
            success:  function(response) { 
            	//result = jQuery.parseJSON(response);
            	document.getElementById(result_form).innerHTML = response;//document.getElementById(result_form).innerHTML.replace(',', ', '+result.name+', ');
        	},
        	error: function(response) { 
        		document.getElementById(result_form).innerHTML = "Ошибка.";
        	}
		})
	}
	function sendAjaxForm3(type,idval,val, ajax_form, url) {
          jQuery.ajax({
            url:     url, 
            type:     "POST", 
            dataType: "html", 
            data: jQuery("#"+ajax_form).serialize(),  
            success:  function(response) { 
            	//result = jQuery.parseJSON(response);
            	//document.getElementById(result_form).innerHTML = response;//document.getElementById(result_form).innerHTML.replace(',', ', '+result.name+', ');
				var idcont = document.getElementById(idval).value;
				var tp = document.getElementById('type_'+type).options[document.getElementById('type_'+type).selectedIndex];
				document.getElementById(type+idcont).innerHTML = tp.text+' '+document.getElementById(val).value;
				document.getElementById('contNsp').style.display = 'none';
				document.getElementById('contVul').style.display = 'none';
        	},
        	error: function(response) { 
				alert('err');
        		document.getElementById(result_form).innerHTML = "Ошибка.";
        	}
		})
	}
	function sendAjaxForm4 (result_form, val, url) {
          jQuery.ajax({
            url:     url, 
            type:     "POST", 
            dataType: "html", 
            data:  {"id":val}, //jQuery("#"+ajax_form).serialize(),  
            success:  function(response) { 
            	//result = jQuery.parseJSON(response);
            	 document.getElementById(result_form).innerHTML = response;//document.getElementById(result_form).innerHTML.replace(',', ', '+result.name+', ');
				//var idcont = document.getElementById(idval).value;
				//document.getElementById(type+idcont).innerHTML = document.getElementById(val).value;
				//document.getElementById('contNsp').style.display = 'none';
				//document.getElementById('contVul').style.display = 'none';
        	},
        	error: function(response) { 
				alert('err');
        		document.getElementById(result_form).innerHTML = "Ошибка.";
        	}
		})
	}
	
	function showWindEditNsp(idnsp,nsp){
		document.getElementById('contNsp').style.display = 'block';
		document.getElementById('nsp').value = nsp;
		document.getElementById('idNsp').value = idnsp;
		typensp(idnsp);
	}
	function showWindEditVul(idvul,vul){
		document.getElementById('contVul').style.display = 'block';
		document.getElementById('vul').value = vul;
		document.getElementById('idVul').value = idvul;
		typevul(idvul);
	}
	function typensp(idnsp){
		var data0 = [	
			{id: "1",	value:"с."},
			{id: "2",	value:"м."},
			{id: "3",	value:"смт."},
			{id: "4",	value:"СТ"},
			{id: "5",	value:"ГК"},
			{id: "6",	value:"OK"}
			]
		var typeid=document.getElementById('nsp_'+idnsp).value;
		nspEl = document.querySelector('#type_nsp')
		data0.forEach(function(item, i, arr) {
			var sel = item.id==typeid;
			nspEl.options[i] = new Option(item.value, item.id, false, sel);
		})
		

	}
	function typevul(idvul){
		var data1 = [
				{id: "1",	value:"вул."},
				{id: "2",	value:"пров."},
				{id: "3",	value:"просп."},
				{id: "4",	value:"бульв."},
				{id: "5",	value:"пл."},
				{id: "6",	value:"тупик"},
				{id: "8",	value:"проїзд"},
				{id: "11",	value:"набер."}
				]	
		var typeid=document.getElementById('vul_'+idvul).value;
		vulEl = document.querySelector('#type_vul')
		data1.forEach(function(item, i, arr) {
			var sel = item.id==typeid;
			vulEl.options[i] = new Option(item.value, item.id, false, sel);
		})
	}
	
	
</script>

<div class="win_edit" id="contVul">
	<div class="inner_win_edit">
		<form name="vulForm" id="vulForm">
			<input type="text" name="vul" id="vul" value="vul" class="text_win">
			<input type="hidden" name="idVul" id="idVul" value="0">
			<select name="type_vul" id="type_vul">
				
			</select>
			<input type="button" value="Зберегти" class="left" onclick="sendAjaxForm3('vul','idVul','vul','vulForm','edit_vul.php');">
			<input type="button" value="Відміна" onclick="document.getElementById('contVul').style.display = 'none';" class="right">
		</form>
	</div>
</div>
<div class="win_edit" id="contNsp">
	<div class="inner_win_edit" >
		<form name="nspForm" id="nspForm">
			<input type="text" name="nsp" id="nsp" value="nsp" class="text_win">
			<input type="hidden" name="idNsp" id="idNsp" value="0">
			<select name="type_nsp" id="type_nsp">
				
			</select>
			<input type="button" value="Зберегти" class="left" onclick="sendAjaxForm3('nsp','idNsp','nsp','nspForm','edit_nsp.php');">
			<input type="button" value="Відміна" onclick="document.getElementById('contNsp').style.display = 'none';" class="right">
		</form>
	</div>
</div>