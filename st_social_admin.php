<?php
if( ! class_exists( 'WP_List_Table' ) ) {
    require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}

$networks = array('facebook' => 'Facebook',
                 'twitter'=> 'Twitter',
				 'googleplus'=>'Google Plus');
				 
$icon_images = array("facebook"  => array("facebook_30","facebook_32","facebook_48","facebook_48_grey","facebook_64"),
                     "twitter"   => array("twitter_30","twitter_32","twitter_48","twitter_48_grey","twitter_64"),
					 "googleplus" => array("googleplus_30","googleplus_32","googleplus_48","googleplus_48_grey","googleplus_64"));

add_action('admin_menu', 'social_link_admin_menu');
function social_link_admin_menu() 
{
	$page = add_menu_page( 'Social Link Page', 'Social Link', 'manage_options','social-link','social_link_option_page', plugins_url( 'st-social-links/images/icon.png' ));
	wp_register_style('stylesocial.css',WP_SOCIAL_LINK_URL.'/css/stylesocial.css');
	wp_enqueue_style('stylesocial.css');
}


class Social_Link_List_Table extends WP_List_Table {
	function get_columns(){
		$columns = array(
			'social_network' 	=> 'Network',
			'social_link_url'   => 'Link',
			'img_link'      	=> 'Image'
		);
		return $columns;
	}
	function get_sortable_columns() {
		$sortable_columns = array(
			'social_network' => array('social_network',false),
			'social_link_url' 	=> array('social_link_url',false)
		);
		return $sortable_columns;
	}
	function usort_reorder( $a, $b ) {
		// If no sort, default to title
		$orderby = ( ! empty( $_GET['orderby'] ) ) ? $_GET['orderby'] : 'social_network';
		// If no order, default to asc
		$order = ( ! empty($_GET['order'] ) ) ? $_GET['order'] : 'asc';
		// Determine sort order
		$result = strcmp( $a[$orderby], $b[$orderby] );
		// Send final sort direction to usort
		return ( $order === 'asc' ) ? $result : -$result;
	}
	function prepare_items() {
		$columns = $this->get_columns();
		$hidden = array();
		$sortable = $this->get_sortable_columns();
		
		global $wpdb;
		global $table_suffix;
		$table_suffix = "sociallink";
		$table_name = $wpdb->prefix . $table_suffix;
		$this->items = $wpdb->get_results("SELECT * FROM $table_name",ARRAY_A);
		$this->_column_headers = array($columns, $hidden, $sortable);
		usort( $this->items, array( &$this, 'usort_reorder' ) );
		
		$per_page = 5;
		$current_page = $this->get_pagenum();
		$total_items = count($this->items);
		// only ncessary because we have sample data
			$this->found_data = array_slice($this->items,(($current_page-1)*$per_page),$per_page);
			$this->set_pagination_args( array(
				'total_items' => $total_items,                  //WE have to calculate the total number of items
				'per_page'    => $per_page                     //WE have to determine how many items to show on a page
			) );
		$this->items = $this->found_data;
	}
	function column_default( $item, $column_name ) {
	  switch( $column_name ) { 
		case 'social_network':
			return $item[ $column_name ];
		case 'social_link_url':
			return '<a href="' . $item[ $column_name ] . '" >' . $item[ $column_name ] . '</a>';
		case 'img_link': 
			return '<img src="' . $item[ $column_name ] . '" />';
		default:
		  return print_r( $item, true ) ; //Show the whole array for troubleshooting purposes
	  }
	}
	function process_bulk_action() {
        
        //Detect when a bulk action is being triggered...
        if( 'delete'===$this->current_action() ) {
            wp_die('Items deleted (or they would be if we had items to delete)!');
        }
        
    }
	function column_social_network($item) {
		$actions = array(
            'edit'      => sprintf('<a href="?page=%s&action=%s&social_link=%s">Edit</a>',$_REQUEST['page'],'edit',$item['id']),
            'delete'    => sprintf('<a href="?page=%s&action=%s&social_link=%s">Delete</a>',$_REQUEST['page'],'delete',$item['id']),
        );
		return sprintf('%1$s %2$s', $item['social_network'], $this->row_actions($actions) );
	}
	function column_cb($item) {
        return sprintf(
            '<input type="checkbox" name="social_link[]" value="%s" />', $item['ID']
        );    
    }
	function no_items() {
		_e( 'Add a Social Link using the form above.' );
	}
}



