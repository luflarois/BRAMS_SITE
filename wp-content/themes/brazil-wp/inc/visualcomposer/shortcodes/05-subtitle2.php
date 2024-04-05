<?php

vc_map( array(
        'name' =>'Webnus Subtitle 2',
        'base' => 'subtitle2',
		"description" => "Subtitle 2",
        "icon" => "webnus_subtitle2",
        'params'=>array(
					
					array(
							'type' => 'textarea',
							'heading' => __( 'Subtitle Content', 'WEBNUS_TEXT_DOMAIN' ),
							'param_name' => 'content',
							'value' => 'Subtitle text',
							'description' => __( 'Enter the Subtitle content', 'WEBNUS_TEXT_DOMAIN')
					),
		),
		'category' => __( 'Webnus Shortcodes', 'WEBNUS_TEXT_DOMAIN' ),
        
    ) );



vc_map( array(
        'name' =>'Webnus Subtitle 3',
        'base' => 'subtitle3',
		"description" => "Subtitle 3",
        "icon" => "webnus_subtitle3",
        'params'=>array(
					
					array(
							'type' => 'textarea',
							'heading' => __( 'Subtitle Content', 'WEBNUS_TEXT_DOMAIN' ),
							'param_name' => 'content',
							'value' => 'Subtitle text',
							'description' => __( 'Enter the Subtitle content', 'WEBNUS_TEXT_DOMAIN')
					),
		),
		'category' => __( 'Webnus Shortcodes', 'WEBNUS_TEXT_DOMAIN' ),
        
    ) );




?>