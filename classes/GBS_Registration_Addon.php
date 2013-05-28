<?php


class GBS_Registration_Addon {

	public static function init() {
		require_once 'GBS_Registration.php';
		GB_Registration::init();
		require_once 'GBS_Fields.php';
		GBS_Fields::init();
	}

	public static function gb_addon( $addons ) {
		$addons['registration_path'] = array(
			'label' => gb__( 'Custom Registration Path' ),
			'description' => gb__( 'Modify the registration path.' ),
			'files' => array(),
			'callbacks' => array(
				array( __CLASS__, 'init' ),
			)
		);
		return $addons;
	}
}
