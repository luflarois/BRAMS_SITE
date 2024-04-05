<?php
	function kakapo_add_custom_box() {
		add_meta_box( 'kakapo', __( 'Use custom sidebar', 'kakapo_textdomain' ), 'kakapo_inner_custom_box', 'page', 'side' );
		add_meta_box( 'kakapo', __( 'Use custom sidebar', 'kakapo_textdomain' ), 'kakapo_inner_custom_box', 'post', 'side' );
	}

	function kakapo_inner_custom_box() 
	{
		global $wp_registered_sidebars;
		wp_nonce_field( plugin_basename(__FILE__), 'kakapo_noncename' );

		echo '<select id="sidebartitles" name="title_sidebar_select">
		<option value="#NONE#">&mdash; Choice &mdash;</option>';
		foreach ( $wp_registered_sidebars as $current ) 
		{
			if(get_post_meta($_GET['post'], 'title_sidebar', true) == $current['id']) echo '<option value="'.$current['id'].'" selected="selected">'.$current['name'].'</option>'; else echo '<option value="'.$current['id'].'">'.$current['name'].'</option>';
		}
		echo '</select>';
		echo ' 
		<input class="hide-if-js" type="text" id="sidebartitle" name="title_sidebar_input" value="" />
		<a href="#postc" class="hide-if-no-js" onclick="jQuery(\'#sidebartitle, #sidebartitles, #enternew_title, #cancelnew_title\').toggle();return false;"><br/>
		<span id="enternew_title">Enter new</span>
		<span id="cancelnew_title" class="hidden">Return</span></a>';
	}

	function kakapo_postdata( $post_id ) 
	{
		if ( !isset( $_POST['kakapo_noncename'] ) ) return $post_id;
		if ( !wp_verify_nonce( $_POST['kakapo_noncename'], plugin_basename(__FILE__) )) return $post_id;
		if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) return $post_id;
		if ( 'page' == $_POST['post_type'] ) 
		{
			if ( !current_user_can( 'edit_page', $post_id ) ) return $post_id;
		}else
			{
				if ( !current_user_can( 'edit_post', $post_id ) ) return $post_id;
			}

		global $wp_registered_sidebars;
		
		if($_POST['title_sidebar_input'] == null)
		{
			update_post_meta($_POST['ID'], 'title_sidebar', $_POST['title_sidebar_select']);
		}else{
				$text = '|\'id\'\s=>\s\''.$_POST['title_sidebar_input'].'\'|U';
				$default_value = array
					(
						'before_widget' => '<li id="%1$s" class="widget %2$s">',
						'after_widget' => '</li>',
						'before_title' => '<h2 class="widgettitle">',
						'after_title' => '</h2>'
					);

				if(sizeof($wp_registered_sidebars)!=0)
					{
						foreach($wp_registered_sidebars as $sidebar_current)
							{
								$id = explode('-',$sidebar_current['id']);
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
							if(!$id)
								{
									$default_value = array
										(
											'before_widget' => str_replace("'",'"',$sidebar_current['before_widget']),
											'after_widget' => str_replace("'",'"',$sidebar_current['after_widget']),
											'before_title' => str_replace("'",'"',$sidebar_current['before_title']),
											'after_title' => str_replace("'",'"',$sidebar_current['after_title'])
										);
										break;
								}
							}
					}
				$default_value['id'] = md5(sizeof($wp_registered_sidebars).mktime());
				$default_value['title'] = $_POST['title_sidebar_input'];
				

				$json_data = get_kakapo_json_array();

				$json_data[] = $default_value;

				$fp = fopen(ABS_KAKAPO_JSON_LIST_SIDEBARS, 'w');
				fputs($fp, json_encode($json_data));
				fclose($fp);

				reload_list_sidebar($json_data);
				update_post_meta($_POST['ID'], 'title_sidebar', 'kakapo-'.$default_value['id']);
			}
	}

?>