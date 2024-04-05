<?php

  // Subtitle
 function webnus_subtitle ($atts, $content = null) {
 	extract(shortcode_atts(array(
 	'type'      => '1'
 	
						), $atts));

$out= '';
	switch($type){
		case 1:
		 	$out = '<h4 class="subtitle">';
		 	$out .= do_shortcode($content);
		 	$out .= '</h4>';
		break;
		case 2:
			$out =  '<div class="title">';
			$out .= '<h4>'. do_shortcode($content) .'</h4>';
			$out .= '</div>';			
		break;
		case 3:
			$out =  '<div class="sub-content">';
			$out .= '<h6 class="h-sub-content">'. do_shortcode($content) .'</h6>';
			$out .= '</div>';			
		break;
	}
 	return $out;
 }
 add_shortcode('subtitle','webnus_subtitle');




/*  bigtitle */


function bigtitle_shortcode ($atts, $content = null) {
	extract(shortcode_atts(array(
	'title'      => ''
						), $atts));

	
	$out = '<h2 class="mex-title">'. $content .'</h2>';
	
	return $out;
}

add_shortcode('big_title','bigtitle_shortcode');






function bigtitle2_shortcode ($atts, $content = null) {
	extract(shortcode_atts(array(
	'title'      => '',
	
						), $atts));

	
	$out = '<h2 class="mex-title">'. $content .'</h2>';
	
	return $out;
}
add_shortcode('big_title2','bigtitle2_shortcode');

function webnus_title($atts, $content)
{
	extract(shortcode_atts(array(
	'type'      => '4',

	), $atts));

	$out = '<h'.$type.'><strong>'.$content.'</strong></h'.$type.'>';
	return $out;
}

add_shortcode('title', 'webnus_title');



 // Max Title


function maxtitle_shortcode ($atts, $content = null) {
	extract(shortcode_atts(array(
	'type'      => '',
						), $atts));
	if( '1'==$type )
		$out = '<div class="max-title"><h2>'. $content .'</h2><span class="max-line"></span></div>';
	else
		$out = '<div class="max-title'.$type.'"><h2>'. $content .'</h2></div>';	
	
	return $out;
}
add_shortcode('maxtitle','maxtitle_shortcode');



function maxtitle2_shortcode ($atts, $content = null) {
	extract(shortcode_atts(array(
	'title'      => '',
						), $atts));

	$out = '<div class="max-title2"><h2>'. $content .'</h2></div>';
	return $out;
}
add_shortcode('max-title2','maxtitle2_shortcode');



function maxtitle3_shortcode ($atts, $content = null) {
	extract(shortcode_atts(array(
	'title'      => '',
						), $atts));

	$out = '<div class="max-title3"><h2>'. $content .'</h2></div>';
	return $out;
}
add_shortcode('max-title3','maxtitle3_shortcode');



function maxtitle4_shortcode ($atts, $content = null) {
	extract(shortcode_atts(array(
	'title'      => '',
						), $atts));

	$out = '<div class="max-title4"><h2>'. $content .'</h2></div>';
	return $out;
}
add_shortcode('max-title4','maxtitle4_shortcode');



?>