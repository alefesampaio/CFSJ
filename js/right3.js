$(document).ready(function() {
$("input:submit, input:button").button();
$("input:radio").buttonset();
$("#loading").hide();
$("#main2 a").click(function () {
     $("#right")
     .ajaxStart(function(){ $("#loaderDiv").show();  })
     .load($(this).attr('href'))
     .ajaxStop(function(){ $("#loaderDiv").hide(); })
     return false;
});
$('form').submit(function() {  // Enviamos el formulario usando AJAX
        $.ajax({
            type: 'POST',
            url: $(this).attr('action'),
            data: $(this).serialize(),
            success: function(data) { // Mostramos un mensaje con la respuesta de PHP
                $('#right').fadeIn("slow").html(data);
            }
        })        
        return false;
}); 
return false;
})  
	
	
	
	
	
 