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

