$(document).ready(function(){
	$("#mandataria").change(function(){
		$.post(
			"cargar_os.php",
			{id_mandataria:$(this).val()},
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