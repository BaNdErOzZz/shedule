<?php
/**
 * Shedule tables function
 * 
 * Function for working with shedule table entity
 * @package Shedule
 * @version 1.0.0
 */

/**
 * Function get shedule table from DB
 * 
 * @param int $id Shedule table identificator
 * @return mixed Shedule table entity or array of shedules
 */
function get_shedule_table($id = 0){
    global $wpdb;
    if((int)$id === 0){
        
        $query = 'SELECT sht.id, sht.title, sht.description, 
                                 sht.date_time_begin, sht.date_time_end,
                                 sht.shortcode, sht.date_create, sht.date_update, sht.labels  
                                 FROM '.SHEDULE_PRFX.'sh_shedule_table sht';

        $result = $wpdb->get_results($query);        
        
        if(!is_array($result)) return FALSE;
        foreach($result as &$key){
            $key->labels = unserialize($key->labels);
        }
    }else{
    
        $query = $wpdb->prepare('SELECT sht.id, sht.title, sht.description, 
                                 sht.date_time_begin, sht.date_time_end,
                                 sht.shortcode, sht.date_create, sht.date_update, sht.labels   
                                 FROM '.SHEDULE_PRFX.'sh_shedule_table sht 
                                 WHERE sht.id = %d', $id);

        $result = $wpdb->get_row($query);
    
        if(!is_object($result)) return FALSE;   

        $result->labels = unserialize($result->labels);
    };
    
    return $result;
}

/**
 * Function get shedule table from DB
 * 
 * @param array $args Have values 'title', 'desc', 'date_begin', 'date_end', 'shortcode'
 * @return obj Shedule table entity
 */
function set_shedule_table($args){
    global $wpdb;
    $title = htmlspecialchars(strip_tags($args['title']));
    $desc = wp_filter_post_kses($args['desc']);
    $date_begin = date('Y-m-d H:i:s',strtotime($args['date_begin']));
    $date_end = date('Y-m-d H:i:s',strtotime($args['date_end']));
    $shortcode = 'shedule';
    if(is_array($args['labels'])){
        foreach($args['labels'] as $key => &$value){
            strip_tags(htmlspecialchars($value['sh_table_label_color']));
            strip_tags(htmlspecialchars($value['sh_table_label_title']));
        }
        $labels = maybe_serialize($args['labels']);
    }else{
        $labels = '';
    }

    $labels = mysql_real_escape_string($labels);
    
    $query = $wpdb->prepare("INSERT INTO ".SHEDULE_PRFX."sh_shedule_table(title, description, shortcode, labels, date_time_begin, date_time_end, date_create, date_update) 
                             VALUES(%s, %s, %s, '{$labels}', %s, %s, NOW(), NOW())", array($title, $desc, $shortcode, $date_begin, $date_end));

    if($wpdb->query($query)){
        $result = $wpdb->insert_id;
    }else{
        $result = FALSE;
    }
    return $result;
}

/**
 * Function get shedule table from DB
 * 
 * @param int $id Shedule table identificator
 * @return obj Shedule table entity
 */
function update_shedule_table($id, $args){
    global $wpdb;
    
    if((int)$id == 0) return FALSE ; 
    
    $title = strip_tags(htmlspecialchars($args['title']));
    $desc = wp_filter_post_kses($args['desc']);
    $date_begin = date('Y-m-d H:i:s',strtotime($args['date_begin']));
    $date_end = date('Y-m-d H:i:s',strtotime($args['date_end']));
    if(is_array($args['labels'])){
        foreach($args['labels'] as $key => &$value){
            strip_tags(htmlspecialchars($value['sh_table_label_color']));
            strip_tags(htmlspecialchars($value['sh_table_label_title']));
        }
        $labels = maybe_serialize($args['labels']);
    }else{
        $labels = '';
    }

    $labels = mysql_real_escape_string($labels);
    $shortcode = 'shedule';
    
    $query = $wpdb->prepare("UPDATE ".SHEDULE_PRFX."sh_shedule_table sht SET sht.title = %s,
                             sht.description = %s, sht.date_time_begin = %s, sht.labels = '{$labels}',  
                             sht.date_time_end = %s, sht.date_update = NOW() 
                             WHERE sht.id = %d ;", array($title, $desc, $date_begin, $date_end, $id));
    if($wpdb->query($query)){
        $result = TRUE;
    }else{
        $result = FALSE;
    }
    return $result;
}

/**
 * Function get shedule table from DB
 * 
 * @param int $id Shedule table identificator
 * @return obj Shedule table entity
 */
function delete_shedule_table($id){
    global $wpdb;
    
    if((int)$id == 0) return FALSE ; 
    
    $query = $wpdb->prepare('DELETE FROM '.SHEDULE_PRFX.'sh_shedule_table 
                             WHERE id = %d ', $id);
    if($wpdb->query($query)){
        $result = TRUE;
    }else{
        $result = FALSE;
    }
    return $result;
}
?>
