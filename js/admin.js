function tab(pos,cant) {
	for (n=1;n<=cant;n++) {
		if (n == pos) {
			document.getElementById("tab_"+n).className = "selected";
			document.getElementById("block_"+n).className = "";
		} else {
			document.getElementById("tab_"+n).className = "";
			document.getElementById("block_"+n).className = "hide";
		}
	}
}
function dropDown(name,arrow) {
	var el = document.getElementById(name);
	arrow = document.getElementById(arrow);
	if (el.className == "hide") {
		el.className = "";
		arrow.className = "ar_drop2";
	} else {
		el.className = "hide";
		arrow.className = "ar_drop";
	}
}
function hideError(el) {
	el.className = "inputtext";
}
function upAction(id, valor, act) {
	if (valor != 0) {
		window.location = "?act="+act+"&id="+id+"&estado="+valor;
	}
}
function repAction(id, valor, act) {
	if (valor != 0) {
		if (valor == "enviarmsg") {
			var msg=prompt("Escribe mensaje adicional:","");
			valor += "&msg="+msg;
		}
		if (id!="check") {
			id = "&id="+id;
		} else {
			id = '';
		}
		$("#form_rep").attr("action","reportes?act="+act+id+"&accion="+valor).submit();
	}
}
function uploadAction(id, valor, act) {
	if (valor != 0) {
		if (valor == "noaprobado") {
			var msg=prompt("Escribe una razón (opcional):","");
			valor += "&msg="+msg;
		}
		window.location = "?act="+act+"&id="+id+"&accion="+valor;
	}
}
function Inint_AJAX() {
   try { return new ActiveXObject('Msxml2.XMLHTTP');  } catch(e) {} //IE
   try { return new ActiveXObject('Microsoft.XMLHTTP'); } catch(e) {} //IE
   try { return new XMLHttpRequest();          } catch(e) {} //Native Javascript
   alert('XMLHttpRequest no soportado');
   return null;
};

function dochange(src, val, url) {
	 var req = Inint_AJAX();
	 req.onreadystatechange = function () { 
		  if (req.readyState==4) {
			   if (req.status==200) {
				   if (document.getElementById(src)) {
						document.getElementById(src).innerHTML=req.responseText; //retuen value
				   }
			   } 
		  }
	 };
	 req.open('GET', url+'?data='+src+'&val='+val); //make connection
	 req.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded;charset=iso-UTF-8'); // set Header
	 req.send(null); //send value
}
function list(valor1, atributo1, valor2, atributo2) {
	
	window.location = "?"+atributo1+"="+valor1+"&"+atributo2+"="+valor2;
}
function listame(act, valor, tipo){
	window.location = "?act="+act+"&user="+valor+"&subtipo="+tipo;
}
function getMoretipo(el) {
	if (el.value == "serie") {
		document.getElementById("list_series").style.display = "table-row";
		document.getElementById("list_shows").style.display = "none";
	} else {
		document.getElementById("list_shows").style.display = "table-row";
		document.getElementById("list_series").style.display = "none";
	}
}
function imgCoord(img, selection) {
    $('#x1').val(selection.x1);
    $('#y1').val(selection.y1);
    $('#x2').val(selection.x2);
    $('#y2').val(selection.y2);   
}
function getTipoVivo(el) {
	if (el.value == "custom") {
		document.getElementById("in_customhtml").style.display = "table-row";
		document.getElementById("in_canalid").style.display = "none";
	} else {
		document.getElementById("in_canalid").style.display = "table-row";
		document.getElementById("in_customhtml").style.display = "none";
	}
}

function delTrailerN(id){
	$("#"+id).remove();
}


