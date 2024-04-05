<?php

GLOBAL $webnus_options;

?><!DOCTYPE html>
<!--[if (gte IE 9)|!(IE)]><!--><html <?php language_attributes(); ?>> <!--<![endif]-->
<head>

	<!-- Basic Page Needs
  ================================================== -->
	<meta charset="<?php bloginfo('charset');?>">
	<title><?php
	
	/***************************************/
	/*			Title Generation Process
	/***************************************/
	if(is_plugin_active('all-in-one-seo-pack/all_in_one_seo_pack.php'))
	{
		
		wp_title( '|', true, 'right' );
			
	}elseif(is_plugin_active('wordpress-seo/wp-seo.php'))
	{
		
		wp_title( '|', true, 'right' );
		
	}else{
		
		global $page, $paged;
		
		wp_title( '|', true, 'right' );
		
		bloginfo( 'name' );
		
		$site_description = get_bloginfo( 'description', 'display' );
		
		if ( $site_description && ( is_home() || is_front_page() ) )
			echo " | $site_description";
		if ( $paged >= 2 || $page >= 2 )
			echo ' | ' . sprintf( __( 'Page' ,WEBNUS_TEXT_DOMAIN) . ' %s', max( $paged, $page ) );
	}
		/***************************************/
	/*			End Title Generation Process
	/***************************************/
		
		
?></title>
<?php 

if(is_plugin_inactive('all-in-one-seo-pack/all_in_one_seo_pack.php') && is_plugin_inactive('wordpress-seo/wp-seo.php'))
{
?>

<?php } //end of all in one seo installation check ?>
<meta name="author" content="<?php 

if( !is_single() )
	echo get_bloginfo('name');
else {
	global $post;
	
	if(isset($post) && is_object($post))
	{
		
			
		$flname = get_the_author_meta('first_name',$post->post_author). ' ' . get_the_author_meta('last_name',$post->post_author);
		$flname = trim($flname);
		if (empty($flname)) 
			the_author_meta('display_name',$post->post_author);
		else 
			echo $flname;
		
	}
	
}


?>">
	<!-- Mobile Specific Metas
  ================================================== -->
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">


	<!-- CSS
  ================================================== -->

	<!-- JS
  ================================================== -->
   <?php wp_enqueue_script("jquery"); ?>
	<!--[if lt IE 9]>
	<script src="<?php echo get_template_directory_uri(); ?>/js/modernizr.custom.11889.js" type="text/javascript"></script>
	<![endif]-->
	<!-- HTML5 Shiv events (end)-->
    
	<!-- Favicons
  ================================================== -->
	<?php if($webnus_options->webnus_fav_icon()): ?>
	<link rel="shortcut icon" href="<?php echo $webnus_options->webnus_fav_icon(); ?>">
	<?php else: ?>
	<link rel="shortcut icon" href="<?php echo get_template_directory_uri(); ?>/images/favicon.ico">
	<?php endif; ?>
	<?php 
	$iphone_icon = $webnus_options->webnus_apple_iphone_icon();
	$ipad_icon = $webnus_options->webnus_apple_ipad_icon();
	?>
	<?php if(!empty($iphone_icon)) { ?>
	<link rel="apple-touch-icon-precomposed" href="<?php echo $iphone_icon ?>"/>
	<?php } ?>
	<?php if(!empty($ipad_icon)) { ?>
	<link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?php echo $ipad_icon; ?>">
	<?php } ?>
	<?php wp_head(); ?>
	

	
    </head>
	
	
<body <?php body_class(); ?>>

	<!-- Primary Page Layout
	================================================== -->

<div id="<?php echo $webnus_options->webnus_get_layout(); ?>" >
<?php
 /******************/
 /**  Load Topbar Template
 /******************/
 //get_template_part('parts/topbar'); 
 /******************/
 /**  End Load Topbar Template
 /******************/
 get_template_part('parts/header1');
 ?>