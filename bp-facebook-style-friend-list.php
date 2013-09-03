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

function bp_facebook_style_friend_list_register_widgets() {
	add_action('widgets_init', create_function('', 'return register_widget("Bp_Facebook_Style_Friend_List_Widget");') );
}
add_action( 'plugins_loaded','bp_facebook_style_friend_list_register_widgets' );

class Bp_Facebook_Style_Friend_List_Widget extends WP_Widget {
	function bp_facebook_style_friend_list_widget() {
		$widget_opoo = array('classname' => 'widget_facebook_style_friend_list', 'description' => __( "Show Photos And Names of User's Friends Or Current Viewing Member's Friends", "bp-facebook-style-friend-list") );
		parent::WP_Widget( false, $name = __('FB Style Friend List','bp-facebook-style-friend-list'), $widget_opoo);
		
	}
	
	
	
  function widget( $args, $instance ) { 
 		   global $bp; 
 		   extract( $args ); 
 		   if ( bp_displayed_user_domain() ) { 
 		   $user_id = $bp->displayed_user->id; 
 		   $link = str_replace( bp_displayed_user_domain(), bp_displayed_user_domain(), bp_get_friends_slug() ); 
 		   $instance['title'] = sprintf( __( '%s friends', 'bp-facebook-style-friend-list' ), bp_get_displayed_user_fullname() ); 
 		 
 		   } elseif ( bp_loggedin_user_domain() ) { 
 		   $user_id = $bp->loggedin_user->id; 
 		   $link = trailingslashit( bp_loggedin_user_domain() . bp_get_friends_slug() ); 
 		   $instance['title'] = __( 'My friends', 'bp-facebook-style-friend-list' ); 
 		 
 		      } else { 
 		          return; 
 		          } 
 		 
 		          if ( !$instance['friend_default'] ) 
 	                 $instance['friend_default'] = 'active'; 
 		 
 		         $title = apply_filters( 'widget_title', $instance['title'] ); 
 		 
 		           echo $before_widget; 
 		 
 		            $title = $instance['link_title'] ? '<a href="' . $link . '">' . $title . '</a>' : $title; 
 		 
 		            echo $before_title 
 		              . $title 
 		              . $after_title; ?> 
 		 
<?php if ( bp_has_members( 'user_id=' . $user_id . '&type=' . $instance['friend_default'] . '&max=' . $instance['max_friends'] . '&populate_extras=1' ) ) : ?>
<ul id="members-list" class="item-list">
	 <?php while ( bp_members() ) : bp_the_member(); ?>
         <li>
         <div class="item-avatar">
         <a href="<?php bp_member_permalink() ?>"><?php bp_member_avatar('type=full&width=40&height=40') ?></a></div>
         <div class="item">
         <div class="item-title">
	 <a href="<?php bp_member_permalink() ?>"><?php bp_member_name() ?></a>
         <div class="clear"></div></div>
	<?php endwhile; ?>
         </div>
		
	<?php else: ?>

	<<?php echo $after_widget; ?> 
 		        <?php 
 		        } 
function update( $new_instance, $old_instance ) { 
 		                $instance = $old_instance; 
 		 
 		                $instance['max_friends']    = strip_tags( $new_instance['max_friends'] ); 
 		                $instance['friend_default'] = strip_tags( $new_instance['friend_default'] ); 
 		                $instance['link_title']     = (bool)$new_instance['link_title']; 
 		 
 		                return $instance; 
 		        } 
 		 
 		        function form( $instance ) { 
 		                $defaults = array( 
 		                        'max_friends'    => 5, 
 		                        'friend_default' => 'active', 
 		                        'link_title'     => false 
 		                ); 
 		                $instance = wp_parse_args( (array) $instance, $defaults ); 
 		 
 		                $max_friends    = strip_tags( $instance['max_friends'] ); 
 		                $friend_default = strip_tags( $instance['friend_default'] ); 
 		                $link_title     = (bool)$instance['link_title']; 
 	                ?> 
 	
 <p><label for="<?php echo $this->get_field_name('link_title') ?>"><input type="checkbox" name="<?php echo $this->get_field_name('link_title') ?>" value="1" <?php checked( $link_title ) ?> /> <?php _e( 'Link widget title to Members directory', 'bp-facebook-style-friend-list' ) ?></label></p> 
 		 
 <p><label for="bp-facebook-style-friend-list-max"><?php _e('Max friends to show:', 'bp-facebook-style-friend-list'); ?> <input class="widefat" id="<?php echo $this->get_field_id( 'max_friends' ); ?>" name="<?php echo $this->get_field_name( 'max_friends' ); ?>" type="text" value="<?php echo esc_attr( $max_friends ); ?>" style="width: 30%" /></label></p> 
 		 
 		                
	<?php
	}
}

?>
