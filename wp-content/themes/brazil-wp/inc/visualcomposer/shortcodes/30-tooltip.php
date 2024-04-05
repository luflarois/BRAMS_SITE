<?php

vc_map( array(
        "name" =>"Webnus Tooltip",
        "base" => "tooltip",
		"description" => "Tooltip",
        "category" => __( 'Webnus Shortcodes', 'WEBNUS_TEXT_DOMAIN' ),
        "icon" => "webnus_tooltip",
        "params" => array(
						array(
							"type" => "textarea",
							"heading" => __( "Tooltip Text", 'WEBNUS_TEXT_DOMAIN' ),
							"param_name" => "tooltiptext",
							"value" => 'Tooltip Text',
							"description" => __( "Tooltip text goes here", 'WEBNUS_TEXT_DOMAIN')
						),
						
						array(
							'type' => "textarea",
							"heading" => __( 'Tooltip Content', 'WEBNUS_TEXT_DOMAIN' ),
							"param_name" => 'content',
							"value"=>'Content goes here',
							"description" => __( "Contet Goes Here", 'WEBNUS_TEXT_DOMAIN')
						),
						
           
        ),
		
        
    ) );


?>