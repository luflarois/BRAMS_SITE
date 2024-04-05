<?php

class WPBakeryShortCode_testimonial_slider extends WPBakeryShortCodesContainer {

    /*
     * Thi methods returns HTML code for frontend representation of your shortcode.
     * You can use your own html markup.
     *
     * @param $atts - shortcode attributes
     * @param @content - shortcode content
     *
     * @access protected
     *
     * @return string
     */

    protected function content($atts, $content = null) {

	  	extract(shortcode_atts(array(
		"el_class" => '',
		
		), $atts));
		$out = '<div class="testimonials-slider-w flexslider">';
		$out .= '<ul class="slides">';
		$out .= do_shortcode($content);
		$out .= '</ul></div>';
	
		return $out;
}

}




vc_map( array(
    "name" => "Webnus Testimonial Slider",
    "base" => "testimonial_slider",
    "category" => __( 'Webnus Shortcodes', 'WEBNUS_TEXT_DOMAIN' ),
     "icon" => "webnus_testimonial",
    "as_parent" => array('only' => 'testimonial_item'), // Use only|except attributes to limit child shortcodes (separate multiple values with comma)
    "content_element" => true,
    "show_settings_on_create" => false,
    
    "params" => array(
        // add params same as with any other content element
        array(
            "type" => "textfield",
            "heading" => __("Extra class name", "js_composer"),
            "param_name" => "el_class",
            "description" => __("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "js_composer")
        )
    ),
    "js_view" => 'VcColumnView'
) );




?>