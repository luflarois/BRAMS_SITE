<?php

class CodePeopleSearchInPlace {
		
	
	private $text_domain = 'codepeople_search_in_place';
	private $javascriptVariable;
    private $id_list = array();
	
	/*
		Load the language file and initialize the javascript object to pass to the client side
	*/
	function init(){
		// I18n
		load_plugin_textdomain($this->text_domain, false, dirname(plugin_basename(__FILE__)) . '/../languages/');
		
		$root = trim( get_admin_url( get_current_blog_id() ), '/').'/';
		
		$this->javascriptVariables = array(
									'more'  => __('More Results', $this->text_domain),
									'empty' => __('0 results', $this->text_domain),
									'char_number' => get_option('search_in_place_minimum_char_number'),
									'root'	=> substr($root, strpos($root, '//') ),
									'home'	=> get_home_url( get_current_blog_id() )
							);
		
		// Fake variables to allow the translation for Poedit application
		$a = __('post', $this->text_domain); 		
		$a = __('page', $this->text_domain); 		
	} // End init
	
	
	public function javascriptVariables(){
		return $this->javascriptVariables;
	} // End javascritpVariables
	
	/*
		The most important method for search process, populate the list of results.
	*/
	public function modifySearchQuery( $query )
	{
		global $cp_search_in_place;
		if( ( !is_admin() && is_search() && isset( $_GET[ 's' ] ) ) || !empty( $cp_search_in_place ) )
		{	
			$connection_operator = get_option( 'search_in_place_connection_operator', 'or' );
			$connection_operator = ( ( empty( $connection_operator ) ) ? "OR" : $connection_operator );
			$query = preg_replace( "/\)\)\s*AND\s*\(\(/i", ")) ".$connection_operator." ((", $query );
		}	
		return $query;
		
	} // End modifySearchQuery
	
    public function populate() {
		global $wp_query, $wpdb, $cp_search_in_place;
		
		$cp_search_in_place = true;
		
		add_filter('posts_request', array(&$this, 'modifySearchQuery'));
		
		$limit = get_option('search_in_place_number_of_posts'); // Number of results to display
		$post_list = array();
		
		$wp_query = new WP_Query();
        
		// Get the posts and pages with the search terms
		$s = $_GET['s'];
		$params = array(
          's' => $s,
		  'showposts' => $limit,
          'post_type' => 'any',
          'post_status' => 'publish',
        );
		
		$wp_query->query( $params );
		$posts = $wp_query->posts;
        
        foreach($posts as $result){
            if(in_array($result->ID, $this->id_list)){
                continue;
            }else{
                array_push($this->id_list, $result->ID);
            }
			$obj = new stdClass();
			// Include the author in search results
			if(get_option('search_in_place_display_author') == 1){
				$author = get_userdata($result->post_author);
				$obj->author = $author->display_name;
			}	
			
			// The link to the item is required
			$obj->link = get_permalink($result->ID);
			
			// Include the thumbnail in search results
			if(get_option('search_in_place_display_thumbnail')){
                if($result->post_type == 'attachment'){
                    if(strpos($result->post_mime_type, 'image') !== false){
                        $obj->thumbnail = wp_get_attachment_thumb_url( $result->ID );
                    }
				}else{
                
                    if ( function_exists('has_post_thumbnail') && has_post_thumbnail($result->ID) ) {
                        // If post thumbnail is used
                        $obj->thumbnail = wp_get_attachment_thumb_url(get_post_thumbnail_id($result->ID, 'thumbnail'));
                    }elseif(function_exists('get_post_image_id')) {
                        // Support for WP 2.9 post thumbnails
                        $imgID = get_post_image_id($result->ID);
                        $img = wp_get_attachment_image_src($imgID, apply_filters('post_image_size', 'thumbnail'));
                        $obj->thumbnail = $img[0];
                    }
                    else {
                        // If not post thumbnail, grab the first image from the post
                        // Get images for this post
                        $imgArr = @get_children('post_type=attachment&post_mime_type=image&post_parent=' . $result->ID );
                        
                        // If images exist for this page
                        if( !empty( $imgArr ) ) {
                            $flag = PHP_INT_MAX;
                            
                            foreach($imgArr as $img) {
                                if($img->menu_order < $flag){
                                    $flag = $img->menu_order;
                                    $img_selected = $img;	
                                }
                            }
                            $obj->thumbnail = wp_get_attachment_thumb_url($img_selected->ID);
                        }
                    }
                
                }    
			}
			
			// Include a post summary in search results, the summary is limited to the number of letters declared in configuration
			if(get_option('search_in_place_display_summary')){
				$length = get_option('search_in_place_summary_char_number');
				if(!empty($result->post_excerpt)){
					$resume = preg_replace( '/\[[^\]]*\]/', '', $result->post_excerpt );
					$resume = substr(apply_filters("localization", $resume), 0, $length);
				}else{
					$resume = preg_replace( '/\[[^\]]*\]/', '', $result->post_content );
					$c = strip_tags(apply_filters("localization", $resume));
					$l = strlen($c);
					$p = strpos(strtolower($c), strtolower($s));
					
					$p = ($p !== false && $p-$length/2 > 0) ? $p-$length/2 : 0;
					
					// Start the summary from the begining of word
					if($p > 0){
						if($c[$p] == ' '){
							$p++;
						}elseif($c[$p-1] !== ' '){
							$k = strrpos($c, " ", -1*($l-$p));
							$k = ($k < 0) ? 0 : $k+1;
							$length += $p-$k;
							$p = $k;
						}	
					}
					$resume = substr($c, $p, $length);
				}
				
				// Set the search terms in bold
				$obj->resume = preg_replace('/('.$s.')/i', '<strong>$1</strong>', $resume).'[...]';
			}	
			
			// Include the publication date in search results
			if(get_option('search_in_place_display_date')){
				$obj->date = date_i18n(get_option('search_in_place_date_format'), strtotime($result->post_date));
			}	
			
			// The post title is a required field
			$obj->title = apply_filters("localization", $result->post_title); 
			
			$type = __($result->post_type, $this->text_domain);
			if(!isset($post_list[$type])){
				$post_list[$type] = array();
			}
			$post_list[$type][] = $obj;
			
		}
		
		print json_encode($post_list);die;
	
	} // End populate
    
