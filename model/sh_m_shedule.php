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
function get_shedule($id = 0, $sh_table = 0, $date_min = '', $date_max = '',$time = ''){
    global $wpdb;
    $args = array();
    $where = ' WHERE ';
    
    if((int)$id != 0) $args[] = $wpdb->prepare(' sh.id = %d ', $id);
    if((int)$sh_table != 0) $args[] = $wpdb->prepare(' sh.shedule_table_id = %d ', $sh_table);
    if($date_min != '') $args[] = $wpdb->prepare(' sh.event_date >= %s ', date('Y-m-d',strtotime($date_min)));
    if($date_max != '') $args[] = $wpdb->prepare(' sh.event_date <= %s ', date('Y-m-d',strtotime($date_max)));
    if($time != '') $args[] = $wpdb->prepare(' sh.event_time = %s', date('H:i:s',strtotime($time)));
       
    $where .= implode(' AND ', $args);
    
    if(strlen($where) == 7){
        
        $query = 'SELECT sh.id, sh.title, sh.title_tooltip, sh.title_link, 
                                sh.description, sh.event_time, sh.event_date, 
                                sh.labels, sh.settings, sh.post_id, 
                                sh.shedule_table_id, sh.date_create, sh.date_update
                                 FROM '.SHEDULE_PRFX.'sh_shedule sh';

        $result = $wpdb->get_results($query);        
        
        if(!is_array($result)) return FALSE;
        foreach($result as &$key){
            $key->labels = maybe_unserialize($result->labels);
            $key->settings = maybe_unserialize($result->settings);
        }

    }else{
    
        $query = 'SELECT sh.id, sh.title, sh.title_tooltip, sh.title_link, 
                                sh.description, sh.event_time, sh.event_date, 
                                sh.labels, sh.settings, sh.post_id, 
                                sh.shedule_table_id, sh.date_create, sh.date_update
                                 FROM '.SHEDULE_PRFX.'sh_shedule sh 
                                 '.$where.' ORDER BY sh.event_time ASC, sh.event_date ASC';

        $result = $wpdb->get_results($query);
    
        if(!is_array($result)) return FALSE;  
            foreach($result as &$key){
                $key->labels = maybe_unserialize($key->labels);
                $key->settings = maybe_unserialize($key->settings);
            }     
    };

    return $result;
}

/**
 * Function set shedule to DB
 * 
 * @param array $args Have values title, title_tooltip, title_link, description, event_time, event_date, labels, settings, post_id, shedule_table_id, date_create, date_update
 * @return int|boolean Shedule insert id
 */
function set_shedule($args){
    global $wpdb;
    
    $title = strip_tags(htmlspecialchars($args['title']));
    $title_tooltip = wp_filter_post_kses($args['title_tooltip']);
    $title_link = strip_tags(htmlspecialchars($args['title_link']));
    $description = wp_filter_post_kses($args['description']);
    $event_time = date('H:i:s',strtotime(strip_tags(htmlspecialchars($args['event_time']))));
    $event_date = date('Y-m-d',strtotime(strip_tags(htmlspecialchars($args['event_date']))));
 
    if(is_array($args['labels'])){
        foreach($args['labels'] as $key => &$value){
            strip_tags(htmlspecialchars($value));
        }
        $labels = maybe_serialize($args['labels']);
    }else{
        $labels = '';
    }
        if(is_array($args['settings'])){
        foreach($args['settings'] as $key => &$value){
            strip_tags(htmlspecialchars($value));
        }
        $settings = maybe_serialize($args['settings']);
    }else{
        $settings = '';
    }
     $settings = mysql_real_escape_string($settings);
    $labels = mysql_real_escape_string($labels);
    $post_id = (int)$args['post_id'];
    $shedule_table_id = (int)$args['shedule_table_id'];

    $query = $wpdb->prepare("INSERT INTO ".SHEDULE_PRFX."sh_shedule(title, title_tooltip, title_link, 
                            description, event_time, event_date, labels, settings, post_id, 
                            shedule_table_id, date_create, date_update) 
                             VALUES(%s, %s, %s, %s, %s, %s, '{$labels}', '{$settings}', %d, %d, NOW(), NOW())", 
            array($title, $title_tooltip, $title_link, $description, $event_time, $event_date, $post_id, $shedule_table_id));

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
function update_shedule($id, $args){
    global $wpdb;
    
    if((int)$id == 0) return FALSE ; 
    
    $title = strip_tags(htmlspecialchars($args['title']));
    $title_tooltip = wp_filter_post_kses($args['title_tooltip']);
    $title_link = strip_tags(htmlspecialchars($args['title_link']));
    $description = wp_filter_post_kses($args['description']);
    $event_time = date('H:i:s',strtotime(strip_tags(htmlspecialchars($args['event_time']))));
    $event_date = date('Y-m-d',strtotime(strip_tags(htmlspecialchars($args['event_date']))));
    if(is_array($args['labels'])){
        foreach($args['labels'] as $key => &$value){
            strip_tags(htmlspecialchars($value));
        }
        $labels = maybe_serialize($args['labels']);
    }else{
        $labels = '';
    }
        if(is_array($args['settings'])){
        foreach($args['settings'] as $key => &$value){
            strip_tags(htmlspecialchars($value));
        }
        $settings = maybe_serialize($args['settings']);
    }else{
        $settings = '';
    }
    
    $settings = mysql_real_escape_string($settings);
    $labels = mysql_real_escape_string($labels);
    
    $post_id = (int)$args['post_id'];
    $shedule_table_id = (int)$args['shedule_table_id'];
    
    $query = $wpdb->prepare("UPDATE ".SHEDULE_PRFX."sh_shedule sh SET sh.title = %s, 
                                sh.title_tooltip = %s, sh.title_link = %s, 
                                sh.description = %s, sh.event_time = %s, sh.event_date = %s, 
                                sh.labels = '{$labels}', sh.settings = '{$settings}', sh.post_id = %d, 
                                sh.shedule_table_id = %d, sh.date_update = NOW() 
                             WHERE sh.id = %d ;", 
            array($title, $title_tooltip, $title_link, $description, $event_time, $event_date, $post_id, $shedule_table_id, $id));

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
function delete_shedule($id){
    global $wpdb;
    if((int)$id == 0) return FALSE ; 
    
    $query = $wpdb->prepare('DELETE FROM '.SHEDULE_PRFX.'sh_shedule 
                             WHERE id = %d ', $id);
    if($wpdb->query($query)){
        return TRUE;
    }else{
        return FALSE;
    }
}
?>
