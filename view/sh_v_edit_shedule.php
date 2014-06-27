<?php 
/**
 * View add shedule
 * 
 * @package Shedule
 * @author Bondars Aleksandr <banderos120@gmail.com>
 * @version 1.0.0
 */
?>
<script>
jQuery(document).ready(function($){
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
        $( "#sh_datepicker" ).datepicker({
            <?php if(!empty($shedule->event_date)): ?>
            defaultDate : '<?php echo date('d.m.Y',strtotime($shedule->event_date));?>',
            <?php endif;?>
                minDate : '<?php echo date('d.m.Y',strtotime($shedule_table->date_time_begin));?>',
                maxDate : '<?php echo date('d.m.Y',strtotime($shedule_table->date_time_end));?>',
            onSelect: function(dateText){
                $('#sh_date').val(dateText);
            }
        });
        $('#sh_timepicker').timepicker({
           altField: '#sh_time',
           <?php echo !empty($shedule->event_time) ? 'defaultTime: "'.$shedule->event_time.'",' : ''?>
           hourText: 'Часы',
           minuteText: 'Минуты',
           rows : 6
        });   
//Chosen
    $('#shedule_post_select').chosen();
//Upload image
        $('.shedule_media_upload').click(function(e) {
            e.preventDefault();

            var custom_uploader = wp.media({
                title: '<?php _e('Upload Image', 'shedule');?>',
                button: {
                    text: '<?php _e('Upload', 'shedule');?>'
                },
                multiple: false  // Set this to true to allow multiple files to be selected
            })
            .on('select', function() {
                var attachment = custom_uploader.state().get('selection').first().toJSON();
                $('.shedule_bkg_image').attr('src', attachment.url);
                $('.shedule_bkg_url').val(attachment.url);
                $('.shedule_bkg_id').val(attachment.id);
            })
            .open();
        });
//Color picker
$('#sh_color_bkg').wpColorPicker();
});
</script>
<div class="wrap">
    <h2><?php  _e('Create Shedule Table', 'shedule');?>
        <a href="admin.php?page=sh_shedule&action=add&table_id=<?php echo $shedule_table->id?>" class="add-new-h2">
            <?php _e('Add new', 'shedule');?>
        </a>
    </h2>
    <form action="admin.php?page=sh_shedule&action=update&id=<?php echo $shedule->id?>&table_id=<?php echo $shedule_table->id; ?>" method="post">
        <input type="hidden" name="shedule_table_id" value="<?php echo $shedule_table->id;?>" />
        <div id="poststuff">
            <div id="post-body" class="metabox-holder columns-2">
                <div id="post-body-content">
                    <?php do_action('shedule/flash', 'error');?>
                    <?php do_action('shedule/flash', 'done');?>
                    <div id="titlediv">
                        <div id="titlewrap">
                                <label class="screen-reader-text" id="title-prompt-text" for="title"><?php _e('Enter a title', 'shedule');?></label>
                                <input type="text" name="sh_title" size="30" value="<?php echo $shedule->title;?>" id="title" autocomplete="off">
                        </div>                        
                    </div>
                    
                    <div id="title_link">
                        <div id="title_link_wrap">
                                <label id="title-prompt-link" for="title_link"><?php _e('Enter a link for title', 'shedule');?></label>
                                <input type="text" name="sh_title_link" size="30" value="<?php echo $shedule->title_link?>" id="title_link" autocomplete="off">
                                <label><?php _e('Open in new tab', 'shedule');?></label>
                                <input type="checkbox" value="1" name="option[sh_title_link_tab]" id="sh_title_link_new_tab" class="" <?php echo !empty($shedule->settings['sh_title_link_tab']) ? 'checked="checked"' : '';?>/>
                        </div>                        
                    </div> 
                    <br />
                    <?php wp_editor((empty($shedule->title_tooltip) ? '' : stripslashes($shedule->title_tooltip)), 'sh_title_tooltip', array(
                        'wpautop'=>1, 
                        'media_buttons'=>1,
                        'textarea_name'=>'sh_title_tooltip',
                        'textarea_rows'=>5,
                        'tabindex'=>'',
                        'editor_class'=>'',
                        'editor_css'=>'',
                        'teeny'=>0,
                        'dfw'=>0,
                        'tinymce'=>1,
                        'quicktags'=>1));?>
                    <br />
                    <div id="title_option">
                        <div id="titlewrap">
                            <label><?php _e('Use Post Link', 'shedule');?></label>
                            <input type="checkbox" value="1" name="option[sh_post_link]" id="" class="" <?php echo !empty($shedule->settings['sh_post_link']) ? 'checked="checked"' : '';?>/>
                            <label><?php _e('Use Post Excerpt like Tooltip', 'shedule');?></label>
                            <input type="checkbox" value="1" name="option[sh_title_exc_tooltip]" id="" class="" <?php echo !empty($shedule->settings['sh_title_exc_tooltip']) ? 'checked="checked"' : '';?>/>
                            <label><?php _e('Use Post Content like Tooltip', 'shedule');?></label>
                            <input type="checkbox" value="1" name="option[sh_title_desc_tooltip]" id="" class="" <?php echo !empty($shedule->settings['sh_title_desc_tooltip']) ? 'checked="checked"' : '';?>/>
                            <label><?php _e('Use Post Content like Description', 'shedule');?></label>
                            <input type="checkbox" value="1" name="option[sh_content_desc]" id="" class="" <?php echo !empty($shedule->settings['sh_content_desc']) ? 'checked="checked"' : '';?>/>
                        </div> 
                        <br />
                        <?php $taxonomies = get_taxonomies();?>
                        <select data-placeholder="<?php _e('Select Post', 'shedule');?>" name="sh_post_id" style="" id="shedule_post_select" tabindex="6">
                           <option value=""></option>
                           <?php $terms = get_terms($taxonomies);?>
                           <?php foreach($terms as $term):?>
                           <optgroup label="<?php echo $term->name;?>">
                              <?php $posts = get_posts(array('post_type' => 'any','posts_per_page'=>-1, 'tax_query'=>array(array('taxonomy'=>$term->taxonomy, 'field'=>'term_id', 'terms'=>$term->term_id))));  ?>
                              <?php foreach($posts as $item):?>
                               <option value="<?php echo $item->ID?>" <?php echo !empty($shedule->post_id) && $shedule->post_id == $item->ID ? 'selected' : '';?>><?php echo $item->post_title?></option>
                              <?php endforeach;?>
                            </optgroup>
                           <?php endforeach;?>
                         </select>
                        
                    </div>
                    <br />
                </div>
                <div id="postbox-container-1" class="postbox-container">
                    <div id="side-sortables" class="meta-box-sortables ui-sortable">
                        <div id="submitdiv" class="postbox ">
                            <div class="handlediv" title="<?php _e('Press to change', 'shedule');?>"><br></div>
                            <h3 class="hndle"><span><?php _e('Public', 'shedule');?></span></h3>
                            <div class="inside">
                                <div id="major-publishing-actions">
                                    <div id="delete-action"></div>

                                    <div id="publishing-action">
                                    <span class="spinner"></span>
                                                    <input name="original_publish" type="hidden" id="original_publish" value="<?php _e('Public', 'shedule')?>">
                                                    <input type="submit" name="publish" id="publish" class="button button-primary button-large" value="<?php _e('Public', 'shedule');?>" accesskey="p"></div>
                                    <div class="clear"></div>
                                </div>
                            </div>
                        </div>
                        <div id="sh_date_div" class="postbox">
                            <div class="handlediv" title="<?php _e('Press to change', 'shedule');?>"><br></div>
                            <h3 class="hndle"><span><?php _e('Select event date', 'shedule');?></span></h3>
                            <div class="inside">
                                <input type="hidden" id="sh_date" name="sh_date" value="<?php echo $shedule->event_date?>"/>
                                <div id="sh_datepicker"></div>
                            </div>                            
                        </div>
                        <div id="sh_time_div" class="postbox">
                            <div class="handlediv" title="<?php _e('Press to change', 'shedule');?>"><br></div>
                            <h3 class="hndle"><span><?php _e('Select time', 'shedule');?></span></h3>
                            <div class="inside">
                                <input type="hidden" id="sh_time" name="sh_time" value="<?php echo $shedule->event_time?>"/>
                                <div id="sh_timepicker"></div>
                            </div>                            
                        </div>
                        <div id="sh_labels" class="postbox">
                            <div class="handlediv" title="<?php _e('Press to change', 'shedule');?>"><br></div>
                            <h3 class="hndle"><span><?php _e('labels', 'shedule');?></span></h3>
                            <div class="inside">
                                <?php if(is_array($shedule_table->labels)):?>
                                    <div class="calendar-info">
                                        <?php foreach($shedule_table->labels as $key => $value):?>
                                        <div class="sh-labels-row">
                                        <input type="checkbox" id="<?php echo $key?>" name="sh_labels[<?php echo $key?>]" value="<?php echo $value['sh_table_label_color']?>" <?php echo !empty($shedule->labels[$key]) ? 'checked="checked"' : '';?>>
                                        <span style="padding: 3px 11px; margin: 0px 10px; background: <?php echo $value['sh_table_label_color']?>">
                                        </span>
                                        <span>
                                            <?php echo $value['sh_table_label_title']?>
                                        </span>
                                        </div>
                                        <?php endforeach;?>
                                    </div>
                                <?php endif;?>
                                <div id="sh_timepicker"></div>
                            </div>                            
                        </div>
                    </div>
                   </div>
                    <div id="postbox-container-2" class="postbox-container">
                        <div id="side-sortables" class="meta-box-sortables ui-sortable">
                            <div id="sh_description_div" class="postbox">
                                <div class="handlediv" title="<?php _e('Press to change', 'shedule');?>"><br></div>
                                <h3 class="hndle"><span><?php _e('Description', 'shedule');?></span></h3>
                                <div class="inside">
                                    <?php wp_editor((empty($shedule->description) ? '' : stripslashes($shedule->description)), 'sh_description', array(
                                        'wpautop'=>1, 
                                        'media_buttons'=>1,
                                        'textarea_name'=>'sh_description',
                                        'textarea_rows'=>5,
                                        'tabindex'=>'',
                                        'editor_class'=>'',
                                        'editor_css'=>'',
                                        'teeny'=>0,
                                        'dfw'=>0,
                                        'tinymce'=>1,
                                        'quicktags'=>1));?>                                    
                                </div>                            
                            </div>
                            <div id="sh_description_div" class="postbox">
                                <div class="handlediv" title="<?php _e('Press to change', 'shedule');?>"><br></div>
                                <h3 class="hndle"><span><?php _e('Options', 'shedule');?></span></h3>
                                <div class="inside">
                                    <div class="sh-wrapper">
                                        <h3 class="sh-wrap-title"><?php _e('Background', 'shedule');?></h3>

                                        <div class="sh-wrap-body">
                                            <div>
                                            <!-- Image Thumbnail -->
                                            <img class="shedule_bkg_image" src="<?php echo $shedule->settings['sh_image_bkg'];?>" style="width:300px; display:inline-block;" />

                                            <!-- Upload button and text field -->
                                            <input class="shedule_bkg_url" id="" type="text" name="option[sh_image_bkg]" value="<?php echo $shedule->settings['sh_image_bkg'];?>" style="margin-bottom:10px; clear:right;">

                                            <a href="#" class="button shedule_media_upload"><?php _e('Upload background image', 'shedule');?></a>
                                            <div>
                                                <input name="option[sh_color_bkg]" type="text" id="sh_color_bkg" <?php echo !empty($shedule->settings['sh_color_bkg']) ? 'value="'.$shedule->settings['sh_color_bkg'].'" data-default-value="'.$shedule->settings['sh_color_bkg'].'"' : 'value="#ffffff" data-default-color="#ffffff"';?>>
                                            </div>
                                            <div class="clear"></div>
                                            </div>
                                        </div>
                                    </div>                                 
                                </div>                            
                            </div>                            
                        </div>
                       </div>
                </div>
            <br class="clear">
        </div>
        <?php wp_nonce_field('admin.php?page=sh_shedule&action=update', 'sh_add_nonce');?>
        <?php wp_referer_field(true);?>
    </form>    
</div>
