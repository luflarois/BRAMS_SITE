<?php

vc_map( array(
        "name" =>"Webnus MaxTitle",
        "base" => "maxtitle",
		"description" => "MaxTitle",
        "category" => __( 'Webnus Shortcodes', 'WEBNUS_TEXT_DOMAIN' ),
        "icon" => "icon-wpb-maxtitle",
        "params" => array(
						array(
							"type" => "dropdown",
							"heading" => __( "Type", 'WEBNUS_TEXT_DOMAIN' ),
							"param_name" => "type",
							"value" => array(
								"Maxtitle 1"=>"1",
								"Maxtitle 2"=>"2",
								"Maxtitle 3"=>"3",
								"Maxtitle 4"=>"4",
								"Maxtitle 5"=>"5",
								
						),
						"description" => __( "Title Type", 'WEBNUS_TEXT_DOMAIN')
						),
						array(
							"type" => "textarea",
							"heading" => __( "Title", 'WEBNUS_TEXT_DOMAIN' ),
							"param_name" => "content",
							"value" => array('Title'),
							"description" => __( "Enter the title", 'WEBNUS_TEXT_DOMAIN')
						),
						
           
        ),
		
        
    ) );


?>