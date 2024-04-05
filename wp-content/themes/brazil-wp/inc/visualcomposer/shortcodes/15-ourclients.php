<?php


$item_array = array();

global $wpdb;
if(empty($wpdb)) die('WPDB not found...!');
  $query = $wpdb->get_results( 
  	"SELECT ID, post_title 
  	FROM $wpdb->posts
  	WHERE post_type = 'client' AND post_status='publish'
  	"
  );
  //var_dump($faq_query);
  
  if(!empty($query))
  {
  	$item_array['All'] = 0;
	 foreach ( $query as $q ) {
      $item_array[$q->post_title] = $q->ID;
    }
	
  }else{
  	
	$item_array['No Client Found'] = -1;
  }



vc_map( array(
        'name' =>'Webnus OurClients',
        'base' => 'ourclients',
		"description" => "Our Clients",
        'category' => __( 'Webnus Shortcodes', 'WEBNUS_TEXT_DOMAIN' ),
        "icon" => "webnus_ourclients",
		'params'=>array(
					array(
							'type' => 'attach_images',
							'heading' => __( 'Clients Images', 'WEBNUS_TEXT_DOMAIN' ),
							'param_name' => 'client_images',
							'value' => '',
							'description' => __( 'OurClients Images', 'WEBNUS_TEXT_DOMAIN')
					),
					
		)
        
    ) );


?>