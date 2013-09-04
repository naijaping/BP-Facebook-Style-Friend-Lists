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


function bp_facebook_style_friend_list( $args, $instance ) {
	       global $bp;
               if(bp_show_friends_is_user()){
			$user_id = $bp->displayed_user->id;
			$user_all_friends_url = $bp->displayed_user->domain . BP_FRIENDS_SLUG;
			$user_name = $bp->displayed_user->fullname;
		}
		elseif(is_user_logged_in()){
			$user_id = $bp->loggedin_user->id;
			$user_all_friends_url = $bp->loggedin_user->domain . BP_FRIENDS_SLUG;
			$user_name = $bp->loggedin_user->fullname;
                        extract( $args );
                        echo $before_widget;
                        echo $before_title;
			if(!bp_show_friends_is_user() || $bp->loggedin_user->id == $bp->displayed_user->id)printf( __( "My Friends<a href='%s'>See All</a>", 'bp-show-friends' ), $user_all_friends_url);
			else printf( __( 'Friends <a href="%2$s">See All</a>', 'bp-show-friends' ), $user_name, $user_all_friends_url);
		        echo $after_title; ?>
<?php if ( bp_has_members( 'user_id=0&type=newest&max='. $instance['max_num'] .'&populate_extras=0' ) ) : ?>
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

	<div class="widget-error">
	<?php _e( 'Sorry no newest member ', 'bp-facebook-style-friend-list' ) ?>
	</ul></div>

	<?php endif; ?>

<?php echo $after_widget; ?>

<?php
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
		
		<p><label for="bp-facebook-style-friend-list-max-num"><?php _e( 'Max Number of Members:','bp-facebook-style-friend-list' ); ?> <input class="widefat" id="<?php echo $this->get_field_id( 'max_num' ); ?>" name="<?php echo $this->get_field_name( 'max_num' ); ?>" type="text" value="<?php echo attribute_escape( $max_num ); ?>" style="width: 30%" /></label></p>
		
	<?php
	}
}
?>
		
               








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
