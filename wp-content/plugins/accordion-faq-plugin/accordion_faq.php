<?php
/*
Plugin Name: Accordion FAQ plugin
Plugin URL: p.mahesh8850@gmail.com 
Description: Faq plugin provide you accordion with simple,easy,best,quick and multiple faq.
Version:1.0.0
Author: maheshpatel
Author URI: p.mahesh8850@gmail.com
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/

// Register Custom Taxonomy
function taxonomy_quick_faq() {

	$labels = array(
		'name'                       => _x( 'Faq  Taxonomies', 'Taxonomy General Name', 'text_domain' ),
		'singular_name'              => _x( 'Faq Taxonomy', 'Taxonomy Singular Name', 'text_domain' ),
		'menu_name'                  => __( 'Quick Faq', 'text_domain' ),
		'all_items'                  => __( 'All Items', 'text_domain' ),
		'parent_item'                => __( 'Parent Item', 'text_domain' ),
		'parent_item_colon'          => __( 'Parent Item:', 'text_domain' ),
		'new_item_name'              => __( 'New Item Name', 'text_domain' ),
		'add_new_item'               => __( 'Add New Item', 'text_domain' ),
		'edit_item'                  => __( 'Edit Item', 'text_domain' ),
		'update_item'                => __( 'Update Item', 'text_domain' ),
		'view_item'                  => __( 'View Item', 'text_domain' ),
		'separate_items_with_commas' => __( 'Separate items with commas', 'text_domain' ),
		'add_or_remove_items'        => __( 'Add or remove items', 'text_domain' ),
		'choose_from_most_used'      => __( 'Choose from the most used', 'text_domain' ),
		'popular_items'              => __( 'Popular Items', 'text_domain' ),
		'search_items'               => __( 'Search Items', 'text_domain' ),
		'not_found'                  => __( 'Not Found', 'text_domain' ),
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => true,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => true,
	);
	register_taxonomy( 'quick_faq_tax', array( 'quick_faq' ), $args );

}
add_action( 'init', 'taxonomy_quick_faq', 0 );


// Register Custom Post Type
function post_quick_faq() {

	$labels = array(
		'name'                => _x( 'Quick Faqs', 'Post Type General Name', 'text_domain' ),
		'singular_name'       => _x( 'Quick Faq', 'Post Type Singular Name', 'text_domain' ),
		'menu_name'           => __( 'Quick Faq', 'text_domain' ),
		'name_admin_bar'      => __( 'Quick Faq', 'text_domain' ),
		'parent_item_colon'   => __( 'Parent Item:', 'text_domain' ),
		'all_items'           => __( 'All Items', 'text_domain' ),
		'add_new_item'        => __( 'Add New Item', 'text_domain' ),
		'add_new'             => __( 'Add New', 'text_domain' ),
		'new_item'            => __( 'New Item', 'text_domain' ),
		'edit_item'           => __( 'Edit Item', 'text_domain' ),
		'update_item'         => __( 'Update Item', 'text_domain' ),
		'view_item'           => __( 'View Item', 'text_domain' ),
		'search_items'        => __( 'Search Item', 'text_domain' ),
		'not_found'           => __( 'Not found', 'text_domain' ),
		'not_found_in_trash'  => __( 'Not found in Trash', 'text_domain' ),
	);
	$args = array(
		'label'               => __( 'Quick Faq', 'text_domain' ),
		'description'         => __( 'Quick Faq Description', 'text_domain' ),
		'labels'              => $labels,
		'supports'            => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'comments', 'trackbacks', 'revisions', 'custom-fields', 'page-attributes', 'post-formats', ),
		'taxonomies'          => array( 'quick_faq_tax' ),
		'hierarchical'        => false,
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'menu_position'       => 5,
		'show_in_admin_bar'   => true,
		'show_in_nav_menus'   => true,
		'can_export'          => true,
		'has_archive'         => true,		
		'exclude_from_search' => false,
		'publicly_queryable'  => true,
		'capability_type'     => 'page',
	);
	register_post_type( 'quick_faq', $args );

}
add_action( 'init', 'post_quick_faq', 0 );


function shortcode_quick_faq( $atts,$content=null) {
	//print_r($atts);
	extract( shortcode_atts(
		array(
		), $atts )
	);
	
	
	ob_start();
	// WP Query
	$WP_Query = new WP_Query( array ( 
								'post_type'      => 'quick_faq',
								'posts_per_page' => -1,
								'orderby'        => 'post_date', 
								'order'          => 'ASC',
								'tax_query' => array(
									array(
										'taxonomy' =>'quick_faq_tax',
										'field' => 'id',
										'terms' => $atts['id']
										),
									)
								) 
						);
	$i = 1;
	// Displays Post Detail
	if( $WP_Query->post_count > 0) :?>
	
	<ul class="faq">
	<?php while ($WP_Query->have_posts()) : $WP_Query->the_post(); ?>
		
		<li class="q"> 
		<img src='<?php echo plugin_dir_url( __FILE__ )."/arrow.png";?>'>
		<?php the_title(); ?>
		</li>
		<li class="a">
			<?php if ( function_exists('has_post_thumbnail') && has_post_thumbnail() ) {
                    the_post_thumbnail('thumbnail'); 
                  }
		    ?>
		    <?php the_content(); ?>
		</li>
	<?php $i++;	endwhile; ?>
	</ul>
	<?php endif; ?>
	<?php	return ob_get_clean();
	}
	add_shortcode("quick_faq", "shortcode_quick_faq");

function quick_faq_scripts() {
	//echo '<script src="//code.jquery.com/jquery-1.11.3.min.js"></script>';
	echo '<style>
	ul.faq{list-style:none;}
	.faq li { padding: 20px; }
	.faq li.q {
	  background: #4FC2E;
	  font-weight: bold;
	  font-size: 120%;
	  border-bottom: 1px #ddd solid;
	  cursor: pointer;
	  
	  display: block;
    cursor: pointer;
    position: relative;
    margin: 2px 0 0 0;
    padding: .5em .5em .5em .7em;
    min-height: 0;
    /* support: IE7; */
    font-size: 100%;
	}

	.faq li.a {	 
	  display: none;
	 
	}
	
	.rotate {
  -moz-transform: rotate(90deg);
  -webkit-transform: rotate(90deg);
  transform: rotate(90deg);
	}
	</style>	
	';
	
	echo "<script>
		// Accordian Action
	var action = 'click';
	var speed = '500';

	jQuery(document).ready(function(){

	// Question handler
	  jQuery('li.q').on(action, function(){

		// gets next element
		// opens .a of selected question
		jQuery(this).next().slideToggle(speed)
		
		// selects all other answers and slides up any open answer
		.siblings('li.a').slideUp();
	  
		// Grab img from clicked question
		var img = jQuery(this).children('img');

		// remove Rotate class from all images except the active
		jQuery('img').not(img).removeClass('rotate');

		// toggle rotate class
		img.toggleClass('rotate');

	  });

	});
	</script>";
		
}
add_action( 'wp_head', 'quick_faq_scripts' );



// Taxonomy Shortcode
add_filter("manage_quick_faq_tax_custom_column", 'quick_faq_shortcode_column', 10, 3);
add_filter("manage_edit-quick_faq_tax_columns", 'quick_faq_shortcode_column_head'); 

function quick_faq_shortcode_column_head($theme_columns) {
    $new_columns = array(
            'cb' => '<input type="checkbox" />',
            'name' => __('Name'),
            'quick_faq_shortcode' => __( 'Shortcode', 'quick_faq' ),
            'slug' => __('Slug'),
            'posts' => __('Posts')
        );
    return $new_columns;
}

function quick_faq_shortcode_column($out, $column_name, $theme_id) {
    $theme = get_term($theme_id, 'quick_faq_tax');
    switch ($column_name) {
        
        case 'title':
            echo get_the_title();
        break;

        case 'quick_faq_shortcode':             
             echo '[quick_faq ID="'. $theme_id.'"]';
        break;
 
        default:
            break;
    }
    return $out;    
}
