<?php
/**
 * This class works with the schedule table
 * 
 * @package Shedule
 * @version 1.0.0
 */
/**
 * This class works with the schedule table
 * 
 * @package Shedule
 * 
 */
class ShCSheduleTable{

    function __construct() {
        // Including script
        $this->enqueue_shedule();
        $action = isset($_GET['action']) ? $_GET['action'] : 'index';
        switch($action){
            case 'index' : 
                $id = (int)$_GET['id'];
                $this->index_shedule_table($id);
                break;
            case 'add' :
                $this->add_shedule_table();
                break;
            case 'create' : 
                $this->create_shedule_table();
                break;
            case 'edit' :
                $id = (int)$_GET['id'];
                $this->edit_shedule_table($id);
                break;
            case 'delete' :
                $id = (int)$_GET['id'];
                $this->delete_shedule_table($id);
                break;
            case 'update' :
                $id = (int)$_GET['id'];
                $this->update_shedule_table($id);
                break;
            default :
                wp_redirect($location);
                break;
        }
    }
    
    public function enqueue_shedule(){
        wp_enqueue_script('jquery');
        wp_enqueue_script('jquery-ui-core');
        wp_enqueue_script('post');
        wp_register_script('jquery-datepicker', SHEDULE_URL.'/js/jquery-ui-1.10.4.custom/js/jquery-ui-1.10.4.custom.min.js', array('jquery', 'jquery-ui-core' ));
        wp_enqueue_script('jquery-datepicker');
        
        wp_register_style('jquery-datepicker-style', SHEDULE_URL.'/js/jquery-ui-1.10.4.custom/css/flick/jquery-ui-1.10.4.custom.min.css');
        wp_enqueue_style('jquery-datepicker-style');
        
        wp_enqueue_script('wp-color-picker');
        wp_enqueue_style( 'wp-color-picker' );    
        
        wp_register_script('sh_shedule', SHEDULE_URL.'/js/sh_shedule.js');
        wp_enqueue_script('sh_shedule');        
        
        wp_register_style('sh_shedule_style', SHEDULE_URL.'/css/sh_style.css');
        wp_enqueue_style('sh_shedule_style');
    }

    public function index_shedule_table($id){
        $shedule_table = get_shedule_table($id);
        if(is_object($shedule_table)){

            $day = 24*60*60;
            $day_count = (strtotime($shedule_table->date_time_end) - strtotime($shedule_table->date_time_begin))/$day;

            $day_curr_begin = date('w', strtotime($shedule_table->date_time_begin)) == 0 ? 7 : date('w', strtotime($shedule_table->date_time_begin));

            $shedule_table->date_day_begin = ($day_curr_begin != 1) ? strtotime($shedule_table->date_time_begin) - ($day_curr_begin - 1)*$day : strtotime($shedule_table->date_time_begin); 
            $date_day_begin = $shedule_table->date_day_begin;
            $shedule_date = $date_day_begin;  
            
            return include_once SHEDULE_DIR.'/view/sh_v_shedule_table_tmpl.php';
        }else{
            $error = __('Unable to find schedules. Try adding a new','shedule');
            do_action('shedule/flash', 'error', $error, 'error');            
            return include_once SHEDULE_DIR.'/view/sh_v_add_shedule_table.php';              
        }
    }
    
    public function add_shedule_table(){
        return include_once SHEDULE_DIR.'/view/sh_v_add_shedule_table.php';
    }
    
    public function create_shedule_table(){
        $error = '';
        
        if(isset($_POST['sh_add_table_nonce'])){
            $args = array('title', 'desc', 'date_begin', 'date_end');
            if(empty($_POST['sh_table_title'])) $error .= __('Titile is empty. ', 'shedule');
            if(empty($_POST['sh_table_date_begin'])) $error .= __('Begining date is none checked. ', 'shedule');
            if(empty($_POST['sh_table_date_end'])) $error .= __('End date is none checked. ', 'shedule');
            if($error){
                do_action('shedule/flash', 'error', $error, 'error');
                return include_once SHEDULE_DIR.'/view/sh_v_add_shedule_table.php';
            }
            
            $args['title'] = $_POST['sh_table_title'];
            $args['desc'] = $_POST['sh_table_desc'];
            $args['labels'] = $_POST['sh_table_labels'];
            $args['date_begin'] = $_POST['sh_table_date_begin'];
            $args['date_end'] = $_POST['sh_table_date_end'];
            // Insert ot the database
            $id = set_shedule_table($args);
            
            if($id){
                $message = __('Shedule has bin saved','shedule');
                do_action('shedule/flash', 'done', $message, 'updated');                
                return $this->edit_shedule_table($id);
            }else{
                $error = __('Shedule can not insert to the base','shedule');
                do_action('shedule/flash', 'error', $error, 'error');
                return include_once SHEDULE_DIR.'/view/sh_v_add_shedule_table.php';                
            };
        }
          return include_once SHEDULE_DIR.'/view/sh_v_add_shedule_table.php';           
    }
    
