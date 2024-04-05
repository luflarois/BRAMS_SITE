<?php
	/*
	Plugin Name: Kakapo - Custom sidebar for every page
	Plugin URI: http://codecanyon.net/item/kakapo-custom-sidebar-for-every-page/1500800?ref=morfi
	Description: Allows you to choose an already existing sidebar or create a new sidebar when creating a page. It is managed through the WordPress admin panel, so you don’t have to identify the new sidebars etc.
	Version: 1.2
	Author: Morfi
	Author URI: http://morfim.net
	*/
	if(!defined('URL_KAKAPO_PLUGIN_DIR')) define('URL_KAKAPO_PLUGIN_DIR', plugins_url('',__FILE__));
	if(!defined('ABS_KAKAPO_PLUGIN_DIR')) define('ABS_KAKAPO_PLUGIN_DIR', dirname(__FILE__).'/');
	if(!defined('ABS_KAKAPO_LIST_SIDEBARS')) define('ABS_KAKAPO_LIST_SIDEBARS', ABS_KAKAPO_PLUGIN_DIR.'list_sidebars.php');
	if(!defined('ABS_KAKAPO_JSON_LIST_SIDEBARS')) define('ABS_KAKAPO_JSON_LIST_SIDEBARS', ABS_KAKAPO_PLUGIN_DIR.'json_list_sidebars.php');
	
	add_action('admin_menu', 'add_kakapo_sidebars');
	
	add_action('admin_init', 'kakapo_add_custom_box', 1);
	add_action('save_post', 'kakapo_postdata');
	
	include_once(ABS_KAKAPO_PLUGIN_DIR.'choice_sidebar.php');
	
	if ( function_exists('register_sidebar') ) include_once(ABS_KAKAPO_LIST_SIDEBARS);
	
	function page_list_sidebar() 
	{
		global $wp_registered_sidebars;
		
		if(isset($_REQUEST['delete'])) if ( $_REQUEST['delete'] ) echo '<div id="message" class="updated fade"><p><strong>Removal was successful.</strong></p></div>';
	?>
	<div class="wrap">
		<div id="icon-themes" class="icon32"><br></div>
		<h2>List Sidebars</h2>
		<br/>
	<div style="margin-right: 20px;">
		<table class="wp-list-table widefat fixed posts" cellspacing="0">
			<thead>
				<tr>
					<td scope="col" id="number" class="manage-column column-categories" style="width:10px;"></td>
					<td scope="col" id="categories" class="manage-column column-categories" style="">Title Sidebar</td>
					<td scope="col" id="action" class="manage-column column-categories" style="text-align:center;width:16px;">Action</td>
				</tr>
			</thead>
			<tfoot>
				<tr>
					<td scope="col" id="number" class="manage-column column-categories" style="text-align:center;width:10px;"></td>
					<td scope="col" id="categories" class="manage-column column-categories" style="">Title Sidebar</td>
					<td scope="col" id="action" class="manage-column column-categories" style="text-align:center;width:16px;">Action</td>
				</tr>
			</tfoot>

			<tbody id="the-list">
		<?php 
			$i=1;
			foreach ($wp_registered_sidebars as $sidebar) 
			{ 
				$id = explode('-',$sidebar['id']);
				if(sizeof($id) > 1) 
					{
						if($id[0] == 'kakapo')
							{
								$id = true;
							}else
								{
									$id = false;
								}
					}else
						{
							$id = false;
						}
		?>
				<tr class="alternate author-self status-publish format-default iedit" valign="top">
					<td scope="row" id="number" style="text-align:center;width:10px;"><?php echo $i;?></td>
					<td class="post-title page-title column-title"><strong><?php echo $sidebar['name']; ?></strong>	</td>
					<td class="post-title page-title column-title" style="text-align:center;width:16px;">
					<?php 
						if($id) { 
					?>
						<form method="post">
							<input type="hidden" name="title" value="<?php echo $sidebar['id']; ?>" />
							<input name="delete" type="submit" value="Delete" />
							<input type="hidden" name="action" value="delete" />
						</form>
					<?php }else{ ?>
						<span style="font-weight:bolder;">system</span>
					<?php }?>
					</td>
				</tr>	
		<?php
			$i++;
			}
		?>
			</tbody>
		</table>
	</div>
	</div>
	<?php
	}
	
	function add_kakapo_sidebars() 
	{
		if(isset($_GET['page']))
			{
				if ( $_GET['page'] == 'kakapo' ) {
				if(isset($_REQUEST['action']))
					if ( 'delete' == $_REQUEST['action'] ) {							
							$json_data = get_kakapo_json_array();

							$new_json_data = array();
							for($i=0;$i<sizeof($json_data);$i++)
								{
									if('kakapo-'.$json_data[$i]['id'] != $_REQUEST['title'])
									{
										$new_json_data[] = $json_data[$i];
									}
								}
							unset($json_data);
							$fp = fopen(ABS_KAKAPO_JSON_LIST_SIDEBARS, 'w');
							fputs($fp, json_encode($new_json_data));
							fclose($fp);
							
							reload_list_sidebar($new_json_data);
							unset($new_json_data);
							header("Location: ".get_bloginfo('url')."/wp-admin/themes.php?page=kakapo&delete=true");
							die;
					}
				}
			}
		add_theme_page("Sidebars", "Sidebars", 'edit_themes', 'kakapo', 'page_list_sidebar');
	}
	
	function kakapo_sidebar($id_post = 0)
		{
			if($id_post == 0)
				{
					global $post,$wp_query;
					if(isset($wp_query->queried_object->ID))
						{
							$id_post = $wp_query->queried_object->ID;
						}else
							{
								$kakapo_back_post = $post;
								$kakapo_query = new WP_Query();
								
								while ( $kakapo_query->have_posts() ) : $kakapo_query->the_post();
									$id_post = get_the_ID();
								endwhile;
								$post = $kakapo_back_post;
								
								unset($kakapo_back_post);
								unset($kakapo_query);
							}
					}
			if(get_post_meta($id_post, 'title_sidebar', true) != null)
				{
					if ( ! dynamic_sidebar( get_post_meta($id_post, 'title_sidebar', true) ) ) : endif;	
				}
		}
	
	function reload_list_sidebar($json_data)
		{
			$fp = fopen(ABS_KAKAPO_LIST_SIDEBARS, 'w');
			fputs($fp, "<?php\n");
			for($i=0;$i<sizeof($json_data);$i++)
				{
					$text = 'register_sidebar( array( \'name\' => \''.$json_data[$i]['title'].'\', \'id\' => \''.'kakapo-'.$json_data[$i]['id'].'\', \'before_widget\' => \''.$json_data[$i]['before_widget'].'\', \'after_widget\' => \''.$json_data[$i]['after_widget'].'\', \'before_title\' => \''.$json_data[$i]['before_title'].'\', \'after_title\' => \''.$json_data[$i]['after_title'].'\' ) );';
					fputs($fp, $text."\n");
					$text = '';
				}
			fputs($fp, "?>");
			fclose($fp);
		}
	
 	function get_kakapo_json_array()
		{
			$json_data = array();
			if(filesize(ABS_KAKAPO_JSON_LIST_SIDEBARS)!=0)
				{
					$fp = fopen(ABS_KAKAPO_JSON_LIST_SIDEBARS, "r");
					$json_string = '';
					while (!feof($fp)) {
					   $json_string .= fgets($fp);
					}
					fclose($fp);
					$json_data = json_decode($json_string,true);
					unset($json_string);
				}
			return $json_data;
		} 
?>