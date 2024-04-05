Custom Sidebar for every page

Allows you to choose an already existing sidebar or create a new sidebar when creating a page. It is managed through the WordPress admin panel, so you don’t have to identify the new sidebars etc.

Installation:
	download the plug-in into the folder named ‘wp-content/plugins’
	activate
	*replace in your sidebar.php (wp-content/your_theme/sidebar.php) 
		<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar("TITLE") ) : endif; ?>
	with 
		<?php if(function_exists('kakapo_sidebar')) kakapo_sidebar(); ?>
	in files of the current theme.

	* 	-	Can be in other files. 

Video tutorial:
	http://vimeo.com/36020436
	
Features:
	The number of sidebars is unlimited
	Management through a separate page
	Standard widget control
	Possibility to set an individual sidebar on every page 