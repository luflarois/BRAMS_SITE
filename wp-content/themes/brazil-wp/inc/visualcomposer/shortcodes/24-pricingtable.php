<?php
/*
 * Old Pricing Table
 */
 /*
vc_map( array(
        'name' =>'Webnus PricingTable',
        'base' => 'pricing_table',
        'category' => __( 'Webnus Shortcodes', 'WEBNUS_TEXT_DOMAIN' ),
        'params' => array(
						array(
							'type' => 'textfield',
							'heading' => __( 'Title', 'WEBNUS_TEXT_DOMAIN' ),
							'param_name' => 'title',
							'value' => 'Title',
							'description' => __( 'Enter the Pricing Table Title', 'WEBNUS_TEXT_DOMAIN')
						),
						array(
							'type' => 'textfield',
							'heading' => __( 'Price', 'WEBNUS_TEXT_DOMAIN' ),
							'param_name' => 'price',
							'value' => '$30',
							'description' => __( 'Enter the Pricing Table Price', 'WEBNUS_TEXT_DOMAIN')
						),
						
						array(
							'type' => 'textfield',
							'heading' => __( 'Period', 'WEBNUS_TEXT_DOMAIN' ),
							'param_name' => 'period',
							'value' => '/Month',
							'description' => __( 'Enter the Pricing Table Period', 'WEBNUS_TEXT_DOMAIN')
						),
						
						array(
							'type' => 'textfield',
							'heading' => __( 'Link URL', 'WEBNUS_TEXT_DOMAIN' ),
							'param_name' => 'link',
							'value' => '#',
							'description' => __( 'Enter the Pricing Table Link URL', 'WEBNUS_TEXT_DOMAIN')
						),
						
						array(
							'type' => 'textfield',
							'heading' => __( 'Link Title', 'WEBNUS_TEXT_DOMAIN' ),
							'param_name' => 'link_title',
							'value' => 'Order Now',
							'description' => __( 'Enter the Pricing Table Link Text', 'WEBNUS_TEXT_DOMAIN')
						),
						
						array(
							'type' => 'textarea',
							'heading' => __( 'Table Items', 'WEBNUS_TEXT_DOMAIN' ),
							'param_name' => 'content',
							'value' => '[price_item]2 Users[/price_item][price_item]100 mb Disk space[/price_item][price_item]20 Gig Data transfer[/price_item][price_item]Starter Admin Panel[/price_item][price_item]- APIs[/price_item][price_item]Email Support[/price_item]',
							'description' => __( 'Enter the Pricing Table Content, [price_item] Acceptable', 'WEBNUS_TEXT_DOMAIN')
						),
						
           
        ),
		
        
    ) );

*/
global $wpdb;
$query = "SELECT option_name FROM {$wpdb->options}
		WHERE 
		option_name LIKE 'css3_grid_shortcode_settings%'
		ORDER BY option_name";
$pricing_tables_list = $wpdb->get_results($query);
$css3GridAllShortcodeIds = array();
foreach($pricing_tables_list as $pricing_table)
	$css3GridAllShortcodeIds[] = substr($pricing_table->option_name,29,strlen($pricing_table->option_name));
sort($css3GridAllShortcodeIds);


vc_map( array(
        'name' =>'Webnus Css3PricingTable',
        'base' => 'css3_grid',
		"description" => "Pricing table",
        "icon" => "webnus_pricingtable",
        'category' => __( 'Webnus Shortcodes', 'WEBNUS_TEXT_DOMAIN' ),
        'params' => array(
						array(
							'type' => 'dropdown',
							'heading' => __( 'Pricing table ID', 'WEBNUS_TEXT_DOMAIN' ),
							'param_name' => 'id',
							'value' => $css3GridAllShortcodeIds,
							'description' => __( 'Select the pricing table ID', 'WEBNUS_TEXT_DOMAIN')
						),
						
						
           
        ),
		
        
    ) );
?>