<?php

namespace CF_PayPal_Pro\PayPal;

use CF_PayPal_Pro\Menu\Settings;

class Api_Classic {

	protected static $instance;
	private $config;

	protected function __construct() {
		$this->config = [
			'acct1.UserName' => Settings::get_classic_sandbox_username(),
			'acct1.Password' => Settings::get_classic_sandbox_pass(),
			'acct1.Signature' => Settings::get_classic_sandbox_signature(),
		];
		$this->set_config( 'sandbox' );
	}

	public function set_live() {
		$this->config = [
			'mode' => 'sandbox',
			'acct1.UserName' => Settings::get_classic_username(),
			'acct1.Password' => Settings::get_classic_pass(),
			'acct1.Signature' => Settings::get_classic_signature(),
		];
		$this->set_config( 'live' );
	}

	public function set_config( $mode ) {
		if ( is_array( $this->config ) ) {
			$this->config['mode'] = $mode;
		}
	}

	public function get_config() {
		return $this->config;
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

	public function prepare_card_type( $card_type ) {
		$card_type = strtolower( $card_type );
		switch ( $card_type ) {
			case 'visa' :
				return 'Visa';
				break;
			case 'mastercard' :
				return 'MasterCard';
				break;
			case 'discover' :
				return 'Discover';
				break;
			case 'amex' :
				return 'Amex';
				break;
		}
	}

	public function prepare_expiration_year( $year ) {
		$size = strlen( $year );
		if ( $size === 2 ) {
			return '20' . $year;
		}

		return $year;
	}

	public static function instance() {
		if ( ! self::$instance ) {
			self::$instance = new self;
		}
		return self::$instance;
	}

}