<?php

vc_map( array(
        "name" =>"Webnus Button",
        "base" => "button",
        "description" => "Button shortcode",
        "category" => __( 'Webnus Shortcodes', 'WEBNUS_TEXT_DOMAIN' ),
        "icon" => "webnus_button",
        "params" => array(
						array(
						"type" => "textarea",
						"heading" => __( "Content", 'WEBNUS_TEXT_DOMAIN' ),
						"param_name" => "content",
						"value"=>'Text',
						"description" => __( "Button Text Content", 'WEBNUS_TEXT_DOMAIN')
						),
						
						
						array(
						"type" => "textfield",
						"heading" => __( "URL", 'WEBNUS_TEXT_DOMAIN' ),
						"param_name" => "url",
						"value"=>'#',
						"description" => __( "Button URL Link", 'WEBNUS_TEXT_DOMAIN')
						),
												
						array(
						"type" => "dropdown",
						"heading" => __( "Target", 'WEBNUS_TEXT_DOMAIN' ),
						"param_name" => "target",
						"value" => array(
							"Blank"=>"_blank",
							"Self"=>"_self",
							"Parent"=>"_parent",
							"Top"=>"_top",
							
						),
						"description" => __( "Button URL Target", 'WEBNUS_TEXT_DOMAIN'),
						
						
						),
						
						array(
						"type" => "dropdown",
						"heading" => __( "Color", 'WEBNUS_TEXT_DOMAIN' ),
						"param_name" => "color",
						"value" => array(
							"Green"=>"green",
							"Red"=>"red",
							"Blue"=>"blue",
							"Gray"=>"gray",
							"Cherry"=>"cherry",
							"Orchid"=>"orchid",
							"Pink"=>"pink",
							"Orange"=>"orange",
							"Teal"=>"teal",
							"SkyBlue"=>"skyblue",
							"Jade"=>"jade",
						),
						"description" => __( "Button Color", 'WEBNUS_TEXT_DOMAIN')
						),
												
						array(
						"type" => "dropdown",
						"heading" => __( "Size", 'WEBNUS_TEXT_DOMAIN' ),
						"param_name" => "size",
						"value" => array(
							"Small"=>"small",
							"Medium"=>"medium",
							"Large"=>"large",
							
						),
						"description" => __( "Button Size", 'WEBNUS_TEXT_DOMAIN')
						),

						array(
						"type" => "dropdown",
						"heading" => __( "Bordered?", 'WEBNUS_TEXT_DOMAIN' ),
						"param_name" => "border",
						"value"=>array('Normal'=>'false','Bordered'=>'true'),
						"description" => __( "Is button bordered?", 'WEBNUS_TEXT_DOMAIN')
						),
						array(
						"type" => "iconfonts",
						"heading" => __( "Icon", 'WEBNUS_TEXT_DOMAIN' ),
						"param_name" => "icon",
						"value"=>'',
						"description" => __( "Select Button Icon", 'WEBNUS_TEXT_DOMAIN')
						),
				
        ),
		
        
    ) );


?>