<?php
/*
Template Name: Blog Masonry
*/
get_header();
GLOBAL $webnus_options;


?>
<section id="main-content-pin">
<hr class="vertical-space1">
<div class="container">

<div id="pin-content">
<?php
$page = (get_query_var('paged')) ? get_query_var('paged') : 1;
$args = array(
	   'orderby'=>'date',
	   'order'=>'desc',
	   'post_type'=>'post',
	   'paged' => $page,
); 
query_posts($args);
 
if (have_posts()) : while (have_posts()) : the_post();
?>
<article  class="pin-box entry -item">
<div class="img-item">
<a href="<?php $large_image =  wp_get_attachment_image_src( get_post_thumbnail_id(get_the_ID()), 'fullsize', false, '' ); 
					$large_image = $large_image[0]; echo $large_image; ?>" class="prettyPhoto" >
<?php get_the_image( array( 'meta_key' => array( 'Full', 'Full' ), 'size' => 'Full' ) );?><span class="zoomex">&nbsp;</span></a>
</div>
<div class="pin-ecxt">
<h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
<h6 class="blog-author"><?php echo get_the_date('d M Y');?> </h6>
<p><?php the_excerpt(); ?></p>
</div>
<div class="pin-ecxt2">
<?php echo get_avatar( get_the_author_meta( 'user_email' ), 90 ); ?>
<p>
<small>Posted by</small>
<?php the_author(); ?>
</p>
</div>

</article>
<?php 
endwhile;
endif;

?>

</div><!-- end-pin-content -->

<hr class="vertical-space2">

</div>  
	
	<section class="container aligncenter">
        <?php 
			if(function_exists('wp_pagenavi')) {
				wp_pagenavi();	
			}
	    ?>
        <hr class="vertical-space2">
    </section>

</section><!-- end-main-content-pin -->
<?php  wp_reset_query(); // Reset the Query Loop 
get_footer();
?>