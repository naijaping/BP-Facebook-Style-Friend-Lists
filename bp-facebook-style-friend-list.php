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
		if(bp_facebook_style_friend_list_is_user()){
			$user_id = $bp->displayed_user->id;
			$user_all_friends_url = $bp->displayed_user->domain . BP_FRIENDS_SLUG;
			$user_name = $bp->displayed_user->fullname;
		}
		elseif(is_user_logged_in()){
			$user_id = $bp->loggedin_user->id;
			$user_all_friends_url = $bp->loggedin_user->domain . BP_FRIENDS_SLUG;
			$user_name = $bp->loggedin_user->fullname;
		}
		?>
                        <?php
			extract( $args );
			echo $before_widget;
			echo $before_title;
			if(!bp_show_friends_is_user() || $bp->loggedin_user->id == $bp->displayed_user->id) printf( __( "My Friends - <a href='%s'>All</a>", 'bp-facebook-style-friend-list' ), $user_all_friends_url);
			else printf( __( '%1$s&apos;s Friends - <a href="%2$s">All</a>', 'bp-facebook-style-friend-list' ), $user_name, $user_all_friends_url);
		    echo $after_title; ?>

 function bp_facebook_style_friend_list_show_list($user_id,$max_num){
 if ( bp_has_members( 'user_id='.$user_id ) ) : ?>
<ul id="widget-members-friends-list" class="item-list">
<?php while ( bp_members() ) : bp_the_member(); ?>
<li>
<div class="item-avatar">
<a href="<?php bp_member_permalink(); ?>"><?php bp_member_avatar(); ?></a>
</div>
<div class="item">
<div class="item-title">
<a href="<?php bp_member_permalink(); ?>"><?php bp_member_name(); ?></a>
</div>
<div class="clear"></div>
		</li>
<?php endwhile; ?>

	</ul>

<?php else: ?>

<p><?php _e( "Sorry, no friends found.", 'bp-facebook-style-friend-list' ); ?></p>
	

<?php endif; 

}

function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['max_num'] = strip_tags( $new_instance['max_num'] );

		return $instance;
	}

	function form( $instance ) {
		$instance = wp_parse_args( (array) $instance, array( 'max_num' => 5 ) );
		$max_num = strip_tags( $instance['max_num'] );
		?>
		
		<p><label for="bp-facebook-style-friend-list-widget-max-num"><?php _e( 'Max Number of Friends:','bp-facebook-style-friend-list' ); ?> <input class="widefat" id="<?php echo $this->get_field_id( 'max_num' ); ?>" name="<?php echo $this->get_field_name( 'max_num' ); ?>" type="text" value="<?php echo attribute_escape( $max_num ); ?>" style="width: 30%" /></label></p>
		
	<?php
	}
}

?>
