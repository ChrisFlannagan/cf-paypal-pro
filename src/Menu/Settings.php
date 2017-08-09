<?php

namespace CF_PayPal_Pro\Menu;

class Settings {

	protected static $key = '_caldera_forms_paypal_pro';

	protected static function defaults() {
		return array(
			'apikey' => '',
			'secret' => '',
		);
	}

	public static function get_apikey(){
		$settings = self::prepare( get_option( self::$key, array() ) );
		return $settings[ 'apikey' ];
	}

	public static function get_secret(){
		$settings = self::get_settings();
		return $settings[ 'secret' ];
	}

	public static function save_apikey( $ua ){
		$settings = self::get_settings();
		$settings[ 'apikey' ] = strip_tags( $ua );
		update_option( self::$key, $settings );
	}

	public static function save_secret( $secret ){
		$settings = self::get_settings();
		$settings[ 'secret' ] = strip_tags( $secret );
		update_option( self::$key, $settings );
	}

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