<?php
/*
Plugin Name: St Social Links
Plugin URI: http://sanskrutitech.in/index.php/wordpress-plugins/
Description: A simple plugin to add links to your social network. You can add the list on header, footer or widget.
Version: 0.0.1
Author: Dhara Shah
Author URI: http://sanskrutitech.in/
License: GPL
*/

register_activation_hook(__FILE__,'st_social_install'); 

/* Runs on plugin deactivation*/
register_deactivation_hook( __FILE__, 'st_social_uninstall' );

global $st_facebook;
global $st_twitter;

$st_facebook="";
$st_twitter="";


add_action( 'init', 'checkheaderfooter' );

function checkheaderfooter(){


	$st_showheader_value=get_option("st_social_header");
	$st_showfooter_value=get_option("st_social_footer");
	
	if ($st_showheader_value=="on"){
		add_action( 'wp_head', 'add_social_tag' );
	}
	
	if ($st_showfooter_value=="on"){
		add_action( 'wp_footer', 'add_social_tag' );
	}
	
	
}

function add_social_tag()
{		
	echo '<div id="page">';
	display();
	echo '</div>';
}

function display()
{
	$st_fb_value=get_option("st_social_facebook");
	$st_twit_value=get_option("st_social_twitter");
	$st_lnkdn_value=get_option("st_social_linkedin");
	$st_googleplus_value=get_option("st_social_googleplus");
	
	
	if($st_fb_value!="")
	{
		echo '<div style="float:right; width:27px;">';
		echo '<a target="_blank" href="'.$st_fb_value.'" ><img src="'.plugins_url('images/Facebook.png',__FILE__).'" \></a>';
		echo '</div>';
	}
	if($st_twit_value!="")
	{
		echo '<div style="float:right; width:27px;">';
		echo '<a target="_blank" href="'.$st_twit_value.'" ><img src="'.plugins_url('images/Twitter.png',__FILE__).'" \></a>';
		echo '</div>';
	}
	
	if($st_lnkdn_value!="")
	{
		echo '<div style="float:right; width:27px;">';
		echo '<a target="_blank" href="'.$st_lnkdn_value.'" ><img src="'.plugins_url('images/linkedin.png',__FILE__).'" \></a>';
		echo '</div>';
	}
	if($st_googleplus_value!="")
	{
		echo '<div style="float:right; width:27px;">';
		echo '<a target="_blank" href="'.$st_googleplus_value.'" ><img src="'.plugins_url('images/googleplus.png',__FILE__).'" \></a>';
		echo '</div>';
	}
	
}

function st_social_install()
{	
	update_option("st_social_facebook",$st_facebook);
	update_option("st_social_twitter",$st_twitter);
	update_option("st_social_linkedin",$st_linkedin);
	update_option("st_social_googleplus",$st_googleplus);
}

function st_social_uninstall() {

}

	
if ( is_admin() )
{
	/* Call the html code */
	add_action('admin_menu', 'tag_admin_menu');

	function tag_admin_menu()
	{
		add_options_page('Social Plugin', 'Social Plugin', 'administrator',	'tag-form', 'social_tag_form_option_page');
	}
}

