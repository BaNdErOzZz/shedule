<?php 
/**
 * View add shedule table
 * 
 * @package Shedule
 * @author Bondars Aleksandr <banderos120@gmail.com>
 * @version 1.0.0
 */
?>
<script>
jQuery(function($){
        $.datepicker.regional['ru'] = {
                closeText: 'Закрыть',
                prevText: '&#x3c;Пред',
                nextText: 'След&#x3e;',
                currentText: 'Сегодня',
                monthNames: ['Январь','Февраль','Март','Апрель','Май','Июнь',
                'Июль','Август','Сентябрь','Октябрь','Ноябрь','Декабрь'],
                monthNamesShort: ['Янв','Фев','Мар','Апр','Май','Июн',
                'Июл','Авг','Сен','Окт','Ноя','Дек'],
                dayNames: ['воскресенье','понедельник','вторник','среда','четверг','пятница','суббота'],
                dayNamesShort: ['вск','пнд','втр','срд','чтв','птн','сбт'],
                dayNamesMin: ['Вс','Пн','Вт','Ср','Чт','Пт','Сб'],
                weekHeader: 'Не',
                dateFormat: 'dd.mm.yy',
                firstDay: 1,
                isRTL: false,
                showMonthAfterYear: false,
                yearSuffix: ''};
        $.datepicker.setDefaults($.datepicker.regional['ru']);
        $( "#sh_datepicker_start" ).datepicker({
            defaultDate : '<?php echo date('d.m.Y',strtotime($shedule->date_time_begin));?>',
            onSelect: function(dateText){
                $('#sh_shedule_date_start').val(dateText);
            }
        });
        $( "#sh_datepicker_end" ).datepicker({
            defaultDate : '<?php echo date('d.m.Y',strtotime($shedule->date_time_end));?>',
            onSelect: function(dateText){
                $('#sh_shedule_date_end').val(dateText);
            }
        });
        //Color picker
$('.sh_table_label_color').wpColorPicker();
//
$('#add_button').on('click', function (){
    var $this = $(this);
    var color = $('.sh_table_label_color').val();
    var text = $('.sh_table_label_title').val();
    var i = $('input').length+1;
    $this.closest('.inside').append(
    '<div style="margin: 10px 0px;"><input type="hidden" class="" name="sh_table_labels[sh_table_label_'+i+'][sh_table_label_color]" value="'+color+'"/>'+
    '<input type="hidden" class="" name="sh_table_labels[sh_table_label_'+i+'][sh_table_label_title]" value="'+text+'"/>'+
    '<span style="background:'+color+'; padding: 3px 10px; border: 1px solid; margin: 0px 5px;"></span>'+
    '<span>'+text+'</span></div>'
);
});        
});
</script>
<div class="wrap">
    <h2><?php  _e('Create Shedule Table', 'shedule');?>
        <a href="admin.php?page=sh_shedule_table&action=add" class="add-new-h2">
            <?php _e('Add new', 'shedule');?>
        </a>
    </h2>
    <form action="admin.php?page=sh_shedule_table&action=update&id=<?php echo $shedule->id;?>" method="post">
        <div id="poststuff">
            <div id="post-body" class="metabox-holder columns-2">
                <div id="post-body-content">
                    <?php do_action('shedule/flash', 'error');?>
                    <?php do_action('shedule/flash', 'done');?>
                    <div id="titlediv">
                        <div id="titlewrap">
                            <label class="screen-reader-text" id="title-prompt-text" for="title"><?php _e('Enter a title', 'shedule');?></label>
                                <input type="text" name="sh_table_title" size="30" value="<?php echo $shedule->title;?>" id="title" autocomplete="off">
                        </div>                        
                    </div>
                    <?php wp_editor($shedule->description, 'sh_table_desc', array(
                        'wpautop'=>1, 
                        'media_buttons'=>0,
                        'textarea_name'=>'sh_table_desc',
                        'textarea_rows'=>10,
                        'tabindex'=>'',
                        'editor_class'=>'',
                        'editor_css'=>'',
                        'teeny'=>0,
                        'dfw'=>0,
                        'tinymce'=>1,
                        'quicktags'=>1));?>
                </div>
                <div id="postbox-container-1" class="postbox-container">
                    <div id="side-sortables" class="meta-box-sortables ui-sortable">
                        <div id="submitdiv" class="postbox ">
                            <div class="handlediv" title="<?php _e('Press to change', 'shedule');?>"><br></div>
                            <h3 class="hndle"><span><?php _e('Public', 'shedule');?></span></h3>
                            <div class="inside">
                                <div id="major-publishing-actions">
                                    <div id="delete-action">
                                        <a class="submitdelete deletion" href="admin.php?page=sh_shedule_table&action=delete&id=<?php echo $shedule->id;?>"><?php _e('Delete', 'shedule');?></a></div>

                                    <div id="publishing-action">
                                    <span class="spinner"></span>
                                                    <input name="original_publish" type="hidden" id="original_publish" value="<?php _e('Update', 'shedule')?>">
                                                    <input type="submit" name="publish" id="publish" class="button button-primary button-large" value="<?php _e('Update', 'shedule');?>" accesskey="p"></div>
                                    <div class="clear"></div>
                                </div>
                            </div>
                        </div>
                        <div id="sh_date_start" class="postbox">
                            <div class="handlediv" title="<?php _e('Press to change', 'shedule');?>"><br></div>
                            <h3 class="hndle"><span><?php _e('Select shedule date start', 'shedule');?></span></h3>
                            <div class="inside">
                                <input type="hidden" id="sh_shedule_date_start" name="sh_table_date_begin" value="<?php echo date('d.m.Y',strtotime($shedule->date_time_begin));?>"/>
                                <div id="sh_datepicker_start"></div>
                            </div>                            
                        </div>
                        <div id="sh_date_end" class="postbox">
                            <div class="handlediv" title="<?php _e('Press to change', 'shedule');?>"><br></div>
                            <h3 class="hndle"><span><?php _e('Select shedule date end', 'shedule');?></span></h3>
                            <div class="inside">
                                <input type="hidden" id="sh_shedule_date_end" name="sh_table_date_end" value="<?php echo date('d.m.Y',strtotime($shedule->date_time_end));?>"/>
                                <div id="sh_datepicker_end"></div>
                            </div>                            
                        </div>
                        <div id="sh_labels" class="postbox">
                            <div class="handlediv" title="<?php _e('Press to change', 'shedule');?>"><br></div>
                            <h3 class="hndle"><span><?php _e('Labels for table', 'shedule');?></span></h3>
                            <div class="inside">
                                    <input type="text" class="sh_table_label_color" name="" value=""/>
                                    <input type="text" class="sh_table_label_title" name="" value=""/>
                                    <div class="button button-primary button-large" id="add_button"><?php _e('Add', 'shedule')?></div><div class="button-cancel" id="del_button" style="color: red; cursor: pointer"><?php _e('Delete', 'shedule')?></div>
                                <?php if(!empty($shedule->labels)):?>
                                <?php foreach($shedule->labels as $key=>$value):?>
                                    <div style="margin: 10px 0px;">
                                    <input type="hidden" class="" name="sh_table_labels[<?php echo $key?>][sh_table_label_color]" value="<?php echo $value['sh_table_label_color']?>"/>
                                    <input type="hidden" class="" name="sh_table_labels[<?php echo $key?>][sh_table_label_title]" value="<?php echo $value['sh_table_label_title']?>"/>
                                    <span style="background:<?php echo $value['sh_table_label_color']?>; padding: 3px 10px; border: 1px solid; margin: 0px 5px;"></span>
                                    <span><?php echo $value['sh_table_label_title']?></span>
                                    </div>
                                <?php endforeach;?>                                    
                                <?php endif;?>
                                <div id="sh_datepicker_end"></div>
                            </div>                            
                        </div>
                    </div>
                    </div>
                   </div>
                </div>
            <br class="clear">
        </div>
        <?php wp_nonce_field('admin.php?page=sh_shedule_table&action=create', 'sh_add_table_nonce');?>
        <?php wp_referer_field(true);?>
    </form>    
</div>
