<?php
/**
 * Generate administration menu, and administration pages.
 * 
 * If the user will be in the administration panel, then this class will be launched.
 * @package Shedule
 * @version 1.0.0
 */
/**
 * Class generates administrative panel plugin
 * 
 * @package Shedule
 * 
 */
class ShCAdmin{
    
    function __construct() {
        if(SHEDULE_ADMIN){
            $this->actions();
        }else{
            return false;
        };
    }
    
    private function actions(){
        add_action('init', array($this, 'sh_session_start'), 1);
        add_action('wp_logout', array($this, 'sh_session_end'));
        add_action('wp_login', array($this, 'sh_session_end'));
        add_action('admin_menu', array($this, 'menu'));
    }
    
    public function sh_session_start(){
        if(!session_id()){
            session_start();
        }
    }

    public function sh_session_end(){
        session_destroy();
    }

    private function filters(){
        
    }

    public function menu(){
        add_submenu_page( null ,__('Shedule Post', 'shedule'), __('Shedule Post', 'shedule'), 'manage_options', 'sh_shedule', array($this, 'shedule'));
        add_submenu_page( null ,__('Shedule Table', 'shedule'), __('Shedule Table', 'shedule'), 'manage_options', 'sh_shedule_table', array($this, 'shedule_table'));
        add_submenu_page( null ,__('Options', 'shedule'), __('Options', 'shedule'), 'manage_options', 'sh_options', array($this, 'options'));
        
        add_menu_page(__('Shedule', 'shedule'), __('Shedule', 'shedule'), 'manage_options', 'shedule', array($this, 'get_table'), 'dashicons-feedback', 8);
        add_submenu_page('shedule',__('Add Shedule Table', 'shedule'), __('Add Shedule Table', 'shedule'), 'manage_options', 'admin.php?page=sh_shedule_table&action=add');
        add_submenu_page('shedule',__('Options', 'shedule'), __('Options', 'shedule'), 'manage_options', 'admin.php?page=sh_options&action=index');
    }

    public function options(){
        include_once SHEDULE_DIR.'/view/sh_c_options.php';          
    }
    
    public function get_table(){
        wp_register_script('sh_shedule', SHEDULE_URL.'/js/sh_shedule.js');
        wp_enqueue_script('sh_shedule');        
        
        wp_register_style('sh_shedule_style', SHEDULE_URL.'/css/sh_style.css');
        wp_enqueue_style('sh_shedule_style');        
        $shedule_tables = get_shedule_table();
        include_once SHEDULE_DIR.'/view/sh_v_shedule_table.php';        
    }
    
    public function shedule_table(){
        include_once SHEDULE_DIR.'/controller/sh_c_shedule_table.php';
    }
    
    public function shedule(){
        include_once SHEDULE_DIR.'/controller/sh_c_shedule.php';
    }    
    
}

new ShCAdmin();
?>