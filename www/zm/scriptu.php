<script type="text/javascript">
//---------------------------Begin select1 adress-----------------------------------------
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
  		$.getJSON("../js/cascadeSelectNsp.php",{rayon:rayonValue},function(data) { tmpSelect.fillSelect(data).attr("disabled",false); adjustVulutsya(); });
  		
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
  		$.getJSON("../js/cascadeSelectVul.php",{rayon:rayonValue,nsp:nspValue},function(data) { tmpSelect.fillSelect(data).attr("disabled",false); });
	}
  };
	
  $("#rayon").change(function(){
  	adjustNaspunkt();
  }).change();
  $("#nas_punkt").change(adjustVulutsya);
  
  
  
//---------------------------Begin select adress edit-----------------------------------------

  // вибір населеного пункту
  function adjustNaspunkte(){
  	var rayonValue = $("#rne").val();
  	var tmpSelect = $("#nspe");
	var ns_e = "<?php echo $ns; ?>";
  	if(rayonValue.length == 0) {
  		tmpSelect.attr("disabled","disabled");
  		tmpSelect.clearSelect();
  		adjustVulutsyae();
  	} else {
  		$.getJSON("../js/cascadeSelectNsp_e.php",{rayon:rayonValue,ns:ns_e},function(data) { tmpSelect.fillSelect(data).attr("disabled",false); adjustVulutsyae(); });
  		
  	}
  };
  // вибір вулиці
  function adjustVulutsyae(){
  	var rayonValue = $("#rne").val();
  	var nspValue = $("#nspe").val();
  	var tmpSelect = $("#vule");
	var vl_e = "<?php echo $vl; ?>";
  	if(rayonValue.length == 0||nspValue.length == 0) {
  		tmpSelect.attr("disabled","disabled");
  		tmpSelect.clearSelect();
  	} else {
  		$.getJSON("../js/cascadeSelectVul_e.php",{rayon:rayonValue,nsp:nspValue,vl:vl_e},function(data) { tmpSelect.fillSelect(data).attr("disabled",false); });
	}
  };
	
/*   $("#rne").change(function(){
  	adjustNaspunkte();
  }).change();
  $("#nspe").change(adjustVulutsyae); */
   $("#nspe").focus(function(){adjustNaspunkte();}); 
//---------------------------End select adress edit--------------------------------------------
  
  
  
});
//---------------------------End select1 adress--------------------------------------------
//---------------------------Begin select2 adress-----------------------------------------
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
  	var rayonValue = $("#rayon3").val();
  	var tmpSelect = $("#nas_punkt3");
  	if(rayonValue.length == 0) {
  		tmpSelect.attr("disabled","disabled");
  		tmpSelect.clearSelect();
  		adjustVulutsya();
  	} else {
  		$.getJSON("../js/cascadeSelectNsp.php",{rayon:rayonValue},function(data) { tmpSelect.fillSelect(data).attr("disabled",false); adjustVulutsya(); });
  		
  	}
  };
  // вибір вулиці
  function adjustVulutsya(){
  	var rayonValue = $("#rayon3").val();
  	var nspValue = $("#nas_punkt3").val();
  	var tmpSelect = $("#vulutsya3");
  	if(rayonValue.length == 0||nspValue.length == 0) {
  		tmpSelect.attr("disabled","disabled");
  		tmpSelect.clearSelect();
  	} else {
  		$.getJSON("../js/cascadeSelectVul.php",{rayon:rayonValue,nsp:nspValue},function(data) { tmpSelect.fillSelect(data).attr("disabled",false); });
	}
  };
	
  $("#rayon3").change(function(){
  	adjustNaspunkt();
  }).change();
  $("#nas_punkt3").change(adjustVulutsya);
});
//---------------------------End select2 adress--------------------------------------------
//---------------------------Begin autozap----------------------------------------
$(document).ready(function(){
function liFormat (row, i, num) {
	var result = row[0];
	return result;
}
// --- Автозаповнення ---
$("#idn").autocomplete("../js/idn.php", {
	delay:10,
	minChars:2,
	matchSubset:1,
	autoFill:true,
	matchContains:1,
	cacheLength:10,
	selectFirst:true,
	formatItem:liFormat,
	maxItemsToShow:30,
}); 
});
//---------------------------End autozap-------------------------------------------
//---------------------Begin autozap robitnuk----------------------------------
$(document).ready(function(){
function liFormat (row, i, num) {
	var result = row[0];
	return result;
}
// --- Автозаповнення ---
$("#vu").autocomplete("../js/robitnuk.php", {
	delay:10,
	minChars:2,
	matchSubset:1,
	autoFill:true,
	matchContains:1,
	cacheLength:10,
	selectFirst:true,
	formatItem:liFormat,
	maxItemsToShow:30,
}); 
}); 
//------------------------End autozap robitnuk---------------------------------
//---------------------Begin autozap robitnuk----------------------------------
$(document).ready(function(){
function liFormat (row, i, num) {
	var result = row[0];
	return result;
}
// --- Автозаповнення ---
$("#prm").autocomplete("../js/robitnuk.php", {
	delay:10,
	minChars:2,
	matchSubset:1,
	autoFill:true,
	matchContains:1,
	cacheLength:10,
	selectFirst:true,
	formatItem:liFormat,
	maxItemsToShow:30,
}); 
}); 
//------------------------End autozap robitnuk---------------------------------
//---------------------Begin autozap robitnuk----------------------------------
$(document).ready(function(){
function liFormat (row, i, num) {
	var result = row[0];
	return result;
}
// --- Автозаповнення ---
$("#arh").autocomplete("../js/robitnuk.php", {
	delay:10,
	minChars:2,
	matchSubset:1,
	autoFill:true,
	matchContains:1,
	cacheLength:10,
	selectFirst:true,
	formatItem:liFormat,
	maxItemsToShow:30,
}); 
}); 
//------------------------End autozap robitnuk---------------------------------
//---------------------Begin autozap robitnuk----------------------------------
$(document).ready(function(){
function liFormat (row, i, num) {
	var result = row[0];
	return result;
}
// --- Автозаповнення ---
$("#cmp").autocomplete("../js/robitnuk.php", {
	delay:10,
	minChars:2,
	matchSubset:1,
	autoFill:true,
	matchContains:1,
	cacheLength:10,
	selectFirst:true,
	formatItem:liFormat,
	maxItemsToShow:30,
}); 
}); 
//------------------------End autozap robitnuk---------------------------------
//---------------------Begin autozap robitnuk----------------------------------
$(document).ready(function(){
function liFormat (row, i, num) {
	var result = row[0];
	return result;
}
// --- Автозаповнення ---
$("#rees").autocomplete("../js/robitnuk.php", {
	delay:10,
	minChars:2,
	matchSubset:1,
	autoFill:true,
	matchContains:1,
	cacheLength:10,
	selectFirst:true,
	formatItem:liFormat,
	maxItemsToShow:30,
}); 
}); 
//------------------------End autozap robitnuk---------------------------------
//------------------------Begin masked input--------------------------------------
jQuery(function($){  
    $("#date").mask("99.99.9999");  
    $("#date1").mask("99.99.9999");
    $("#date2").mask("99.99.9999");
    $("#phone").mask("99-99-99");  
    $("#tin").mask("99-9999999");  
    $("#ssn").mask("999-99-9999");  
}); 
//------------------------End masked input--------------------------------------
</script>