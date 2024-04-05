<?php
get_header();
?>
<section class="container page-content" >
<hr class="vertical-space2">
<div class="col-md-8"><h1 class="portfolio-item-title"><?php the_title(); ?></h1></div>
<div class="col-md-4">
<?php if($webnus_options->webnus_portfolio_likebox_enable() == 1 ) { ?>
<div class="portfolio-item-dets">
<div class="portfolio-item-like-box">
<i class="fa-heart"></i><br>
<input type="hidden" id="pageID" value="<?php the_ID(); ?>"/>
<span>0</span>
</div>
<script>
jQuery(document).ready(function(){
var pageID = jQuery('#pageID').val();

jQuery.ajax({url:"<?php echo get_template_directory_uri(); ?>/inc/likes/get-likes.php?pageid="+pageID ,success:function(result){
    jQuery('.portfolio-item-like-box span').text(result);
  }});

jQuery.ajax({url:"<?php echo get_template_directory_uri(); ?>/inc/likes/get-likes.php?isliked&pageid="+pageID ,success:function(result){
    if( 'yes' == result )
	jQuery('.portfolio-item-like-box i').addClass('liked');
  }});
  
 jQuery('.portfolio-item-like-box i').click(function(){
 
 jQuery.ajax({url:"<?php echo get_template_directory_uri(); ?>/inc/likes/like.php?pageid="+pageID ,success:function(result){
    if( '1' == result ){
	jQuery('.portfolio-item-like-box i').addClass('liked');
	jQuery.ajax({url:"<?php echo get_template_directory_uri(); ?>/inc/likes/get-likes.php?pageid="+pageID ,success:function(result){
		jQuery('.portfolio-item-like-box span').text(result);
	}});
	
	}else alert(result);
  }});
 
 });
});
</script>
<div class="portfolio-item-detail-box">
Date: <?php the_time('d M Y'); ?>
<hr>
Cat: <?php $terms = get_the_terms(get_the_id(), 'filter' );
	$terms_slug_str = '';
	
	if ($terms && ! is_wp_error($terms)) :
		$term_slugs_arr = array();
		foreach ($terms as $term) {
			$term_slugs_arr[] = '<a href="'. get_term_link($term, 'filter') .'">' . $term->name . '</a>';
		}
		$terms_slug_str = join( ", ", $term_slugs_arr);
	endif;
	echo $terms_slug_str; ?>
</div>
</div>
<?php } ?>
</div>
<article class="col-md-12">
<hr class="vertical-space2">
<?php 
if(have_posts()): while(have_posts()): the_post();

echo the_content();

endwhile;
endif;
if( '1' == $webnus_options->webnus_portfolio_recentworks_enable() )
	echo do_shortcode('[related_works count=7]');
?>
</article>

</section>
  <?php get_footer(); ?>