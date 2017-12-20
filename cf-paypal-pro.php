<?php
/**
 * Plugin Name: PayPal Pro for Caldera Forms
 * Description: Accept Credit Card Payments with a PayPal Account Through Caldera Forms
 * Version: 1.0.2
 * Author:      Chris Flannagan
 * Author URI:  https://whoischris.com
 * License:     GPLv2+
 * Text Domain: cf-paypal-pro
 * Domain Path: /languages
 */

/**
 * Copyright (c) 2017 Chris Flanagan
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License, version 2 or, at
 * your discretion, any later version, as published by the Free
 * Software Foundation.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 */

/**
 * Define constants
 */
define( 'CF_PAYPAL_PRO_VER', '1.0.2' );
define( 'CF_PAYPAL_PRO_URL', plugin_dir_url( __FILE__ ) );
define( 'CF_PAYPAL_PRO_PATH', dirname( __FILE__ ) . '/' );
define( 'CF_PAYPAL_PRO_CORE', dirname( __FILE__ )  );

/**
 * Default initialization for the plugin:
 * - Registers the default textdomain.
 */
function cf_paypal_pro_init_text_domain() {
	load_plugin_textdomain( 'cf-paypal-pro', false, CF_PAYPAL_PRO_PATH . 'languages' );
}

add_action( 'plugins_loaded', 'cf_paypal_pro_init' );
function cf_paypal_pro_init() {

	include CF_PAYPAL_PRO_PATH . 'includes/functions.php';

	if ( ! version_compare( PHP_VERSION, '5.3.0', '>=' ) ) {
		if ( is_admin() ) {
			$message = __( sprintf( 'Caldera Forms PayPal Pro requires PHP version 5.3 or later. We strongly recommend PHP 5.6 or later for security and performance reasons. Current version is %2s.',  PHP_VERSION ), 'cf-paypal-pro' );
			echo caldera_warnings_dismissible_notice( $message, true, 'activate_plugins', 'cf-paypal-pro' );
		}
	} else {
		require_once __DIR__ . '/vendor/autoload.php';
		\CF_PayPal_Pro\Util\Init::hook();
		\CF_PayPal_Pro\Menu\Menu::instance();
	}

}

add_filter( 'caldera_forms_field_option_presets', function( $presets ){
	$presets[ 'country-codes-list' ] = [
		'name' => __( 'Billing Country', 'cf-paypal-pro' ),
		'data' => file_get_contents( CF_PAYPAL_PRO_PATH . 'assets/presets-country-codes.txt' ),
	];

	return $presets;
});