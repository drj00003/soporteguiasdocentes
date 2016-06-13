$(document).ready(function(){

    // Eliminamos las etiquetas active y open provinientes del index
    var active = $(".active");
    active.removeClass('active');
    var open = $( ".open" );
    open.removeClass('open');
    // Seleccionamos los distintos niveles (Añadir open a ul -> desplegable, y active li-> elemento seleccionado )
    var lvl1 = $('#informes-li');
    lvl1.addClass('active');
    
    $('.select2').select2();
    
    
});