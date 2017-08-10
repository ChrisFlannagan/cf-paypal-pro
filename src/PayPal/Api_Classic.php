<?php

namespace CF_PayPal_Pro\PayPal;

use CF_PayPal_Pro\Menu\Settings;

class Api_Classic {

	protected static $instance;
	private $api_context;

	protected function __construct() {

	}

	public static function instance() {
		if ( ! self::$instance ) {
			self::$instance = new self;
		}
		return self::$instance;
	}

}