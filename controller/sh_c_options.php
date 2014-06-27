<?php
/**
 * This class works with the option page
 * 
 * @package Shedule
 * @version 1.0.0
 */
/**
 * This class works with the option page
 * 
 * @package Shedule
 * 
 */
class ShCOptions{

    function __construct() {
        // Including script
        $this->enqueue_shedule();
        $action = isset($_GET['action']) ? $_GET['action'] : 'index';
        switch($action){
            case 'index' : 
                $this->index_option_page();
                break;
            case 'update' :
                $this->update_option_page();
                break;
            default :
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

    public function index_option_page(){
        include_once SHEDULE_URL.'/view/sh_v_option.php';
    }
    
    public function update_option_page(){

    }
    
}

new ShCOptions();
?>