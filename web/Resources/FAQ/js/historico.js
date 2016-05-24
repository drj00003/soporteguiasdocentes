$(document).ready(function(){

// Javascript para la gestion de menus desplegables en grupos y pf.
  $(".respuesta").hide();
   $("dt.pregunta").click(function(event){
             var desplegable = $(this).siblings('.respuesta');
             $('.respuesta').not(desplegable).slideUp('fast');
              desplegable.slideToggle('fast');
              event.preventDefault();
    })
    

});