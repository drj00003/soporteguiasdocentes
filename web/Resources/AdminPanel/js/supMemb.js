$(document).ready(function(){

    
    // Ajustes sidebar-left
    
    // Eliminamos las etiquetas active y open provinientes del index
    var active = $(".active");
    active.removeClass('active');
    var open = $( ".open" );
    open.removeClass('open');
    // Seleccionamos los distintos niveles (Añadir open a ul -> desplegable, y active li-> elemento seleccionado )
    $('ul#Soporte').addClass('open');
    var lvl1 = $('#miembros_soporte-li');
    lvl1.addClass('active');
    var lvl2= lvl1.children('#MiembrosSoporte');
    lvl2.addClass("open");
    lvl2.children('#gestionar_miembros_soporte').addClass('active');
    
    
});