$(document).ready(function(){

// Javascript para la gestion del ancho de los enlaces dentro de la respuesta frecuentes
    var ancho_bloque = $('.respuesta').width();
    $('.respuesta a').each(function(){
        if ($(this).width()> ancho_bloque){
            $(this).css("display","block");
            $(this).css("width", "100%");
        }
    });
    
// Javascript para la gestion de menus desplegables en grupos y pf.
  	$("dd.respuesta").hide();
   $("dt.pregunta").click(function(event){
             var desplegable = $(this).next();
             $('dd.respuesta').not(desplegable).slideUp('fast');
              desplegable.slideToggle('fast');
              event.preventDefault();
    })
    $("dd.pfgrupo").hide();
    $("dt.grupo").click(function(event){
             var desplegable = $(this).next();
             $('dd.pfgrupo').not(desplegable).slideUp('fast');
              desplegable.slideToggle('fast');
              event.preventDefault();
    })
    

});