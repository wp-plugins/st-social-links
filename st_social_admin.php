<?php
add_action('admin_menu', 'social_link_admin_menu');

function social_link_admin_menu() 
{
	$page = add_menu_page( 'Social Link Page', 'Social Link', 'manage_options','social-link','social_link_option_page', plugins_url( 'st-social-links/images/icon.png' ));
}
?>
<?php
function social_link_option_page() {
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
	echo "<h2>Social Plugin</h2>";
	echo "<div class=\"postbox-container\" style=\"width:70%;padding-right:25px;\">";
	echo "<div class=\"metabox-holder\"><div class=\"meta-box-sortables\">";
	echo "<div class=\"postbox \"><div class=\"handlediv\" title=\"Click to toggle\"><br/></div>";
	echo "<div class=\"meta-box-sortables ui-sortable\">";
	echo "<h3 class=\"hndle\"><span>Settings</span></h3>";
	
	echo "<div class=\"inside\">";
	echo "<form method=\"post\" action=\"". $_SERVER["REQUEST_URI"]."\">";
	
	echo "<table class=\"form-table\" border=\"0\" width=\"500px\">";
	echo "<tbody>";
	
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
	echo "</tbody></table>";
	echo "</form>";
	echo "</div></div></div></div></div></div>";
	
	echo "<div class=\"postbox-container side\" style=\"width:20%;\">";
	echo "<div class=\"metabox-holder\">";
	echo "<div class=\"meta-box-sortables\">";
	echo "<div id=\"toc\" class=\"postbox\">";
	echo "<div class=\"handlediv\" title=\"Click to toggle\"><br /></div>";
	echo "<h3 class=\"hndle\"><span>Show your Support</span></h3>";
	echo "<div class=\"inside\">";
	echo "<p><strong>Want to help make this plugin even better? All donations are used to improve this plugin, so donate now!</strong></p>";
	echo "<a href=\"http://sanskrutitech.in/wordpress-plugins/st-social-links/\">Donate</a>";
	echo "<p>Or you could:</p>";
	echo "<ul><li><a href=\"http://wordpress.org/extend/plugins/st-social-links/\">Rate the plugin 5 star on WordPress.org</a></li>";
	echo "<li><a href=\"http://wordpress.org/support/plugin/st-social-links\">Help out other users in the forums</a></li>";
	echo "<li>Blog about it &amp; link to the <a href=\"http://sanskrutitech.in/wordpress-plugins/st-social-links/\">plugin page</a></li>";
	echo "</ul></div></div>";
	echo "<div id=\"toc\" class=\"postbox\">";
	echo "<div class=\"handlediv\" title=\"Click to toggle\"><br /></div>";
	echo "<h3 class=\"hndle\"><span>Connect With Us </span></h3>";
	echo "<div class=\"inside\">";
	echo "<a class=\"facebook\" href=\"https://www.facebook.com/sanskrutitech\"></a>";
	echo "<a class=\"twitter\" href=\"https://twitter.com/#!/sanskrutitech\"></a>";
	echo "<a class=\"googleplus\" href=\"https://plus.google.com/107541175744077337034/posts\"></a>";
	echo "</div>";
	echo "</div>";
}
?>