<?php
/**
 * This class register filters
 * 
 * @package Shedule
 * @version 1.0.0
 * @author Bondars Aleksandr <banderos120@gmail.com>
 */

/**
 * This class register filters
 * 
 * @package Shedule
 * 
 */

class ShCServices{
    
    public $error = '';
    
    function __construct() {
        add_filter('shedule/validate_content', array($this, 'validate_content'));
        add_filter('shedule/validate_date', array($this, 'validate_date'));
        add_filter('shedule/validate_int', array($this, 'validate_int'));
        add_filter('shedule/validate_link', array($this, 'validate_link'));
        
        add_filter('shedule/get_title', array($this, 'get_title'));
        add_filter('shedule/get_tooltip', array($this, 'get_tooltip'));
        add_filter('shedule/get_excerpt', array($this, 'get_excerpt'));
        
        add_action('shedule/flash', array($this, 'flash'), 10, 3);
    }
    
    public function validate_content($content){
        
        return $content;
    }
    
    public function validate_date($date){
        
        return $date;
    }
    
    public function validate_int($int){
        
        return $int;
    }
    
    public function validate_link($link){
        
        return $link;
    } 
    
    public function get_title(stdClass $shedule){
        
        $settings = $shedule->settings;
        $target = (!empty($settings['sh_title_link_tab'])) ? 'target="_blank"' : '';

        if(!empty($shedule->post_id) && !empty($settings['sh_post_link'])){
        
            $post   = get_post((int)$shedule->post_id);
            $link   = $post->guid;
            $title  = sprintf("<a href=\"%s\" %s>%s</a>", $link, $target, $shedule->title);
        }elseif(!empty($shedule->title_link)){
            $link  = $shedule->title_link;
            $title = sprintf("<a href=\"%s\" %s>%s</a>", $link, $target, $shedule->title);
        }else{
            $title = $shedule->title; 
        }
        
        return $title;
                
    }
    
    public function get_tooltip(stdClass $shedule){
        
        $settings = $shedule->settings;
        
        if(!empty($shedule->post_id) && !empty($settings['sh_title_exc_tooltip'])){
        
            $post   = get_post((int)$shedule->post_id);
            $tooltip   = $post->post_excerpt;
            
        }elseif(!empty($shedule->post_id) && !empty($settings['sh_title_desc_tooltip'])){
            
            $post   = get_post((int)$shedule->post_id);
            $tooltip   = $post->post_content;
            
        }else{
            $tooltip = stripslashes($shedule->title_tooltip);
        }
        
        return $tooltip;        
        
    }
    
    public function get_excerpt(stdClass $shedule){
        
        $settings = $shedule->settings;
        
        if(!empty($shedule->post_id) && !empty($settings['sh_content_desc'])){
        
            $post   = get_post((int)$shedule->post_id);
            $desc   = $post->post_content;
            
        }else{
            $desc = stripslashes($shedule->description);
        }
        
        return $desc;          
        
    }
    
    public function flash($flash_name = '', $flash_message = '', $flash_class = 'flash'){
        if(!empty($flash_name)){
            if(!empty($flash_message)){
                if(empty($_SESSION[$flash_name])){
                    $_SESSION[$flash_name] = $flash_message;
                }else{
                    unset($_SESSION[$flash_name]);
                    $_SESSION[$flash_name] = $flash_message;
                }                
                if(empty($_SESSION[$flash_name.'_class'])){
                    $_SESSION[$flash_name.'_class'] = $flash_class;
                }else{
                    unset($_SESSION[$flash_name.'_class']);
                    $_SESSION[$flash_name.'_class'] = $flash_class;
                }                
            }else{
                if(!empty($_SESSION[$flash_name])){
                    echo '<div class="'.$_SESSION[$flash_name.'_class'].'">'.$_SESSION[$flash_name].'</div>';
                    unset($_SESSION[$flash_name]);
                    unset($_SESSION[$flash_name.'_class']);
                }
            }
        }
    }
    
}

new ShCServices();
?>
