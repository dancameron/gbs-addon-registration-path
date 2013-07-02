<?php


class GBS_Registration_Addon {

	public static function init() {
		require_once 'GBS_Registration.php';
		GB_Registration::init();
		require_once 'GBS_Fields.php';
		// GBS_Fields::init();
	}

	public static function gb_addon( $addons ) {
		$addons['registration_path'] = array(
			'label' => gb__( 'Advanced Merchant Registration' ),
			'description' => gb__( 'Allow for a merchant to register for a user and merchant accounts on the same form.' ),
			'files' => array(),
			'callbacks' => array(
				array( __CLASS__, 'init' ),
			)
		);
		return $addons;
	}
}
