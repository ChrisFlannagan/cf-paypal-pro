<?php

function cf_paypal_pro_fields() {
	return array(
		array(
			'id'       => 'sandbox',
			'label'    => __( 'Test Mode', 'cf-paypal-pro' ),
			'type'     => 'checkbox',
			'required' => false,
		),
		array(
			'id'       => 'cf-paypal-pro-restOrClassic',
			'label'    => __( 'Which PayPal API?', 'cf-paypal-pro' ),
			'required' => false,
			'type'     => 'dropdown',
			'options'  => array(
				'rest' => __( 'REST API', 'cf-paypal-pro' ),
				'classic'   => __( 'Classic API', 'cf-paypal-pro' ),
			)
		), /** add this when we want to integrate billing
		array(
			'id'       => 'cf-paypal-pro-planOrSingle',
			'label'    => __( 'One time payment or subscription?', 'cf-paypal-pro' ),
			'required' => false,
			'type'     => 'dropdown',
			'options'  => array(
				'charge' => __( 'One Time Payment', 'cf-paypal-pro' ),
				'plan'   => __( 'Subscription Plan', 'cf-paypal-pro' ),
			)
		), **/
		array(
			'id'       => 'cf-paypal-pro-currency',
			'label'    => __( 'Currency', 'cf-paypal-pro' ),
			'required' => false,
			'type'     => 'dropdown',
			'options'  => cf_paypal_pro_currency_codes(),
		),
		array(
			'id'    => 'amount',
			'label' => __( 'Price', 'cf-paypal-pro' ),
			'required' => true,
		),
		array(
			'id'    => 'cardholderFirstName',
			'label' => __( 'Cardholder First Name', 'cf-paypal-pro' ),
			'required' => true,
		),
		array(
			'id'    => 'cardholderLastName',
			'label' => __( 'Cardholder Last Name', 'cf-paypal-pro' ),
			'required' => true,
		),
		array(
			'id'    => 'card_number',
			'label' => __( 'Card Number', 'cf-paypal-pro' ),
			'allow_types' => 'credit_card_number',
			'required' => true,
		),
		array(
			'id'    => 'card_exp',
			'label' => __( 'Expiration Date (mm/yyyy)', 'cf-paypal-pro' ),
			'allow_types' => 'credit_card_exp',
			'required' => true,
		),
		array(
			'id'    => 'card_cvc',
			'label' => __( 'CVV Code', 'cf-paypal-pro' ),
			'allow_types' => 'credit_card_cvc',
			'required' => true,
		),
		array(
			'id'    => 'type_of_card',
			'label' => __( 'Type of Card', 'cf-paypal-pro' ),
			'required' => true,
		),
		array(
			'id'    => 'first_name',
			'label' => __( 'Customer First Name', 'cf-paypal-pro' ),
		),
		array(
			'id'    => 'last_name',
			'label' => __( 'Customer Last Name', 'cf-paypal-pro' ),
		),
		array(
			'id'          => 'customer_email',
			'label'       => __( 'Customer Email', 'cf-paypal-pro' ),
			'allow_types' => 'email',
			'exclude'     => 'system'
		),
		array(
			'id'       => 'card_address',
			'label'    => __( 'Street Address Line 1', 'cf-paypal-pro' ),
			'required' => false,
		),
		array(
			'id'       => 'card_address_2',
			'label'    => __( 'Street Address Line 2', 'cf-paypal-pro' ),
			'required' => false,
		),
		array(
			'id'       => 'card_city',
			'label'    => __( 'City/ Locality', 'cf-paypal-pro' ),
			'required' => false,
		),
		array(
			'id'       => 'card_state',
			'label'    => __( 'State/ Providence/ Region', 'cf-paypal-pro' ),
			'required' => false,
		),
		array(
			'id'       => 'card_zip',
			'label'    => __( 'Zip Code/ Postal Code', 'cf-paypal-pro' ),
			'required' => false,
		),
		array(
			'id'       => 'card_country',
			'label'    => __( 'Country Code', 'cf-paypal-pro' ),
			'desc' => 'PayPal Requires a country code submitted with the credit card billing information.  You can use our pre-built PayPal form template as a start and customize it your way.  Or, create your own form and make sure to include a select field.  We have a country code preset you can use to load the options into your select field.',
			'required' => true,
		),
	);

}


function cf_paypal_pro_example_form( $forms ) {
	$forms['paypal-pro-single'] = array(
		'name'     => __( 'PayPal One Time Payment Form Example', 'cf-paypal-pro' ),
		'template' => include CF_PAYPAL_PRO_PATH . 'includes/templates/paypal-example.php'
	);

	return $forms;

}