    /*
		Allow for search in posts, pages and attachments
	*/
	function modifySearch(&$query){
		if(!is_admin() && $query->is_search){
            $query->set('post_type', array('post', 'page'));
            $query->set('post_status', array('publish'));
        }
	} // End modifySearch
    
	/*
		Set a link to plugin settings
	*/
	function settingsLink($links) { 
		$settings_link = '<a href="options-general.php?page=codepeople_search_in_place.php">'.__('Settings').'</a>'; 
		array_unshift($links, $settings_link); 
		return $links; 
	} // End settingsLink
	
	/*
		Set a link to contact page
	*/
	function customizationLink($links) { 
		$settings_link = '<a href="http://wordpress.dwbooster.com/contact-us" target="_blank">'.__('Request custom changes').'</a>'; 
		array_unshift($links, $settings_link); 
		return $links; 
	} // End settingsLink
	
	/**
		Print out the admin page
	*/
	function printAdminPage(){
		if(isset($_POST['search_in_place_submit'])){
			
			echo '<div class="updated"><p><strong>'.__("Settings Updated").'</strong></div>';
			
			$_POST['number_of_posts'] = $_POST['number_of_posts']*1;
			$_POST['minimum_char_number'] = $_POST['minimum_char_number']*1;
			$_POST['summary_char_number'] = $_POST['summary_char_number']*1;
			
			$search_in_place_number_of_posts = (!empty($_POST['number_of_posts']) && is_int($_POST['number_of_posts']) && $_POST['number_of_posts'] > 0) ? $_POST['number_of_posts'] : 10;
			$search_in_place_minimum_char_number = (!empty($_POST['minimum_char_number']) && is_int($_POST['minimum_char_number']) && $_POST['minimum_char_number'] > 0) ? $_POST['minimum_char_number'] : 3;
			$search_in_place_summary_char_number = (!empty($_POST['summary_char_number']) && is_int($_POST['summary_char_number']) && $_POST['summary_char_number'] >= 0) ? $_POST['summary_char_number'] : 20;
			$search_in_place_date_format = $_POST['date_format'];
			$search_in_place_display_thumbnail = (!empty($_POST['thumbnail'])) ? $_POST['thumbnail'] : 0;
			$search_in_place_display_date = (!empty($_POST['date'])) ? $_POST['date'] : 0;
			$search_in_place_display_summary = (!empty($_POST['summary'])) ? $_POST['summary'] : 0;
			$search_in_place_display_author = (!empty($_POST['author'])) ? $_POST['author'] : 0;
			$search_in_place_connection_operator = ( !empty( $_POST[ 'connection_operator' ] ) ) ? $_POST[ 'connection_operator' ] : 'or';
			
			update_option('search_in_place_number_of_posts', $search_in_place_number_of_posts);
			update_option('search_in_place_minimum_char_number', $search_in_place_minimum_char_number);
			update_option('search_in_place_summary_char_number', $search_in_place_summary_char_number);
			update_option('search_in_place_date_format', $search_in_place_date_format);
			update_option('search_in_place_display_thumbnail', $search_in_place_display_thumbnail);
			update_option('search_in_place_display_date', $search_in_place_display_date);
			update_option('search_in_place_display_summary', $search_in_place_display_summary);
			update_option('search_in_place_display_author', $search_in_place_display_author);
			update_option('search_in_place_connection_operator', $search_in_place_connection_operator);
			
		}else{
			$search_in_place_number_of_posts = get_option('search_in_place_number_of_posts');
			$search_in_place_minimum_char_number = get_option('search_in_place_minimum_char_number');
			$search_in_place_summary_char_number = get_option('search_in_place_summary_char_number');
			$search_in_place_date_format = get_option('search_in_place_date_format');
			$search_in_place_display_thumbnail = get_option('search_in_place_display_thumbnail');
			$search_in_place_display_date = get_option('search_in_place_display_date');
			$search_in_place_display_summary = get_option('search_in_place_display_summary');
			$search_in_place_display_author = get_option('search_in_place_display_author');
			$search_in_place_connection_operator = get_option('search_in_place_connection_operator', 'or' );
			if( empty( $search_in_place_connection_operator ) ) $search_in_place_connection_operator = 'or';
		}

		echo '
			<div class="wrap">
				<form method="post" action="'.$_SERVER['REQUEST_URI'].'">
					<h1>Search In Place</h1>
					<p  style="border:1px solid #E6DB55;margin-bottom:10px;padding:5px;background-color: #FFFFE0;">'.__('For more information go to the <a href="http://wordpress.dwbooster.com/content-tools/search-in-place" target="_blank">Search in Place</a> plugin page.').' <br />'.__('For any issues with Search in Place, go to our <a href="http://wordpress.dwbooster.com/contact-us" target="_blank">contact page</a> and leave us a message.').'
					<br/><br />'.__('If you want test the premium version of Search in Place go to the following links:<br/> <a href="http://demos.net-factor.com/search-in-place/wp-login.php" target="_blank">Administration area: Click to access the administration area demo</a><br/> <a href="http://demos.net-factor.com/search-in-place/" target="_blank">Public page: Click to access the Search in Place</a>').'</p>
					<table class="form-table">
						<tbody>
							<tr valign="top">
								<th scope="row">
									<label for="number_of_posts">'.__('Enter the number of posts to display', $this->text_domain).'</label>
								</th>
								<td>
									<input type="text" id="number_of_posts" name="number_of_posts" value="'.esc_attr($search_in_place_number_of_posts).'" />
								</td>
							</tr>
							<tr valign="top">
								<th scope="row">
									<label for="minimum_char_number">'.__('Enter the minimum of characters number for start the search', $this->text_domain).'</label>
								</th>
								<td>
									<input type="text" id="minimum_char_number" name="minimum_char_number" value="'.esc_attr($search_in_place_minimum_char_number).'" />
								</td>
							</tr>
							<tr valign="top">
								<th scope="row">
									<label for="operator">'.__('Connection operator', $this->text_domain).'</label>
								</th>
								<td>
									<input type="radio" name="connection_operator" value="or" '.( ( $search_in_place_connection_operator == 'or' ) ? 'CHECKED' : '' ).' /> OR&nbsp;&nbsp;&nbsp;&nbsp;
									<input type="radio" name="connection_operator" value="and" '.( ( $search_in_place_connection_operator == 'and' ) ? 'CHECKED' : '' ).' /> AND <br />
									'.__( 'Get results with any or all of words in the search box.',$this->text_domain ).'
								</td>
							</tr>
						</tbody>
					</table>
					
					<h3>'.__('Elements to display', $this->text_domain).'</h3>
					<table class="form-table">	
						<tbody>
							<tr valign="top">
								<td>
									<input type="checkbox" checked disabled name="title" id="title"> '.__('Post title', $this->text_domain).' <input type="checkbox" name="thumbnail" id="thumbnail" value="1" '.(($search_in_place_display_thumbnail == 1) ? 'checked' : '').' /> '.__('Post thumbnail', $this->text_domain).' <input type="checkbox" name="author" value="1" id="author" '.(($search_in_place_display_author == 1) ? 'checked' : '').' /> '.__('Post author', $this->text_domain).' <input type="checkbox" name="date" id="date" value="1" '.(($search_in_place_display_date == 1) ? 'checked' : '').' /> '.__('Post date', $this->text_domain).' <input type="checkbox" name="summary" id="summary" value="1" '.(($search_in_place_display_summary == 1) ? 'checked' : '').' /> '.__('Post summary', $this->text_domain).'
								</td>
							</tr>
						</tbody>
					</table>	
					<table class="form-table">	
						<tbody>
							<tr valign="top">
								<th scope="row">
									<label for="date_format">'.__("Select the date format", $this->text_domain).'</label>
								</th>
								<td>
									<select name="date_format" id="date_format" style="width:135px;">
										<option value="Y-m-d" '.(($search_in_place_date_format == 'Y-m-d') ? 'selected' : '').'>yyyy-mm-dd</option>
										<option value="Y-d-m" '.(($search_in_place_date_format == 'Y-d-m') ? 'selected' : '').'>yyyy-dd-mm</option>
										<option value="m-d-Y" '.(($search_in_place_date_format == 'm-d-Y') ? 'selected' : '').'>mm-dd-yyyy</option>
										<option value="d-m-Y" '.(($search_in_place_date_format == 'd-m-Y') ? 'selected' : '').'>dd-mm-yyyy</option>
									</select>
								</td>
							</tr>
							<tr valign="top">
								<th scope="row">
									<label for="summary_char_number">'.__("Enter the number of characters for posts' summaries", $this->text_domain).'</label>
								</th>
								<td>
									<input type="text" id="summary_char_number" name="summary_char_number" value="'.esc_attr($search_in_place_summary_char_number).'" />
								</td>
							</tr>
						</tbody>
					</table>
					<p style="border:1px solid #FFCC66;background-color:#FFFFCC;padding:10px;">'.__('The next options are available only for the advanced version of Search in Place', $this->text_domain).'. <a href="http://wordpress.dwbooster.com/content-tools/search-in-place" target="_blank">'.__('CLICK HERE for more information').'</a></p>	
					<h3  style="color:#AAA;">'.__('Search box design').'</h3>
					<table class="form-table">	
						<tbody>
							<tr>
								<th>
									<label for="box_background_color" style="color:#AAA;">'.__('Exclude posts/pages (Ids separated by comma)', $this->text_domain).'</label>
								</th>
								<td>
									<input type="text" style="width:100%;" disabled readonly />
								</td>
							</tr>
							<tr valign="top">
								<th scope="row">
									<label for="box_background_color" style="color:#AAA;">'.__("Background color").'</label>
								</th>
								<td>
									<input type="text" name="box_background_color" id="box_background_color" value="#F9F9F9" disabled readonly />
								</td>
							</tr>
							<tr valign="top">
								<th scope="row">
									<label for="box_border_color"  style="color:#AAA;">'.__("Border color").'</label>
								</th>
								<td>
									<input type="text" name="box_border_color" id="box_border_color" value="#DDDDDD" disabled readonly />
								</td>
							</tr>
							<tr valign="top">
								<th scope="row">
									<label for="label_text_color"  style="color:#AAA;">'.__("Label text color").'</label>
								</th>
								<td>
									<input type="text" name="label_text_color" id="label_text_color" value="#333333" disabled readonly />
								</td>
							</tr>
							<tr valign="top">
								<th scope="row">
									<label for="label_text_shadow"  style="color:#AAA;">'.__("Label text shadow").'</label>
								</th>
								<td>
									<input type="text" name="label_text_shadow" id="label_text_shadow" value="#FFFFFF" disabled readonly />
								</td>
							</tr>
							<tr valign="top">
								<th scope="row">
									<label  style="color:#AAA;">'.__("Label background color").'</label>
								</th>
								<td>
									Gradient start color: 
									<input type="text" name="label_background_start_color" id="label_background_start_color" value="#F9F9F9" disabled readonly />
									Gradient end color:
									<input type="text" name="label_background_end_color" id="label_background_end_color" value="#ECECEC" disabled readonly />
								</td>
							</tr>
							<tr valign="top">
								<th scope="row">
									<label for="active_item_background_color"  style="color:#AAA;">'.__("Background color of active item").'</label>
								</th>
								<td>
									<input type="text" name="active_item_background_color" id="active_item_background_color" value="#FFFFFF" disabled readonly />
								</td>
							</tr>
						</tbody>
					</table>	
					
					<h3  style="color:#AAA;">'.__('Search in', $this->text_domain).'</h3>
					<table class="form-table">	
						<tbody>
							<tr valign="top">
								<th  style="color:#AAA;">
									'.__('Posts/Pages common data (title, content):').'
								</th>
								<td>
									<input type="checkbox" name="post_data" id="post_data" checked disabled readonly />
								</td>
							</tr>
							<tr valign="top">
								<th  style="color:#AAA;">
									'.__('Posts/Pages metadata (additional data of articles):').'
								</th>
								<td>
									<input type="checkbox" name="post_metadata" id="post_metadata" onclick="forbiddenOption(this);" readonly disabled />
								</td>
							</tr>
							<tr>
								<th colspan="2"  style="color:#AAA;">
								'.__('If you are using in your website some of plugins listed below, press the related button for searching in its custom post-types and taxonomies.').'
								</th>
							</tr>
							<tr>
								<th colspan="2">
								<input type="button" class="button-secondary" value="WooCommerce" onclick="window.alert(\'This feature is available only for the advanced version of Search in Place\');" disabled /> 
								<input type="button" class="button-secondary" value="WP e-Commerce" onclick="window.alert(\'This feature is available only for the advanced version of Search in Place\');" disabled /> 
								<input type="button" class="button-secondary" value="Jigoshop" onclick="window.alert(\'This feature is available only for the advanced version of Search in Place\');" disabled /> 
								<input type="button" class="button-secondary" value="Ready! Ecommerce Shopping Cart" onclick="window.alert(\'This feature is available only for the advanced version of Search in Place\');" disabled /> 
								</th>
							</tr>
							<tr valign="top">
								<th  style="color:#AAA;">
									'.__('Posts Type:').'
								</th>
								<td  style="color:#AAA;">
									
									<input type="text" value="post" disabled style="color:#999999;" class="post-type" readonly />  enabled by default <br />
									<input type="text" value="page" disabled style="color:#999999;" class="post-type" readonly />  <br />
							        <input type="button" value="Add new type" class="button-primary" onclick="window.alert(\'This feature is available only in the commercial version of plugin\');" disabled />
								</td>
							</tr>
							
							<tr>
								<th  style="color:#AAA;">
									'.__('Taxonomy:').'
								</th>
								<td>
									<input type="button" id="add_taxonomy" value="Add new taxonomy" class="button-primary" onclick="window.alert(\'The searching in taxonomies is possible only in the commercial version of plugin\');" disabled />
								</td>
							</tr>
						</tbody>
					</table>
					<h3  style="color:#AAA;">'.__('In Search Page', $this->text_domain).'</h3>
					<table class="form-table">	
						<tbody>
							<tr valign="top">
								<th scope="row">
									<label for="highlight"  style="color:#AAA;">'.__("Highlight the terms in result", $this->text_domain).'</label>
								</th>
								<td>
									<input type="checkbox" name="highlight" id="highlight" onclick="forbiddenOption(this);" disabled readonly />
								</td>
							</tr>
							<tr><td colspan="2" style="font-style:italic;color:#AAA;" >
							'.__('Highlights the search terms on search page.', $this->text_domain).'
							</td></tr>
							<tr valign="top">
								<th scope="row">
									<label for="mark_post_type"  style="color:#AAA;">'.__("Identify the posts type in search result", $this->text_domain).'</label>
								</th>
								<td>
									<input type="checkbox" name="mark_post_type" id="mark_post_type" onclick="forbiddenOption(this);" disabled readonly />
								</td>
								<tr><td colspan="2" style="font-style:italic;color:#AAA;" >
								'.__('Indicates the type of document (article or page)', $this->text_domain).'
								</td></tr>
							</tr>
						</tbody>
					</table>
					<h3  style="color:#AAA;">'.__('In Resulting Pages', $this->text_domain).'</h3>
					<table class="form-table">	
						<tbody>
							<tr valign="top">
								<th scope="row">
									<label for="highlight"  style="color:#AAA;">'.__("Highlight the terms in resulting pages", $this->text_domain).'</label>
								</th>
								<td>
									<input type="checkbox" name="highlight_resulting_page" id="highlight_resulting_page" onclick="forbiddenOption(this);" readonly disabled />
								</td>
							</tr>
							<tr><td colspan="2" style="font-style:italic;color:#AAA;" >
							'.__('Highlights the search terms on resulting page.', $this->text_domain).'
							</td></tr>
						</tbody>
					</table>
					<p style="border:1px solid #FFCC66;background-color:#FFFFCC;padding:10px;">'.__('If you require some of features listed above, don\'t doubt to upgrade to the advanced version of Search in Place', $this->text_domain).'. <a href="http://wordpress.dwbooster.com/content-tools/search-in-place" target="_blank">'.__('CLICK HERE for more information').'</a></p>
					<input type="hidden" name="search_in_place_submit" value="ok" />
					<div class="submit"><input type="submit" class="button-primary" value="'.esc_attr(__('Update Settings', $this->text_domain)).'" /></div>
				</form>
			</div>
			<script>
				function forbiddenOption(e){
					e.checked = false;
					window.alert("'.__('The option selected is available only in the advanced version, please go to the product\'s webpage  through the previous link', $this->text_domain).'");
				}
			</script>
		';		
	} // End printAdminPage
	
	/*
		Set configuration variables
	*/
	function _initialize_configuration_variables(){
		update_option('search_in_place_number_of_posts', 10);
		update_option('search_in_place_minimum_char_number', 3);
		update_option('search_in_place_summary_char_number', 20);
		update_option('search_in_place_display_thumbnail', 1);
		update_option('search_in_place_display_date', 1);
		update_option('search_in_place_display_summary', 1);
		update_option('search_in_place_display_author', 1);
	}
	
	function activePlugin( $networkwide ){
		global $wpdb;
			
		if (function_exists('is_multisite') && is_multisite()) {
			if ($networkwide) {
				$old_blog = $wpdb->blogid;
				// Get all blog ids
				$blogids = $wpdb->get_col( "SELECT blog_id FROM $wpdb->blogs" );
				foreach ($blogids as $blog_id) {
					switch_to_blog($blog_id);
					$this->_initialize_configuration_variables();
				}
				switch_to_blog($old_blog);
				return;
			}
		}
		$this->_initialize_configuration_variables();
	} // End activePlugin
	
	/* 
	* A new blog has been created in a multisite WordPress
	*/
	function install_new_blog( $blog_id, $user_id, $domain, $path, $site_id, $meta ){
		global $wpdb;
		if ( is_plugin_active_for_network() ) 
		{
			$current_blog = $wpdb->blogid;
			switch_to_blog( $blog_id );
			$this->_initialize_configuration_variables();
			switch_to_blog( $current_blog );
		}
	}
} // End SearchInPlace
?>