<?php

namespace CF_PayPal_Pro\PayPal;

use CF_PayPal_Pro\PayFlow\PayFlow;
use CF_PayPal_Pro\Menu\Settings;

class Process_PayFlow {

	public static function do_payment( array $config, array $form, $proccesid, \Caldera_Forms_Processor_Get_Data $data_object ) {
		global $transdata;

		$auth     = Api_Classic::instance();

		$vendor = Settings::get_payflow_vendor();
		$partner = Settings::get_payflow_partner();
		$user = Settings::get_payflow_user();
		$pass = Settings::get_payflow_pass();

		$type_transaction = 'recurring';
		if ( $data_object->get_value( 'cf-paypal-pro-restOrClassic' ) === 'payflow' ) {
			$type_transaction = 'single';
		}

		$PayFlow  = new PayFlow(
			$vendor,
			$partner,
			$user,
			$pass,
			$type_transaction
		);

		$currency = $auth->prepare_currency( $data_object );

		$PayFlow->setEnvironment( 'TEST' );
		if ( ! $data_object->get_value( 'sandbox' ) ) {
			$PayFlow->setEnvironment( 'LIVE' );
		}

		$PayFlow->setTransactionType( 'R' );
		if ( $data_object->get_value( 'cf-paypal-pro-restOrClassic' ) === 'payflow' ) {
			$PayFlow->setTransactionType( 'S' );
		}

		$PayFlow->setPaymentMethod( 'C' );
		$PayFlow->setPaymentCurrency( $currency );

		$PayFlow->setProfileAction( 'A' );
		$PayFlow->setProfileName( $data_object->get_value( 'cardholderFirstName' ) . ' ' . $data_object->get_value( 'cardholderLastName' ) );
		$PayFlow->setProfileStartDate( date( 'mdY', strtotime( "+1 day" ) ) );
		$PayFlow->setProfilePayPeriod( 'MONT' );
		$PayFlow->setProfileTerm( 0 );

		$PayFlow->setAmount( $data_object->get_value( 'amount' ), false );
		$PayFlow->setCCNumber( preg_replace( "/[^0-9]/", "", $data_object->get_value( 'card_number' ) ) );
		$PayFlow->setCVV( $data_object->get_value( 'card_cvc' ) );
		$PayFlow->setExpiration( str_replace( '/', '', str_replace( ' ', '', $data_object->get_value( 'card_exp' ) ) ) );
		$PayFlow->setCreditCardName( $data_object->get_value( 'cardholderFirstName' ) . ' ' . $data_object->get_value( 'cardholderLastName' ) );

		$PayFlow->setCustomerFirstName( $data_object->get_value( 'cardholderFirstName' ) );
		$PayFlow->setCustomerLastName( $data_object->get_value( 'cardholderLastName' ) );
		$PayFlow->setCustomerCountry( $data_object->get_value( 'card_country' ) );
		$PayFlow->setCustomerEmail( $data_object->get_value( 'customer_email' ) );
		$PayFlow->setPaymentComment( $form['name'] );

		$response = [];

		try {

			$process = $PayFlow->processTransaction();
			$response = $PayFlow->getResponse();

			if ( ! $process && $response['RESULT'] != '126' ) {
				$data_object->add_error( json_encode( $PayFlow->getResponse() ) );
			}

		} catch ( \Exception $ex ) {
			$data_object->add_error( json_encode( $PayFlow->getResponse() ) );
		}


		$meta = [
			'Transaction Profile ID' => isset( $response['PROFILEID'] ) ? $response['PROFILEID'] : '',
			'Transaction PNREF' => isset( $response['PNREF'] ) ? $response['PNREF'] : '',
			'Transaction RPREF' => isset( $response['RPREF'] ) ? $response['RPREF'] : '',
		];

		return [ 'meta' => $meta, 'data_object' => $data_object ];
	}

}