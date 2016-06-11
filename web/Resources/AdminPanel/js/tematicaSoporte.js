$(document).ready(function(){

    // Ajustes sidebar-left
    
    // Eliminamos las etiquetas active y open provinientes del index
    var active = $(".active");
    active.removeClass('active');
    var open = $( ".open" );
    open.removeClass('open');
    // Seleccionamos los distintos niveles (Añadir open a ul -> desplegable, y active li-> elemento seleccionado )
    $('ul#Soporte').addClass('open');
    var lvl1 = $('#tematica_soporte-li');
    lvl1.addClass('active');
    var lvl2= lvl1.children('#TematicaSoporte');
    lvl2.addClass("open");
    lvl2.children('#gestionar_tematica_soporte').addClass('active');
    
    
    var personales = [];
    // $.getJSON('https://soporteguiasdocentes-utesting.c9users.io/web/app_dev.php/groups/getProfiles')
     $.getJSON(window.location.pathname+'/getPersonales')
    .done( function( response ) {
        //done() es ejecutada cuándo se recibe la respuesta del servidor. response es el objeto JSON recibido
        if( response.success ) {
            $.each(response.data, function(key, value){
                personales.push(value);
            });
        }
    });  
    
    
    $( ".edit" ).click(function() {
        var selector = $(this).parents('.elemento');
        var id_tematica_soporte = selector.attr('id');
        var enunciado = selector.children('.enunciado').text();
        var orden = selector.children('.orden').text();
        var personal = selector.children('.personal').text();
        var s = $("<select  name=\"grupo_soporte\" />");
        $.each(personales,function(key, value){
            if (value==personal){
                $("<option />", {value: key, text: value, selected:true}).appendTo(s);    
            }else{
                $("<option />", {value: key, text: value}).appendTo(s);
            }
        });
        

        bootbox.dialog({
                    title: "Temática de Soporte "+enunciado,
                    message: '<div class="row">  ' +
                        '<div class="col-md-12"> ' +
                        '<form class="form-horizontal tematica_soporte" method="post" action="'+window.location.pathname+'/set'+'"> ' +
                        '<div class="form-group"> ' +
                        '<label class="col-md-4 control-label" for="personal">Personal de Soporte</label> ' +
                        '<div class="col-md-4"> ' +
                        '<select id="personal" required="required" name="personal" class="form-control">' +
                        s.html() +
                        '</select>'+
                        '</div> ' +
                        '</div> ' +
                        '<div class="form-group"> ' +
                        '<label class="col-md-4 control-label" for="enunciado">Enunciado</label> ' +
                        '<div class="col-md-8"> ' +
                        '<textarea id="enunciado" required="required" name="enunciado"'+
                        '" value="'
                        +enunciado+
                        '" rows="7" cols="7" class="form-control"> ' +
                        '"'+enunciado+
                        '"</textarea>'+
                        '</div> ' +
                        '</div> ' +
                        '<div class="form-group"> ' +
                        '<label class="col-md-4 control-label" for="orden">Orden</label> ' +
                        '<div class="col-md-8"> ' +
                        '<input type="number" id="orden" required="required" name="orden"'+
                        '" value="'
                        +orden+
                        '"placeholder="'+
                        orden+
                        '" class="form-control"> ' +
                        '</div> ' +
                        '</div> ' +
                        '<input id="id_tematica_soporte" name="id_tematica_soporte" type="hidden" value="'+id_tematica_soporte+'"> ' +
                        '</form> </div>  </div>',
                    buttons: {
                        submit: {
                            label: "Actualizar",
                            className: "btn-success",
                            type: "submit",
                            callback: function () {
                                $('.tematica_soporte').submit();
                                $('.col-md-12').append('<span class="alert">El miembro de soporte ha sido editado con exito </span>');
                                // var name = $('#name').val();
                                // var answer = $("input[name='awesomeness']:checked").val()
                                // Example.show("Hello " + name + ". You've chosen <b>" + answer + "</b>");
                            }
                        },
                        "Cancelar": {
                            className: "btn-danger",
                            callback: function() {
                                bootbox.hideAll();
                            }
                        }
                    }
                }
            );
    });// Fin boton edición
    
    //Boton Borrado
    $( ".remove" ).click(function() {
        var selector = $(this).parents('.elemento');
        var id_tematica_soporte = selector.attr('id');
        var enunciado = selector.children('.enunciado').text();
        bootbox.dialog( {
            title: "Eliminar Registro",
            message:
                "¿Esta seguro de que desea eliminar tematica de soporte "+enunciado+ "?"+
                '<form class="personal" method="post" action="'+window.location.pathname+'/delete'+'"> ' +
                '<input id="email" name="email" type="hidden" value="'+id_tematica_soporte+'"> ' +
                '</form>',
            buttons: {
                submit: {
                    label: "Aceptar",
                    className: "btn-success",
                    type: "submit",
                    callback: function (result) {
                        $('.personal').submit();
                    
                    }
                },
                "Cancelar": {
                    className: "btn-danger",
                    callback: function() {
                        bootbox.hideAll();
                    }
                }
            }
        }); 
    });
    
});