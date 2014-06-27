
<div class="wrap">
<?php if(is_admin()):?>    
    <h2><?php _e('Shedule tables', 'shedule');?>
        <a href="admin.php?page=sh_shedule&action=add&table_id=<?php echo $shedule_table->id;?>" class="add-new-h2">
            <?php _e('Add new', 'shedule');?>
        </a>
    </h2>
<?php endif;?>
<!-- CALENDAR BEGIN -->
<div class="calendar-box">
    <div class="calendar-head">
        <div class="calendar-title"><?php _e('Shedule table', 'shedule');?>: <?php echo $shedule_table->title;?></div>
        <div class="calendar-date">
            <div class="calendar-select-box">
                <div class="calendar-select">
                    <div class="calendar-select-head">
                        <div class="calendar-current" id="date-1">
                            <?php printf(__('From %s to %s', 'shedule'), 
                                    date('d', $shedule_table->date_day_begin), 
                                    date('d F Y', $shedule_table->date_day_begin+6*$day));?>
                        </div>
                    </div>
                    <div class="calendar-select-body">
                        <?php for($i = 0; $i <= $day_count; $i+= 7):?>
                        <div class="calendar-select-item <?php echo ($i == 0) ? 'active-calendar-item' : '';?>" id="date-<?php echo $i; ?>">
                            <?php printf(__('From %s to %s', 'shedule'), 
                                    date('d', $date_day_begin), 
                                    date('d F Y', $date_day_begin+$day*6));
                                    $date_day_begin += $day*7;
                            ?>
                        </div>
                        <?php endfor;?>
                    </div>
                </div>                                
            </div>
        </div>
        <div class="calendar-download"></div>
    </div>
    <div class="calendar-body">
        <?php for($i = 0; $i <= $day_count; $i+=7):?>
        <?php $date_min = ($i == 0) ? date('Y-m-d',$shedule_table->date_day_begin) : date('Y-m-d',$shedule_table->date_day_begin+$day) ;?>
        <table class="calendar-table <?php echo ($i == 0) ? 'active-calendar-table' : '';?>" id="table-date-<?php echo $i;?>">
            
            
            <thead>
                <tr>
                    
                    <?php /* TIME COL BEGIN */ ?>
                        <th class="calendar-time-col"></th>
                    <?php /* TIME COL END */ ?>
                        
                    <th><div class="day"><?php echo ($i == 0) ? date('d', $shedule_table->date_day_begin) : date('d', $shedule_table->date_day_begin+=$day) ;?></div><?php _e('Mondey', 'shedule');?></th>
                    <th><div class="day"><?php echo date('d', $shedule_table->date_day_begin+=$day) ;?></div><?php _e('Tuesday', 'shedule');?></th>
                    <th><div class="day"><?php echo date('d', $shedule_table->date_day_begin+=$day) ;?></div><?php _e('Wednesday', 'shedule');?></th>
                    <th><div class="day"><?php echo date('d', $shedule_table->date_day_begin+=$day) ;?></div><?php _e('Thursday', 'shedule');?></th>
                    <th><div class="day"><?php echo date('d', $shedule_table->date_day_begin+=$day) ;?></div><?php _e('Friday', 'shedule');?></th>
                    <th><div class="day"><?php echo date('d', $shedule_table->date_day_begin+=$day) ;?></div><?php _e('Saturday', 'shedule');?></th>
                    <th><div class="day"><?php echo date('d', $shedule_table->date_day_begin+=$day) ;?></div><?php _e('Sunday', 'shedule');?></th>
                </tr>
            </thead>
            
            
            <?php $date_max = date('Y-m-d',$shedule_table->date_day_begin); // Max date output?>
            <?php $shedule = get_shedule(0, $shedule_table->id, $date_min, $date_max); // Current shedule for this week?>
            
            <tbody>
                <?php while($shedule):?>
                    <tr>                
                        <?php 
                              // Needed for output empty cell 
                              $flag = false; 
                              // Currenr date
                              $shedule_date = strtotime($date_min);
                              // Sort array with shedule
                              $shedule = array_values($shedule);
                              //Current row time
                              $c_time = $shedule[0]->event_time;
                        ?>
                        
                        <?php /* TIME CELL BEGIN */ ?>
                            <td class="calendar-time-cell">
                                <?php echo date('H:i',strtotime($c_time));?>
                            </td>
                        <?php /* TIME CELL END */ ?>     
                            
                        <?php for($y=1; $y <= 7; $y++):?>
                            
                            <?php foreach($shedule as $key => $value): // BEGIN SHEDULE LOOP?>
                            
                                <?php if($value->event_date == date('Y-m-d',$shedule_date) && $value->event_time == $c_time): ?>
                        
                                <td id="<?php echo $value->id;?>" style="background: <?php echo ($value->settings['sh_image_bkg']) ? "url('".$value->settings['sh_image_bkg']."')" : $value->settings['sh_color_bkg'] ?>">
                                    <div class="calendar-item-wrapper">
                                    <div class="calendar-item-time"><?php echo date('H:i',strtotime($value->event_time))?></div>
                                    
                                    <div class="calendar-item-labels">
                                        <?php if(!empty($value->labels)):
                                            foreach($value->labels as $label):?>
                                            <div class="calendar-item-label" style="background-color: <?php echo $label?>"></div>
                                        <?php endforeach;
                                            endif;?>
                                            <div style="clear: both;"></div>
                                    </div>
                                    <div class="calendar-item-title">
                                        <?php echo apply_filters('shedule/get_title',$value);?>
                                    </div>
                                    <div class="calendar-item-tooltip">
                                        <?php echo apply_filters('shedule/get_tooltip',$value);?>
                                    </div>
                                    <div class="calendar-item-excerpt">
                                        <?php echo apply_filters('shedule/get_excerpt',$value); ?>
                                    </div>
                                    
                                    <?php if(current_user_can('manage_options')):?>
                                        <div class="calendar-controls">
                                            <a href="<?php echo SHEDULE_ADM_URL; ?>admin.php?page=sh_shedule&action=edit&id=<?php echo $value->id?>" class="control-edit"><?php _e('Edit', 'Shedule');?></a>
                                            <span class="control-del" data-url="<?php echo SHEDULE_ADM_URL; ?>admin.php"><?php _e('Delete', 'Shedule');?></span>
                                        </div>
                                    <?php endif;?>
                                    </div>
                                </td>
                                
                                <?php $flag = true; 
                                      unset($shedule[$key]); 
                                      break;?>
                                <?php else: 
                                      $flag = false;?>
                                <?php endif;?>
                                
                            <?php endforeach; // END SHEDULE LOOP ?>
                                
                                <?php if($flag == false):?>
                                
                                <td id="" class="calendar-empty-cell">
                                    <div class="calendar-item-wrapper">
                                    <?php if(current_user_can('manage_options')):?>
                                    <form class="calendar-add-shedule" action="<?php echo SHEDULE_ADM_URL; ?>/admin.php?page=sh_shedule&action=add&table_id=<?php echo $shedule_table->id; ?>" method="post">
                                    <input type="hidden" name="sh_time" value="<?php echo $c_time?>"/>
                                    <input type="hidden" name="sh_date" value="<?php echo date('Y-m-d',$shedule_date)?>"/>
                                    <input type="submit" value="+" class="calendar-add-shedule-btn"/>
                                    </form>
                                    <?php endif;?>
                                    </div>
                                </td>   
                                <?php endif;?>
                        <?php $shedule_date+=$day; 
                              $flag = empty($shedule) ? false : $flag;
                              endfor;?>
                                
                    </tr>     
                    <?php endwhile;?>
            </tbody>
        </table>
        <?php endfor;?>
        <?php if(is_array($shedule_table->labels)):?>
            <div class="calendar-info">
                <?php foreach($shedule_table->labels as $key => $value):?>
                <span style="padding: 3px 11px; margin: 0px 10px; background: <?php echo $value['sh_table_label_color']?>"></span><span><?php echo $value['sh_table_label_title']?></span>
                <?php endforeach;?>
            </div>
        <?php endif;?>
    </div>
</div>
<!-- CALENDAR END -->
</div>