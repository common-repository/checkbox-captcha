<?php
/*
Plugin Name: Checkbox Captcha
Description: This small plugin adds a checked checkbox to the comment form, disabling the submit button. It is less intrussive than an actual captcha and better protects against spam.
Version: 1.0
Author: Andrei Sangeorzan
Author URI: http://huzze.net/
Plugin URI: http://huzze.net/
License: GPL2
*/
require_once( ABSPATH . "wp-includes/pluggable.php" );
if ( !function_exists('is_user_logged_in') ) :
/**
 * Checks if the current visitor is a logged in user.
 *
 * @since 2.0.0
 *
 * @return bool True if user is logged in, false if not logged in.
 */
// make the detection of user logged in available.
function is_user_logged_in() {
	$user = wp_get_current_user();
	if (empty( $user->ID ))
	return false;
	return true;
}
endif;

wp_register_style('css', plugins_url('checkbox-captcha.css', __FILE__));
wp_enqueue_style('css');

// initial settings upon first activation
register_activation_hook( __FILE__, 'set_up_options' );

function set_up_options(){
	add_option('checkbox_comment', 'submit');
	add_option('label_comment', 'Uncheck this to comment (anti-spam method)');
}

// Add settings link on plugin page
function checkbox_captcha_settings_link($links) { 
	$settings_link = '<a href="options-general.php?page=checkbox-captcha">Options</a>'; 
	array_unshift($links, $settings_link); 
	return $links; 
}

$plugin = plugin_basename(__FILE__); 
add_filter("plugin_action_links_$plugin", 'checkbox_captcha_settings_link' );

//actual plugin
class wctest{
	public function __construct(){
		if(is_admin()){
		add_action('admin_menu', array($this, 'add_plugin_page'));
		add_action('admin_init', array($this, 'page_init'));
	}
	}
	
	public function add_plugin_page(){
	// This page will be under "Settings"
	add_options_page('Checkbox Captcha', 'Checkbox Captcha', 'manage_options', 'checkbox-captcha', array($this, 'create_admin_page'));
	}

	public function create_admin_page(){
?>

	<div class="wrap">
		<?php screen_icon( 'my-plugin' ); ?>
		<h2>Checkbox Captcha settings</h2>			
		<form method="post" action="">
			<?php
            // This prints out all hidden setting fields
			settings_fields('checkbox_option_group');	
			do_settings_sections('checkbox-setting-admin');
		?>
		<?php if (isset($_POST['submit-checkbox'])) {
			echo '<span style="color:#177524;">Your settings have been successfully saved.</span>';
			} ?>
			<?php submit_button('Save Options','primary','submit-checkbox'); ?>
		</form>
	</div>
	<?php
	}
	
	public function page_init(){		
	register_setting('test_option_group', 'array_key', array($this, 'check_ID'));
		add_settings_section(
		'checkbox_settings',
		'<br />',
		array($this, 'print_section_info'),
		'checkbox-setting-admin'
		);	
		
		add_settings_field(
		'button_id', 
		'Custom ID for the Submit button', 
		array($this, 'checkbox_comment'), 
		'checkbox-setting-admin',
		'checkbox_settings'			
		);	

		add_settings_field(
		'label_id', 
		'Change the label text:', 
		array($this, 'label_comment'), 
		'checkbox-setting-admin',
		'checkbox_settings'			
		);
	}
	
	public function check_ID($input){
		if(is_numeric($input['button_id'])){
		$mid = $input['button_id'];			
		if(get_option('checkbox_comment_id') === FALSE){
		add_option('checkbox_comment_id', $mid);
		}else{
		update_option('checkbox_comment_id', $mid);
		}
	}else{
		$mid = '';
	}
	return $mid;
	}
	
	public function print_section_info(){
	print 'If the submit button in your theme has a custom ID, please input it here (without the #):';
	}
	
	public function checkbox_comment(){
		?><input type="text" id="checkbox_comment_id" name="checkbox_id" value="<?=get_option('checkbox_comment');?>" style="width:350px;" /><div class="description">The most common value here is "<em>submit</em>". Customise if you have something else.</div><?php
	}
	public function label_comment(){
		?><input type="text" id="label_comment_id" name="label_id" value="<?=get_option('label_comment');?>" style="width:350px;" /><div class="description">This is the text displayed along with the checkbox. It can be whatever you want it to be.</div><?php
	}
}

$wctest = new wctest();
if (isset($_POST['submit-checkbox'])) {
	$option = 'checkbox_comment';
	$new_value = $_POST['checkbox_id'];
	$option_label = "label_comment";
	$new_value_label = $_POST['label_id'];
if ( get_option( $option ) != $new_value ) {
	update_option( $option, $new_value );
} else {
	$deprecated = '';
	$autoload = 'no';
	add_option( $option, $new_value, $deprecated, $autoload );
}

if (get_option( $option_label ) != $new_value_label) {
	update_option( $option_label, $new_value_label );
} else {
	$deprecated = '';
	$autoload = 'no';
	add_option( $option_label, $new_value_label, $deprecated, $autoload );
}
}
if ( !is_user_logged_in() ) {
wp_enqueue_script("jquery");
function checkbox_captcha() {
	echo "<script>
	var comments = jQuery.noConflict();
	comments(function() {
	comments('#".get_option('checkbox_comment')."').attr('disabled', 'disabled');
//$('input.comment-submit').css('display','none');
	comments('#checkbox-comments').click(function() {
		if (comments(this).is(':checked')) {
			comments('#".get_option('checkbox_comment')."').attr('disabled', 'disabled');
		} else {
			comments('#".get_option('checkbox_comment')."').removeAttr('disabled');
		}
	});
});
</script>
<label for=\"checkbox-comments\"><input type=\"checkbox\" id=\"checkbox-comments\" checked />".get_option('label_comment')."</label><br/ >
<!--<input type=\"submit\" id=\"".get_option('checkbox_comment')."\" class=\"comment-submit-new\" value=\"Add your comment!\" disabled=\"disabled\"></input>-->";
}
add_action('comment_form', 'checkbox_captcha');
}
?>