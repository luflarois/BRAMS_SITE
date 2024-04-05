<?php

vc_map( array(
        'name' =>'Webnus Testimonial',
        'base' => 'testimonial',
		"description" => "Testimonial",
        "icon" => "webnus_testimonial",
        'params'=>array(
					
					
					
					array(
							'type' => 'textfield',
							'heading' => __( 'Name', 'WEBNUS_TEXT_DOMAIN' ),
							'param_name' => 'name',
							'value'=>'Name',
							'description' => __( 'Enter the Testimonial Name', 'WEBNUS_TEXT_DOMAIN')
					),
					array(
							'type' => 'attach_image',
							'heading' => __( 'Image', 'WEBNUS_TEXT_DOMAIN' ),
							'param_name' => 'img',
							'value'=>'http://',
							'description' => __( 'Testimonial Image', 'WEBNUS_TEXT_DOMAIN')
					),
					array(
							'type' => 'textfield',
							'heading' => __( 'Subtitle', 'WEBNUS_TEXT_DOMAIN' ),
							'param_name' => 'subtitle',
							'value'=>'Subtitle',
							'description' => __( 'Testimonial Subtitle', 'WEBNUS_TEXT_DOMAIN')
					),
					array(
							'type' => 'textarea',
							'heading' => __( 'Content', 'WEBNUS_TEXT_DOMAIN' ),
							'param_name' => 'content',
							'value' => 'Testimonial content text goes here',
							'description' => __( 'Enter the Testimonial content text', 'WEBNUS_TEXT_DOMAIN')
					),
		),
		'category' => __( 'Webnus Shortcodes', 'WEBNUS_TEXT_DOMAIN' ),
        
    ) );


?>