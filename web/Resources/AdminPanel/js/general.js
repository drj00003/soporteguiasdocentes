$(function () {
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