<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class ShCShedule{
    
    public function __construct() {
        // Include script
        $this->enqueue_shedule();
        $action = isset($_GET['action']) ? $_GET['action'] : 'index';
        switch($action){
            case 'index' : 
                break;
            case 'add' :
                $table_id = (int)$_GET['table_id'];                
                $this->add_shedule($table_id);
                break;
            case 'create' : 
                $table_id = (int)$_GET['table_id']; 
                $this->create_shedule($table_id);
                break;
            case 'edit' :
                $id = (int)$_GET['id'];     
                $this->edit_shedule($id);
                break;
            case 'delete' :
                $id = (int)$_GET['id'];
                $this->delete_shedule($id);
                break;
            case 'update' :
                $id = (int)$_GET['id'];
                $this->update_shedule($id);
                break;
            default :
                
        }
    }
    
    public function enqueue_shedule(){
        wp_enqueue_script('jquery');
        wp_enqueue_script('jquery-ui-core');
        wp_enqueue_script('jquery-ui-datepicker');
        wp_enqueue_script('post');
        
        wp_enqueue_script('wp-color-picker');
        wp_enqueue_style( 'wp-color-picker' );        
        
        wp_register_script('sh-jquery-chosen', SHEDULE_URL.'/js/chosen_v1.1.0/chosen.jquery.min.js', array('jquery', 'jquery-ui-core' ));
        wp_enqueue_script('sh-jquery-chosen');
        
        wp_register_style('sh-chosen-style', SHEDULE_URL.'/js/chosen_v1.1.0/chosen.min.css');
        wp_enqueue_style('sh-chosen-style');        
        
        wp_deregister_style('wp-jquery-ui-dialog');
        
        wp_register_style('jquery-datepicker-style', SHEDULE_URL.'/js/jquery-ui-1.10.4.custom/css/flick/jquery-ui-1.10.4.custom.min.css');
        wp_enqueue_style('jquery-datepicker-style');
        
        wp_register_script('sh_shedule', SHEDULE_URL.'/js/sh_shedule.js');
        wp_enqueue_script('sh_shedule');        
        
        wp_register_style('sh_shedule_style', SHEDULE_URL.'/css/sh_style.css');
        wp_enqueue_style('sh_shedule_style');
        
        wp_register_style('sh_timepicker_style', SHEDULE_URL.'/css/jquery.ui.timepicker.css');
        wp_enqueue_style('sh_timepicker_style');
        
        wp_register_script('sh_timepicker_script', SHEDULE_URL.'/js/jquery.ui.timepicker/jquery.ui.timepicker.js');
        wp_enqueue_script('sh_timepicker_script');        
    }
    
    public function add_shedule($table_id){
        $shedule_table = get_shedule_table($table_id);
        if(is_object($shedule_table)){
           return include_once SHEDULE_DIR.'/view/sh_v_add_shedule.php';
        }else{
            $error = __('Unable to find schedules. Try adding a new','shedule');
            do_action('shedule/flash', 'error', $error, 'error');            
            return include_once SHEDULE_DIR.'/view/sh_v_add_shedule_table.php';              
        }
    }
    
    public function create_shedule($table_id){
        $error = '';
        $shedule_table = get_shedule_table($table_id);
        if(!is_object($shedule_table)) return include_once SHEDULE_DIR.'/view/sh_v_add_shedule.php';
        if(isset($_POST['sh_add_nonce'])){
            $args = array('title'
                , 'title_tooltip'
                , 'title_link'
                , 'description'
                , 'event_time'
                , 'event_date'
                , 'labels'
                , 'settings'
                , 'post_id'
                , 'shedule_table_id');
            if(empty($_POST['sh_title'])) $error .= __('Titile is empty. ', 'shedule');
            if(empty($_POST['sh_date'])) $error .= __('Date is none checked. ', 'shedule');
            if(empty($_POST['sh_time'])) $error .= __('Time is none checked. ', 'shedule');
            if($error){
                do_action('shedule/flash', 'error', $error, 'error');
                return include_once SHEDULE_DIR.'/view/sh_v_add_shedule.php';
            }
            
            $args['title'] = $_POST['sh_title'];
            $args['title_tooltip'] = $_POST['sh_title_tooltip'];
            $args['title_link'] = $_POST['sh_title_link'];
            $args['description'] = $_POST['sh_description'];
            $args['event_time'] = $_POST['sh_time'];
            $args['event_date'] = $_POST['sh_date'];
            $args['labels'] = !empty($_POST['sh_labels']) ? $_POST['sh_labels'] : '';
            $args['settings'] = !empty($_POST['option']) ? $_POST['option'] : '';
            $args['post_id'] = $_POST['sh_post_id'];
            $args['shedule_table_id'] = $_POST['shedule_table_id'];
            
            // Insert ot the database
            $id = set_shedule($args);
            
            if($id){
                $message = __('Shedule has bin saved','shedule');
                do_action('shedule/flash', 'done', $message, 'updated');                
                return $this->edit_shedule($id);
            }else{
                $error = __('Shedule can not insert to the base','shedule');
                do_action('shedule/flash', 'error', $error, 'error');
                return include_once SHEDULE_DIR.'/view/sh_v_add_shedule.php';                
            };
        }
        return include_once SHEDULE_DIR.'/view/sh_v_add_shedule.php';            
    }
    
    public function edit_shedule($id){
        $shedule = get_shedule($id);
        $shedule = is_array($shedule) ? $shedule[0] : NULL ;
        if(is_object($shedule)){
            $shedule_table = get_shedule_table($shedule->shedule_table_id);
            if(is_object($shedule_table)){
                return include_once SHEDULE_DIR.'/view/sh_v_edit_shedule.php';
            }else{
                $error = __('Unable to find schedules. Try adding a new','shedule');
                do_action('shedule/flash', 'error', $error, 'error');            
                return include_once SHEDULE_DIR.'/view/sh_v_add_shedule.php';                              
            }    
        }else{
            $error = __('Unable to find schedules. Try adding a new','shedule');
            do_action('shedule/flash', 'error', $error, 'error');            
            return include_once SHEDULE_DIR.'/view/sh_v_add_shedule.php';              
        }        
    }
    
    public function delete_shedule($id){
        if(!$id) return FALSE;
        $shedule = get_shedule($id);
        if(empty($shedule)) return FALSE;
        delete_shedule($id);
        $shedule_table = get_shedule_table($shedule[0]->id);
        return include_once SHEDULE_DIR.'/view/sh_v_shedule_table_tmpl.php'; 
    }
    
    public function update_shedule($id){
        $error = '';
        $shedule = get_shedule($id);
        $shedule = is_array($shedule) ? $shedule[0] : NULL ;
        if(is_object($shedule)){
            $shedule_table = get_shedule_table($shedule->shedule_table_id);
            if(!is_object($shedule_table)){
                $error = __('Unable to find schedules. Try adding a new','shedule');
                do_action('shedule/flash', 'error', $error, 'error');            
                return include_once SHEDULE_DIR.'/view/sh_v_add_shedule.php';                              
            }    
        }        
        if(isset($_POST['sh_add_nonce'])){
            $args = array('title'
                , 'title_tooltip'
                , 'title_link'
                , 'description'
                , 'event_time'
                , 'event_date'
                , 'labels'
                , 'settings'
                , 'post_id'
                , 'shedule_table_id');
            if(empty($_POST['sh_title'])) $error .= __('Titile is empty. ', 'shedule');
            if(empty($_POST['sh_date'])) $error .= __('Date is none checked. ', 'shedule');
            if(empty($_POST['sh_time'])) $error .= __('Time is none checked. ', 'shedule');
            if($error){
                do_action('shedule/flash', 'error', $error, 'error');
                return include_once SHEDULE_DIR.'/view/sh_v_add_shedule.php';
            }
            
            $args['title'] = $_POST['sh_title'];
            $args['title_tooltip'] = $_POST['sh_title_tooltip'];
            $args['title_link'] = $_POST['sh_title_link'];
            $args['description'] = $_POST['sh_description'];
            $args['event_time'] = $_POST['sh_time'];
            $args['event_date'] = $_POST['sh_date'];
            $args['labels'] = !empty($_POST['sh_labels']) ? $_POST['sh_labels'] : array();
            $args['settings'] = !empty($_POST['option']) ? $_POST['option'] : array();
            $args['post_id'] = $_POST['sh_post_id'];
            $args['shedule_table_id'] = $_POST['shedule_table_id'];
            
            // Insert ot the database
            $result = update_shedule($shedule->id, $args);
            
            if($result){
                $message = __('Shedule has bin saved','shedule');
                do_action('shedule/flash', 'done', $message, 'updated');                
                return $this->edit_shedule($shedule->id);
            }else{
                $error = __('Shedule can not insert to the base','shedule');
                do_action('shedule/flash', 'error', $error, 'error');
                return include_once SHEDULE_DIR.'/view/sh_v_add_shedule.php';                
            };
        }
         return include_once SHEDULE_DIR.'/view/sh_v_add_shedule.php';           
    }        
    
}

new ShCShedule();

?>
