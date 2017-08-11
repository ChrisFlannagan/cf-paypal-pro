<?php

namespace CF_PayPal_Pro\Menu;

/**
 * Class Settings
 * @package CF_PayPal_Pro\Menu
 */
class Settings {

	/** PayPal Rest */
	const APIKEY = 'apikey';
	const SECRET = 'secret';
	const SANDBOX_APIKEY = 'sandbox_apikey';
	const SANDBOX_SECRET = 'sandbox_secret';

	/** PayPal Classic */
	const USERNAME = 'classic_username';
	const PASS = 'classic_pass';
	const SIGNATURE = 'classic_signature';
	const SANDBOX_USERNAME = 'classic_sandbox_username';
	const SANDBOX_PASS = 'classic_sandbox_pass';
	const SANDBOX_SIGNATURE = 'classic_sandbox_signature';

	protected static $key = '_caldera_forms_paypal_pro';

	protected static function defaults() {
		return array(
			self::APIKEY => '',
			self::SECRET => '',
			self::SANDBOX_APIKEY => '',
			self::SANDBOX_SECRET => '',
			self::USERNAME => '',
			self::PASS => '',
			self::SIGNATURE => '',
			self::SANDBOX_USERNAME => '',
			self::SANDBOX_PASS => '',
			self::SANDBOX_SIGNATURE => '',
		);
	}

	/****************************
	 ** PayPal RESTful API Auth *
	 ****************************/

	public static function get_apikey(){
		$settings = self::prepare( get_option( self::$key, array() ) );
		return $settings[ self::APIKEY ];
	}

	public static function get_secret(){
		$settings = self::get_settings();
		return $settings[ self::SECRET ];
	}

	public static function get_sandbox_apikey(){
		$settings = self::prepare( get_option( self::$key, array() ) );
		return $settings[ self::SANDBOX_APIKEY ];
	}

	public static function get_sandbox_secret(){
		$settings = self::get_settings();
		return $settings[ self::SANDBOX_SECRET ];
	}

	public static function save_apikey( $apikey ){
		$settings = self::get_settings();
		$settings[ self::APIKEY ] = strip_tags( $apikey );
		update_option( self::$key, $settings );
	}

	public static function save_secret( $secret ){
		$settings = self::get_settings();
		$settings[ self::SECRET ] = strip_tags( $secret );
		update_option( self::$key, $settings );
	}

	public static function save_sandbox_apikey( $apikey ){
		$settings = self::get_settings();
		$settings[ self::SANDBOX_APIKEY ] = strip_tags( $apikey );
		update_option( self::$key, $settings );
	}

	public static function save_sandbox_secret( $secret ){
		$settings = self::get_settings();
		$settings[ self::SANDBOX_SECRET ] = strip_tags( $secret );
		update_option( self::$key, $settings );
	}

	/****************************
	 ** Classic PayPal API Auth *
	 ****************************/

	public static function get_classic_username(){
		$settings = self::prepare( get_option( self::$key, array() ) );
		return $settings[ self::USERNAME ];
	}

	public static function get_classic_pass(){
		$settings = self::get_settings();
		return $settings[ self::PASS ];
	}

	public static function get_classic_signature(){
		$settings = self::get_settings();
		return $settings[ self::SIGNATURE ];
	}

	public static function get_classic_sandbox_username(){
		$settings = self::prepare( get_option( self::$key, array() ) );
		return $settings[ self::SANDBOX_USERNAME ];
	}

	public static function get_classic_sandbox_pass(){
		$settings = self::get_settings();
		return $settings[ self::SANDBOX_PASS ];
	}

	public static function get_classic_sandbox_signature(){
		$settings = self::get_settings();
		return $settings[ self::SANDBOX_SIGNATURE ];
	}

	public static function save_classic_username( $username ){
		$settings = self::get_settings();
		$settings[ self::USERNAME ] = strip_tags( $username );
		update_option( self::$key, $settings );
	}

	public static function save_classic_pass( $pass ){
		$settings = self::get_settings();
		$settings[ self::PASS ] = strip_tags( $pass );
		update_option( self::$key, $settings );
	}

	public static function save_classic_signature( $signature ){
		$settings = self::get_settings();
		$settings[ self::SIGNATURE ] = strip_tags( $signature );
		update_option( self::$key, $settings );
	}

	public static function save_classic_sandbox_username( $username ){
		$settings = self::get_settings();
		$settings[ self::SANDBOX_USERNAME ] = strip_tags( $username );
		update_option( self::$key, $settings );
	}

	public static function save_classic_sandbox_pass( $pass ){
		$settings = self::get_settings();
		$settings[ self::SANDBOX_PASS ] = strip_tags( $pass );
		update_option( self::$key, $settings );
	}

	public static function save_classic_sandbox_signature( $signature ){
		$settings = self::get_settings();
		$settings[ self::SANDBOX_SIGNATURE ] = strip_tags( $signature );
		update_option( self::$key, $settings );
	}

	/** General settings methods */

	public static function get_settings(){
		return self::prepare( get_option( self::$key, array() ) );
	}

	protected static function prepare( $values = array( ) ){
		$defaults = self::defaults();
		$values = wp_parse_args( $values, $defaults );
		foreach ( $values as $key => $value ) {
			$values[ $key ] = strip_tags( $values[ $key ] );
		}
		return $values;
	}
}