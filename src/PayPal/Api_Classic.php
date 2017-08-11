<?php

namespace CF_PayPal_Pro\PayPal;

use CF_PayPal_Pro\Menu\Settings;

class Api_Classic {

	protected static $instance;
	private $config;

	protected function __construct() {
		$this->config = [
			'acct1.Username' => Settings::get_classic_sandbox_username(),
			'acct1.Password' => Settings::get_classic_sandbox_pass(),
			'acct1.Signature' => Settings::get_classic_sandbox_signature(),
		];
		$this->set_config( 'sandbox' );
	}

	public function set_live() {
		$this->config = [
			'mode' => 'sandbox',
			'acct1.Username' => Settings::get_classic_username(),
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

	public static function instance() {
		if ( ! self::$instance ) {
			self::$instance = new self;
		}
		return self::$instance;
	}

}