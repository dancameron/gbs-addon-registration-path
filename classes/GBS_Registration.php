<?php

class GB_Registration extends Group_Buying_Controller {
	const FORM_ACTION = 'gbs_form_action';
	const STEP_1_ACTION = 'mixed_merchant_registration';
	const STEP_3_ACTION = 'choose_options';
	const STEP_4_ACTION = 'detailed_business_info';

	// Customize the redirect urls here.
	const STEP_2_URL_PATH = '/view-your-options/';
	const STEP_4_URL_PATH = '/detailed-business-information-step-2/';
	const STEP_5_URL_PATH = '/your-application-has-been-submitted/';

	public static function init() {
		// Process
		add_action( 'parse_request', array( get_class(), 'maybe_process_form' ) );

		// Shortcodes
		add_shortcode( 'merchant_registration_form', array( get_class(), 'merchant_registration_form' ) );
		add_shortcode( 'options_form', array( get_class(), 'options_form' ) );
		add_shortcode( 'detailed_business_info_form', array( get_class(), 'detailed_business_info_form' ) );
	}

	public function maybe_process_form() {
		if ( isset( $_POST[self::FORM_ACTION] ) ) {
			switch ( $_POST[self::FORM_ACTION] ) {
			case self::STEP_1_ACTION:
				self::process_mixed_registration();
				break;
			case self::STEP_3_ACTION:
				self::process_options();
				break;
			case self::STEP_4_ACTION:
				self::process_detailed_merchant_info();
				break;

			default:
				break;
			}

		}

	}

	/////////////////////////
	// Mixed Registration //
	/////////////////////////

	/**
	 * Display the registration form
	 *
	 * @return
	 */
	public function merchant_registration_form() {
		$args = array(
			'step' => self::STEP_1_ACTION,
			'next_page_url' => self::STEP_2_URL_PATH
		);
		return self::_load_view_to_string( 'registration-form', $args );
	}

	/**
	 * Process the mixed registration page
	 *
	 * @return
	 */
	public function process_mixed_registration() {
		$user_id = ( is_user_logged_in() ) ? get_current_user_id() : self::register_user_account() ;
		$merchant_id = ( $user_id ) ? self::register_merchant( $user_id ) : 0 ;

		// Redirect
		if ( $merchant_id ) {
			wp_redirect( site_url( self::STEP_2_URL_PATH ) );
			exit();
		}

	}

	/**
	 * Process the user registration form
	 *
	 * @return int user_id
	 */
	public function register_user_account() {
		$errors = array();
		$email_address = isset( $_POST['gb_user_email'] )?$_POST['gb_user_email']:'';
		$username = isset( $_POST['gb_user_login'] )?$_POST['gb_user_login']:$email_address;
		$password = isset( $_POST['gb_user_password'] )?$_POST['gb_user_password']:'';
		$password2 = isset( $_POST['gb_user_password2'] )?$_POST['gb_user_password2']:'';
		$errors = array_merge( $errors, self::validate_user_fields( $username, $email_address, $password, $password2 ) );

		$errors = apply_filters( 'gb_validate_account_registration', $errors, $username, $email_address, $_POST );
		if ( $errors ) {
			foreach ( $errors as $error ) {
				self::set_message( $error, self::MESSAGE_STATUS_ERROR );
			}
			return FALSE;
		} else {
			$sanitized_user_login = sanitize_user( $username );
			$user_email = apply_filters( 'user_registration_email', $email_address );
			$password = isset( $_POST['gb_user_password'] )?$_POST['gb_user_password']:'';
			$user_id = Group_Buying_Accounts_Registration::create_user( $sanitized_user_login, $user_email, $password, $_POST );
			if ( $user_id ) {
				$user = wp_signon(
					array(
						'user_login' => $sanitized_user_login,
						'user_password' => $password,
						'remember' => false
					), false );
				do_action( 'gb_registration', $user, $sanitized_user_login, $user_email, $password, $_POST );
			}
		}
		return $user->ID;
	}

