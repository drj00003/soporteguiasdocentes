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
    
    
        // Funcion de refresco JQuery
    $(function(){
        // panel refresh
        $('.panel [data-refresh]').on('click', function(){
            var $this = $(this),
                panel = $this.attr('data-refresh');

            setTimeout(function(){
                $(panel).find('.panel-progress').remove();  // remove proggress spinner
            }, 1000 );
        });


        // datatables
        $('.datatables').dataTable({
            "iDisplayLength": 5,
            "aLengthMenu": [[5, 10, 25, 50, -1], [5, 10, 25, 50, "All"]]
        });

    });    
    
    // Boton de edición

    $( ".edit" ).click(function() {
        var selector = $(this).parents('.elemento');
        var email = selector.attr('id');
        var nombre = selector.children('.nombre').text();
        var apellidos = selector.children('.apellidos').text();
        var departamento = selector.children('.departamento').text();
        

        bootbox.dialog({
                    title: "Personal de Soporte "+email,
                    message: '<div class="row">  ' +
                        '<div class="col-md-12"> ' +
                        '<form class="form-horizontal personal" method="post" action="'+window.location.pathname+'/set'+'"> ' +
                        '<div class="form-group"> ' +
                        '<label class="col-md-4 control-label" for="nombre">Nombre</label> ' +
                        '<div class="col-md-8"> ' +
                        '<input id="nombre" required="required" name="nombre"'+
                        '" value="'
                        +nombre+
                        '"placeholder="'+
                        nombre+
                        '" class="form-control"> ' +
                        '</div> ' +
                        '</div> ' +
                        '<div class="form-group"> ' +
                        '<label class="col-md-4 control-label" for="apellidos">Apellidos</label> ' +
                        '<div class="col-md-8"> ' +
                        '<input id="apellidos" required="required" name="apellidos"'+
                        '" value="'
                        +apellidos+
                        '"placeholder="'+
                        apellidos+
                        '" class="form-control"> ' +
                        '</div> ' +
                        '</div> ' +
                        '<div class="form-group"> ' +
                        '<label class="col-md-4 control-label" for="departamento">Departamento</label> ' +
                        '<div class="col-md-8"> ' +
                        '<input id="departamento" name="departamento"'+
                        '" value="'
                        +departamento+
                        '"placeholder="'+
                        departamento+
                        '" class="form-control"> ' +
                        '</div> ' +
                        '</div> ' +
                        '<input id="email" name="email" type="hidden" value="'+email+'"> ' +
                        '</form> </div>  </div>',
                    buttons: {
                        submit: {
                            label: "Actualizar",
                            className: "btn-success",
                            type: "submit",
                            callback: function () {
                                $('.personal').submit();
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
        var email = selector.attr('id');
        var nombre = selector.children('.nombre').text();
        var apellidos = selector.children('.apellidos').text();
        bootbox.dialog( {
            title: "Eliminar Registro",
            message:
                "¿Esta seguro de que desea eliminar el personal de soporte "+nombre+ ' '+apellidos+"?"+
                "La acción implicará que se elimine la tematica de soporte asociada a su perfil"+
                '<form class="personal" method="post" action="'+window.location.pathname+'/delete'+'"> ' +
                '<input id="email" name="email" type="hidden" value="'+email+'"> ' +
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