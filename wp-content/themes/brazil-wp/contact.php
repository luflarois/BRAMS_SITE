<?php

/*

Template Name: Contact Page

*/

GLOBAL $webnus_options;
$recaptcha_desire = false;

if ( $webnus_options->webnus_recaptcha_site_key() && $webnus_options->webnus_recaptcha_secret_key() ) : 
	require_once get_template_directory() . '/inc/helpers/recaptchalib.php';
	// Register API keys at https://www.google.com/recaptcha/admin
	$siteKey = $webnus_options->webnus_recaptcha_site_key();
	$secret = $webnus_options->webnus_recaptcha_secret_key();

	// reCAPTCHA supported 40+ languages listed here: https://developers.google.com/recaptcha/docs/language
	$lang = get_bloginfo ( 'language' );

	// The response from reCAPTCHA
	$resp = null;
	// The error code from reCAPTCHA, if any
	$error = null;

	$reCaptcha = new ReCaptcha($secret);

	
	$recaptcha_desire = true;
	
endif;


$errors = array();
$isError = false;

$errorName = __( 'Please enter your name.', 'WEBNUS_TEXT_DOMAIN' );
$errorEmail = __( 'Please enter a valid email address.', 'WEBNUS_TEXT_DOMAIN' );
$errorMessage = __( 'Please enter the message.', 'WEBNUS_TEXT_DOMAIN' );
if ( $recaptcha_desire ) { $errorreCaptcha = __( 'Please enter the valid captcha.', 'WEBNUS_TEXT_DOMAIN' ); }

// Get the posted variables and validate them.
if ( isset( $_POST['is-submitted'] ) ) {
	$name    = $_POST['cName'];
	$email   = $_POST['cEmail'];
	$subject   = $_POST['cSubject'];
	$message = $_POST['cMessage'];

	// Check the name
	if ( ! webnus_validate_length( $name, 2 ) ) {
		$isError             = true;
		$errors['errorName'] = $errorName;
	}

	// Check the email
	if ( ! is_email( $email ) ) {
		$isError              = true;
		$errors['errorEmail'] = $errorEmail;
	}

	// Check the message
	if ( ! webnus_validate_length( $message, 2 ) ) {
		$isError                = true;
		$errors['errorMessage'] = $errorMessage;
	}

	if ( $recaptcha_desire ) :
		$recaptcha = $_POST["g-recaptcha-response"];

		// Check the recaptcha
		if ( ! webnus_validate_length( $recaptcha, 2 ) ) {
			$isError                = true;
			$errors['errorreCaptcha'] = $errorreCaptcha;
		}

		// Was there a reCAPTCHA response?
		if ( $_POST["g-recaptcha-response"] ) {
		    $resp = $reCaptcha->verifyResponse(
		        $_SERVER["REMOTE_ADDR"],
		        $_POST["g-recaptcha-response"]
		    );
		}
	endif;


	// If there's no error, send email
	if ( ! $isError ) {
		// Get admin email
		$emailReceiver = get_option( 'admin_email' );

		$emailSubject = sprintf( __( 'You have been contacted by %s', 'WEBNUS_TEXT_DOMAIN' ), $name );
		$emailBody    = sprintf( __( 'Subject: %1$s', 'WEBNUS_TEXT_DOMAIN' ), $subject ) . PHP_EOL . PHP_EOL;
		$emailBody    .= sprintf( __( 'You have been contacted by %1$s. Their message is:', 'WEBNUS_TEXT_DOMAIN' ), $name ) . PHP_EOL . PHP_EOL;
		$emailBody    .= $message . PHP_EOL . PHP_EOL;
		$emailBody    .= sprintf( __( 'You can contact %1$s via email at %2$s', 'WEBNUS_TEXT_DOMAIN' ), $name, $email );
		$emailBody    .= PHP_EOL . PHP_EOL;
		
		$emailHeaders[] = "Reply-To: $email" . PHP_EOL;

		add_filter( 'wp_mail_from_name', 'custom_wp_mail_from_name' );
			function custom_wp_mail_from_name( $name ) {
				return 'Webnus Contact form';
		}


		$emailIsSent = wp_mail( $emailReceiver, $emailSubject, $emailBody, $emailHeaders );
	}

}


get_header();

GLOBAL $webnus_options;
GLOBAL $webnus_page_options_meta;

$meta = isset($webnus_page_options_meta)?$webnus_page_options_meta->the_meta():null;
if(!empty($meta)) {
	$show_titlebar =  isset($meta['webnus_page_options'][0]['show_page_title_bar'])?$meta['webnus_page_options'][0]['show_page_title_bar']:null;
	$titlebar_bg =  isset($meta['webnus_page_options'][0]['title_background_color'])?$meta['webnus_page_options'][0]['title_background_color']:null;
	$titlebar_fg =  isset($meta['webnus_page_options'][0]['title_text_color'])?$meta['webnus_page_options'][0]['title_text_color']:null;
	$sidebar_pos =  isset($meta['webnus_page_options'][0]['sidebar_position'])?$meta['webnus_page_options'][0]['sidebar_position']:'right';
}

if($show_titlebar && ( 'show' == $show_titlebar)): ?>
	<section id="headline" style="<?php if(!empty($titlebar_bg)) echo ' background-color:' . esc_html( $titlebar_bg ) . ';'; ?>">
	    <div class="container">
	      <h3 style="<?php if(!empty($titlebar_fg)) echo ' color:'. esc_html( $titlebar_fg ) .';';  ?>"><?php the_title(); ?></h3>
	    </div>
	</section>
<?php endif; ?>

