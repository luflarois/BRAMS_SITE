<?php

vc_map( array(
        'name' =>'Webnus LatestBlogs',
        'base' => 'latestblog',
        "icon" => "webnus_latestfromblog",
		"description" => "Recent posts",
        'category' => __( 'Webnus Shortcodes', 'WEBNUS_TEXT_DOMAIN' ),
        'params' => array(

					array(
							'type' => 'textfield',
							'heading' => __( 'Extra Class', 'WEBNUS_TEXT_DOMAIN' ),
							'param_name' => 'class',
							'value' => '',
							'description' => __( 'Extra Class', 'WEBNUS_TEXT_DOMAIN')
					),


        ),
		
        
    ) );
?>