<?php

namespace CF_PayPal_Pro\PayPal;

use CF_PayPal_Pro\PayFlow\PayFlow;

class Process_PayFlow_Subscription {

	public static function do_payment( array $config, array $form, $proccesid, \Caldera_Forms_Processor_Get_Data $data_object ) {
		global $transdata;

		$auth = Api_Classic::instance();
		$PayFlow = new PayFlow( 'chrisflannagan', 'PayPal', 'chrisflannagan', 'Tolkie#1', 'recurring' );
		$currency   = $auth->prepare_currency( $data_object );

		$PayFlow->setEnvironment( 'TEST' );
		if ( ! $data_object->get_value( 'sandbox' ) ) {
			$PayFlow->setEnvironment( 'live' );
		}
		$PayFlow->setTransactionType( 'R' );
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
		$PayFlow->setCustomerAddress( '589 8th Ave Suite 10' );
		$PayFlow->setCustomerCity( 'New York' );
		$PayFlow->setCustomerState( 'NY' );
		$PayFlow->setCustomerZip( '10018' );
		$PayFlow->setCustomerCountry( 'US' );
		$PayFlow->setCustomerPhone( '212-123-1234' );
		$PayFlow->setCustomerEmail( 'email@gmail.com' );
		$PayFlow->setPaymentComment( "Name of Caldera Form Here" );

		try {

			$process = $PayFlow->processTransaction();

			if ( ! $process ) {
				$data_object->add_error( json_encode( $PayFlow->getResponse() ) );
			}

		} catch ( \Exception $ex ) {
			$data_object->add_error( json_encode( $PayFlow->getResponse() ) );
		}


		$transdata[ $proccesid ]['meta'] = [ 'Transaction ID' => mt_rand() ];

		return $data_object;
	}

}