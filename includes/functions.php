<?php

function cf_paypal_pro_fields(){
	return array(
		array(
			'id'       => 'sandbox',
			'label'    => __( 'Test Mode', 'cf-paypal-pro' ),
			'type'     => 'checkbox',
			'required' => false,
		),
		array(
			'id'    => 'paypal_merchant_id',
			'label' => __( 'Merchant ID', 'cf-paypal-pro' ),
			'desc'  => __( 'Enter your unique merchant ID (found on the portal under API Keys when you first login).', 'cf-braintree' ),
			'type'  => 'text',
			'magic' => false,
		),
		array(
			'id'    => 'paypal_rest_api_key',
			'label' => __( 'Rest API Key', 'cf-paypal-pro' ),
			'desc'  => __( 'Enter Your API Key', 'cf-braintree' ),
			'type'  => 'text',
			'magic' => false,
		),
		array(
			'id'    => 'paypal_rest_api_secret',
			'label' => __( 'Rest API Secret', 'cf-paypal-pro' ),
			'desc'  => __( 'Enter your API Secret', 'cf-braintree' ),
			'type'  => 'text',
			'magic' => false,
		),
	);

}


/**
 * Show warning if global settings are not available.
 *
 * @since 1.1.0
 */
function cf_ppp_settings_nag(){
	$settings = \CF_PayPal_Pro\Menu\Settings::get_settings();
	if ( empty( $settings[ 'apikey' ] ) || empty( $settings[ 'secret' ] ) ) {
		?>
		<div class="notice notice-error">
			<p><?php esc_html_e( 'Before using this processor, you must set the API Key and Secret in the Caldera Forms PayPal Pro menu.', 'cf-paypal-pro' ); ?></p>
		</div>

		<?php
	}
}