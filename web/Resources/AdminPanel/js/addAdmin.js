$(document).ready(function(){

    
    // Ajustes sidebar-left
    
    // Eliminamos las etiquetas active y open provinientes del index
    var active = $(".active");
    active.removeClass('active');
    var open = $( ".open" );
    open.removeClass('open');
    // Seleccionamos los distintos niveles (Añadir open a ul -> desplegable, y active li-> elemento seleccionado )
    $('ul#Administrador').addClass('open');
    var lvl1 = $('#Administrador-li');
    lvl1.addClass('active');
    var lvl2= lvl1.children('#Administrador');
    lvl2.addClass("open");
    lvl2.children('#añadir_administrador').addClass('active');
    
    
});