<section id="main-content" class="container">
	<!-- Start Page Content -->
	<hr class="vertical-space2">
	
	<div class="col-md-5 contact-inf">
		<h4><?php echo esc_html__( 'Contact Information','WEBNUS_TEXT_DOMAIN' ); ?>:</h4><br>
		<p><strong><?php esc_html_e( 'Address','WEBNUS_TEXT_DOMAIN' ); ?>:</strong></p>
		<p><?php echo esc_html( $webnus_options->webnus_contact_address() ); ?></p><br>
		<p><strong><?php esc_html_e( 'Phone','WEBNUS_TEXT_DOMAIN' ); ?>:</strong></p>
		<p><?php echo esc_html( $webnus_options->webnus_contact_phone() ); ?><br></p><br>
		<p><strong><?php esc_html_e( 'Email', 'WEBNUS_TEXT_DOMAIN' ); ?>:</strong></p>
		<p><?php echo esc_html( $webnus_options->webnus_contact_email() ); ?><br></p><br>
		<hr class="boldbx">
		<?php 
		  if( have_posts() ): while( have_posts() ): the_post();
			the_content(); 
		  endwhile; // end loop
		  endif;
		?>
	</div> <!-- end contact-info -->

	<div class="col-md-6 col-md-offset-1">
		<div class="contact-form">
			<div class="clr"></div><br>

			<form action="<?php the_permalink(); ?>" method="POST" id="contact-form" class="frmContact" role="form" novalidate>
				<div class="field-group">
					<h5><?php esc_html_e( 'Whats your Name?', 'WEBNUS_TEXT_DOMAIN' ); ?></h5>
					<input type="text" name="cName" class="txbx" placeholder="<?php esc_html_e( 'Name','WEBNUS_TEXT_DOMAIN' ); ?>" value="<?php if ( isset( $_POST['cName'] ) ) { echo esc_html( $_POST['cName'] ); } ?>" /><br>
					<?php if ( isset( $errors['errorName'] ) ) : ?>
						<span class="bad-field"><?php echo  esc_html( $errors['errorName'] ); ?></span>
					<?php endif; ?>
				</div>

				<div class="field-group">
					<h5><?php esc_html_e( 'Whats your Email?','WEBNUS_TEXT_DOMAIN' ); ?></h5>
					<input  type="text" name="cEmail" class="txbx" placeholder="<?php esc_html_e( 'Email','WEBNUS_TEXT_DOMAIN' ); ?>" value="<?php if ( isset( $_POST['cEmail'] ) ) { echo esc_html( $_POST['cEmail'] ); } ?>" /><br>
					<?php if ( isset( $errors['errorEmail'] ) ) : ?>
						<span class="bad-field"><?php echo esc_html( $errors['errorEmail'] ); ?></span>
					<?php endif; ?>
				</div>

				<div class="field-group">
					<h5><?php esc_html_e( 'Email Subject?','WEBNUS_TEXT_DOMAIN' ); ?></h5>
					<input name="cSubject" type="text" class="txbx" placeholder="<?php esc_html_e( 'Subject','WEBNUS_TEXT_DOMAIN' ); ?>" value="<?php if ( isset( $_POST['cSubject'] ) ) { echo esc_html( $_POST['cSubject'] ); } ?>" /><br>
				</div>

				<div class="erabox">
					<div class="field-group">
						<h5><?php esc_html_e( 'Message to us','WEBNUS_TEXT_DOMAIN' ); ?></h5>
						<textarea name="cMessage" class="txbx era"><?php if ( isset( $_POST['cMessage'] ) ) { echo esc_html( $_POST['cMessage'] ); } ?></textarea><br>
						<?php if ( isset( $errors['errorMessage'] ) ) : ?>
							<span class="bad-field"><?php echo esc_html( $errors['errorMessage'] ); ?></span>
						<?php endif; ?>
					</div>
					
					<?php if ( $recaptcha_desire ) : ?>
						<?php if ( isset( $errors['errorreCaptcha'] ) ) : ?>
							<span class="bad-field captcha"><?php echo esc_html( $errors['errorreCaptcha'] ); ?></span>
						<?php endif; ?>
						<div class="g-recaptcha" data-sitekey="<?php echo esc_html( $siteKey ); ?>"></div>
						<script type="text/javascript" src="https://www.google.com/recaptcha/api.js?hl=<?php echo esc_html( $lang );?>"></script>
					<?php endif; ?>

					<input type="hidden" name="is-submitted" id="is-submitted" value="true">
					<button type="submit" class="sendbtn btnSend" ><?php esc_html_e( 'Send Message','WEBNUS_TEXT_DOMAIN' ); ?></button>


					<?php if ( isset( $emailIsSent ) && $emailIsSent ) { ?>
						<div class="alert alert-success">
							<?php esc_html_e( 'Your message has been sucessfully sent, thank you!', 'WEBNUS_TEXT_DOMAIN' ); ?>
						</div> <!-- end alert -->
					<?php } elseif ( isset( $isError ) && $isError ) { ?>
						<div class="alert-alert-danger">
							<?php esc_html_e( 'Sorry, it seems there was an error.', 'WEBNUS_TEXT_DOMAIN' ); ?>
						</div> <!-- end alert -->
					<?php } ?>

				</div>
			</form>
		</div><!-- end-contact-form  -->
	</div>

	<div class="white-space"></div>

	<section class="col-md-12">
		<div id="contact-map">
			<?php echo $webnus_options->webnus_google_map(); ?>
		</div><!-- END-contact Map -->
	</section><!-- END-Google Map Section -->

	<hr class="vertical-space3">
</section><!-- container -->

<?php get_footer(); ?>