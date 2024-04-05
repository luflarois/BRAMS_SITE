<?php

function webnus_iconbox( $attributes, $content = null ) {

	extract(shortcode_atts(array(
				"type"=>'0',
				'icon_title'=>'',
				'icon_link_url'=>'',
				'icon_link_text'=>'',
				"icon_name"=>'',
				"icon_size"=>'',
				"icon_color"=>'',
				"icon_image"=>''
		), $attributes));
	ob_start();		
	switch($type){
		case 1:
		echo '<article class="icon-box1">';
		break;
		case 2:
		echo '<article class="icon-box2">';
		break;
		case 3:
		echo '<article class="icon-box3">';
		break;
		case 4:
		echo '<article class="icon-box4">';
		break;
		case 5:
		echo '<article class="icon-box5">';
		break;
		case 6:
		echo '<article class="icon-box6">';
		break;
		case 7:
		echo '<article class="icon-box7">';
		break;
		default:
		echo '<article class="icon-box">';
		break;
	}

	if(!empty($icon_name) && $icon_name != 'none')
	{
		
		if(!empty($icon_link_url))
			echo "<a href='$icon_link_url'>"  . do_shortcode(  "[icon name='$icon_name' size='$icon_size' color='$icon_color']" ).'</a>';
		else
			echo  do_shortcode(  "[icon name='$icon_name' size='$icon_size' color='$icon_color']" );
	}
	elseif(!empty($icon_image)) {
		
		if(is_numeric($icon_image)){
			
			$icon_image = wp_get_attachment_url( $icon_image );
		
		}
		
			
		echo "<a href='$icon_link_url'>" . '<img src="'.$icon_image.'" />' . '</a>' ;
	}		
		
		switch($type){
			case 1:
			echo '<h4><strong>' . $icon_title . '</strong></h4>';
			break;
			case 2:
			echo '<h4><strong>' . $icon_title . '</strong></h4>';
			break;
			case 3:
			echo '<br /><h5><strong>' . $icon_title . '</strong></h5>';
			break;
			case 4:
			echo '<br /><h5><strong>' . $icon_title . '</strong></h5>';
			break;
			case 5:
			echo '<h4>' . $icon_title . '</h4>';
			break;
			case 6:
			echo '<h4>' . $icon_title . '</h4>';
			break;
			case 7:
			echo '<h4><strong>' . $icon_title . '</strong></h4>';
			break;
			default:
			echo '<h4><strong>' . $icon_title . '</strong></h4>';
		}
	
?><?php
      
      	 echo '<p>'.do_shortcode($content) .'</p>' ;
		 echo (!empty($icon_link_url) &&  (!empty($icon_link_text)) )?"<a class=\"magicmore\" href=\"{$icon_link_url}\">{$icon_link_text}</a>":'';
       	     
      ?></article><?php	
$out = ob_get_contents();
ob_end_clean();
$out = str_replace('<p></p>','',$out);
	
	return $out;
 }
 add_shortcode('iconbox', 'webnus_iconbox');
 
 

 
?>