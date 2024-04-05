<?php

/***************************************/
/*			Globalization $woptions
/***************************************/


GLOBAL $webnus_options;

include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
?><!DOCTYPE html>
<!--[if (gte IE 9)|!(IE)]><!--><html lang="en"> <!--<![endif]-->
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
	<meta name="description" content="<?php
	/***************************************/
	/*			Description Meta Tag Generator
	/***************************************/
		
		
		global $page_seo_meta;
		
		$seo_meta = !empty($page_seo_meta)?$page_seo_meta->the_meta():null;

		if( !empty( $seo_meta ) && !empty( $seo_meta['webnus_seo_options'][0]['seo_desc'] ) )
		{
				
			echo($seo_meta['webnus_seo_options'][0]['seo_desc']);
			
		}else{
		
		
			if ( is_single() ) {
			
				single_post_title('', true); 
				
			} else {
			
				bloginfo('name'); echo " - "; bloginfo('description');
				
			}
			
			
		}
		
/***************************************/
/*			End Description Meta Tag Generator
/***************************************/

?>">
<meta name="keywords" content="<?php

/***************************************/
/*			Keywords Meta Tag Generator
/***************************************/

	global $page_seo_meta;
	
	$seo_meta = !empty($page_seo_meta)?$page_seo_meta->the_meta():null;
	
	if( !empty($seo_meta) && !empty($seo_meta['webnus_seo_options'][0]['seo_keyword']) )
	{
	
		echo($seo_meta['webnus_seo_options'][0]['seo_keyword']);
		
	}

/***************************************/
/*			End Keywords Meta Tag Generator
/***************************************/


?>" />
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
<meta http-equiv="X-UA-Compatible" content="IE=edge">

	<!-- Mobile Specific Metas
  ================================================== -->
<?php

$responsive = $webnus_options->webnus_enable_responsive();

if(1 == $responsive){
?>
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<?php } else { ?>
<meta name="viewport" content="width=1200,user-scalable=no">
<?php } ?>


	<!-- Modernizer
  ================================================== -->

	<!--[if lt IE 9]>
	<script src="<?php echo get_template_directory_uri(); ?>/js/modernizr.custom.11889.js" type="text/javascript"></script>
	<script src="<?php echo get_template_directory_uri(); ?>/js/respond.js" type="text/javascript"></script>
	<![endif]-->
		<!-- HTML5 Shiv events (end)-->
	<!-- MEGA MENU -->
 	
	
	<!-- Favicons
  ================================================== -->
<?php if($webnus_options->webnus_fav_icon()): ?>
<link rel="shortcut icon" href="<?php echo $webnus_options->webnus_fav_icon(); ?>">
<?php else: ?>
<link rel="shortcut icon" href="<?php echo get_template_directory_uri(); ?>/images/favicon.ico">
<?php endif; ?>

	<!-- CSS + JS
  ================================================== -->
<?php wp_head();  ?>
</head>
<?php
/*
 * Codes for transparent header
 * 
*/

GLOBAL $webnus_page_options_meta;

$transparent_header = '';

if(!is_search())
{

$transparent_header_meta = isset($webnus_page_options_meta)?$webnus_page_options_meta->the_meta():null;

$transparent_header =(isset($transparent_header_meta) && is_array($transparent_header_meta) && isset($transparent_header_meta['webnus_page_options'][0]['webnus_transparent_header']))?$transparent_header_meta['webnus_page_options'][0]['webnus_transparent_header']:null;



}

$transparent_header_class = (!empty($transparent_header))?'transparent-header-w':'';

?>	
<body <?php body_class('default-header '. $transparent_header_class); ?>>

<div id="barra-brasil" style="background:#7F7F7F; height: 20px; padding:0 0 0 10px;display:block;"> 
	<ul id="menu-barra-temp" style="list-style:none;">
		<li style="display:inline; float:left;padding-right:10px; margin-right:10px; border-right:1px solid #EDEDED"><a href="http://brasil.gov.br" style="font-family:sans,sans-serif; text-decoration:none; color:white;">Portal do Governo Brasileiro</a></li> 
		<li><a style="font-family:sans,sans-serif; text-decoration:none; color:white;" href="http://epwg.governoeletronico.gov.br/barra/atualize.html">Atualize sua Barra de Governo</a></li>
	</ul>
</div>
<script defer="defer" src="//barra.brasil.gov.br/barra.js" type="text/javascript"></script>

	<!-- Primary Page Layout
	================================================== -->

<div id="wrap" class="colorskin-<?php echo $webnus_options->webnus_color_skin(); ?> <?php echo $webnus_options->webnus_get_layout(); ?>">
<?php
 
  /******************/
 /**  Load Topbar Template
 /******************/

 
 $menu_type = $webnus_options->webnus_header_menu_type();
 
 switch($menu_type)
 {
	case 1:
		get_template_part('parts/topbar'); 
		get_template_part('parts/header1');
	break;
	case 2:
	case 3:
	case 4:
	case 5:
		get_template_part('parts/topbar'); 
		get_template_part('parts/header2');
	break;
	
	
	default:
		get_template_part('parts/header1');
	break;
 }

/***************************************/
/*			If woocommerce available add page headline section.
/***************************************/

if(isset($post) && 'product' == get_post_type( $post->ID ))
{
if( ((function_exists('is_product') && is_product()) && $webnus_options->webnus_woo_product_title_enable()) ){
?>

<section id="headline">
    <div class="container">
      <h3><?php 
	  
	  if( function_exists('is_product') ){
	  
	  if( is_product() )
		echo $webnus_options->webnus_woo_product_title() ;
	  
	  
	  }
	  
	  ?></h3>
    </div>
</section><?php
	}

if((function_exists('is_product') && !is_product()) && $webnus_options->webnus_woo_shop_title_enable())
{?>
	
	<section id="headline">
    <div class="container">
      <h3><?php 
	  
	 
	 
		echo $webnus_options->webnus_woo_shop_title() ;
	  
	 
	  
	  ?></h3>
    </div>
</section>

<?php }
/***************************************/
/*			End woocommerce section
/***************************************/
?>
<section class="container" >
<!-- Start Page Content -->
<hr class="vertical-space">
<?php

}
?>