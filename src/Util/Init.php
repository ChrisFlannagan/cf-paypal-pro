<?php

namespace CF_PayPal_Pro\Util;

use CF_PayPal_Pro\Base\Base;
use CF_PayPal_Pro\Menu\Route;

class Init {

	public static function register_processor() {

		if ( ! class_exists( '\Caldera_Forms_Processor_Get_Data' ) || ! class_exists( '\Caldera_Forms_Processor_Processor' ) ) {
			return;
		}

		\Caldera_Forms_Autoloader::add_root( 'CF_PayPal_Pro', CF_PAYPAL_PRO_PATH . 'src' );

		$processor = array(
			"name"				=>	__( 'PayPal Pro for Caldera Forms', 'cf-paypal-pro'),
			"description"		=>	__( 'PayPal Pro for Caldera Forms', 'cf-paypal-pro'),
			"icon"				=>	CF_PAYPAL_PRO_URL . "icon.png",
			"author"			=>	'Chris Flanagan',
			"author_url"		=>	'https://whoischris.com',

			"template"			=>	CF_PAYPAL_PRO_PATH . "includes/config.php",

		);

		new Base( $processor, cf_paypal_pro_fields(), 'cf_paypal_pro' );

	}

	public static function hook() {
		add_action( 'caldera_forms_pre_load_processors', [ '\CF_PayPal_Pro\Util\Init', 'register_processor' ] );
		add_filter( 'caldera_forms_get_form_templates', 'cf_paypal_pro_example_form' );
		add_action( 'caldera_forms_rest_api_pre_init', function( $api ){
			$api->add_route( new Route() );
		});
	}
}