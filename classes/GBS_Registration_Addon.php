<?php


class GBS_Dynamic_Charities_Addon {

	public static function init() {
		require_once 'GB_Registration.php';
		GB_Registration::init();
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
