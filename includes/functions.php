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
				'rest'    => __( 'REST API', 'cf-paypal-pro' ),
				'classic' => __( 'Classic API', 'cf-paypal-pro' ),
				'payflow' => __( 'PayFlow Subscription', 'cf-paypal-pro' ),
			)
		),
		array(
			'id'       => 'cf-paypal-pro-currency',
			'label'    => __( 'Currency', 'cf-paypal-pro' ),
			'required' => false,
			'type'     => 'dropdown',
			'options'  => array(
				'USD' => __( 'USD', 'cf-paypal-pro' ),
				'CAD' => __( 'CAD', 'cf-paypal-pro' ),
				'EUR' => __( 'EUR', 'cf-paypal-pro' ),
				'GBP' => __( 'GBP', 'cf-paypal-pro' ),
				'JPY' => __( 'JPY', 'cf-paypal-pro' ),
				'AUD' => __( 'AUD', 'cf-paypal-pro' ),
			)
		),
		array(
			'id'       => 'amount',
			'label'    => __( 'Price', 'cf-paypal-pro' ),
			'required' => true,
		),
		array(
			'id'       => 'cardholderFirstName',
			'label'    => __( 'Cardholder First Name', 'cf-paypal-pro' ),
			'required' => true,
		),
		array(
			'id'       => 'cardholderLastName',
			'label'    => __( 'Cardholder Last Name', 'cf-paypal-pro' ),
			'required' => true,
		),
		array(
			'id'          => 'card_number',
			'label'       => __( 'Card Number', 'cf-paypal-pro' ),
			'allow_types' => 'credit_card_number',
			'required'    => true,
		),
		array(
			'id'          => 'card_exp',
			'label'       => __( 'Expiration Date (mm/yyyy)', 'cf-paypal-pro' ),
			'allow_types' => 'credit_card_exp',
			'required'    => true,
		),
		array(
			'id'          => 'card_cvc',
			'label'       => __( 'CVV Code', 'cf-paypal-pro' ),
			'allow_types' => 'credit_card_cvc',
			'required'    => true,
		),
		array(
			'id'       => 'type_of_card',
			'label'    => __( 'Type of Card', 'cf-paypal-pro' ),
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
			'required' => true,
		),
	);

}


function cf_paypal_pro_example_form( $forms ) {
	$forms['paypal-pro-single'] = array(
		'name'     => __( 'PayPal One Time Payment Form Example', 'cf-paypal-pro' ),
		'template' => include CF_PAYPAL_PRO_PATH . 'includes/templates/paypal-example.php'
	);

	$forms['paypal-pro-subscription'] = array(
		'name'     => __( 'PayPal Subscription Payment Form Example', 'cf-paypal-pro' ),
		'template' => include CF_PAYPAL_PRO_PATH . 'includes/templates/subscription-example.php'
	);

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