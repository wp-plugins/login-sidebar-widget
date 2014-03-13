<?php
/*
Plugin Name: Login Widget With Shortcode
Plugin URI: http://avifoujdar.wordpress.com/category/my-wp-plugins/
Description: This is a simple login form in the widget. just install the plugin and add the login widget in the sidebar. Thats it. :)
Version: 2.0.1
Author: AFO
Author URI: http://avifoujdar.wordpress.com/
*/

/**
	  |||||   
	<(`0_0`)> 	
	()(afo)()
	  ()-()
**/

include_once dirname( __FILE__ ) . '/login_afo_widget.php';
include_once dirname( __FILE__ ) . '/login_afo_widget_shortcode.php';

add_action('admin_menu', 'login_widget_afo_menu');

function login_widget_afo_menu() {  
  add_options_page( 'Login Widget', 'Login Widget Settings', 1, 'login_widget_afo', 'login_widget_afo_options');
}

function login_widget_afo_options() {
global $wpdb;

$redirect_page = get_option('redirect_page');
$logout_redirect_page = get_option('logout_redirect_page');
$link_in_username = get_option('link_in_username');
?>

<table width="98%" border="0" style="background-color:#FFFFD2; border:1px solid #FFFF00;">
 <tr>
 <td align="right"><h3>Even $0.60 Can Make A Difference</h3></td>
    <td><form name="_xclick" action="https://www.paypal.com/cgi-bin/webscr" method="post">
          <input type="hidden" name="cmd" value="_xclick">
          <input type="hidden" name="business" value="avifoujdar@gmail.com">
          <input type="hidden" name="item_name" value="Donation for plugins">
          <input type="hidden" name="currency_code" value="USD">
          <input type="hidden" name="amount" value="0.60">
          <input type="image" src="https://www.paypal.com/en_US/i/btn/btn_donate_LG.gif" border="0" name="submit" alt="Make a donation with PayPal">
        </form></td>
  </tr>
</table>
<form name="f" method="post" action="">
<input type="hidden" name="option" value="login_widget_afo_save_settings" />
<table width="100%" border="0">
  <tr>
    <td width="45%"><h1>Login Widget AFO Settings</h1></td>
	<td width="55%">&nbsp;</td>
  </tr>
  <tr>
    <td><strong>Login Redirect Page:</strong></td>
	<td><?php
			$args = array(
			'depth'            => 0,
			'selected'         => $redirect_page,
			'echo'             => 1,
			'show_option_none' => '-',
			'id' 			   => 'redirect_page',
			'name'             => 'redirect_page'
			);
			wp_dropdown_pages( $args ); 
		?></td>
  </tr>
  
   <tr>
    <td><strong>Logout Redirect Page:</strong></td>
	 <td><?php
			$args1 = array(
			'depth'            => 0,
			'selected'         => $logout_redirect_page,
			'echo'             => 1,
			'show_option_none' => '-',
			'id' 			   => 'logout_redirect_page',
			'name'             => 'logout_redirect_page'
			);
			wp_dropdown_pages( $args1 ); 
		?></td>
  </tr>
   
  <tr>
    <td><strong>Link in Username:</strong></td>
	<td><?php
			$args2 = array(
			'depth'            => 0,
			'selected'         => $link_in_username,
			'echo'             => 1,
			'show_option_none' => '-',
			'id' 			   => 'link_in_username',
			'name'             => 'link_in_username'
			);
			wp_dropdown_pages( $args2 ); 
		?></td>
  </tr>
 
  <tr>
    <td>&nbsp;</td>
    <td><input type="submit" name="submit" value="Save" /></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2">Use <span style="color:#000066;">[login_widget]</span> shortcode to display login form in post or page.<br />
	 Example: <span style="color:#000066;">[login_widget title="Login Here"]</span></td>
  </tr>
</table>
</form>
<?php 
} // end of function 


function login_widget_afo_save_settings(){
	if($_POST['option'] == "login_widget_afo_save_settings"){
		update_option( 'redirect_page', $_POST['redirect_page'] );
		update_option( 'logout_redirect_page', $_POST['logout_redirect_page'] );
		update_option( 'link_in_username', $_POST['link_in_username'] );
	}
}

add_action( 'admin_init', 'login_widget_afo_save_settings' );