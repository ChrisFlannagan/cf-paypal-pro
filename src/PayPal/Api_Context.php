<?php

namespace CF_PayPal_Pro\PayPal;

use CF_PayPal_Pro\Menu\Settings;
use PayPal\Rest\ApiContext;
use PayPal\Auth\OAuthTokenCredential;

class Api_Context {

	protected static $instance;
	private $context;

	protected function __construct() {
		$this->context = new ApiContext(
			new OAuthTokenCredential(
				Settings::get_sandbox_apikey(), // ClientID
				Settings::get_sandbox_secret()  // ClientSecret
			)
		);
		$this->set_config( 'sandbox' );
	}

	public function set_live() {
		$this->context = new ApiContext(
			new OAuthTokenCredential(
				Settings::get_apikey(), // ClientID
				Settings::get_secret()  // ClientSecret
			)
		);
		$this->set_config( 'live' );
	}

	public function set_config( $mode ) {
		if ( is_a( $this->context, '\PayPal\Rest\ApiContext' ) ) {
			$this->context->setConfig(
				[
					'mode' => $mode,
				]
			);
		}
	}

	/**
	 * @param $data_object \Caldera_Forms_Processor_Get_Data
	 *
	 * @return string
	 */
	public function prepare_currency( $data_object ) {
		if ( null !== $data_object->get_value( 'cf-paypal-pro-currency' ) ) {
			return $data_object->get_value( 'cf-paypal-pro-currency' );
		}

		return 'USD';
	}

	public function prepare_expiration_year( $year ) {
		$size = strlen( $year );
		if ( $size === 2 ) {
			return '20' . $year;
		}

		return $year;
	}

	public function get_context() {
		return $this->context;
	}

	public static function instance() {
		if ( ! self::$instance ) {
			self::$instance = new self;
		}
		return self::$instance;
	}

}