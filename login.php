<?php
/*
Plugin Name: Login Widget
Plugin URI: http://avifoujdar.wordpress.com/category/my-wp-plugins/
Description: This is a simple login form in the widget. just install the plugin and add the login widget in the sidebar. Thats it. :)
Version: 1.0
Author: AFO
Author URI: http://avifoujdar.wordpress.com/
*/

/**
	  |||||   
	<(`0_0`)> 	
	()(afo)()
	  ()-()
**/

class login_wid extends WP_Widget {
	
	public function __construct() {
		add_action( 'wp_enqueue_scripts', array( $this, 'register_plugin_styles' ) );
		parent::__construct(
	 		'login_wid',
			'Login Widget AFO',
			array( 'description' => __( 'This is a simple login form in the widget.', 'text_domain' ), )
		);
	 }

	public function widget( $args, $instance ) {
		extract( $args );
		
		$wid_title = apply_filters( 'widget_title', $instance['wid_title'] );
		
		echo $args['before_widget'];
		if ( ! empty( $wid_title ) )
			echo $args['before_title'] . $wid_title . $args['after_title'];
			$this->loginForm( $instance );
		echo $args['after_widget'];
	}

	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['wid_title'] = strip_tags( $new_instance['wid_title'] );
		$instance['redirect_page'] = strip_tags( $new_instance['redirect_page'] );
		$instance['logout_redirect_page'] = strip_tags( $new_instance['logout_redirect_page'] );
		$instance['link_in_username'] = strip_tags( $new_instance['link_in_username'] );
		return $instance;
	}


	public function form( $instance ) {
		$wid_title = $instance[ 'wid_title' ];
		$redirect_page = $instance[ 'redirect_page' ];
		$logout_redirect_page = $instance[ 'logout_redirect_page' ];
		$link_in_username = $instance[ 'link_in_username' ];
		?>
		<p><label for="<?php echo $this->get_field_id('wid_title'); ?>"><?php _e('Title:'); ?> </label>
		<input class="widefat" id="<?php echo $this->get_field_id('wid_title'); ?>" name="<?php echo $this->get_field_name('wid_title'); ?>" type="text" value="<?php echo $wid_title; ?>" />
		</p>
		<p><label for="<?php echo $this->get_field_id('redirect_page'); ?>"><?php _e('Login Redirect Page:'); ?> </label><br />
		<?php
			$args = array(
			'depth'            => 0,
			'selected'         => $redirect_page,
			'echo'             => 1,
			'show_option_none' => '-',
			'id' 			   => $this->get_field_id('redirect_page'),
			'name'             => $this->get_field_name('redirect_page')
			);
			wp_dropdown_pages( $args ); 
		?>
		</p>
		<p><label for="<?php echo $this->get_field_id('logout_redirect_page'); ?>"><?php _e('Logout Redirect Page:'); ?> </label><br />
		<?php
			$args1 = array(
			'depth'            => 0,
			'selected'         => $logout_redirect_page,
			'echo'             => 1,
			'show_option_none' => '-',
			'id' 			   => $this->get_field_id('logout_redirect_page'),
			'name'             => $this->get_field_name('logout_redirect_page')
			);
			wp_dropdown_pages( $args1 ); 
		?>
		</p>
		<p><label for="<?php echo $this->get_field_id('link_in_username'); ?>"><?php _e('Link in Username:'); ?> </label><br />
		<?php
			$args2 = array(
			'depth'            => 0,
			'selected'         => $link_in_username,
			'echo'             => 1,
			'show_option_none' => '-',
			'id' 			   => $this->get_field_id('link_in_username'),
			'name'             => $this->get_field_name('link_in_username')
			);
			wp_dropdown_pages( $args2 ); 
		?>
		</p>
		<?php 
	}
	
	private function loginForm($instance){
		global $post;
		
		if($instance['redirect_page']){
			$redirect =  get_permalink($instance['redirect_page']);
		} else {
			$redirect =  get_permalink($post->ID);
		}
		
		if($instance['logout_redirect_page']){
			$logout_redirect_page = get_permalink($instance['logout_redirect_page']);
		} else {
			$logout_redirect_page = get_permalink($post->ID);
		}
		$this->error_message();
		if(!is_user_logged_in()){
		?>
		<form name="login" id="login" method="post" action="">
		<input type="hidden" name="option" value="afo_user_login" />
		<input type="hidden" name="redirect" value="<?php echo $redirect; ?>" />
			<ul>
			<li>Username</li>
			<li><input type="text" name="user_username" required="required"/></li>
			<li>Password</li>
			<li><input type="password" name="user_password" required="required"/></li>
			<li>&nbsp;</li>
			<li><input name="login" type="submit" value="Login" /></li>
			</ul>
		</form>
		<?php 
		} else {
		global $current_user;
     	get_currentuserinfo();
		
		if($instance['link_in_username']){
			$link_with_username = '<a href="'.get_permalink($instance['link_in_username']).'">Howdy, '.$current_user->display_name.'</a>';
		} else {
			$link_with_username = 'Howdy, '.$current_user->display_name;
		}
		?>
		<ul>
			<li><?php echo $link_with_username;?> | <a href="<?php echo wp_logout_url( $logout_redirect_page ); ?>" title="Logout">Logout</a></li>
		</ul>
		<?php 
		}
	}
	
	public function error_message(){
		if($_SESSION['msg']){
			echo '<div class="'.$_SESSION['msg_class'].'">'.$_SESSION['msg'].'</div>';
			unset($_SESSION['msg']);
			unset($_SESSION['msg_class']);
		}
	}
	
	public function register_plugin_styles() {
		wp_enqueue_style( 'style_login_widget', plugins_url( 'widget_login/style_login_widget.css' ) );
	}
	
} 

function login_validate(){
	if($_POST['option'] == "afo_user_login"){

		if($_POST['user_username'] != "" and $_POST['user_password'] != ""){
			$creds = array();
			$creds['user_login'] = $_POST['user_username'];
			$creds['user_password'] = $_POST['user_password'];
			$creds['remember'] = true;
		
			$user = wp_signon( $creds, true );
			if($user->ID == ""){
				$_SESSION['msg_class'] = 'error_wid_login';
				$_SESSION['msg'] = 'Error in login!';
			}
		} else {
			$_SESSION['msg_class'] = 'error_wid_login';
			$_SESSION['msg'] = 'Username or password is empty!';
		}
		wp_redirect( $_POST['redirect'] );
		exit;
	}
}

add_action( 'widgets_init', create_function( '', 'register_widget( "login_wid" );' ) );
add_action( 'init', 'login_validate' );