function set_option($option_name,$new_value)
{
	//option exists?
	if ( !get_option( $option_name )) {
		//add if not exists
		add_option( $option_name, $new_value);
	} else {
		//update if exists
		update_option( $option_name, $new_value );
	}
}

?>
<?php
function social_link_option_page() {
	global $networks;
	
	?>
	<script>
		function showimages(){
			var social_network = document.getElementById("social_network").value;
			//first hide all
			<?php
				foreach($networks as $k => $v)
				{	echo "document.getElementById('".$k."').style.display='none';";	}
			?>
			//show the required div
  		    document.getElementById(social_network).style.display="block";
		}
	</script>
	<?php
		$social_network = $_REQUEST["social_network"];
		$social_link_url = $_REQUEST["social_link_url"];
		$img_link = plugins_url('images/'. $_REQUEST["img_link"] .'.png',__FILE__);
		
		global $wpdb;
		global $table_suffix;
		$table_suffix = "sociallink";
		$table_name = $wpdb->prefix . $table_suffix;
		
		//Edit
		if (isset($_REQUEST['Submit']) && isset($_REQUEST['edit_id'])) {
			
			$qry = "UPDATE $table_name SET social_network = '" . $social_network . "',social_link_url='" . $social_link_url . "', img_link='" . $img_link . "' WHERE id = " . $_REQUEST['edit_id'];
			$wpdb->query($qry);
			echo "<div id=\"message\" class=\"updated fade\"><p><strong>Social Link Updated Successfully!</strong></p></div>";
		}
		// Insert
		if (isset($_REQUEST['Submit']) && !isset($_REQUEST['edit_id'])  ) {
			$rows_affected = $wpdb->insert( $table_name, array( 'social_network' => $social_network, 'social_link_url' => $social_link_url, 'img_link' => $img_link) );
			echo "<div id=\"message\" class=\"updated fade\"><p><strong>Social Link Inserted Successfully!</strong></p></div>";
		}
		//delete
		if ($_GET["action"]=="delete")
		{
			$wpdb->query("DELETE FROM $table_name WHERE id = " .$_GET["social_link"]);
			echo "<div id=\"message\" class=\"updated fade\"><p><strong>Social Link Deleted Successfully!</strong></p></div>";
		}
		//edit
		if ($_GET["action"]=="edit")
		{
			$edit_id = $_GET["social_link"];
			$edit_data = $wpdb->get_row("SELECT * FROM $table_name where id = $edit_id");
			$edit_social_network = $edit_data->social_network;
			$edit_social_link_url = $edit_data->social_link_url;
			$edit_img_link = $edit_data->img_link;
			
		}
		//is display option set
		if (isset($_REQUEST['DisplayOption']))
		{
			$settings = $_REQUEST['display_option'];
			set_option('st_social_link_header',$settings);
		}
		//Refresh Table
		$SocialLinkListTable = new Social_Link_List_Table();
		$SocialLinkListTable->prepare_items(); 
	?>
	
	<div class="wrap">
		<h2>Social Plugin</h2>
			<div class="postbox-container" style="width:70%;padding-right:20px;">
				<div class="metabox-holder">
					<div class="meta-box-sortables">
						<div class="postbox"><div class="handlediv" title="Click to toggle"><br/></div>
							<div class="meta-box-sortables ui-sortable">
								<h3 class="hndle"><span>Add / Edit</span></h3>
								<div class="inside">
									<form id="add_social_link" action="<?php echo $_SERVER['PHP_SELF']."?page=social-link"; ?>" method="post">
										<input type="hidden" name="edit_id" value="<?=$edit_id?>" />	
										<select id="social_network" name="social_network" onchange="showimages();">
											<option value="" ></option>
											<?php 
												global $networks;
												foreach($networks as $k => $v)
												{
													$selected = '';
													if ($_GET["action"]=="edit" && $edit_social_network == $k) 
													{$selected = 'selected="selected"';} 
													echo "<option value='" .$k. "' $selected >".$v."</option>";
												}
											?>
										</select>
										<label>Link</label>
										<input type="text" name="social_link_url" class="regular-text" value="<?=$edit_social_link_url?>"/>
										<?php
											global $networks;
											global $icon_images;
											foreach($networks as $k => $v)
											{
												$style = 'style="display:none;"';
												if ($_GET["action"]=="edit" && $edit_social_network == $k) 
												{$style = 'style="display:block;"';}
												echo "<div id='$k' class='icon_all_img' $style>";
													foreach($icon_images[$k] as $icon)
													{
														$checked = '';
														if ($_GET["action"]=="edit" && strpos($edit_img_link,$icon) > 0) 
														{$checked = 'checked="checked"';} 
														echo "<div class='icon_image'>";
														echo "<input type='radio' name='img_link' value='$icon' $checked>";
														echo "<img src=" . plugins_url('images/' . $icon .'.png',__FILE__). " \>";
														echo "</div>";
													}
												echo "</div>";
											}
										?>
										
										<input class="button-primary" type="submit" name="Submit" value="Submit" />
									</form>
								</div>
							</div>
						</div>
						<div class="postbox"><div class="handlediv" title="Click to toggle"><br/></div>
							<div class="meta-box-sortables ui-sortable">
								<h3 class="hndle"><span>Links</span></h3>
									<div class="inside">
										<form id="link_table" method="get">
											<input type="hidden" name="page" value="<?=$_REQUEST['page'];?>" />
	<?php	echo $SocialLinkListTable->display(); ?>
										</form>
									</div>
								</div>
						</div>
					</div>		
				</div>	
			</div>
			
			<div class="postbox-container side" style="width:20%;">
				<div class="metabox-holder">
					<div class="meta-box-sortables">	
						<div id="toc" class="postbox">
							<div class="handlediv" title="Click to toggle"><br /></div>
							<h3 class="hndle"><span>How to Use</span></h3>
							<div class="inside">
								<ol>
									<li><strong>Add Social Links</strong></li>
									<li><strong>Add Social Link Widget</strong></li>
									or
									<li><strong>Use Short Code <code>[stsociallink]</code></strong></li>
									or
									<li><strong>Use PHP Code </strong><br/>
										<code>
											&lt;?php
											if (function_exists('add_social_link')) {
												print add_social_link('[stsociallink]');
											}
											?&gt;
										</code>
									</li>
								</ol>
							</div>
						</div>
						<div id="toc" class="postbox">
							<div class="handlediv" title="Click to toggle"><br /></div>
							<h3 class="hndle"><span>Show your Support</span></h3>
							<div class="inside">
								<p><strong>Want to help make this plugin even better? All donations are used to improve this plugin, so donate now!</strong></p>
								<a href="http://sanskrutitech.in/wordpress-plugins/st-social-links/">Donate</a>
								<p>Or you could:</p>
								<ul>
									<li><a href="http://wordpress.org/extend/plugins/st-social-links/">Rate the plugin 5 star on WordPress.org</a></li>
									<li><a href="http://wordpress.org/support/plugin/st-social-links">Help out other users in the forums</a></li>
									<li>Blog about it &amp; link to the <a href="http://sanskrutitech.in/wordpress-plugins/st-social-links/">plugin page</a></li>
								</ul>
							</div>
						</div>
						<div id="toc" class="postbox">
							<div class="handlediv" title="Click to toggle"><br/></div>
							<h3 class="hndle"><span>Connect With Us </span></h3>
							<div class="inside">
								<a class="facebook" href="https://www.facebook.com/sanskrutitech"></a>
								<a class="twitter" href="https://twitter.com/#!/sanskrutitech"></a>
								<a class="googleplus" href="https://plus.google.com/107541175744077337034/posts"></a>
							</div>
						</div>
					</div>
				</div>
			</div>
	</div>
	<?php
}
?>