	/**
	 * copied from merchant registration process_form_submission
	 *
	 */
	public function register_merchant( $authorize_user = 0 ) {
		$errors = array();
		if ( !$authorize_user ) {
			$authorize_user = get_current_user_id();
		}
		$title = isset( $_POST['gb_contact_merchant_title'] ) ? esc_html( $_POST['gb_contact_merchant_title'] ) : '';
		$allowed_tags = wp_kses_allowed_html( 'post' );
		$allowed_tags['iframe'] = array(
			'width' => true,
			'height' => true,
			'src' => true,
			'frameborder' => true,
			'webkitAllowFullScreen' => true,
			'mozallowfullscreen' => true,
			'allowfullscreen' => true
		);
		$content = isset( $_POST['gb_contact_merchant_description'] ) ? wp_kses( $_POST['gb_contact_merchant_description'], $allowed_tags ) : '';
		$contact_title = isset( $_POST['gb_contact_merchant_title'] ) ? esc_html( $_POST['gb_contact_merchant_title'] ) : '';
		$contact_name = isset( $_POST['gb_contact_name'] ) ? esc_html( $_POST['gb_contact_name'] ) : '';
		$contact_street = isset( $_POST['gb_contact_street'] ) ? esc_html( $_POST['gb_contact_street'] ) : '';
		$contact_city = isset( $_POST['gb_contact_city'] ) ? esc_html( $_POST['gb_contact_city'] ) : '';
		$contact_state = isset( $_POST['gb_contact_zone'] ) ? esc_html( $_POST['gb_contact_zone'] ) : '';
		$contact_postal_code = isset( $_POST['gb_contact_postal_code'] ) ? esc_html( $_POST['gb_contact_postal_code'] ) : '';
		$contact_country = isset( $_POST['gb_contact_country'] ) ? esc_html( $_POST['gb_contact_country'] ) : '';
		$contact_phone = isset( $_POST['gb_contact_phone'] ) ? esc_html( $_POST['gb_contact_phone'] ) : '';
		$website = isset( $_POST['gb_contact_website'] ) ? esc_url( $_POST['gb_contact_website'] ) : '';
		$facebook = isset( $_POST['gb_contact_facebook'] ) ? esc_url( $_POST['gb_contact_facebook'] ) : '';
		$twitter = isset( $_POST['gb_contact_twitter'] ) ? esc_url( $_POST['gb_contact_twitter'] ) : '';
		$type_id = isset( $_POST['gb_merchant_type'] ) ? (int) $_POST['gb_merchant_type'] : '';

		$errors = apply_filters( 'gb_validate_merchant_registration', $errors, $_POST );
		if ( !empty( $errors ) ) {
			foreach ( $errors as $error ) {
				self::set_message( $error, self::MESSAGE_STATUS_ERROR );
			}
			return FALSE;
		} else {
			$post_id = wp_insert_post( array(
					'post_status' => 'draft',
					'post_type' => Group_Buying_Merchant::POST_TYPE,
					'post_title' => $title,
					'post_content' => $content
				) );
			$merchant = Group_Buying_Merchant::get_instance( $post_id );
			$merchant->set_contact_name( $contact_name );
			$merchant->set_contact_title( $contact_title );
			$merchant->set_contact_street( $contact_street );
			$merchant->set_contact_city( $contact_city );
			$merchant->set_contact_state( $contact_state );
			$merchant->set_contact_postal_code( $contact_postal_code );
			$merchant->set_contact_country( $contact_country );
			$merchant->set_contact_phone( $contact_phone );
			$merchant->set_website( $website );
			$merchant->set_facebook( $facebook );
			$merchant->set_twitter( $twitter );
			$merchant->authorize_user( $authorize_user );

			wp_set_object_terms( $post_id, $type_id, Group_Buying_Merchant::MERCHANT_TYPE_TAXONOMY );

			do_action( 'register_merchant', $merchant );

			if ( !empty( $_FILES['gb_contact_merchant_thumbnail'] ) ) {
				// Set the uploaded field as an attachment
				$merchant->set_attachement( $_FILES, 'gb_contact_merchant_thumbnail' );
			}
		}
		return $post_id;
	}

	////////////////////////
	// Options Selection //
	////////////////////////


	public function options_form() {
		$merchants = gb_get_merchants_by_account();
		$merchant_id = $merchants[0];
		$args = array(
			'step' => self::STEP_3_ACTION,
			'merchant_id' => $merchant_id
		);
		return self::_load_view_to_string( 'options-form', $args );
	}

	public function process_options() {
		$errors = array();
		$merchants = gb_get_merchants_by_account();
		$merchant_id = $merchants[0];
		$merchant = Group_Buying_Merchant::get_instance( $merchant_id );

		$contact_street = isset( $_POST['gb_contact_street'] ) ? esc_html( $_POST['gb_contact_street'] ) : '';
		$contact_city = isset( $_POST['gb_contact_city'] ) ? esc_html( $_POST['gb_contact_city'] ) : '';
		$contact_state = isset( $_POST['gb_contact_state'] ) ? esc_html( $_POST['gb_contact_state'] ) : '';
		$contact_country = isset( $_POST['gb_contact_country'] ) ? esc_html( $_POST['gb_contact_country'] ) : '';
		$website = isset( $_POST['gb_contact_website'] ) ? esc_url( $_POST['gb_contact_website'] ) : '';

		$package = isset( $_POST['gb_merchant_package_option'] ) ? $_POST['gb_merchant_package_option'] : '';

		// Save
		GBS_Fields::set_package( $merchant_id, $package );
		$merchant->set_contact_street( $contact_street );
		$merchant->set_contact_city( $contact_city );
		$merchant->set_contact_state( $contact_state );
		$merchant->set_contact_country( $contact_country );
		$merchant->set_website( $website );


		// Redirect
		if ( empty( $errors ) ) {
			wp_redirect( site_url( self::STEP_4_URL_PATH ) );
			exit();
		}
	}


	///////////////////
	// Detailed Biz //
	///////////////////


	public function detailed_business_info_form() {
		$merchants = gb_get_merchants_by_account();
		$merchant_id = $merchants[0];
		$args = array(
			'step' => self::STEP_4_ACTION,
			'merchant_id' => $merchant_id
		);
		return self::_load_view_to_string( 'detailed-biz-form', $args );
	}

