<?php
/*
Plugin Name: Custom Merchant Registration
Version: 1
Plugin URI: http://groupbuyingsite.com/marketplace
Description: Merchant registration includes account registration if not logged in.
Plugin URI: http://groupbuyingsite.com/marketplace/
Author: Sprout Venture
Author URI: http://sproutventure.com/
Plugin Author: Dan Cameron
Plugin Author URI: http://sproutventure.com/
Contributors: Dan Cameron
Text Domain: group-buying
*/

define ('GB_SSB_REG_URL', plugins_url( '', __FILE__) );
define( 'GB_SSB_REG_PATH', WP_PLUGIN_DIR . '/' . basename( dirname( __FILE__ ) ) );

// Load after all other plugins since we need to be compatible with groupbuyingsite
add_action( 'plugins_loaded', 'gb_load_custom_registration' );
function gb_load_custom_registration() {
	$gbs_min_version = '4.3';
	if ( class_exists( 'Group_Buying_Controller' ) && version_compare( Group_Buying::GB_VERSION, $gbs_min_version, '>=' ) ) {
		require_once 'classes/GBS_Registration_Addon.php';

		// Hook this plugin into the GBS add-ons controller
		add_filter( 'gb_addons', array( 'GBS_Registration_Addon', 'gb_addon' ), 10, 1 );
	}
}