$(document).ready(function(){
	$("#obraSocial").change(function(){
		$.post(
			"cargarPlanes.php",
			{ id:$(this).val() },
			function(data){
				$("#plan").html(data);
			});
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
				} else {
					$("table tr.hide").hide();
				}
				});
		return false;
	});
	$("#lnkPrint").click(function(){
		$("#succesBlock").hide();
		$("div.subtit2").hide();
		$("div.imprimir").hide();
		$("#main2").jqprint();
		return false;
	});
	$("#cargoEntidad").change(function(){
		$.post(
			"calcularNeto.php",
			{cargoEntidad:$(this).val(), bonificacion:$("#bonificacion").val(), importe:$("#importe").val()},
			function(data){
				$("#neto").attr('value', data);
		});
	return false;
	});
});