	public function process_detailed_merchant_info() {
		$errors = array();
		$merchants = gb_get_merchants_by_account();
		$merchant_id = $merchants[0];

		$advertising_methods = isset( $_POST['advertising_methods'] ) ? $_POST['advertising_methods']  : '';
		$time_in_biz = isset( $_POST['time_in_biz'] ) ? $_POST['time_in_biz']  : '';
		$details = isset( $_POST['details'] ) ? $_POST['details']  : '';
		$promo_methods = isset( $_POST['promo_methods'] ) ? $_POST['promo_methods']  : '';
		$internet_marketing = isset( $_POST['internet_marketing'] ) ? $_POST['internet_marketing']  : '';
		$does_int_marketing = isset( $_POST['does_int_marketing'] ) ? $_POST['does_int_marketing']  : '';
		$biz_hours = isset( $_POST['biz_hours'] ) ? $_POST['biz_hours']  : '';
		$storefront_detail = isset( $_POST['storefront_detail'] ) ? $_POST['storefront_detail']  : '';

		GBS_Fields::set_advertising_methods( $merchant_id, $advertising_methods );
		GBS_Fields::set_time_in_biz( $merchant_id, $time_in_biz );
		GBS_Fields::set_details( $merchant_id, $details );
		GBS_Fields::set_promo_methods( $merchant_id, $promo_methods );
		GBS_Fields::set_internet_marketing( $merchant_id, $internet_marketing );
		GBS_Fields::set_does_int_marketing( $merchant_id, $does_int_marketing );
		GBS_Fields::set_biz_hours( $merchant_id, $biz_hours );
		GBS_Fields::set_storefront_detail( $merchant_id, $storefront_detail );

		// Redirect
		if ( empty( $errors ) ) {
			wp_redirect( site_url( self::STEP_5_URL_PATH ) );
			exit();
		}
	}


	////////////////
	// Utilities //
	////////////////

	/**
	 * Validation
	 *
	 * taken from accounts controller
	 */
	private function validate_user_fields( $username, $email_address, $password, $password2 ) {
		$errors = new WP_Error();
		if ( is_multisite() && GB_IS_AUTHORIZED_WPMU_SITE ) {
			$validation = wpmu_validate_user_signup( $username, $email_address );
			if ( $validation['errors']->get_error_code() ) {
				$errors = apply_filters( 'registration_errors_mu', $validation['errors'] );
			}
		} else { // Single-site install, so we don't have the wpmu functions
			// This is mostly just copied from register_new_user() in wp-login.php
			$sanitized_user_login = sanitize_user( $username );
			$user_email = apply_filters( 'user_registration_email', $email_address );

			if ( $password2 == '' )
				$password2 = $password;

			// check Password
			if ( $password == '' || $password2 == '' ) {
				$errors->add( 'empty_password', __( 'Please enter a password.' ) );
			} elseif ( $password != $password2 ) {
				$errors->add( 'password_mismatch', __( 'Passwords did not match.' ) );
			}
			// Check the username
			if ( $sanitized_user_login == '' ) {
				$errors->add( 'empty_username', __( 'Please enter a username.' ) );
			} elseif ( ! validate_username( $username ) ) {
				$errors->add( 'invalid_username', __( 'This username is invalid because it uses illegal characters. Please enter a valid username.' ) );
				$sanitized_user_login = '';
			} elseif ( username_exists( $sanitized_user_login ) ) {
				$errors->add( 'username_exists', __( 'This username is already registered, please choose another one.' ) );
			}

			// Check the e-mail address
			if ( $user_email == '' ) {
				$errors->add( 'empty_email', __( 'Please type your e-mail address.' ) );
			} elseif ( ! is_email( $user_email ) ) {
				$errors->add( 'invalid_email', __( 'The email address isn&#8217;t correct.' ) );
				$user_email = '';
			} elseif ( email_exists( $user_email ) ) {
				$errors->add( 'email_exists', __( 'This email is already registered, please choose another one.' ) );
			}

			do_action( 'register_post', $sanitized_user_login, $user_email, $password, $password2, $errors );
			$errors = apply_filters( 'registration_errors', $errors, $sanitized_user_login, $user_email, $password, $password2 );
		}
		if ( $errors->get_error_code() ) {
			return $errors->get_error_messages();
		} else {
			return array();
		}
	}



	private static function _load_view_to_string( $path, $args = array() ) {
		$args['FORM_ACTION'] = self::FORM_ACTION;
		ob_start();
		extract( $args );
		// Check if there's a template specific file
		$file = ( file_exists( GB_SSB_REG_PATH . '/views/' . GBS_THEME_SLUG . '/' . $path . '.php' ) ) ? GB_SSB_REG_PATH . '/views/' . GBS_THEME_SLUG . '/' . $path . '.php' : GB_SSB_REG_PATH . '/views/prime_theme/' . $path . '.php' ;
		@include $file;
		return ob_get_clean();
	}

}
