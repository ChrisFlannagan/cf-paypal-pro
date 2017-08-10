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
		),
		array(
			'id'       => 'cf-paypal-pro-planOrSingle',
			'label'    => __( 'One time payment or subscription?', 'cf-paypal-pro' ),
			'required' => false,
			'type'     => 'dropdown',
			'options'  => array(
				'charge' => __( 'One Time Payment', 'cf-paypal-pro' ),
				'plan'   => __( 'Subscription Plan', 'cf-paypal-pro' ),
			)
		),
		array(
			'id'    => 'amount',
			'label' => __( 'Price', 'cf-paypal-pro' ),
		),
		array(
			'id'    => 'cf-paypal-pro-plan-actual',
			'type'  => 'hidden',
			'label' => 'Actual Plan'
		),
		array(
			'id'    => 'cardholderFirstName',
			'label' => __( 'Cardholder First Name', 'cf-paypal-pro' ),
		),
		array(
			'id'    => 'cardholderLastName',
			'label' => __( 'Cardholder Last Name', 'cf-paypal-pro' ),
		),
		array(
			'id'    => 'card_number',
			'label' => __( 'Card Number', 'cf-paypal-pro' ),
		),
		array(
			'id'    => 'card_exp_month',
			'label' => __( 'Expiration Month', 'cf-paypal-pro' ),
		),
		array(
			'id'    => 'card_exp_year',
			'label' => __( 'Expiration Year', 'cf-paypal-pro' ),
		),
		array(
			'id'    => 'card_cvc',
			'label' => __( 'CVV Code', 'cf-paypal-pro' ),
		),
		array(
			'id'    => 'type_of_card',
			'label' => __( 'Type of Card', 'cf-paypal-pro' ),
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


function cf_ppp_example_form( $forms ) {
	$forms['paypal-pro-single'] = array(
		'name'     => __( 'PayPal One Time Payment Form Example', 'cf-paypal-pro' ),
		'template' => include CF_PAYPAL_PRO_PATH . 'includes/templates/paypal-example.php'
	);

	return $forms;

}

function cf_ppp_prepare_meta( $result ) {
	$meta= array();

	if ( is_object( $result ) ) {

		$metas = array(
			'orderID',
			'amount',
			'planID',
			'status',
			'type',
			'merchantAccountId',
			'processorAuthorizationCode'

		);


		foreach( $metas as $key ) {
			if ( array_key_exists( $key, $result->transaction->_attributes) ) {
				$meta[ $key ] = $result->transaction->__get( $key );
			}


		}

		$meta[ 'time' ] = time();

	}

	return $meta;
}

/**
 * Show warning if global settings are not available.
 *
 * @since 1.1.0
 */
function cf_ppp_settings_nag() {
	$settings = \CF_PayPal_Pro\Menu\Settings::get_settings();
	if ( empty( $settings['apikey'] ) || empty( $settings['secret'] ) ) {
		?>
        <div class="notice notice-error">
            <p><?php esc_html_e( 'Before using this processor, you must set the API Key and Secret in the Caldera Forms PayPal Pro menu.', 'cf-paypal-pro' ); ?></p>
        </div>

		<?php
	}
}