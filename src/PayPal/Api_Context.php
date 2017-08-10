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
				Settings::get_sandbox_apikey()  // ClientSecret
			)
		);
	}

	public function set_live() {
		$this->context = new ApiContext(
			new OAuthTokenCredential(
				Settings::get_apikey(), // ClientID
				Settings::get_apikey()  // ClientSecret
			)
		);
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