<?php
/**
 * Plugin Name: WP Anti-Clickjack
 * Plugin URI: https://drawne.com/wordpress-anti-clickjack-plugin/
 * Description: Plugin to prevent your site from being clickjacked
 * Version: 1.4.0
 * Text Domain: wp-anti-clickjack
 * Author: Andy Feliciotti
 * Author URI: https://drawne.com
 */

defined('ABSPATH') or die("you do not have access to this page!");

class wp_anticlickjack {

    public function __construct()
    {	    
	  add_action('admin_head', array($this,'include_anticlickjack_script'));
      add_action('wp_head', array($this,'include_anticlickjack_script'));
      add_action('login_head', array($this,'include_anticlickjack_script'));
	}

    public function include_anticlickjack_script() {
	    
	    $pagebuilder = false;

	    if( class_exists('\Elementor\Plugin') ){
		    if(\Elementor\Plugin::$instance->preview->is_preview_mode() || \Elementor\Plugin::$instance->editor->is_edit_mode()){
			    $pagebuilder = true;
		    }
	    }
	    
	    if ( !is_customize_preview() && !$pagebuilder ) {
	        echo '<script language="javascript" type="text/javascript">
			 var style = document.createElement("style");
			 style.type = "text/css";
			 style.id = "antiClickjack";
			 if ("cssText" in style){
			   style.cssText = "body{display:none !important;}";
			 }else{
			   style.innerHTML = "body{display:none !important;}";
			}
			document.getElementsByTagName("head")[0].appendChild(style);

			if (top === self) {
			 var antiClickjack = document.getElementById("antiClickjack");
			 antiClickjack.parentNode.removeChild(antiClickjack);
			} else {
			 top.location = self.location;
			}
		  </script>';
		}
    }
}

$wp_anticlickjack = new wp_anticlickjack();
unset($wp_anticlickjack);
