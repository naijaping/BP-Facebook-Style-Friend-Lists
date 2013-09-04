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

/***************************Start****************************************/


// Avatar list start 

	function bp_facebook_style_friend_list ($args) {
		global $bp;

	        extract( $args );
                global $displayed_user;
                $username = $displayed_user->user_login;
		echo $before_widget;
		echo $before_title
		   . 'Friends <a style="font-size:11px;color:#3B5998;float:right;margin-right:12px" href="' . bp_displayed_user_domain() . 'friends/">View All</a>'
		   . $after_title; ?>
		  
<?php if ( bp_has_members( 'type=newest&max=4&user_id='.bp_displayed_user_id() ) & is_user_logged_in() ) : ?>
	 <ul id="members-list" class="item-list">
	 <?php while ( bp_members() ) : bp_the_member(); ?>
         <li>
         <div class="item-avatar">
         <a href="<?php bp_member_permalink() ?>"><?php bp_member_avatar('type=full&width=50&height=50') ?></a></div>
         <div class="item">
         <div class="item-title">
	 <a href="<?php bp_member_permalink() ?>"><?php bp_member_name() ?></a>
         <p style="font-size:9px;">Friends ( <?php echo friends_get_total_friend_count( $user_id);?> )</p>
        <div class="clear"></div></div>
	<?php endwhile; ?>
         </div>
		
	<?php else: ?>


			<div class="widget-error">
				
                                <p><?php _e( "Sorry, no friends found.", 'bp-facebook-style-friend-list' ); ?></p>
			</div>

		<?php endif; ?>

		<?php echo $after_widget; ?>
<?php
	}

/**************************End*****************************************/

register_sidebar_widget('FB Style Friend List)','bp_facebook_style_friend_list');
?>
