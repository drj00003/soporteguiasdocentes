$(document).ready(function(){

    
    // Ajustes sidebar-left
    
    // Eliminamos las etiquetas active y open provinientes del index
    var active = $(".active");
    active.removeClass('active');
    var open = $( ".open" );
    open.removeClass('open');
    // Seleccionamos los distintos niveles (Añadir open a ul -> desplegable, y active li-> elemento seleccionado )
    $('ul#FAQ').addClass('open');
    var lvl1 = $('#grupos_soporte-li');
    lvl1.addClass('active');
    var lvl2= lvl1.children('#GruposSoporte');
    lvl2.addClass("open");
    lvl2.children('#gestionar_grupos_soporte').addClass('active');

    // Json para obtener los perfiles defindos para los grupos de PF
    var perfiles = [];
    // $.getJSON('https://soporteguiasdocentes-utesting.c9users.io/web/app_dev.php/groups/getProfiles')
     $.getJSON(window.location.pathname+'/getProfiles')
    .done( function( response ) {
        //done() es ejecutada cuándo se recibe la respuesta del servidor. response es el objeto JSON recibido
        if( response.success ) {
            $.each(response.data, function(key, value){
                perfiles.push(value);
            });
        }
    });   


    $( ".edit" ).click(function() {
        var selector = $(this).parents('.elemento');
        var id_grupo_soporte_perfil = selector.attr('id');
        var nombre = selector.children('.nombre').text();
        var pregunta = selector.children('.pregunta').text();
        var respuesta = selector.children('.respuesta').text();
        var habilitada = selector.children('.habilitada').text();
        var perfil = selector.children('.perfil').text();
        

        var s = $("<select  name=\"perfil\" />");
        $.each(perfiles,function(key, value){
            if (value==perfil){
                $("<option />", {value: value, text: value, selected:true}).appendTo(s);    
            }else{
                $("<option />", {value: value, text: value}).appendTo(s);
            }
        });
        bootbox.dialog({
                    title: "Grupo Soporte"+ nombre,
                    message: '<div class="row">  ' +
                        '<div class="col-md-12"> ' +
                        '<form class="form-horizontal grupos_soporte_has_perfil" method="post" action="'+window.location.pathname+'/set'+'"> ' +
                        '<div class="form-group"> ' +
                        '<label class="col-md-4 control-label" for="perfil">Perfil</label> ' +
                        '<div class="col-md-8"> ' +
                        '<select id="perfil" required="required" name="perfil" class="form-control">' +
                        s.html() +
                        '</select>'+
                        '</div> ' +
                        '</div> ' +
                        '<div class="form-group"> ' +
                        '<label class="col-md-4 control-label" for="nombre">Nombre</label> ' +
                        '<div class="col-md-8"> ' +
                        '<input id="nombre" required="required" name="nombre" placeholder="'+
                        nombre+
                        '" value="'
                        +nombre+
                        '" class="form-control"> ' +
                        '</div> ' +
                        '</div> ' +
                        '<div class="form-group"> ' +
                        '<label class="col-md-4 control-label" for="pregunta">Pregunta</label> ' +
                        '<div class="col-md-8"> ' +
                        '<textarea id="pregunta" required="required" name="pregunta"' +
                        '" value="'
                        +pregunta+
                        '" rows="7" cols="7" class="form-control"> ' +
                        '"'+pregunta+
                        '"</textarea>'+
                        '</div> ' +
                        '</div> ' +
                        '<div class="form-group"> ' +
                        '<label class="col-md-4 control-label" for="respuesta">Respuesta</label> ' +
                        '<div class="col-md-8"> ' +
                        '<textarea id="respuesta" required="required" name="respuesta"' +
                        '" value="'+
                        '" rows="7" cols="7" class="form-control"> ' +
                        '"'+respuesta+
                        '"</textarea>'+
                        '</div> ' +
                        '</div> ' +
                        '<div class="form-group"> ' +
                        '<label class="col-md-4 control-label" for="habilitada">Habilitada</label> ' +
                        '<div class="checkbox"> ' +
                        '<input id="habilitada" name="habilitada" type="checkbox" value="'+ 
                        +habilitada+ 
                        '" class="form-control" checked>'+
                        '</div> ' +
                        '</div> ' +
                        '<input id="id_grupo_soporte_perfil" name="id_grupo_soporte_perfil" type="hidden" value="'+id_grupo_soporte_perfil+'"> ' +
                        '</form> </div>  </div>',
                    buttons: {
                        submit: {
                            label: "Actualizar",
                            className: "btn-success",
                            type: "submit",
                            callback: function () {
                                $('.grupo_soporte_has_perfil').submit();
                                $('.col-md-12').append('<span class="alert">El grupo de Soporte ha sido actualizado con exito </span>');
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
        var id_grupo_soporte_perfil = selector.attr('id');
        var nombre = selector.children('.nombre').text();
        bootbox.dialog( {
            title: "Eliminar registro",
            message:
                "¿Esta seguro de que desea eliminar el grupo de soporte"+ nombre+ "?"+
                '<form class="grupo_soporte_has_perfil" method="post" action="'+window.location.pathname+'/delete'+'"> ' +
                '<input id="id_grupo_soporte_perfil" name="id_grupo_soporte_perfil" type="hidden" value="'+id_grupo_soporte_perfil+'"> ' +
                '</form>',
            buttons: {
                submit: {
                    label: "Aceptar",
                    className: "btn-success",
                    type: "submit",
                    callback: function (result) {
                        $('.grupo_soporte_has_perfil').submit();
                    
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
    // Fin botón borrado



});