function addTrailer() {
	var t = $("#trailers"), l = $("tr",t).length-1, newt = l+1;
	$("#trailer_sample").clone().attr('id', 'trailer_'+newt).appendTo(t);
	t.append($("#trailer_add"));
	
	var ta = $("#trailer_"+newt);	
	$(".ref",ta).html("Trailer ID #"+newt);
	
	$("input[name=trailer_id[]]",ta).remove();	
	$("a.dele",ta).remove();
	$("input[name=trailer_yid[]]",ta).val("").focus();
	$("input[name=trailer_n[]]",ta).val("");
}
function addSource() {
	var sr = $("#sources"), l = $("tr",sr).length-1, newl = l+1;
	$("#source_sample").clone().attr('id','source_'+newl).appendTo(sr);
	sr.append($("#source_add"));
	
	var sa = $("#source_"+newl);
	$(".ref",sa).html("Fuente Mega ID #"+newl);
	
	$("input[name=fuente_id[]]",sa).remove();
	$(".uploader",sa).remove();
	$("a.del",sa).remove();
	$("input[name=fuente[]]",sa).val("").focus();
}
function delSourceN(id) {
	$("#"+id).remove();
}
function delTrailer(id,pos){
	if(pos==1) pos = 'sample';
	$("a.dele",$("#trailer_"+pos)).html("Eliminado...");
	$.ajax({
		url: 'ajax/trailer_del.php',
		type: 'POST',
		data: {id:id},
		success: function() {
			delTrailerGet(id,pos);
			},
			error: function() {
				$("a.dele",$("#trailer_"+pos)).html("Error");
			}
	});
	}
function delSource(id,pos) {
	if (pos==1) pos = 'sample';
	$("a.del",$("#source_"+pos)).html("Eliminando...");
	$.ajax({
		url: 'ajax/fuente_del.php',
		type: 'POST',
		data: {id:id},
		success: function() {
			delSourceGet(id,pos);
		},
		error: function() {
			$("a.del",$("#source_"+pos)).html("Error");
		}
	});
}
function delTrailerGet(id,pos) {
	var t = $("#trailers"), l = $("tr",t).length-1, newt = l+1;
	if (l==1) {
		if (pos==1) pos = 'sample';
		var ta = $("#trailer_"+pos);
		ta.attr('id','trailer_sample');
		$(".ref",ta).html("Trailer ID #1");
		$("input[name=trailer_id[]]",ta).remove();
		$("input[name=trailer_n[]]",ta).val("");
		$("input[name=trailer_yid[]]",ta).val("");
	} else {
		$("#trailer_"+pos).remove();
		if (pos==1) $('tr',t).eq(0).attr('id','trailer_sample');
	}
}

function delSourceGet(id,pos) {
	var sr = $("#sources"), l = $("tr",sr).length-1, newl = l+1;
	if (l==1) {
		if (pos==1) pos = 'sample';
		var sa = $("#source_"+pos);
		sa.attr('id','source_sample');
		$(".ref",sa).html("Fuente Mega ID #1");
		$("input[name=fuente_id[]]",sa).remove();
		$(".uploader",sa).remove();
		$("input[name=fuente[]]",sa).val("");
	} else {
		$("#source_"+pos).remove();
		if (pos==1) $('tr',sr).eq(0).attr('id','source_sample');
	}
}
function selectAll() {
	$("input[name=id[]]").attr("checked","checked").each(function(){
		$(this).parent().parent().addClass("check");
	});
}
function deselectAll() {
	$("input[name=id[]]").attr("checked",null).each(function(){
		$(this).parent().parent().removeClass("check");
	});
}
function selAllbyId(id) {
	$("table tr td.id").each(function() {
		var t = $(this);
		if (t.text()==id) {
			$("input[name=id[]]",t.parent()).attr("checked","checked");
			t.parent().addClass("check");
		} else {
			$("input[name=id[]]",t.parent()).attr("checked",null);
			t.parent().removeClass("check");
		}
	});
}
function selAllbySubtype(id) {
	$("table tr td.subtype").each(function() {
		var t = $(this);
		if (t.text()==id) {
			$("input[name=id[]]",t.parent()).attr("checked","checked");
			t.parent().addClass("check");
		} else {
			$("input[name=id[]]",t.parent()).attr("checked",null);
			t.parent().removeClass("check");
		}
	});

}
function selAllbyType(id) {
	$("table tr td.subtype").each(function() {
		var t = $(this);
		if (t.text()==id) {
			$("input[name=id[]]",t.parent()).attr("checked","checked");
			t.parent().addClass("check");
		} else {
			$("input[name=id[]]",t.parent()).attr("checked",null);
			t.parent().removeClass("check");
		}
	});
}