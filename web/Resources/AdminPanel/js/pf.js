$(document).ready(function(){

    
    // Ajustes sidebar-left
    
    // Eliminamos las etiquetas active y open provinientes del index
    var active = $(".active");
    active.removeClass('active');
    var open = $( ".open" );
    open.removeClass('open');
    // Seleccionamos los distintos niveles (Añadir open a ul -> desplegable, y active li-> elemento seleccionado )
    $('ul#FAQ').addClass('open');
    var lvl1 = $('#preguntas_frecuentes-li');
    lvl1.addClass('active');
    var lvl2= lvl1.children('#PreguntasFrecuentes');
    lvl2.addClass("open");
    lvl2.children('#gestionar_pf').addClass('active');
    
    // Fin sidebar-left
    
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
            // "aaSorting": [[ 3, "desc" ]],
            "iDisplayLength": 7,
            "aLengthMenu": [[5, 10, 25, 50, -1], [5, 10, 25, 50, "All"]],
"columns": [ { "width": "25px" }, { "width": "25px" }, { "width": "450px" }, { "width": "20px" }, { "width": "20px" }, { "width": "20px" }, { "width": "20px" } ],
        });
    //         $('.datatables').dataTable({
    //             "iDisplayLength": 25,
    //             "bDestroy": true,
    //             "bJQueryUI": true,
    //             "sPaginationType": "full_numbers",
    //             "bAutoWidth": false
    // });

    });    

    
    // Json para obtener los grupos de soporte defindos para los perfiles
    var group = [];
    // $.getJSON('https://soporteguiasdocentes-utesting.c9users.io/web/app_dev.php/groups/getProfiles')
     $.getJSON(window.location.pathname+'/getGroup')
    .done( function( response ) {
        //done() es ejecutada cuándo se recibe la respuesta del servidor. response es el objeto JSON recibido
        if( response.success ) {
            // $.each(response.data, function(key, value){
            //     group.push(value);
            // });
            group = response.data;
        }
    });    
    





// Boton de edición

    $( ".edit" ).click(function() {
        var selector = $(this).parents('.elemento');
        var id_pf = selector.attr('id');
        var pregunta = selector.children('.pregunta').text();
        var respuesta = selector.children('.respuesta').text();
        var grupo = selector.children('.grupo').text();
        var habilitada = selector.children('.habilitada').text();
        var orden = selector.children('.orden').text();
        
        var s = $("<select  name=\"grupo\" />");
        $.each(group,function(key, value){
            $("<optgroup />", {label: key}).appendTo(s);
            $.each (value, function(k,v){
                $("<option />", {value:k, text: v}).appendTo(s);    
            })
        });
        // Será necesario añadir comillas a pregunta y respuesta ya que incorporan etiquetas html que serían interpretadas en el navegador sin estas
        bootbox.dialog({
                    title: "Pregunta Frecuente",
                    message: '<div class="row">  ' +
                        '<div class="col-md-12"> ' +
                        '<form class="form-horizontal pf" method="post" action="'+window.location.pathname+'/set'+'"> ' +
                        '<div class="form-group"> ' +
                        '<label class="col-md-4 control-label" for="grupo_soporte">Grupo Soporte</label> ' +
                        '<div class="col-md-8"> ' +
                        '<select id="grupo" required="required" name="grupo" class="form-control">' +
                        s.html() +
                        '</select>'+
                        '</div> ' +
                        '</div> ' +
                        '<div class="form-group"> ' +
                        '<label class="col-md-4 control-label" for="pregunta">Pregunta</label> ' +
                        '<div class="col-md-8"> ' +
                        '<textarea id="pregunta" required="required" name="pregunta"'+
                        '" rows="7" cols="7" class="form-control">'+
                        '"'+pregunta+'"</textarea>'+
                        '</div> ' +
                        '</div> ' +
                        '<div class="form-group"> ' +
                        '<label class="col-md-4 control-label" for="respuesta">Respuesta</label> ' +
                        '<div class="col-md-8"> ' +
                        '<textarea id="respuesta" required="required" name="respuesta"' +
                        '" rows="7" cols="7" class="form-control">' +
                        '"'+respuesta+'"</textarea>'+
                        '<div id="inform-comillas" class="alert alert-info alert-icon">'+
                        '<a href="#"  class="close" data-dismiss="alert" aria-label="close">&times;</a>'+
                        'Por favor introduzca el texto separado por comillas.'+
                        '</div>'+
                        '</div> ' +
                        '</div> ' +
                        '<div class="form-group"> ' +
                        '<label class="col-md-4 control-label" for="habilitada">Habilitada</label> ' +
                        '<div class="col-md-8"> ' +
                        '<input id="habilitada" name="habilitada" type="checkbox" value="'+ 
                        +habilitada+ 
                        '" checked="'+
                        habilitada+
                        '">'+
                        '</div> ' +
                        '</div> ' +
                        '<div class="form-group"> ' +
                        '<label class="col-md-4 control-label" for="orden">Orden</label> ' +
                        '<div class="col-md-8"> ' +
                        '<input id="orden" required="required" name="orden" type="number" placeholder="'
                        +orden+
                        '" value="'
                        +orden+
                        '"class="form-control input-md"> ' +
                        '</div> ' +
                        '</div> ' +
                        '<input id="id_pf" name="id_pf" type="hidden" value="'+id_pf+'"> ' +
                        '</form> </div>  </div>',
                    buttons: {
                        submit: {
                            label: "Actualizar",
                            className: "btn-success",
                            type: "submit",
                            callback: function () {
                                // Eliminamos las comillas de inicio y fin para que no persistan el BBDD
                                var val = $('textarea#pregunta').val();
                                $('textarea#pregunta').val(val.substring(2, val.length-2));
                                var val = $('textarea#respuesta').val();
                                $('textarea#respuesta').val(val.substring(2, val.length-2));
                                $('.pf').submit();

                                $('.col-md-12').append('<span class="alert">La pf ha sido editada </span>');
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
        var id_pf = selector.attr('id');
        bootbox.dialog( {
            title: "Eliminar registro",
            message:
                "¿Esta seguro de que desea eliminar la pregunta frecuente?"+
                '<form class="pf" method="post" action="'+window.location.pathname+'/delete'+'"> ' +
                '<input id="id_pf" name="id_pf" type="hidden" value="'+id_pf+'"> ' +
                '</form>',
            buttons: {
                submit: {
                    label: "Aceptar",
                    className: "btn-success",
                    type: "submit",
                    callback: function (result) {
                        $('.pf').submit();
                    
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


    //Menu
    

    
});