function cf_paypal_pro_currency_codes() {
    $currency_codes = wp_cache_get( 'cf_paypal_pro_currency_codes_' . CF_PAYPAL_PRO_VER );

    if ( ! $currency_codes ) {
        $currency_codes = [];
        $string_codes = file_get_contents( CF_PAYPAL_PRO_PATH . 'assets/preset-currency-codes.txt' );
        $codes = explode( "\n", $string_codes );

        foreach ( $codes as $code ) {
	        if ( strpos( $code, '|' ) === false ) {
		        continue;
	        }

            $code = explode( '|', $code );
            $currency_codes[ $code[1] ] = $code[0];
        }
    }

    return $currency_codes;
}

/**
 * @param $transaction \PayPal\Api\Transaction
 *
 * @return array
 */
function cf_paypal_pro_prepare_meta( $transaction ) {
	$meta = [];

	if ( is_a( $transaction, '\PayPal\Api\Transaction' ) ) {

		$meta = [
			'Transaction ID' => $transaction->getInvoiceNumber(),
			'amount' => $transaction->getAmount(),
		];

		$meta[ 'time' ] = time();

	}

	return $meta;
}

/**
 * Show warning if global settings are not available.
 *
 * @since 1.1.0
 */
function cf_paypal_pro_rest_settings_nag() {
	$settings = \CF_PayPal_Pro\Menu\Settings::get_settings();
	?><div id="cf-paypal-pro-rest-nag" style="display:none;"><?php
	if ( empty( $settings[ \CF_PayPal_Pro\Menu\Settings::APIKEY ] ) ||
         empty( $settings[ \CF_PayPal_Pro\Menu\Settings::SECRET ] ) ) {
		?>
        <div class="notice notice-error">
            <p><?php esc_html_e( 'Before using this processor, you must update the PayPal REST API settings in the Caldera Forms PayPal Pro menu.', 'cf-paypal-pro' ); ?></p>
        </div>

		<?php
	}
	?></div><?php
}

/**
 * Show warning if global settings are not available.
 *
 * @since 1.1.0
 */
function cf_paypal_pro_rest_sandbox_settings_nag() {
	$settings = \CF_PayPal_Pro\Menu\Settings::get_settings();
	?><div id="cf-paypal-pro-rest-sandbox-nag" style="display:none;"><?php
	if ( empty( $settings[ \CF_PayPal_Pro\Menu\Settings::SANDBOX_APIKEY ] ) ||
	     empty( $settings[ \CF_PayPal_Pro\Menu\Settings::SANDBOX_SECRET ] ) ) {
		?>
        <div class="notice notice-warning">
            <p><?php esc_html_e( 'Before using this processor in TEST MODE, you must update the PayPal REST API sandbox settings in the Caldera Forms PayPal Pro menu.', 'cf-paypal-pro' ); ?></p>
        </div>

		<?php
	}
	?></div><?php
}

/**
 * Show warning if global settings are not available.
 *
 * @since 1.1.0
 */
function cf_paypal_pro_classic_settings_nag() {
	$settings = \CF_PayPal_Pro\Menu\Settings::get_settings();
	?><div id="cf-paypal-pro-classic-nag" style="display:none;"><?php
	if ( empty( $settings[ \CF_PayPal_Pro\Menu\Settings::USERNAME ] ) ||
         empty( $settings[ \CF_PayPal_Pro\Menu\Settings::PASS ] ) ||
         empty( $settings[ \CF_PayPal_Pro\Menu\Settings::SIGNATURE ] ) ) {
		?>
        <div class="notice notice-error">
            <p><?php esc_html_e( 'Before using this processor, you must update the PayPal Classic API settings in the Caldera Forms PayPal Pro menu.', 'cf-paypal-pro' ); ?></p>
        </div>

		<?php
	}
	?></div><?php
}

/**
 * Show warning if global settings are not available.
 *
 * @since 1.1.0
 */
function cf_paypal_pro_classic_sandbox_settings_nag() {
	$settings = \CF_PayPal_Pro\Menu\Settings::get_settings();
	?><div id="cf-paypal-pro-classic-sandbox-nag" style="display:none;"><?php
	if ( empty( $settings[ \CF_PayPal_Pro\Menu\Settings::SANDBOX_USERNAME ] ) ||
	     empty( $settings[ \CF_PayPal_Pro\Menu\Settings::SANDBOX_PASS ] ) ||
	     empty( $settings[ \CF_PayPal_Pro\Menu\Settings::SANDBOX_SIGNATURE ] ) ) {
		?>
        <div class="notice notice-warning">
            <p><?php esc_html_e( 'Before using this processor in TEST MODE, you must update the PayPal Classic API sandbox settings in the Caldera Forms PayPal Pro menu.', 'cf-paypal-pro' ); ?></p>
        </div>

		<?php
	}
	?></div><?php
}