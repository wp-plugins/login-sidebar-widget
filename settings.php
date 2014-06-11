<?php
class login_settings {

	static $title = 'Login Widget AFO Settings';
	static $login_redirect_page = 'Login Redirect Page:';
	static $logout_redirect_page = 'Logout Redirect Page:';
	static $link_in_username = 'Link in Username';
	
	function __construct() {
		$this->load_settings();
	}
	
	function login_widget_afo_save_settings(){
		if($_POST['option'] == "login_widget_afo_save_settings"){
			update_option( 'redirect_page', $_POST['redirect_page'] );
			update_option( 'logout_redirect_page', $_POST['logout_redirect_page'] );
			update_option( 'link_in_username', $_POST['link_in_username'] );
		}
	}
	
	function  login_widget_afo_options () {
	global $wpdb;
	
	$redirect_page = get_option('redirect_page');
	$logout_redirect_page = get_option('logout_redirect_page');
	$link_in_username = get_option('link_in_username');
	
	$this->donate_form_login();
	?>
	<table width="98%" border="0" style="background-color:#FFFFD2; border:1px solid #E6DB55; padding:0px 0px 0px 10px; margin:2px;">
  <tr>
    <td><p>There is a PRO version of this plugin that supports login with <strong>Facebook</strong>, <strong>Google</strong> And <strong>Twitter</strong>. You can get it <a href="http://donateafo.net84.net/fb-login-widget-pro/" target="_blank">here</a> in <strong>USD 1.00</strong> </p></td>
  </tr>
</table>

	<form name="f" method="post" action="">
	<input type="hidden" name="option" value="login_widget_afo_save_settings" />
	<table width="100%" border="0">
	  <tr>
		<td width="45%"><h1><?php echo self::$title?></h1></td>
		<td width="55%">&nbsp;</td>
	  </tr>
	  <tr>
		<td><strong><?php echo self::$login_redirect_page?></strong></td>
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
		<td><strong><?php echo self::$logout_redirect_page?></strong></td>
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
		<td><strong><?php echo self::$link_in_username?></strong></td>
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
		<td><input type="submit" name="submit" value="Save" class="button button-primary button-large" /></td>
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
	<?php }
	
	function login_widget_afo_menu () {
		add_options_page( 'Login Widget', 'Login Widget Settings', 1, 'login_widget_afo', array( $this,'login_widget_afo_options' ));
	}
	
	function load_settings(){
		add_action( 'admin_menu' , array( $this, 'login_widget_afo_menu' ) );
		add_action( 'admin_init', array( $this, 'login_widget_afo_save_settings' ) );
	}
	
	function donate_form_login(){?>
	<table width="98%" border="0" style="background-color:#FFFFD2; border:1px solid #E6DB55; margin:2px;">
	 <tr>
	 <td align="right"><h3>Even $0.60 Can Make A Difference</h3></td>
		<td><form name="_xclick" action="https://www.paypal.com/cgi-bin/webscr" method="post">
			  <input type="hidden" name="cmd" value="_xclick">
			  <input type="hidden" name="business" value="avifoujdar@gmail.com">
			  <input type="hidden" name="item_name" value="Donation for plugins (Login)">
			  <input type="hidden" name="currency_code" value="USD">
			  <input type="hidden" name="amount" value="0.60">
			  <input type="image" src="https://www.paypal.com/en_US/i/btn/btn_donate_LG.gif" border="0" name="submit" alt="Make a donation with PayPal">
			</form></td>
	  </tr>
	</table>
	<?php }
}
new login_settings;
