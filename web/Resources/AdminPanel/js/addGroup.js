$(document).ready(function(){
    
    // Eliminamos las etiquetas active y open provinientes del index
    var active = $(".active");
    active.removeClass('active');
    var open = $( ".open" );
    open.removeClass('open');
    // Seleccionamos los distintos niveles (Añadir open a ul -> desplegable, y active li-> elemento seleccionado )
    $('ul#FAQ').addClass('open');
    var lvl1 = $('#gruposPF-li');
    lvl1.addClass('active');
    var lvl2= lvl1.children('#GruposPF');
    lvl2.addClass("open");
    lvl2.children('#añadir_grupo').addClass('active');
    
    
    $('.select2').select2();
});