function social_tag_form_option_page()
{	
	global $showhead;
	global $showfoot;
	
	$st_fb_value=get_option("st_social_facebook");
	$st_twit_value=get_option("st_social_twitter");
	$st_linkedin_value=get_option("st_social_linkedin");
	$st_googleplus_value=get_option("st_social_googleplus");
	$st_showheader_value=get_option("st_social_header");
	$st_showfooter_value=get_option("st_social_footer");
	
	if ($st_showheader_value=="on"){
		$showhead="checked";
	}
	else
	{
		$showhead="";
	}
	
	if ($st_showfooter_value=="on"){
		$showfoot="checked";
	}
	else{
		$showfoot="";
	}
	
	echo "<div class=\"wrap\">";
	echo "<form method=\"post\" action=\"". $_SERVER["REQUEST_URI"]."\">";
	echo "<table class=\"form-table\" border=\"0\" width=\"500px\">";
	
	echo "<tr valign=\"top\" >";
	echo "<td width=\"90px\"><label> Facebook Url: </label ></td>";
	echo "<td ><input type=\"text\" name=\"txt_facebook_url\" value=\"".$st_fb_value."\" size=\"50\"></input></td>";
	echo "</tr>";
	
	echo "<tr valign=\"top\" >";
	echo "<td width=\"90px\"><label> Twitter Url: </label ></td>";
	echo "<td ><input type=\"text\" name=\"txt_twitter_url\" value=\"".$st_twit_value."\" size=\"50\"></input></td>";
	echo "</tr>";
	
	echo "<tr valign=\"top\" >";
	echo "<td width=\"90px\"><label> Linked In Url: </label ></td>";
	echo "<td ><input type=\"text\" name=\"txt_linkedin_url\" value=\"".$st_linkedin_value."\" size=\"50\"></input></td>";
	echo "</tr>";
	
	echo "<tr valign=\"top\" >";
	echo "<td width=\"90px\"><label> Google Plus Url: </label ></td>";
	echo "<td ><input type=\"text\" name=\"txt_googleplus_url\" value=\"".$st_googleplus_value."\" size=\"50\"></input></td>";
	echo "</tr>";
	
	echo "<tr valign=\"top\" >";
	echo "<td width=\"90px\"><label> Where you want to display link? </label ></td>";
	echo "<td align=\"\"><input type=\"checkbox\" name=\"chkheader\" $showhead >Header</input><input type=\"checkbox\" name=\"chkfooter\" $showfoot>Footer</input></td>";
	echo "</tr>";	

	echo "<tr valign=\"top\" >";
	echo "<td colspan=\"2\" align=\"\"><input type=\"submit\" name=\"Submit\" value=\"Submit\" id=\"btnsubmit\" class=\"button-primary\"></input></td>";
	echo "</tr>";
	echo "</table>";
	echo "</form>";
	echo "</div>";
	
}

if(isset($_POST["Submit"]))
{
	update_option("st_social_facebook",$_POST['txt_facebook_url']);
	update_option("st_social_twitter",$_POST['txt_twitter_url']);
	update_option("st_social_linkedin",$_POST['txt_linkedin_url']);
	update_option("st_social_googleplus",$_POST['txt_googleplus_url']);
	update_option("st_social_header",$_POST['chkheader']);
	update_option("st_social_footer",$_POST['chkfooter']);

}



/**
 * Add function to widgets_init that'll load our widget.
 */
add_action( 'widgets_init', 'st_social_load_widgets' );


/**
 * Register our widget.
 * 'st_social_Widget' is the widget class used below.
 */
function st_social_load_widgets() {
	register_widget( 'st_social_Widget' );
}

class st_social_Widget extends WP_Widget {

	/**
	 * Widget setup.
	 */
	function st_social_Widget() {
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'social_link', 'description' => __('An widget that displays Social Link ', 'social_link') );

		/* Widget control settings. */
		$control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'st-social-widget' );

		/* Create the widget. */
		$this->WP_Widget( 'st-social-widget', __('Social Link Widget', 'social_link'), $widget_ops, $control_ops );
	}

	
	/**
	 * How to display the widget on the screen.
	 */
	function widget( $args, $instance )
	{
		extract( $args );

		/* Our variables from the widget settings. */
		$title = apply_filters('widget_title', $instance['title'] );
		if ( $title )
		{
			echo $before_title . $title . $after_title;
		}
		$st_fb_value=get_option("st_social_facebook");
		$st_twit_value=get_option("st_social_twitter");
	
		echo '<div>';
		display();
		echo '</div>';
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		/* Strip tags for title and name to remove HTML (important for text inputs). */
		$instance['title'] = strip_tags( $new_instance['title'] );
		
		return $instance;
	}
	
	/**
	 * Displays the widget settings controls on the widget panel.
	 * Make use of the get_field_id() and get_field_name() function
	 * when creating your form elements. This handles the confusing stuff.
	 */
	function form( $instance ) 
	{
		/* Set up some default widget settings. */
		$defaults = array( 'title' => __('Social Link', 'social link') );
		$instance = wp_parse_args( (array) $instance, $defaults );
	?>

		<!-- Widget Title: Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'hybrid'); ?></label>
			<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width:100%;" />
		</p>

	<?php
	}
}	
?>