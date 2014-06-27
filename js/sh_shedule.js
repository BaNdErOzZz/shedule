jQuery(document).ready(function($){
    
    
    $('.calendar-current').on('click', function(){
        if($('.show-calendar-body').length){
           $('.show-calendar-body').removeClass('show-calendar-body');
           return false;
        }
        $('.calendar-select-body').addClass('show-calendar-body');
    });
    
    $('.calendar-select-item').on('click', function(){
        if($(this).hasClass('active-calendar-item')) return false;
        var id = $(this).attr('id');
        var text = $(this).text();
        var $a_select = $('.active-calendar-item');
        $('.calendar-current').attr('id', id).text(text);
        $(this).addClass('active-calendar-item');
        $a_select.removeClass('active-calendar-item');
        show_calendar_by_id(id);
        $('.show-calendar-body').removeClass('show-calendar-body');
    });

    function show_calendar_by_id(id){
        var $c_body = $('#table-'+id);
        var $a_c_body = $('.active-calendar-table');
        $a_c_body.removeClass('active-calendar-table');
        $c_body.addClass('active-calendar-table');        
    }

    // Tooltip

    $('.calendar-item-title').hover(
      //on
    function(){
        if($.trim($(this).closest('td').find('.calendar-item-tooltip').text()) == '') return false;
        $(this).closest('td').find('.calendar-item-tooltip').css('display', 'block');
    },//out 
    function(){
        if($.trim($(this).closest('td').find('.calendar-item-tooltip').text()) == '') return false;
        $(this).closest('td').find('.calendar-item-tooltip').css('display', 'none');
    });

    $('.calendar-item-title').mousemove(function(e){
        if($.trim($(this).closest('td').find('.calendar-item-tooltip').text()) == '') return false;
        $(this).closest('td').find('.calendar-item-tooltip').css({left : (e.clientX+15)+'px', top: (e.clientY+25)+'px'});
    });
     
   $('.control-del').on('click', function(){
     var $t =  $(this);
     var $td = $t.closest('td');
     var id = $td.attr('id');
     if(confirm('Вы уверены ?')){
        $td.empty().attr('style', '');
        var data = {
            page   : 'sh_shedule',
            action : 'delete',
            id     : id
        }
        $.get($t.attr('data-url'), data, function(r){ }), 'json';
     }else{
         return false;
     }
   });
     
$('.sh-delete-table').on('click', function(){
     var $t =  $(this);
     var $tr = $t.closest('tr');
     var id = $tr.attr('id');
     if(confirm('Вы уверены ?')){
        $tr.empty().attr('style', '');
        var data = {
            page   : 'sh_shedule_table',
            action : 'delete',
            id     : id
        }
        $.get($t.attr('data-url'), data, function(r){ }), 'json';
     }else{
         return false;
     }
   });
   
});