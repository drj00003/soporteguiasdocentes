$(document).ready(function(){
    // $('#data').dataTable( {
    //         "language": {
    //             "url": "dataTables.spanish.lang"
    //         }
    //     } );
    // } );
    
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
        /** variation datatables style
        $('.datatables').dataTable({"sPaginationType": "bs_normal"});
        $('.datatables').dataTable({"sPaginationType": "bs_two_button"});
        $('.datatables').dataTable({"sPaginationType": "bs_four_button"});
        $('.datatables').dataTable({"sPaginationType": "bs_full"});
        */
    });    
    
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
    


// Boton de edición

    $( ".edit" ).click(function() {
        var selector = $(this).parents('.elemento');
        var id_grupo_perfil = selector.attr('id');
        var nombre = selector.children('.nombre').text();
        var perfil = selector.children('.perfil').text();
        var orden = selector.children('.orden').text();
        var s = $("<select  name=\"perfil\" />");
        $.each(perfiles,function(key, value){
            if (value==perfil){
                $("<option />", {value: value, text: value, selected:true}).appendTo(s);    
            }else{
                $("<option />", {value: value, text: value}).appendTo(s);
            }
        });
        bootbox.dialog({
                    title: "Grupo "+nombre,
                    message: '<div class="row">  ' +
                        '<div class="col-md-12"> ' +
                        '<form class="form-horizontal grupo_perfil" method="post" action="'+window.location.pathname+'/set'+'"> ' +
                        '<div class="form-group"> ' +
                        '<label class="col-md-4 control-label" for="perfil">Perfil</label> ' +
                        '<div class="col-md-4"> ' +
                        '<select id="perfil" required="required" name="perfil" class="form-control">' +
                        s.html() +
                        '</select>'+
                        '</div> ' +
                        '</div> ' +
                        '<div class="form-group"> ' +
                        '<label class="col-md-4 control-label" for="nombre">Nombre</label> ' +
                        '<div class="col-md-4"> ' +
                        '<input id="name" required="required" name="nombre" type="text" placeholder="'
                        +nombre+ 
                        '" value="'
                        +nombre+
                        '"class="form-control input-md"> ' +
                        '</div> ' +
                        '</div> ' +
                        '<div class="form-group"> ' +
                        '<label class="col-md-4 control-label" for="orden">Orden</label> ' +
                        '<div class="col-md-4"> ' +
                        '<input id="name" required="required" name="orden" type="text" placeholder="'
                        +orden+
                        '" value="'
                        +orden+
                        '"class="form-control input-md"> ' +
                        '</div> ' +
                        '</div> ' +
                        '<input id="id_grupo_perfil" name="id_grupo_perfil" type="hidden" value="'+id_grupo_perfil+'"> ' +
                        '</form> </div>  </div>',
                    buttons: {
                        submit: {
                            label: "Actualizar",
                            className: "btn-success",
                            type: "submit",
                            callback: function () {
                                $('.grupo_perfil').submit();
                                $('.col-md-12').append('<span class="alert">La consulta ha sido envida </span>');
                                // var name = $('#name').val();
                                // var answer = $("input[name='awesomeness']:checked").val()
                                // Example.show("Hello " + name + ". You've chosen <b>" + answer + "</b>");
                            }
                        },
                        "Cancelar": {
                            className: "btn-danger close",
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
        var id_grupo_perfil = selector.attr('id');
        var nombre = selector.children('.nombre').text();
        var perfil = selector.children('.perfil').text();
        var orden = selector.children('.orden').text();
        bootbox.dialog( {
            title: "Eliminar registro",
            message:
                "¿Esta seguro de que desea eliminar el grupo "+nombre+"?"+
                '<form class="grupo_perfil" method="post" action="'+window.location.pathname+'/delete'+'"> ' +
                '<input id="id_grupo_perfil" name="id_grupo_perfil" type="hidden" value="'+id_grupo_perfil+'"> ' +
                '</form>',
            buttons: {
                submit: {
                    label: "Aceptar",
                    className: "btn-success",
                    type: "submit",
                    callback: function (result) {
                        $('.grupo_perfil').submit();
                    
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