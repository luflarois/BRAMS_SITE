<?php
vc_map( array(
    'name' =>'Webnus ContactForm',
    'base' => 'contactform',
    "icon" => "webnus_contactform",
	"description" => "Contact form",
    'category' => __( 'Webnus Shortcodes', 'WEBNUS_TEXT_DOMAIN' ),
    'params' => array(

		array(
			'type' => 'dropdown',
			'heading' => __( 'Form type', 'WEBNUS_TEXT_DOMAIN' ),
			'param_name' => 'type',
			'value' => array('Vertical'=>'1','Horizontal'=>'2'),
			'description' => __( 'Contact form type', 'WEBNUS_TEXT_DOMAIN')
		),

)));
?>