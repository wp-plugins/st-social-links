<?php
/*
Plugin Name: St Social Links
Plugin URI: http://sanskrutitech.in/index.php/wordpress-plugins/
Description: A simple plugin to add links to your social network. You can add the list on header, footer or widget.
Version: 0.0.6
Author: Dhara Shah
Author URI: http://sanskrutitech.in/
License: GPL
*/

define('WP_SOCIAL_LINK_FOLDER', dirname(plugin_basename(__FILE__)));
define('WP_SOCIAL_LINK_URL', plugins_url('',__FILE__));

register_activation_hook(__FILE__,'st_social_install'); 

/* Runs on plugin deactivation*/
register_deactivation_hook( __FILE__, 'st_social_uninstall' );

global $st_social_link_db_ver;
global $table_suffix;

$st_social_link_db_ver = "0.0.5";
$table_suffix = "sociallink";

if ( is_admin() )
{
	require_once dirname( __FILE__ ) . '/st_social_admin.php';
}
function generate_links()
{
	//fetch data from table
	global $wpdb;
	global $table_suffix;
	$table_suffix = "sociallink";
	$table_name = $wpdb->prefix . $table_suffix;
	$table_result = $wpdb->get_results("SELECT * FROM $table_name");
	
	$links = '';
	foreach ( $table_result as $table_row ) 
	{
		$links = $links .  '<div style="float:left;padding:2px;">';
		$links = $links .  '<a target="_blank" href="'.$table_row->social_link_url.'" ><img src="'.$table_row->img_link.'" \></a>';
		$links = $links .  '</div>';
	}
	return $links;
}
add_shortcode( 'stsociallink', 'add_social_link');
function add_social_link($attr)
{
	return generate_links();	
}
function st_social_install()
{	
	global $wpdb;
	global $table_suffix;
	global $st_daily_tip_db_ver;
	 
	$table_name = $wpdb->prefix . $table_suffix;
	
	$sql = "CREATE TABLE " . $table_name . " (
			id mediumint(9) NOT NULL AUTO_INCREMENT,
			social_network	varchar(50) NOT NULL,
			social_link_url varchar(255) NOT NULL,
			img_link		varchar(255) NOT NULL,
			PRIMARY KEY id (id)
		);";
	require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
	dbDelta($sql);
	
	global $st_facebook,$st_twitter,$st_linkedin,$st_googleplus;
	
	$st_facebook=get_option("st_social_facebook");
	$st_twitter=get_option("st_social_twitter");
	$st_linkedin=get_option("st_social_linkedin");
	$st_googleplus=get_option("st_social_googleplus");
	
	if($st_facebook!=false){
		//add_option("st_social_facebook",$st_facebook);
		if (get_option("st_social_small_imgfb")=="on")
		{
			$img_url = plugins_url('images/facebook_30.png',__FILE__);
		}
		else if (get_option("st_social_big_imgfb")=="on")
		{
			$img_url = plugins_url('images/likefb.png',__FILE__);
		}		
		$rows_affected = $wpdb->insert( $table_name, array( 'social_network'=>'facebook','social_link_url' => $st_facebook, 'img_link' => $img_url) );
		delete_option('st_social_facebook');
		delete_option('st_social_small_imgfb');
		delete_option('st_social_big_imgfb');
	}
	if($st_twitter!=false){
		//add_option("st_social_twitter",$st_twitter);
		if (get_option("st_social_small_imgtwit")=="on")
		{
			$img_url = plugins_url('images/twitter_30.png',__FILE__);
		}
		if (get_option("st_social_big_imgtwit")=="on")
		{
			$img_url = plugins_url('images/followtwitt.png',__FILE__);
		}
		$rows_affected = $wpdb->insert( $table_name, array( 'social_network'=>'twitter','social_link_url' => $st_twitter, 'img_link' => $img_url) );
		delete_option('st_social_twitter');
		delete_option('st_social_small_imgtwit');
		delete_option('st_social_big_imgtwit');
	}
	if($st_linkedin!=false){
		//add_option("st_social_linkedin",$st_linkedin);
		if (get_option("st_social_small_imglinkedin")=="on")
		{
			$img_url = plugins_url('images/linkedin-small.png',__FILE__);
		}
		if (get_option("st_social_big_imglinkedin")=="on")
		{
			$img_url = plugins_url('images/linkedinfollow.png',__FILE__);
		}
		$rows_affected = $wpdb->insert( $table_name, array( 'social_network'=>'linkedin','social_link_url' => $st_linkedin, 'img_link' => $img_url) );
		delete_option('st_social_small_imglinkedin');
		delete_option('st_social_big_imglinkedin');
		delete_option('st_social_linkedin');
	}
	if($st_googleplus!=false){
		//add_option("st_social_googleplus",$st_googleplus);
		if (get_option("st_social_small_imggoogle")=="on")
		{
			$img_url = plugins_url('images/googleplus_30.png',__FILE__);
		}
		if (get_option("st_social_big_imggoogle")=="on")
		{
			$img_url = plugins_url('images/googleplusfollow.png',__FILE__);
		}
		$rows_affected = $wpdb->insert($table_name,array('social_network'=>'googleplus','social_link_url'=>$st_googleplus, 'img_link' => $img_url) );
	}
	add_option("st_social_link_db_ver", $st_social_link_db_ver);
	delete_option('st_social_googleplus');
	delete_option('st_social_small_imggoogle');
	delete_option('st_social_big_imggoogle');
}

function st_social_uninstall() {

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
	
		$links = generate_links();
		echo '<div>';
		echo $links;
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