<?php
/*
Plugin Name: St Social Links
Plugin URI: http://sanskrutitech.in/index.php/wordpress-plugins/
Description: A simple plugin to add links to your social network. You can add the list on header, footer or widget.
Version: 0.0.2
Author: Dhara Shah
Author URI: http://sanskrutitech.in/
License: GPL
*/

define('WP_SOCIAL_LINK_FOLDER', dirname(plugin_basename(__FILE__)));
define('WP_SOCIAL_LINK_URL', plugins_url('',__FILE__));

register_activation_hook(__FILE__,'st_social_install'); 

/* Runs on plugin deactivation*/
register_deactivation_hook( __FILE__, 'st_social_uninstall' );

global $st_facebook;
global $st_twitter;
global $st_linkedin;
global $st_googleplus;

$st_facebook="";
$st_twitter="";
$st_linkedin="";
$st_googleplus="";

add_action( 'init', 'checkheaderfooter' );

function checkheaderfooter(){
	wp_register_style('stylesocial.css',WP_SOCIAL_LINK_URL.'/css/stylesocial.css');
	wp_enqueue_style('stylesocial.css');
	
	$st_showheader_value=get_option("st_social_header");
	$st_showfooter_value=get_option("st_social_footer");
	$st_showfix_value=get_option("st_social_fix");
	
	$st_showsmallimgfb_value=get_option("st_social_small_imgfb");
	$st_showbigimgfb_value=get_option("st_social_big_imgfb");
	
	$st_showsmallimgtwit_value=get_option("st_social_small_imgtwit");
	$st_showbigimgtwit_value=get_option("st_social_big_imgtwit");
	
	$st_showsmallimg_valuegoogle=get_option("st_social_small_imggoogle");
	$st_showbigimg_valuegoogle=get_option("st_social_big_imggoogle");
	
	$st_showsmallimg_valuelinkedin=get_option("st_social_small_imglinkedin");
	$st_showbigimg_valuelinkedin=get_option("st_social_big_imglinkedin");

		if ($st_showheader_value=="on"){
			add_action( 'wp_head', 'add_social_tag' );
		}
		if ($st_showfooter_value=="on"){
			add_action( 'wp_footer', 'add_social_tag' );
		}
		if ($st_showfix_value=="on"){
			add_action( 'wp_head', 'add_social_tag_fix' );
		}	
}
function add_social_tag_fix()
{	
	$st_fb_value=get_option("st_social_facebook");
	$st_twit_value=get_option("st_social_twitter");
	$st_lnkdn_value=get_option("st_social_linkedin");
	$st_googleplus_value=get_option("st_social_googleplus");
	
	echo '<div id="divfix">';
	if($st_fb_value!="")
	{
		echo '<div id="divimg">';
		echo '<a target="_blank" href="'.$st_fb_value.'" ><img src="'.plugins_url('images/Facebook-small.png',__FILE__).'" \>';
		echo '</div>';
	}
	if($st_twit_value!="")
	{
		echo '<div id="divimg">';
		echo '<a target="_blank" href="'.$st_twit_value.'" ><img src="'.plugins_url('images/Twitter-small.png',__FILE__).'" \>';
		echo '</div>';
	}
	
	if($st_lnkdn_value!="")
	{
		echo '<div id="divimg">';
		echo '<a target="_blank" href="'.$st_lnkdn_value.'" ><img src="'.plugins_url('images/linkedin-small.png',__FILE__).'" \>';
		echo '</div>';
	}
	if($st_googleplus_value!="")
	{
		echo '<div id="divimg">';
		echo '<a target="_blank" href="'.$st_googleplus_value.'" ><img src="'.plugins_url('images/googleplus-small.png',__FILE__).'" \>';
		echo '</div>';
	}	
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
		if (get_option("st_social_small_imgfb")=="on")
		{
			echo '<div style="float:right; width:27px;position:relative;z-index:99999;">';
			echo '<a target="_blank" href="'.$st_fb_value.'" ><img src="'.plugins_url('images/Facebook-small.png',__FILE__).'" \></a>';
			echo '</div>';	
		}
		else if (get_option("st_social_big_imgfb")=="on")
		{
			echo '<div style="float:right; width:126px;position:relative;z-index:99999;">';
			echo '<a target="_blank" href="'.$st_fb_value.'" ><img src="'.plugins_url('images/likefb.png',__FILE__).'" width="125px"\></a>';
			echo '</div>';	
		}		
	}
	if($st_twit_value!="")
	{
		if (get_option("st_social_small_imgtwit")=="on")
		{
			echo '<div style="float:right; width:27px;position:relative;z-index:99999;">';
			echo '<a target="_blank" href="'.$st_twit_value.'" ><img src="'.plugins_url('images/Twitter-small.png',__FILE__).'" \></a>';
			echo '</div>';
		}
		if (get_option("st_social_big_imgtwit")=="on")
		{
			echo '<div style="float:right; width:126px;position:relative;z-index:99999;">';
			echo '<a target="_blank" href="'.$st_twit_value.'" ><img src="'.plugins_url('images/followtwitt.png',__FILE__).'" width="125px"\></a>';
			echo '</div>';	
		}
	}	
	if($st_lnkdn_value!="")
	{
		if (get_option("st_social_small_imglinkedin")=="on")
		{
			echo '<div style="float:right; width:27px;position:relative;z-index:99999;">';
			echo '<a target="_blank" href="'.$st_lnkdn_value.'" ><img src="'.plugins_url('images/linkedin-small.png',__FILE__).'" \></a>';
			echo '</div>';
		}
		if (get_option("st_social_big_imglinkedin")=="on")
		{
			echo '<div style="float:right; width:126px;position:relative;z-index:99999;">';
			echo '<a target="_blank" href="'.$st_lnkdn_value.'" ><img src="'.plugins_url('images/linkedinfollow.png',__FILE__).'" width="125px"\></a>';
			echo '</div>';	
		}
	}
	if($st_googleplus_value!="")
	{
		if (get_option("st_social_small_imggoogle")=="on")
		{
			echo '<div style="float:right; width:27px;position:relative;z-index:99999;">';
			echo '<a target="_blank" href="'.$st_googleplus_value.'" ><img src="'.plugins_url('images/googleplus-small.png',__FILE__).'" \></a>';
			echo '</div>';
		}
		if (get_option("st_social_big_imggoogle")=="on")
		{
			echo '<div style="float:right; width:126px;position:relative;z-index:99999;">';
			echo '<a target="_blank" href="'.$st_googleplus_value.'" ><img src="'.plugins_url('images/googleplusfollow.png',__FILE__).'" width="125px"\></a>';
			echo '</div>';	
		}
	}	
}

