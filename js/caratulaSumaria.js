$(document).ready(function(){
	$("#obraSocial").change(function(){
		$.post(
			"cargarPeriodo.php",
			{id:$(this).val()},
			function(data){
				$("#periodo").attr('value', data);
			});
		$.post(
			"cargarBonificacion.php",
			{idOS:$(this).val(), idFar:$("#idFar").val()},
			function(data){
				if(data !== ''){
					$("#bonificacion").attr('value', data);
					$("table tr.hide").show();
				}else{
					$("table tr.hide").hide();
				}
			});
		$.post(
			"cargarGrillaPlanes.php",
			{idOS:$(this).val()},
			function(data){
				$("#grid").html(data);
			});
	return false;
	});
	$("#enviar").click(function() {
		$("#grillaPlanes").val($("<div>").append( $("#grid").eq(0).clone(true)).html());
	});
	$("#lnkPrint").click(function(){
		$("#succesBlock").hide();
		$("div.subtit2").hide();
		$("div.imprimir").hide();
		$("#main2").jqprint();
		return false;
	});
});