$(document).ready(function() {
$("input:submit.ui-jQuery, input:button.ui-jQuery, a.ui-jQuery").button();
$("input:radio.ui-jQuery").buttonset();
$("#loading").hide();
$("#main2 a.here").click(function () {
     $("#right")
     .ajaxStart(function(){ $("#loaderDiv").show();  })
     .load($(this).attr('href'))
     .ajaxStop(function(){ $("#loaderDiv").hide(); })
     return false;
});
$('form.ajax').submit(function() {  // Enviamos el formulario usando AJAX
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
	
	
	
	
	
 