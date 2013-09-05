<?php
/*
Plugin Name: BP Facebook Style Friend Lists 
Plugin URI: http://cityflavourmagazine.com
Description: Show Photos And Names of User's Friends Or Current Viewing Member's Friends  
Version: 1.0
Requires at least: WordPress 3.0 / BuddyPress 1.3
Tested up to: WordPress 3.6  / BuddyPress 1.8 
License: GNU/GPL 2
Author URI: http://cityflavourmagazine.com/
Author:Prince Abiola Ogundipe
*/


/**
 *  Make sure BuddyPress is loaded
 */
if ( !function_exists( 'bp_core_install' ) ) {
	require_once( ABSPATH . '/wp-admin/includes/plugin.php' );
	if ( is_plugin_active( 'buddypress/bp-loader.php' ) )
		require_once ( WP_PLUGIN_DIR . '/buddypress/bp-loader.php' );
	else
		return;
}

/**
 * bp_facebook_style_friend_list_register_widgets
 * register widget.
 */

function bp_facebook_style_friend_list_register_widgets() {
	add_action('widgets_init', create_function('', 'return register_widget("Bp_Facebook_Style_Friend_List_Widget");') );
}
add_action( 'plugins_loaded','bp_facebook_style_friend_list_register_widgets' );

class Bp_Facebook_Style_Friend_List_Widget extends WP_Widget {
	
	function bp_facebook_style_friend_list_widget() {
		$widget_ops = array('classname' => 'widget_facebook_style_friend_list','description' => __( "Show Photos And Names of User's Friends Or Current Viewing Member's Friends", "bp-facebook-style-friend-list") );
		parent::WP_Widget( false, $name = __('FB Style Friend List','bp-facebook-style-friend-list'), $widget_ops);
	}


