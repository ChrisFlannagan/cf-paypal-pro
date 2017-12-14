<?php

function cf_paypal_pro_fields() {
	return [
		[
			'id'       => 'sandbox',
			'label'    => __( 'Test Mode', 'cf-paypal-pro' ),
			'type'     => 'checkbox',
			'required' => false,
		],
		[
			'id'       => 'cf-paypal-pro-restOrClassic',
			'label'    => __( 'Which PayPal API?', 'cf-paypal-pro' ),
			'required' => false,
			'type'     => 'dropdown',
			'options'  => [
				'rest'        => __( 'REST API', 'cf-paypal-pro' ),
				'classic'     => __( 'Classic API', 'cf-paypal-pro' ),
				'payflow-rec' => __( 'PayFlow Recurring', 'cf-paypal-pro' ),
				'payflow'     => __( 'PayFlow One Time Payment', 'cf-paypal-pro' ),
			],
		],
		[
			'id'       => 'cf-paypal-pro-recurringPeriod',
			'label'    => __( 'Recurring Period', 'cf-paypal-pro' ),
			'required' => false,
			'type'     => 'dropdown',
			'options'  => [
				'WEEK' => __( 'Weekly', 'cf-paypal-pro' ),
				'BIWK' => __( 'Bi-Weekly', 'cf-paypal-pro' ),
				'SMMO' => __( 'Semi-Monthly', 'cf-paypal-pro' ),
				'MONT' => __( 'Monthly', 'cf-paypal-pro' ),
				'QTER' => __( 'Quarterly', 'cf-paypal-pro' ),
				'SMYR' => __( 'Semi-Annually', 'cf-paypal-pro' ),
				'YEAR' => __( 'Annually', 'cf-paypal-pro' ),
			],
		],
		[
			'id'       => 'cf-paypal-pro-currency',
			'label'    => __( 'Currency', 'cf-paypal-pro' ),
			'required' => false,
			'type'     => 'dropdown',
			'options'  => [
				'USD' => __( 'USD', 'cf-paypal-pro' ),
				'CAD' => __( 'CAD', 'cf-paypal-pro' ),
				'EUR' => __( 'EUR', 'cf-paypal-pro' ),
				'GBP' => __( 'GBP', 'cf-paypal-pro' ),
				'JPY' => __( 'JPY', 'cf-paypal-pro' ),
				'AUD' => __( 'AUD', 'cf-paypal-pro' ),
			],
		],
		[
			'id'       => 'amount',
			'label'    => __( 'Price', 'cf-paypal-pro' ),
			'required' => true,
		],
		[
			'id'       => 'cardholderFirstName',
			'label'    => __( 'Cardholder First Name', 'cf-paypal-pro' ),
			'required' => true,
		],
		[
			'id'       => 'cardholderLastName',
			'label'    => __( 'Cardholder Last Name', 'cf-paypal-pro' ),
			'required' => true,
		],
		[
			'id'          => 'card_number',
			'label'       => __( 'Card Number', 'cf-paypal-pro' ),
			'allow_types' => 'credit_card_number',
			'required'    => true,
		],
		[
			'id'          => 'card_exp',
			'label'       => __( 'Expiration Date (mm/yyyy)', 'cf-paypal-pro' ),
			'allow_types' => 'credit_card_exp',
			'required'    => true,
		],
		[
			'id'          => 'card_cvc',
			'label'       => __( 'CVV Code', 'cf-paypal-pro' ),
			'allow_types' => 'credit_card_cvc',
			'required'    => true,
		],
		[
			'id'       => 'type_of_card',
			'label'    => __( 'Type of Card', 'cf-paypal-pro' ),
			'required' => true,
		],
		[
			'id'    => 'first_name',
			'label' => __( 'Customer First Name', 'cf-paypal-pro' ),
		],
		[
			'id'    => 'last_name',
			'label' => __( 'Customer Last Name', 'cf-paypal-pro' ),
		],
		[
			'id'          => 'customer_email',
			'label'       => __( 'Customer Email', 'cf-paypal-pro' ),
			'allow_types' => 'email',
			'exclude'     => 'system'
		],
		[
			'id'       => 'card_address',
			'label'    => __( 'Street Address Line 1', 'cf-paypal-pro' ),
			'required' => false,
		],
		[
			'id'       => 'card_address_2',
			'label'    => __( 'Street Address Line 2', 'cf-paypal-pro' ),
			'required' => false,
		],
		[
			'id'       => 'card_city',
			'label'    => __( 'City/ Locality', 'cf-paypal-pro' ),
			'required' => false,
		],
		[
			'id'       => 'card_state',
			'label'    => __( 'State/ Providence/ Region', 'cf-paypal-pro' ),
			'required' => false,
		],
		[
			'id'       => 'card_zip',
			'label'    => __( 'Zip Code/ Postal Code', 'cf-paypal-pro' ),
			'required' => false,
		],
		[
			'id'       => 'card_country',
			'label'    => __( 'Country Code', 'cf-paypal-pro' ),
			'desc' => 'PayPal Requires a country code submitted with the credit card billing information.  You can use our pre-built PayPal form template as a start and customize it your way.  Or, create your own form and make sure to include a select field.  We have a country code preset you can use to load the options into your select field.',
			'required' => true,
		],
	];

}


