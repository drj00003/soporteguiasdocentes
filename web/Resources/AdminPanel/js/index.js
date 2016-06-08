// $(document).ready(function(){
    
    
  

    // console.log($.getJSON(window.location.pathname+'/getNumConsultasByMonth')
    // .done());
    
    
    // $(function(){
            // var year =new Date().getFullYear();
            // var data1=[];
            // $.ajax({
            //     type: "GET",
            //     url: "admin/getNumConsultasByMonth",
            //     dataType: 'json',
            //     success: function(response){
            //         $.each(response.data, function(key, value){
            //             // console.log("entro", response.data);
            //         data1.push({
            //         dates: key,
            //         sales: value
            //     });
            // });
            //     }
            // })
    //         var data1 = [];
    //  $.getJSON(window.location.pathname+'/getNumConsultasByMonth')
    // .done( function( response ) {
    //     //done() es ejecutada cuándo se recibe la respuesta del servidor. response es el objeto JSON recibido
    //     if( response.success ) {
    //         $.each(response.data, function(key, value){
    //                 // console.log("entro", response.data);
    //             data1.push({
    //             dates: key,
    //             sales: value
    //             })
    //          });
    //         }
    // });    
    //         console.log(data1);
    
    
//       var data1 = [
//                 {dates: '2013-10-30', sales: 236},
//                 {dates: '2013-10-31', sales: 137},
//                 {dates: '2013-11-01', sales: 275},
//                 {dates: '2013-11-02', sales: 380},
//                 {dates: '2013-11-03', sales: 655},
//                 {dates: '2013-11-04', sales: 571}
//             ],
//             // data1,
//             revenueChart = Morris.Line({
//                 element: 'revenue-chart',
//                 data: data1,
//                 lineColors: ['#3498db'],
//                 gridTextColor: '#34495e',
//                 pointFillColors: ['#3498db'],
//                 xkey: 'dates',
//                 ykeys: ['sales'],
//                 labels: ['Sales'],
//                 barRatio: 0.4,
//                 hideHover: 'auto'
//             });
//             // update data on content or window resize
//             var update = function(){
//                 revenueChart.redraw();
//             }
    
//             // handle chart responsive on toggle .content
//             $(window).on('resize', function(){
//                 update();
//             })
//             $('#toggle-aside').on('click', function(){
//                 // update chart after transition finished
//                 $("#content").bind("transitionend webkitTransitionEnd oTransitionEnd MSTransitionEnd", function(){
//                     update();
//                     $(this).unbind();
//                 });
//             })
//             $('#toggle-content').on('click', function(){
//                 update();
//             })
//             // end chart
    
    
    
//             // todo list
//             $('.icheck').iCheck({
//                 checkboxClass: 'icheckbox_flat-green',
//                 radioClass: 'iradio_flat-green',
//                 increaseArea: '20%' // optional
//             }).on('ifChanged', function(){
//                 var $this = $(this),
//                     todo = $(this).parent().parent().parent();
    
//                 todo.toggleClass('todo-marked');
//                 todo.find('.label').toggleClass('label-success');
//             });
     
// }); // Fin document ready
    
    
//     // data1[1].dates;
    
//  $('#año').click(function() {
//     //  console.log("admin/getNumConsultasByMonth/"+$(this).text());
        
//             var data1=[];
//             $.ajax({
//                 type: "POST", // ES POST
//                 url: "admin/getNumConsultasByMonth",
//                 dataType: 'json',
//                 success: function(response){
//                     $.each(response.data, function(key, value){
//                         // console.log("entro", response.data);
//                     data1.push({
//                     dates: key,
//                     sales: value
//                 });
//             });
//                 }
//             })
//             console.log(data1);
        
//         // if ($('#revenue-chart svg').length==0){
    
//     //   var data1 = [
//     //             {dates: '2013-10-30', sales: 236},
//     //             {dates: '2013-10-31', sales: 137},
//     //             {dates: '2013-11-01', sales: 275},
//     //             {dates: '2013-11-02', sales: 380},
//     //             {dates: '2013-11-03', sales: 655},
//     //             {dates: '2013-11-04', sales: 571}
//     //         ],
//             data1,
//             revenueChart = Morris.Line({
//                 element: 'revenue-chart',
//                 data: data1,
//                 lineColors: ['#3498db'],
//                 gridTextColor: '#34495e',
//                 pointFillColors: ['#3498db'],
//                 xkey: 'dates',
//                 ykeys: ['sales'],
//                 labels: ['Sales'],
//                 barRatio: 0.4,
//                 hideHover: 'auto'
//             });
//         // }
//             // update data on content or window resize
//             var update = function(){
//                 revenueChart.redraw();
//             }
    
//             // handle chart responsive on toggle .content
//             $(window).on('resize', function(){
//                 update();
//             })
//             $('#toggle-aside').on('click', function(){
//                 // update chart after transition finished
//                 $("#content").bind("transitionend webkitTransitionEnd oTransitionEnd MSTransitionEnd", function(){
//                     update();
//                     $(this).unbind();
//                 });
//             })
//             $('#toggle-content').on('click', function(){
//                 update();
//             })
//             // end chart
    
    
    
//             // todo list
//             $('.icheck').iCheck({
//                 checkboxClass: 'icheckbox_flat-green',
//                 radioClass: 'iradio_flat-green',
//                 increaseArea: '20%' // optional
//             }).on('ifChanged', function(){
//                 var $this = $(this),
//                     todo = $(this).parent().parent().parent();
    
//                 todo.toggleClass('todo-marked');
//                 todo.find('.label').toggleClass('label-success');
//             });
     
//     });
            
        
$(function () {
    
    
       
    
    // Json para obtener los perfiles defindos para los grupos de PF
    // $.getJSON('https://soporteguiasdocentes-utesting.c9users.io/web/app_dev.php/groups/getProfiles')
  
            // charts
            // chart revenue
            // data1,
            var data1 = [
                {dates: '2013-10-30', sales: 236},
                {dates: '2013-10-31', sales: 137},
                {dates: '2013-11-01', sales: 275},
                {dates: '2013-11-02', sales: 380},
                {dates: '2013-11-03', sales: 655},
                {dates: '2013-11-04', sales: 571}
            ],
            // data1,
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
    
    
    
            // Quick Mail
            $('#quick-mail-reseiver').tagsInput({
                height: '70px',
                width:'auto',           // support percent (90%)
                defaultText: '+ añadir'
            });
            // manual style for .tagsinput
            $('div.tagsinput input').on('focus', function(){
                var tagsinput = $(this).parent().parent();
                tagsinput.addClass('focus');
            }).on('focusout', function(){
                var tagsinput = $(this).parent().parent();
                tagsinput.removeClass('focus');
            });
            $('#quick-mail-content').wysihtml5({
                "font-styles": true, //Font styling, e.g. h1, h2, etc. Default true
                "emphasis": true, //Italics, bold, etc. Default true
                "lists": false, //(Un)ordered lists, e.g. Bullets, Numbers. Default true
                "html": false, //Button which allows you to edit the generated HTML. Default false
                "link": true, //Button to insert a link. Default true
                "image": true, //Button to insert an image. Default true,
                "color": false, //Button to change color of font  
                "size": 'sm' // use button small ion and primary
            });
});