    public function edit_shedule_table($id){
        $shedule = get_shedule_table($id);
        if(is_object($shedule)){
            return include_once SHEDULE_DIR.'/view/sh_v_edit_shedule_table.php';
        }else{
            $error = __('Unable to find schedules. Try adding a new','shedule');
            do_action('shedule/flash', 'error', $error, 'error');            
            return include_once SHEDULE_DIR.'/view/sh_v_add_shedule_table.php';              
        }
    }
    
    public function delete_shedule_table($id){
        $shedule = get_shedule_table($id);
        if(is_object($shedule)){
            if(delete_shedule_table($id)){
                return include_once SHEDULE_DIR.'/view/sh_v_shedule_table.php';
            }else{
                $error = __('Shedule does not delete','shedule');
                do_action('shedule/flash', 'error', $error, 'error');
                return include_once SHEDULE_DIR.'/view/sh_v_edit_shedule_table.php';                  
            }
        }else{
            $error = __('Unable to find schedules. Try adding a new','shedule');
            do_action('shedule/flash', 'error', $error, 'error');            
            return include_once SHEDULE_DIR.'/view/sh_v_add_shedule_table.php';              
        }
    }
    
    public function update_shedule_table($id){
        $error = '';
        
        $shedule = get_shedule_table($id);
        
        if(!is_object($shedule)){
            $error = __('Unable to find schedules. Try adding a new','shedule');
            do_action('shedule/flash', 'error', $error, 'error');            
            return include_once SHEDULE_DIR.'/view/sh_v_add_shedule_table.php';              
        }       
        
        if(isset($_POST['sh_add_table_nonce'])){
            $args = array('title', 'desc', 'date_begin', 'date_end');
            
            $shedule->title = $_POST['sh_table_title'];
            $shedule->description  = $_POST['sh_table_desc'];
            $shedule->date_time_begin = $_POST['sh_table_date_begin'];
            $shedule->date_time_end = $_POST['sh_table_date_end'];
            
            if(empty($_POST['sh_table_title'])) $error .= __('Titile is empty. ', 'shedule');
            if(empty($_POST['sh_table_date_begin'])) $error .= __('Begining date is none checked. ', 'shedule');
            if(empty($_POST['sh_table_date_end'])) $error .= __('End date is none checked. ', 'shedule');
            
            if($error){
                do_action('shedule/flash', 'error', $error, 'error');
                return include_once SHEDULE_DIR.'/view/sh_v_edit_shedule_table.php';
            }
            
            $args['title'] = $_POST['sh_table_title'];
            $args['desc'] = $_POST['sh_table_desc'];
            $args['date_begin'] = $_POST['sh_table_date_begin'];
            $args['date_end'] = $_POST['sh_table_date_end'];
            $args['labels'] = $_POST['sh_table_labels'];
            // Insert ot the database
            $result = update_shedule_table($id, $args);
            
            if($result){
                $message = __('Shedule has bin saved','shedule');
                do_action('shedule/flash', 'done', $message, 'updated');                
                return $this->edit_shedule_table($id);
            }else{
                $error = __('Shedule does not update','shedule');
                do_action('shedule/flash', 'error', $error, 'error');
                return include_once SHEDULE_DIR.'/view/sh_v_edit_shedule_table.php';                
            };
        }
        return include_once SHEDULE_DIR.'/view/sh_v_add_shedule_table.php';   
    }
    
}

new ShCSheduleTable();
?>