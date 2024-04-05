<?php

vc_map( array(
        'name' =>'Webnus Subtitle',
        'base' => 'subtitle',
		"description" => "Subtitle ",
        "icon" => "webnus_subtitle1",
        'params'=>array(
					
					array(
							'type' => 'dropdown',
							'heading' => __( 'Subtitle type', 'WEBNUS_TEXT_DOMAIN' ),
							'param_name' => 'type',
							'value' => array('Subtitle 1'=>'1','Subtitle 2'=>'2','Subtitle 3'=>'3'),
							'description' => __( 'Select subtitle type', 'WEBNUS_TEXT_DOMAIN')
					),
					
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