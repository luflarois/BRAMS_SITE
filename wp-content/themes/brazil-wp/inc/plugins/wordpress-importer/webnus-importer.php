<?php

if(!class_exists('webnus_importer_class'))
{
	class webnus_importer_class{
		
		var $result;
		
		function __construct()
		{
			add_action('admin_menu',array($this,'init_admin_menu'));
		}
		function init_admin_menu()
		{
			//add_submenu_page( 'webnus_theme_options', 'Webnus Importer Plus', 'Webnus Importer +', 'manage_options', 'webnus_importer_plus', array($this, 'generate_importer_page') );
			add_menu_page( 'Webnus Importer Plus', 'Importer +', 'manage_options', 'webnus_importer_plus', array($this, 'generate_importer_page'),null , 300 );
		}
		function generate_importer_page()
		{
		?>
		<div class="webnus-import-wrapper">
			<form action="" id="webnus_import">
				<div class="">
					<div class="webnus-importer-header">
						<h3>Webnus Importer Plus</h3>
					</div>
						<table class="form-table">
							<tbody>
							<tr valign="middle">
								<td scope="row" width="150"><?php esc_html_e('Import', 'WEBNUS_TEXT_DOMAIN'); ?></td>
								<td>
									<select name="webnus_import_option" id="webnus_import_option">
										<option value="">Please Select</option>
										<option value="all">All</option>
										<option value="pages">Pages demo data</option>
										<option value="templatera">Templatera demo data</option>
										
									</select>
									<button class="button-primary" type="button"  name="webnus_import" id="import_demo_data">Import</button>
								</td>
							</tr>
							<tr style="display:hidden" valign="middle">
								<td scope="row" width="150"><?php esc_html_e('Import attachments', 'WEBNUS_TEXT_DOMAIN'); ?></td>
								<td>
									<input type="checkbox" value="1" name="webnus_import_attachments" id="webnus_import_attachments" />

								</td>
							</tr>
							<tr valign="middle">
								<td scope="row" width="150"><?php esc_html_e('Import Widgets', 'WEBNUS_TEXT_DOMAIN'); ?></td>
								<td>
									<button class="button-primary" type="button"  name="webnus_import_widgets" id="webnus_import_widgets">Import Widgets</button> <br/>
									<strong>Note that this will overwrite all widget settings.</strong>
								</td>
							</tr>
							<tr valign="middle">
								<td scope="row" width="150"><?php esc_html_e('Import Menus Setting', 'WEBNUS_TEXT_DOMAIN'); ?></td>
								<td>
									<button class="button-primary" type="button"  name="webnus_import_menus" id="webnus_import_menus">Import Menus</button> <br/>
									<strong>Note that this will overwrite all menu settings.</strong>
								</td>
							</tr>
							<tr valign="middle">
								<td scope="row" width="150"><?php esc_html_e('Import Reading Settings', 'WEBNUS_TEXT_DOMAIN'); ?></td>
								<td>
									<button class="button-primary" type="button"  name="webnus_import_reading_settings" id="webnus_import_reading_settings">Import Reading Settings</button> <br/>
									<strong>Note that this will overwrite Front page displays in Reading Setting.</strong>
								</td>
							</tr>
							<tr valign="middle">
								<td scope="row" width="150"><?php esc_html_e('Import Theme Options', 'WEBNUS_TEXT_DOMAIN'); ?></td>
								<td>
									<button class="button-primary" type="button"  name="webnus_import_theme_options" id="webnus_import_theme_options">Import Theme Options</button> <br/>
									<strong>Note that this will overwrite Theme Options.</strong>
								</td>
							</tr>
							<tr class="loading-row"><td></td><td><div class="import_load"><span><?php _e('The import process may take some time. Please be patient.', 'WEBNUS_TEXT_DOMAIN') ?> </span><br />
										<div class="qode-progress-bar-wrapper html5-progress-bar">
											<div class="progress-bar-wrapper">
												<div id="progressbar" style="width:200px;height:20px "><div class="progress" style="height: 20px;width:0%;background-color: #333;margin-top: 0.5em"></div></div>					<span style="color: #000000;margin: 0.5em;auto 0.5em auto;display: inline-block;font-size: 12px;}" class="progress-value"></span>
											</div>
											<div  class="progress-bar-message">
											</div>
										</div>
									</div></td></tr>
							<tr><td colspan="2">
									<?php _e('Important notes:', 'WEBNUS_TEXT_DOMAIN') ?><br />
									- <?php _e('Please note that import process will take time needed to download all attachments from demo web site.', 'WEBNUS_TEXT_DOMAIN'); ?><br />
									- <?php _e('If you plan to use shop, please install WooCommerce before you run import.', 'WEBNUS_TEXT_DOMAIN') ?>
								</td></tr>
							<tr><td></td><td><div class="success_msg" id="success_msg"><?php echo $this -> result; ?></div></td></tr>
							</tbody>
						</table>
				</div>
			</form>
		</div>
		<script type="text/javascript">
			jQuery(document).ready(function() {

				jQuery('#import_demo_data').click(function() {

					var file_name = '';
					var webnus_import_option = jQuery('#webnus_import_option').val();
					var progressbar = jQuery('#progressbar .progress');

					var import_attachments_status = jQuery('#webnus_import_attachments:checked').val();
					var import_attachments = false;
					if (import_attachments_status)
						import_attachments = 'true';
					else
						import_attachments = 'false';

					switch(webnus_import_option) {
						case 'all':
							file_name = 'dummy.xml';
							break;
						case 'pages':
							file_name = 'dummy2.xml';
							break;
						case 'templatera':
							file_name = 'dummy3.xml';
							break;
						default:
							alert('Please select an option form list');
							return;
					}

					var data = {
						'action' : 'webnus_import_action',
						'webnus_importer_filename' : file_name,
						'webnus_importer_attachments' : import_attachments,
					};

					jQuery('.progress-value').text('Please wait...');

					jQuery.post(ajaxurl, data, function(response) {

						progressbar.animate({
							width : '100%'
						}, 2000, function() {

							jQuery('.progress-value').text(response);

						});

					});

				});

				/* Widgets */

				jQuery('#webnus_import_widgets').click(function() {

					var data = {
						'action' : 'webnus_import_widgets',

					};
					var progressbar = jQuery('#progressbar .progress');

					jQuery('.progress-value').text('Please wait...');
					progressbar.css('width', '0%');
					jQuery.post(ajaxurl, data, function(response) {

						progressbar.animate({
							width : '100%'
						}, 2000, function() {

							jQuery('.progress-value').text(response);

						});

					});

				});

				/* Menus */

				jQuery('#webnus_import_menus').click(function() {

					var data = {
						'action' : 'webnus_import_menus',

					};
					var progressbar = jQuery('#progressbar .progress');

					jQuery('.progress-value').text('Please wait...');
					progressbar.css('width', '0%');
					jQuery.post(ajaxurl, data, function(response) {

						progressbar.animate({
							width : '100%'
						}, 2000, function() {

							jQuery('.progress-value').text(response);

						});

					});

				});

				/* Reading settings */

				jQuery('#webnus_import_reading_settings').click(function() {

					var data = {
						'action' : 'webnus_import_reading_settings',

					};
					var progressbar = jQuery('#progressbar .progress');
					
					jQuery('.progress-value').text('Please wait...');
					progressbar.css('width', '0%');
					jQuery.post(ajaxurl, data, function(response) {

						progressbar.animate({
							width : '100%'
						}, 2000, function() {

							jQuery('.progress-value').text(response);

						});

					});

				});

				/* Import theme options */
				
					
				jQuery('#webnus_import_theme_options').click(function() {

					var data = {
						'action' : 'webnus_import_theme_options',

					};
					var progressbar = jQuery('#progressbar .progress');
					
					jQuery('.progress-value').text('Please wait...');
					progressbar.css('width', '0%');
					jQuery.post(ajaxurl, data, function(response) {

						progressbar.animate({
							width : '100%'
						}, 2000, function() {

							jQuery('.progress-value').text(response);

						});

					});

				});

			});

		</script>
		<?php
		}

		function do_import()
		{
			$import_attachments = (isset($_POST['webnus_importer_attachments'] ) && $_POST['webnus_importer_attachments'] == 'true') ?true: false;
			GLOBAL $wpdb;
	
			$current = error_reporting();
			error_reporting(0);
			if ( ! class_exists( 'WP_Import' ) )
				include_once get_template_directory() . "/inc/plugins/wordpress-importer/wordpress-importer.php";
	
			$file_name = '';
			if(isset($_POST['webnus_importer_filename']))
				$file_name = $_POST['webnus_importer_filename'];
	
			$file_name = empty($file_name)?'dummy.xml' : $file_name;
	
			$myimporter = new WP_Import();
			ob_start();
			$myimporter->fetch_attachments = false; //$import_attachments;
			$myimporter->import(get_template_directory() . '/inc/dummy-data/'.$file_name);
	
			ob_end_clean();
			error_reporting($current);
			echo 'Done! Demo data imported.';
			die();
		}

		function import_widgets()
		{

			global $wpdb;
			$inputFile = file_get_contents(get_template_directory() . '/inc/plugins/wordpress-importer/files/widgets.txt');
	
			$array = explode('-------',$inputFile);
			
			$i= 0;
			$query="";
			foreach($array as $arr)
			{
				$out = explode("+++",$arr);
				$name = $out[0];
				$value = $out[1];
				update_option($out[0],unserialize(trim($out[1])));
		
				$i++;
			}
			$inputFile = file_get_contents(get_template_directory() . '/inc/plugins/wordpress-importer/files/sidebars.txt');
			update_option('sidebars_widgets',unserialize(trim($inputFile)));
	
			echo 'Done! Widgets imported';
			die();
		}

		function import_menus()
		{

	
			$menu = wp_get_nav_menu_object('Corporate');
			if(!empty($menu))
			{
				$menu_id = $menu->term_id;
		
				$locations = get_theme_mod('nav_menu_locations');
				$locations['header-menu'] = $menu_id;
		
				set_theme_mod('nav_menu_locations',$locations);
		
			}
			
			echo 'Done! Menus imported';
			die();
		}

		function import_reading_settings(){

			$home = get_page_by_title( 'Home 1 - Business' );
			if(!empty($home))
			{
				update_option( 'page_on_front', $home->ID );
				update_option( 'show_on_front', 'page' );
				
			}
			// Set the blog page
			$blog   = get_page_by_title( 'Blog' );
			if(!empty($blog))
			{
				update_option( 'page_for_posts', $blog->ID );
			}
			
			echo "Done! Reading settings imported.";
			die();
		}
		
		function import_theme_options(){
			
			$inputFile = file_get_contents(get_template_directory() . '/inc/plugins/wordpress-importer/files/theme.txt');
			update_option('webnus_options',unserialize(trim($inputFile)));
	
			echo 'Done! Theme Options imported';
			die();			
			
			
		}

		}

		$webnus_importer_plus = new webnus_importer_class();

		add_action('wp_ajax_webnus_import_action',array($webnus_importer_plus,'do_import'));
		add_action('wp_ajax_webnus_import_widgets',array($webnus_importer_plus,'import_widgets'));
		add_action('wp_ajax_webnus_import_menus',array($webnus_importer_plus,'import_menus'));
		add_action('wp_ajax_webnus_import_reading_settings',array($webnus_importer_plus,'import_reading_settings'));
		add_action('wp_ajax_webnus_import_theme_options',array($webnus_importer_plus,'import_theme_options'));
		}
	