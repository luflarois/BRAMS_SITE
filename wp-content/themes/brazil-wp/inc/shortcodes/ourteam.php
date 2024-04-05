<?php
function ourteam1_shortcode ($atts, $content = null) {
	extract(shortcode_atts(array(
	'img'=>'',
	'name' => 'Name',
	'title' =>'Title',
	'text'=>'Text goes here',
	'first_social'=>'twitter',
	'first_url'=>'#',
	'second_social'=>'facebook',
	'second_url'=>'#',
	'third_social'=>'google-plus',
	'third_url'=>'#',
	'fourth_social'=>'linkedin',
	'fourth_url'=>'#',
	), $atts));
	if(is_numeric($img)){
		$img = wp_get_attachment_url( $img );
	}
	$out  = '<article class="our-team"><figure><img src="'. $img .'" alt=""></figure>';
	$out .= '<h2>'. $name .'</h2>';
	$out .= '<h5>'. $title .'</h5>';
	$out .= '<p>'. $text .'</p>';
	$out .= '<div class="social-team">';
	if(!empty($first_url))
		$out .= '<a href="'. $first_url .'"><i class="fa-'. $first_social .'"></i></a>';
	if(!empty($second_url))
		$out .= '<a href="'. $second_url .'"><i class="fa-'. $second_social .'"></i></a>';
	if(!empty($third_url))
		$out .= '<a href="'. $third_url .'"><i class="fa-'. $third_social .'"></i></a>';
	if(!empty($fourth_url))
		$out .= '<a href="'. $fourth_url .'"><i class="fa-'. $fourth_social .'"></i></a>';
	$out .= '</div>';
	$out .= '</article>';
return $out;
}
add_shortcode('ourteam','ourteam1_shortcode');
?>