function cf_paypal_pro_example_form( $forms ) {
	$forms['paypal-pro-single'] = [
		'name'     => __( 'PayPal One Time Payment Form Example', 'cf-paypal-pro' ),
		'template' => include CF_PAYPAL_PRO_PATH . 'includes/templates/paypal-example.php'
	];

	$forms['paypal-pro-subscription'] = [
		'name'     => __( 'PayPal Subscription Payment Form Example', 'cf-paypal-pro' ),
		'template' => include CF_PAYPAL_PRO_PATH . 'includes/templates/subscription-example.php'
	];

	return $forms;

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
			'amount'         => $transaction->getAmount(),
		];

		$meta['time'] = time();

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
	?>
    <div id="cf-paypal-pro-rest-nag" style="display:none;"><?php
	if ( empty( $settings[ \CF_PayPal_Pro\Menu\Settings::APIKEY ] ) ||
	     empty( $settings[ \CF_PayPal_Pro\Menu\Settings::SECRET ] )
	) {
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
	?>
    <div id="cf-paypal-pro-classic-nag" style="display:none;"><?php
	if ( empty( $settings[ \CF_PayPal_Pro\Menu\Settings::USERNAME ] ) ||
	     empty( $settings[ \CF_PayPal_Pro\Menu\Settings::PASS ] ) ||
	     empty( $settings[ \CF_PayPal_Pro\Menu\Settings::SIGNATURE ] )
	) {
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
 * @since 1.0.1
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

/**
 * Show warning if global settings are not available.
 *
 * @since 1.1.0
 */

function cf_paypal_pro_payflow_settings_nag() {
	$settings = \CF_PayPal_Pro\Menu\Settings::get_settings();
	?>
    <div id="cf-paypal-pro-payflow-nag" style="display:none;"><?php
	if ( empty( $settings[ \CF_PayPal_Pro\Menu\Settings::PARTNER ] ) ||
	     empty( $settings[ \CF_PayPal_Pro\Menu\Settings::VENDOR ] ) ||
	     empty( $settings[ \CF_PayPal_Pro\Menu\Settings::USER ] ) ||
	     empty( $settings[ \CF_PayPal_Pro\Menu\Settings::PASS ] )
	) {
		?>
        <div class="notice notice-error">
            <p><?php esc_html_e( 'Before using this processor, you must update the PayPal PayFlow API settings in the Caldera Forms PayPal Pro menu.', 'cf-paypal-pro' ); ?></p>
        </div>

		<?php
	}
	?></div><?php
}