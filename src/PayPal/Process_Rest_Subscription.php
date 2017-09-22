<?php

namespace CF_PayPal_Pro\PayPal;

use PayPal\Api\ChargeModel;
use PayPal\Api\Currency;
use PayPal\Api\MerchantPreferences;
use PayPal\Api\PaymentDefinition;
use PayPal\Api\Plan;

class Process_Rest_Subscription {

	public static function do_payment( array $config, array $form, $proccesid, \Caldera_Forms_Processor_Get_Data $data_object ) {
		global $transdata;

		$auth = Api_Context::instance();
		if ( ! $data_object->get_value( 'sandbox' ) ) {
			$auth->set_live();
		}

		$plan = new Plan();
		$order_id = uniqid();

		//TODO Possibly add subscription/biling option

		try {

			$payment->create( $auth->get_context() );

			if ( 'approved' == $payment->getState() ) {
				$transdata[ $proccesid ]['meta'] = cf_paypal_pro_prepare_meta( $payment->getTransactions()[0] );
				do_action( 'cf_paypal_pro_success', $payment, $order_id, $transaction, $config, $form, $proccesid );
			} else {
				$data_object->add_error( __( 'Your Card Was Not Approved', 'cf-paypal-pro' ) );
			}

		} catch ( PayPalConnectionException $ex ) {
			$data_object->add_error( __( 'There Was An Error With Your Card Or Billing Information', 'cf-paypal-pro' ) );
		}


		return $data_object;
	}

}