function add_social_tag()
{		
	echo '<div id="page">';
	display();
	echo '</div>';
}


function st_social_install()
{	
	global $st_facebook,$st_twitter,$st_linkedin,$st_googleplus;
	
	$st_facebook=get_option("st_social_facebook");
	$st_twitter=get_option("st_social_twitter");
	$st_linkedin=get_option("st_social_linkedin");
	$st_googleplus=get_option("st_social_googleplus");
	
	if($st_facebook==false){
	add_option("st_social_facebook",$st_facebook);
	}
	if($st_twitter==false){
	add_option("st_social_twitter",$st_twitter);
	}
	if($st_linkedin==false){
	add_option("st_social_linkedin",$st_linkedin);
	}
	if($st_googleplus==false){
	add_option("st_social_googleplus",$st_googleplus);
	}
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
	global $showfix;
	
	global $showsmallimgfb;
	global $showbigimgfb;
	
	global $showsmallimgtwit;
	global $showbigimgtwit;
	
	global $showsmallimglinkedin;
	global $showbigimgtwit;
	
	global $showsmallimggoogle;
	global $showbigimggoogle;
	
	$st_fb_value=get_option("st_social_facebook");
	$st_twit_value=get_option("st_social_twitter");
	$st_linkedin_value=get_option("st_social_linkedin");
	$st_googleplus_value=get_option("st_social_googleplus");
	
	$st_showheader_value=get_option("st_social_header");
	$st_showfooter_value=get_option("st_social_footer");
	$st_showfix_value=get_option("st_social_fix");
	
	$st_showsmallimgfb_value=get_option("st_social_small_imgfb");
	$st_showbigimgfb_value=get_option("st_social_big_imgfb");
	
	$st_showsmallimgtwit_value=get_option("st_social_small_imgtwit");
	$st_showbigimgtwit_value=get_option("st_social_big_imgtwit");
	
	$st_showsmallimg_valuegoogle=get_option("st_social_small_imggoogle");
	$st_showbigimg_valuegoogle=get_option("st_social_big_imggoogle");
	
	$st_showsmallimg_valuelinkedin=get_option("st_social_small_imglinkedin");
	$st_showbigimg_valuelinkedin=get_option("st_social_big_imglinkedin");
	
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
	
	if ($st_showfix_value=="on"){
		$showfix="checked";
	}
	else{
		$showfix="";
	}
	
	if ($st_showsmallimg_value=="on"){
		$showsmallimg="checked";
	}
	else{
		$showsmallimg="unchecked";		
	}
	
	if ($st_showbigimg_value=="on"){
		$showbigimg="checked";
	}
	else{
		$showbigimg="unchecked";
	}
	
	if ($st_showsmallimgfb_value=="on"){
		$showsmallimgfb="checked";
	}
	else{
		$showsmallimgfb="unchecked";
	}
	
	if ($st_showbigimgfb_value=="on"){
		$showbigimgfb="checked";
	}
	else{
		$showbigimgfb="unchecked";
	}
	
	
	if ($st_showsmallimgtwit_value=="on"){
		$showsmallimgtwit="checked";
	}
	else{
		$showsmallimgtwit="unchecked";
	}
	
	if ($st_showbigimgtwit_value=="on"){
		$showbigimgtwit="checked";
	}
	else{
		$showbigimgtwit="unchecked";
	}
	
	if ($st_showsmallimg_valuegoogle=="on"){
		$showsmallimggoogle="checked";
	}
	else{
		$showsmallimggoogle="unchecked";
	}
	
	if ($st_showbigimg_valuegoogle=="on"){
		
		$showbigimggoogle="checked";
	}
	else{
		$showbigimggoogle="unchecked";
	}
	
	if ($st_showsmallimg_valuelinkedin=="on"){
		$showsmallimglinkedin="checked";
	}
	else{
		$showsmallimglinkedin="unchecked";
	}
	
	if ($st_showbigimg_valuelinkedin=="on"){
		$showbigimglinkedin="checked";
	}
	else{
		$showbigimglinkedin="unchecked";
	}
	
	
	echo "<div class=\"wrap\">";
	echo "<form method=\"post\" action=\"". $_SERVER["REQUEST_URI"]."\">";
	echo "<table class=\"form-table\" border=\"0\" width=\"500px\">";
	
	echo "<tr valign=\"top\" >";
	echo "<td width=\"50px\"><label> Facebook Url: </label ></td>";
	echo "<td width=\"50px\"><input type=\"text\" name=\"txt_facebook_url\" value=\"".$st_fb_value."\" size=\"50\"></input></td>";
	echo "<td><input type=\"radio\" name=\"radioimgfb\"  value=\"imgsmallfb\" $showsmallimgfb>";
	echo '</input><img src="'.plugins_url('images/Facebook-small.png',__FILE__).'" \>';
	echo "<input type=\"radio\" name=\"radioimgfb\"  value=\"imgbigfb\" $showbigimgfb>";	
	echo '<img src="'.plugins_url('images/likefb.png',__FILE__).'" width="125px"\></td>';
	echo "</tr>";
	
	echo "<tr valign=\"top\" >";
	echo "<td width=\"90px\"><label> Twitter Url: </label ></td>";
	echo "<td ><input type=\"text\" name=\"txt_twitter_url\" value=\"".$st_twit_value."\" size=\"50\"></input></td>";
	echo "<td><input type=\"radio\" name=\"radioimgtwit\"  value=\"imgsmalltwit\" $showsmallimgtwit>";
	echo '</input><img src="'.plugins_url('images/Twitter-small.png',__FILE__).'" \>';
	echo "<input type=\"radio\" name=\"radioimgtwit\"  value=\"imgbigtwit\" $showbigimgtwit>";	
	echo '<img src="'.plugins_url('images/followtwitt.png',__FILE__).'" width="125px"\></td>';
	echo "</tr>";
	
	echo "<tr valign=\"top\" >";
	echo "<td width=\"90px\"><label> Linked In Url: </label ></td>";
	echo "<td ><input type=\"text\" name=\"txt_linkedin_url\" value=\"".$st_linkedin_value."\" size=\"50\"></input></td>";
	echo "<td><input type=\"radio\" name=\"radioimglinkedin\"  value=\"imgsmalllinkedin\" $showsmallimglinkedin>";
	echo '</input><img src="'.plugins_url('images/linkedin-small.png',__FILE__).'" \>';
	echo "<input type=\"radio\" name=\"radioimglinkedin\"  value=\"imgbiglinkedin\" $showbigimglinkedin>";	
	echo '<img src="'.plugins_url('images/linkedinfollow.png',__FILE__).'" width="125px"\></td>';
	echo "</tr>";
	
	echo "<tr valign=\"top\" >";
	echo "<td width=\"90px\"><label> Google Plus Url: </label ></td>";
	echo "<td ><input type=\"text\" name=\"txt_googleplus_url\" value=\"".$st_googleplus_value."\" size=\"50\"></input></td>";
	echo "<td><input type=\"radio\" name=\"radioimggoogle\"  value=\"imgsmallgoogle\" $showsmallimggoogle>";
	echo '</input><img src="'.plugins_url('images/googleplus-small.png',__FILE__).'" \>';
	echo "<input type=\"radio\" name=\"radioimggoogle\"  value=\"imgbiggoogle\" $showbigimggoogle>";	
	echo '<img src="'.plugins_url('images/googleplusfollow.png',__FILE__).'" width="125px"\></td>';
	echo "</tr>";
	
	echo "<tr valign=\"top\" >";
	echo "<td width=\"90px\"><label> Where you want to display link? </label ></td>";
	echo "<td align=\"\"><input type=\"checkbox\" name=\"chkheader\" $showhead >Header</input>&nbsp;<input type=\"checkbox\" name=\"chkfooter\" $showfoot>Footer</input>&nbsp;<input type=\"checkbox\" name=\"chkfix\" $showfix>FixPosition</input></td>";
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
	update_option("st_social_fix",$_POST['chkfix']);
	
	if(isset($_POST['radioimgfb']))
	{
		if ($_POST['radioimgfb']  == 'imgsmallfb') 
		{
			update_option("st_social_small_imgfb","on");
			update_option("st_social_big_imgfb","off");
		}
		else if ($_POST['radioimgfb'] == 'imgbigfb') 
		{
			update_option("st_social_big_imgfb","on");
			update_option("st_social_small_imgfb","off");
		}
	}
	
	if(isset($_POST['radioimgtwit']))
	{	
		if ($_POST['radioimgtwit']  == 'imgsmalltwit') 
		{
			update_option("st_social_small_imgtwit","on");
			update_option("st_social_big_imgtwit","off");
		}
		else if ($_POST['radioimgtwit'] == 'imgbigtwit') 
		{
			update_option("st_social_big_imgtwit","on");
			update_option("st_social_small_imgtwit","off");
		}
	}
	if(isset($_POST['radioimggoogle']))
	{	
		if ($_POST['radioimggoogle']  == 'imgsmallgoogle') 
		{
			update_option("st_social_small_imggoogle","on");
			update_option("st_social_big_imggoogle","off");
		}
		else if ($_POST['radioimggoogle'] == 'imgbiggoogle') 
		{
			update_option("st_social_big_imggoogle","on");
			update_option("st_social_small_imggoogle","off");
		}
	}
	if(isset($_POST['radioimglinkedin']))
	{	
		if ($_POST['radioimglinkedin']  == 'imgsmalllinkedin') 
		{
			update_option("st_social_small_imglinkedin","on");
			update_option("st_social_big_imglinkedin","off");
		}
		else if ($_POST['radioimglinkedin'] == 'imgbiglinkedin') 
		{
			update_option("st_social_big_imglinkedin","on");
			update_option("st_social_small_imglinkedin","off");
		}
	}
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
		$this->WP_Widget( 'st-social-widget', __('Social Links', 'social_link'), $widget_ops, $control_ops );
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
		//$defaults = array( 'title' => __('Social Link', 'social link') );
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