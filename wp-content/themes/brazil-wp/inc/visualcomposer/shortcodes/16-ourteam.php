<?php vc_map( array(
        'name' =>'Webnus OurTeam',
        'base' => 'ourteam',
		"description" => "Team member",
        "icon" => "webnus_ourteam",
        'params'=>array(
				array(
						'type' => 'attach_image',
						'heading' => __( 'Team Image', 'WEBNUS_TEXT_DOMAIN' ),
						'param_name' => 'img',
						'value'=>'',
						'description' => __( 'Team member image', 'WEBNUS_TEXT_DOMAIN')
				),
				array(
						'type' => 'textfield',
						'heading' => __( 'Team Memeber Name', 'WEBNUS_TEXT_DOMAIN' ),
						'param_name' => 'name',
						'value'=>'Name',
						'description' => __( 'Team member name', 'WEBNUS_TEXT_DOMAIN')
				),
				array(
						'type' => 'textfield',
						'heading' => __( 'Team Memeber Title', 'WEBNUS_TEXT_DOMAIN' ),
						'param_name' => 'title',
						'value'=>'Title',
						'description' => __( 'Team member title', 'WEBNUS_TEXT_DOMAIN')
				),
				array(
						'type' => 'textarea',
						'heading' => __( 'Team Memeber Description Text', 'WEBNUS_TEXT_DOMAIN' ),
						'param_name' => 'text',
						'value'=>'Text goes here',
						'description' => __( 'Team member description text', 'WEBNUS_TEXT_DOMAIN')
				),
				array(
						'type' => 'dropdown',
						'heading' => __( 'First Social Name', 'WEBNUS_TEXT_DOMAIN' ),
						'param_name' => 'first_social',
						 'value' => array(
							"Twitter"=>'twitter',
							"Facebook"=>'facebook',
							"Google Plus"=>'google-plus',
							"Vimeo"=>'vimeo',
							"Dribbble"=>'dribbble',
							"Youtube"=>'youtube',
							"Youtube"=>'youtube',
							"Pinterest"=>'pinterest',
							"LinkedIn"=>'linkedin',
							"Instagram"=>'instagram',
								),
							'std' => 'twitter',
						'description' => __( 'Select Social Name', 'WEBNUS_TEXT_DOMAIN')
				),
				array(
						'type' => 'textfield',
						'heading' => __( 'First Social URL', 'WEBNUS_TEXT_DOMAIN' ),
						'param_name' => 'first_url',
						'value'=>'',
						'description' => __( 'First social URL', 'WEBNUS_TEXT_DOMAIN')
				),
				array(
						'type' => 'dropdown',
						'heading' => __( 'Second Social Name', 'WEBNUS_TEXT_DOMAIN' ),
						'param_name' => 'second_social',
						 'value' => array(
							"Twitter"=>'twitter',
							"Facebook"=>'facebook',
							"Google Plus"=>'google-plus',
							"Vimeo"=>'vimeo',
							"Dribbble"=>'dribbble',
							"Youtube"=>'youtube',
							"Youtube"=>'youtube',
							"Pinterest"=>'pinterest',
							"LinkedIn"=>'linkedin',
							"Instagram"=>'instagram',
								),
							'std' => 'facebook',

						'description' => __( 'Select Social Name', 'WEBNUS_TEXT_DOMAIN')
				),
				array(
						'type' => 'textfield',
						'heading' => __( 'Second Social URL', 'WEBNUS_TEXT_DOMAIN' ),
						'param_name' => 'second_url',
						'value'=>'',
						'description' => __( 'Second social URL', 'WEBNUS_TEXT_DOMAIN')
				),
				array(
						'type' => 'dropdown',
						'heading' => __( 'Third Social Name', 'WEBNUS_TEXT_DOMAIN' ),
						'param_name' => 'third_social',
						 'value' => array(
							"Twitter"=>'twitter',
							"Facebook"=>'facebook',
							"Google Plus"=>'google-plus',
							"Vimeo"=>'vimeo',
							"Dribbble"=>'dribbble',
							"Youtube"=>'youtube',
							"Youtube"=>'youtube',
							"Pinterest"=>'pinterest',
							"LinkedIn"=>'linkedin',
							"Instagram"=>'instagram',
								),
							'std' => 'Google Plus',
						'description' => __( 'Select Social Name', 'WEBNUS_TEXT_DOMAIN')
				),
				array(
						'type' => 'textfield',
						'heading' => __( 'Third Social URL', 'WEBNUS_TEXT_DOMAIN' ),
						'param_name' => 'third_url',
						'value'=>'',
						'description' => __( 'Third social URL', 'WEBNUS_TEXT_DOMAIN')
				),
				array(
						'type' => 'dropdown',
						'heading' => __( 'Fourth Social Name', 'WEBNUS_TEXT_DOMAIN' ),
						'param_name' => 'fourth_social',
						 'value' => array(
							"Twitter"=>'twitter',
							"Facebook"=>'facebook',
							"Google Plus"=>'google-plus',
							"Vimeo"=>'vimeo',
							"Dribbble"=>'dribbble',
							"Youtube"=>'youtube',
							"Youtube"=>'youtube',
							"Pinterest"=>'pinterest',
							"LinkedIn"=>'linkedin',
							"Instagram"=>'instagram',
								),
							'std' => 'Google Plus',
						'description' => __( 'Select Social Name', 'WEBNUS_TEXT_DOMAIN')
				),

				array(
						'type' => 'textfield',
						'heading' => __( 'Fourth Social URL', 'WEBNUS_TEXT_DOMAIN' ),
						'param_name' => 'fourth_url',
						'value'=>'',
						'description' => __( 'Fourth social URL', 'WEBNUS_TEXT_DOMAIN')
				),
		),
		'category' => __( 'Webnus Shortcodes', 'WEBNUS_TEXT_DOMAIN' ),    
    ) );
?>