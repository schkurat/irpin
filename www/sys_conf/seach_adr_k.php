<script type="text/javascript">
(function($){
  // очищаем select
  $.fn.clearSelect = function() {
	  return this.each(function(){
		  if(this.tagName=="SELECT") {
		      this.options.length = 0;
		      $(this).attr("disabled","disabled");
		  }
	  });
  }
  // заполняем select
  $.fn.fillSelect = function(dataArray) {
	  return this.clearSelect().each(function(){
		  if(this.tagName=="SELECT") {
			  var currentSelect = this;
			  $.each(dataArray,function(index,data){
				  var option = new Option(data.text,data.value);
				  if($.support.cssFloat) {
					  currentSelect.add(option,null);
				  } else {
					  currentSelect.add(option);
				  }
			  });
		  }
	  });
  }
})(jQuery);

$(document).ready(function(){

  // вибір населеного пункту
  function adjustNaspunkt(){
  	var rayonValue = $("#rayon").val();
  	var tmpSelect = $("#nas_punkt");
  	if(rayonValue.length == 0) {
  		tmpSelect.attr("disabled","disabled");
  		tmpSelect.clearSelect();
  		adjustVulutsya();
  	} else {
  		$.getJSON("js/cascadeSelectNsp.php",{rayon:rayonValue},function(data) { tmpSelect.fillSelect(data).attr("disabled",false); adjustVulutsya(); });
  		
  	}
  };
  // вибір вулиці
  function adjustVulutsya(){
  	var rayonValue = $("#rayon").val();
  	var nspValue = $("#nas_punkt").val();
  	var tmpSelect = $("#vulutsya");
  	if(rayonValue.length == 0||nspValue.length == 0) {
  		tmpSelect.attr("disabled","disabled");
  		tmpSelect.clearSelect();
  	} else {
  		$.getJSON("js/cascadeSelectVul.php",{rayon:rayonValue,nsp:nspValue},function(data) { tmpSelect.fillSelect(data).attr("disabled",false); });
	}
  };
	
  $("#rayon").change(function(){
  	adjustNaspunkt();
  }).change();
  $("#nas_punkt").change(adjustVulutsya);
  
});
</script>
<form action="admin.php" name="myform" method="get">
<table align="center" class="zmview">
<tr><th colspan="4" align="center">Пошук по за адресою</th></tr>
<tr>
<td>Район: </td>
<td colspan="3">
<div class="border">
<select class="sel_ad" id="rayon" name="rajon">
<option value="">Оберіть район</option>
<option value="КР">Кременчуцький</option>
<option value="КО">Козельщинський</option>
<option value="КМ">Комсомольський</option>
<option value="КБ">Кобеляцький</option>
<option value="ГЛ">Глобинський</option>
</select>
</div>
</td>
</tr>
<tr>
<td>Населений пункт: </td>
<td colspan="3">
<div class="border">
<select class="sel_ad" id="nas_punkt" name="nsp" disabled="disabled"></select>
</div>
</td>
</tr>
<tr>
<td>Вулиця: </td>
<td colspan="3">
<div class="border">
<select class="sel_ad" id="vulutsya" name="vyl" disabled="disabled"></select>
</div>
</td>
</tr>
<tr>
<td>Будинок: </td>
<td><input type="text" size="10" maxlength="10" name="bud" value=""/></td>
<td>Корпус: </td>
<td><input type="text" size="3" maxlength="3" name="kor" value=""/></td>
</tr>
<tr>
<td>Квартира: </td>
<td><input type="text" size="3" maxlength="3" name="kv" value=""/>
<input name="filter" type="hidden" value="kart_view" />
<input name="rj_saech" type="hidden" value="adr" />
</td>
<td>Кім.: </td>
<td><input type="text" size="3" maxlength="3" name="kim" value=""/></td>
</tr>

<tr><td colspan="2" align="center">
<input name="Ok" type="submit" value="Пошук" /></td>
</form><form action="find.php?filter=logo" name="myform" method="post">
<td colspan="2" align="center">
<input name="Cancel" type="submit" value="Відміна" />
</form>
</td>
</tr>
</table>