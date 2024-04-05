<?php

/*

Template Name: Half Dark

*/

get_header('dark');




?>
<section id="main-content" class="container">
<!-- Start Page Content -->
<?php


		  echo '<div class="row-wrapper-x">';
		  if( have_posts() ): while( have_posts() ): the_post();
			the_content(); 
		  endwhile;
		  endif;
		  echo '</div>';
		 


?>

</section>
<?php get_footer(); ?>