<?php
/**
 * @package Shedule
 */
/*
Plugin Name: Shedule
Plugin URI: http://biz-online.by
Description: Display all you trining
Version: 1.0.0
Author: Bondars Aleksandr
Author URI: banderos120@gmail.com
License: GPLv2 or later
*/

/*
This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
*/
/**
 * Version of plugin
 * 
 * @var string
 */
define('SHEDULE_VER', '1.0.0');

/**
 * Directory of plugin
 * 
 * @var string
 */
define('SHEDULE_DIR', plugin_dir_path( __FILE__ ));

/**
 * Url of plugin
 * 
 * @var string
 */
define('SHEDULE_URL', plugin_dir_url( __FILE__ ));

/**
 * Check administration rights
 * 
 * @var boolean
 */
define('SHEDULE_ADMIN', is_admin());
define('SHEDULE_ROLE', 'administrator');

/**
 * Get site url
 * 
 * @var string 
 */
define('SHEDULE_SITE_URL', get_site_url());

/**
 * Get admin url
 * 
 * @var string 
 */
define('SHEDULE_ADM_URL', get_admin_url());
global $wpdb;

/**
 * Database prefix
 * 
 * @var string
 */
define('SHEDULE_PRFX', $wpdb->prefix);

/**
 * Shedule class
 * 
 * @package Shedule
 * @author Bondars Aleksandr <banderos120@gmail.com> * 
 */
class Sh{
    
    function __construct() {
        load_plugin_textdomain('shedule', false, dirname( plugin_basename( __FILE__ ) ).'/languages/');
        //Install Plugin
        register_activation_hook(__FILE__, array($this, 'install'));
        //Uninstall Plugin
        register_deactivation_hook(__FILE__, array($this, 'uninstall'));
        //Add filters
        $this->get_filters();
        //Add entities
        $this->get_entities();        
        //Shortcode
        add_shortcode('shedule_table', array($this, 'get_shortcode'));
        //If admin page
        if(SHEDULE_ADMIN){
            $this->get_admin();
        };
    }
    
    /**
     * Includes filter files
     * 
     * @return void
     * @access public
     */   
    public function get_filters(){
        include_once SHEDULE_DIR.'/controller/sh_c_services.php';
    }
    
    /**
     * Includes filter files
     * 
     * @return void
     * @access public
     */   
    public function get_entities(){
        include_once SHEDULE_DIR.'/model/sh_m_shedule.php';
        include_once SHEDULE_DIR.'/model/sh_m_shedule_table.php';
    }
    
    public function get_shortcode($atts){
            wp_register_script('sh_shedule', SHEDULE_URL.'/js/sh_shedule.js');
            wp_enqueue_script('sh_shedule');        

            wp_register_style('sh_shedule_style', SHEDULE_URL.'/css/sh_style.css');
            wp_enqueue_style('sh_shedule_style');
        
            $id = (int)$atts['id'];
            $shedule_table = get_shedule_table($id);
            if(empty($shedule_table)) return FALSE;
            
            $day = 24*60*60;
            $day_count = (strtotime($shedule_table->date_time_end) - strtotime($shedule_table->date_time_begin))/$day;

            $day_curr_begin = date('w', strtotime($shedule_table->date_time_begin)) == 0 ? 7 : date('w', strtotime($shedule_table->date_time_begin));

            $shedule_table->date_day_begin = ($day_curr_begin != 1) ? strtotime($shedule_table->date_time_begin) - ($day_curr_begin - 1)*$day : strtotime($shedule_table->date_time_begin); 
            $date_day_begin = $shedule_table->date_day_begin;
            $shedule_date = $date_day_begin;  
            
                return include_once SHEDULE_DIR.'/view/sh_v_shedule_table_tmpl.php';
    }
    
    /**
     * Includes files for administrative panel
     * 
     * @return void
     * @access private
     */    
    private function get_admin(){
        include_once SHEDULE_DIR.'/controller/sh_c_admin.php';
    }
    /**
     * Gets files for installation
     * 
     * @return void
     * @access public
     */
    public function install(){
        include_once SHEDULE_DIR.'/model/sh_m_install.php';
    }
    /**
     * Gets files for deletion
     * 
     * @return void
     * @access private
     */
    private function uninstall(){
        include_once SHEDULE_DIR.'/model/sh_m_uninstall.php';
    }
}

new Sh();

?>
