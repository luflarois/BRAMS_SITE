<?php

 function webnus_latestfromblog( $attributes, $content = null ) {
 	

	
	$wpbp = new WP_Query(array( 'post_type' => 'post', 'posts_per_page' => 4));
	
	$i=0;
	
	ob_start();
		
?>
      <?php
	if ($wpbp->have_posts()) : while ($wpbp->have_posts()) : $wpbp->the_post();
	  ?>
	  <div class="col-md-3 col-sm-3"><article class="latest-b">
	  <figure class="latest-img"><?php get_the_image( array( 'meta_key' => array( 'thumbnail', 'thumbnail' ), 'size' => 'home_lfb' ) );   ?></figure>
		<div class="latest-content">
		<p class="latest-date"><?php the_time('d M y'); ?></p>
		<h3 class="latest-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
		<p class="latest-author">by <?php the_author(); ?> in <?php the_category(', '); ?></p>  
		</div> 
      </article></div>
      <?php
	  ++$i;
	  endwhile; endif;
	  ?>
	<?php
	$out = ob_get_contents();
	ob_end_clean();
	
	wp_reset_query();
	return $out;
 }
 add_shortcode('latestblog', 'webnus_latestfromblog');
?>