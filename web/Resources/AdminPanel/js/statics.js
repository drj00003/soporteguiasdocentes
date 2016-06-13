$(document).ready(function(){

    // Eliminamos las etiquetas active y open provinientes del index
    var active = $(".active");
    active.removeClass('active');
    var open = $( ".open" );
    open.removeClass('open');
    // Seleccionamos los distintos niveles (Añadir open a ul -> desplegable, y active li-> elemento seleccionado )
    var lvl1 = $('#estadisticas-li');
    lvl1.addClass('active');
    
    // $('#revenue-chart').hide();
    
    var data1 = [];
     $.getJSON('https://soporteguiasdocentes-utesting.c9users.io/web/admin/getNumConsultasByMonth')
    .done( function( response ) {
        //done() es ejecutada cuándo se recibe la respuesta del servidor. response es el objeto JSON recibido
        if( response.success ) {
            $.each(response.data, function(key, value){
                data1.push({
                dates: key,
                sales: value
                })
             });
            }
    }); 
    
    

    $(function () {
        
        $('#año').click(function(){
            // $('#revenue-chart').show();
            console.log($(this).text());
                data1,
                revenueChart = Morris.Line({
                    element: 'revenue-chart',
                    data: data1,
                    lineColors: ['#3498db'],
                    gridTextColor: '#34495e',
                    pointFillColors: ['#3498db'],
                    xkey: 'dates',
                    ykeys: ['sales'],
                    labels: ['Sales'],
                    barRatio: 0.4,
                    hideHover: 'auto'
                });
        
                // update data on content or window resize
                var update = function(){
                    revenueChart.redraw();
                }
        
                // handle chart responsive on toggle .content
                $(window).on('resize', function(){
                    update();
                })
                $('#toggle-aside').on('click', function(){
                    // update chart after transition finished
                    $("#content").bind("transitionend webkitTransitionEnd oTransitionEnd MSTransitionEnd", function(){
                        update();
                        $(this).unbind();
                    });
                })
                $('#toggle-content').on('click', function(){
                    update();
                })
                // end chart
        
        
        
                // todo list
                $('.icheck').iCheck({
                    checkboxClass: 'icheckbox_flat-green',
                    radioClass: 'iradio_flat-green',
                    increaseArea: '20%' // optional
                }).on('ifChanged', function(){
                    var $this = $(this),
                        todo = $(this).parent().parent().parent();
        
                    todo.toggleClass('todo-marked');
                    todo.find('.label').toggleClass('label-success');
                });
        
        });
    });
});