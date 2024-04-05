<?php
GLOBAL $webnus_options;
?>
<?php

GLOBAL $webnus_page_options_meta;

$hideheader_meta = isset($webnus_page_options_meta)?$webnus_page_options_meta->the_meta():null;
$hideheader = '';
$hideheader =(isset($hideheader_meta) && is_array($hideheader_meta) && isset($hideheader_meta['webnus_page_options'][0]['maxone_hideheader']))?$hideheader_meta['webnus_page_options'][0]['maxone_hideheader']:null;

?>
<header id="header"  class="<?php

$menu_icon = $webnus_options->webnus_header_menu_icon();

if(!empty($menu_icon)) echo ' sm-rgt-mn ';


echo ($hideheader == 'yes')? ' hi-header ' : '';
echo ' '.$webnus_options->webnus_header_color_type()

 ?>">
	<div  class="container">
	 <div class="col-sm-7 logo-wrap">
		<div class="logo">
			<a href="<?php echo home_url( '/' ); ?>">
<?php
/* Check if there is one logo exists at least. */
$has_logo = false;

$logo ='';
$logo_width = '';


$transparent_logo = '';
$transparent_logo_width = '150';

$sticky_logo = '';
$sticky_logo_width = '150';


$logo = $webnus_options->webnus_logo();
$logo_width = $webnus_options->webnus_logo_width();

$transparent_logo = $webnus_options->webnus_transparent_logo();
$transparent_logo_width = $webnus_options->webnus_transparent_logo_width();

$sticky_logo = $webnus_options->webnus_sticky_logo();
$sticky_logo_width = $webnus_options->webnus_sticky_logo_width();


if( !empty($logo) || !empty($transparent_logo) || !empty($sticky_logo) ) $has_logo = true;


if((TRUE === $has_logo))
{

if(!empty($logo))
	echo '<a href="'.home_url( '/' ).'"><img src="'.$logo.'" width="'. (!empty($logo_width)?$logo_width:"150"). '" id="img-logo-w1" alt="logo" class="img-logo-w1"></a>';

if(!empty($transparent_logo))
	echo '<a href="'.home_url( '/' ).'"><img src="'.$transparent_logo.'" width="'. (!empty($transparent_logo_width)?$transparent_logo_width:"150"). '" id="img-logo-w2" alt="logo" class="img-logo-w2"></a>';
else 
	echo '<a href="'.home_url( '/' ).'"><img src="'.$logo.'" width="'. (!empty($transparent_logo_width)?$transparent_logo_width:$logo_width). '" id="img-logo-w2" alt="logo" class="img-logo-w2"></a>';

if(!empty($sticky_logo))
	echo '<span class="logo-sticky"><a href="'.home_url( '/' ).'"><img src="'.$sticky_logo.'" width="'. (!empty($sticky_logo_width)?$sticky_logo_width:"150"). '" id="img-logo-w3" alt="logo" class="img-logo-w3"></a></span>';
else 
	echo '<span class="logo-sticky"><a href="'.home_url( '/' ).'"><img src="'.$logo.'" width="'. (!empty($sticky_logo_width)?$sticky_logo_width:$logo_width). '" id="img-logo-w3" alt="logo" class="img-logo-w3"></a></span>';


 
}else{ ?>
<h5 id="site-title"><a href="<?php echo home_url( '/' ); ?>"><?php bloginfo( 'name' ); ?>
<small>
<?php 
                
	$slogan = $webnus_options->webnus_slogan();
   
	if( empty($slogan))
		bloginfo( 'description' );
	else
		echo $slogan;
                
                
?>
</a>
</small></h5>

<?php } ?>
		</div></div>
		<?php
		$logo_rightside = $webnus_options->webnus_header_logo_rightside();
		if( 0 != $logo_rightside )
		{
			if( 1 == $logo_rightside )
			{
			?>
				<div class="col-md-5 col-sm-7 alignright">
					<hr class="vertical-space" />
					<form action="<?php echo home_url( '/' ); ?>" method="get">
						<input name="s" type="text" placeholder="<?php _e('Search...','WEBNUS_TEXT_DOMAIN') ?>" class="header-saerch" >
					</form>
					
				</div>
				
			<?php
			}elseif(2 == $logo_rightside)
			{
			?>
				<div class="col-md-5 col-sm-7 alignright"><hr class="vertical-space" /><h6><i class="fa-envelope-o-2"></i> <?php echo $webnus_options->webnus_header_email(); ?></h6> <h6><i class="fa-phone"></i> <?php echo $webnus_options->webnus_header_phone(); ?></h6></div>
		<?php 
			}
			elseif(3 == $logo_rightside)
			{ ?>
				<div class="col-md-5 col-sm-7 alignright"><hr class="vertical-space" /><?php dynamic_sidebar('header-advert'); ?>
				<?php if(is_active_sidebar('woocommerce_header')) {
						dynamic_sidebar('woocommerce_header');
						}
				?>
				</div>
			<?php }
		}
		?>
		
	</div>
	<hr class="vertical-space" />
	<nav id="nav-wrap" class="nav-wrap2 <?php 
		
		switch($webnus_options->webnus_header_menu_type()){
			case 3:
				echo 'darknavi';
				break;
			case 4:
				echo 'mn4';
				break;
			case 5:
				echo 'mn4 darknavi';
				break;
			default:
				echo '';
		}


	?>">
		<div class="container">	
			<?php
					if(is_page_template('page-onepage.php'))
					{
					
					if ( has_nav_menu( 'onepage-header-menu' ) ) { 
						
						wp_nav_menu( array( 'theme_location' => 'onepage-header-menu', 'container' => 'false', 'menu_id' => 'nav', 'depth' => '5', 'fallback_cb' => 'wp_page_menu', 'items_wrap' => '<ul id="%1$s">%3$s</ul>',  'walker' => new webnus_description_walker() ) );
					}
					}
					else{
					if ( has_nav_menu( 'header-menu' ) ) { 
						wp_nav_menu( array( 'theme_location' => 'header-menu', 'container' => 'false', 'menu_id' => 'nav', 'depth' => '5', 'fallback_cb' => 'wp_page_menu', 'items_wrap' => '<ul id="%1$s">%3$s</ul>',  'walker' => new webnus_description_walker() ) );
					}
					}

				
				
				
			?>
		</div>
	</nav>
			<!-- /nav-wrap -->
	
</header>

<!-- end-header -->
