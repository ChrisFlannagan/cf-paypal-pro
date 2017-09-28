<?php

namespace CF_PayPal_Pro\PayPal;

use PayPal\Api\Currency;
use PayPal\Api\MerchantPreferences;
use PayPal\Api\PaymentDefinition;
use PayPal\Api\Plan;
use PayPal\Api\Agreement;
use PayPal\Api\CreditCard;
use PayPal\Api\FundingInstrument;
use PayPal\Api\Payer;
use PayPal\Api\PayerInfo;
use PayPal\Exception\PayPalConnectionException;
use PayPal\Api\Patch;
use PayPal\Api\PatchRequest;
use PayPal\Common\PayPalModel;

class Process_Rest_Subscription {

	public static function do_payment( array $config, array $form, $proccesid, \Caldera_Forms_Processor_Get_Data $data_object ) {
		global $transdata;

		$auth = Api_Context::instance();
		if ( ! $data_object->get_value( 'sandbox' ) ) {
			$auth->set_live();
		}

		$order_id = uniqid();
		$currency = $auth->prepare_currency( $data_object );

		$plan = new Plan();

		$plan->setName( 'T-Shirt of the Month Club Plan' )
		     ->setDescription( 'Template creation.' )
		     ->setType( 'fixed' );

		$paymentDefinition = new PaymentDefinition();

		$paymentDefinition->setName( 'Regular Payments' )
		                  ->setType( 'REGULAR' )
		                  ->setFrequency( 'Month' )
		                  ->setFrequencyInterval( "1" )
		                  ->setCycles( "12" )
		                  ->setAmount( new Currency( array( 'value'    => (float) $data_object->get_value( 'amount' ),
		                                                    'currency' => $currency
		                  ) ) );

		$merchantPreferences = new MerchantPreferences();

		$merchantPreferences->setReturnUrl( site_url() . '?success=true&pid=' . $proccesid )
		                    ->setCancelUrl( site_url() . '?success=false&pid=' . $proccesid )
		                    ->setAutoBillAmount( "yes" )
		                    ->setInitialFailAmountAction( "CONTINUE" )
		                    ->setMaxFailAttempts( "0" );

		$plan->setPaymentDefinitions( array( $paymentDefinition ) );
		$plan->setMerchantPreferences( $merchantPreferences );


		try {

			$plan->create( $auth->get_context() );

			if ( 'CREATED' != $plan->getState() ) {
				$data_object->add_error( __( 'There Was An Error With Your Card Or Billing Information', 'cf-paypal-pro' ) );

				return $data_object;
			}

			try {
				$patch = new Patch();

				$value = new PayPalModel( '{"state":"ACTIVE"}' );

				$patch->setOp( 'replace' )
				      ->setPath( '/' )
				      ->setValue( $value );
				$patchRequest = new PatchRequest();
				$patchRequest->addPatch( $patch );

				$plan->update( $patchRequest, $auth->get_context() );

				$plan = Plan::get( $plan->getId(), $auth->get_context() );
			} catch ( \Exception $ex ) {
				$data_object->add_error( __( 'There Was An Error With Your Card Or Billing Information', 'cf-paypal-pro' ) );

				return $data_object;
			}

		} catch ( PayPalConnectionException $ex ) {
			$data_object->add_error( __( 'There Was An Error With Your Card Or Billing Information', 'cf-paypal-pro' ) );

			return $data_object;
		}

		/**
		 * Now that we have created a billing plan we can setup the agreement and process payment
		 */

		$expiration = $auth->prepare_expiration( $data_object->get_value( 'card_exp' ) );

		$agreement = new Agreement();
		$agreement->setName( 'DPRP' . $order_id )
		          ->setDescription( 'Payment with credit Card' )
		          ->setStartDate( '2019-06-17T9:45:04Z' );

		$new_plan = new Plan();
		$new_plan->setId( $plan->getId() );
		$agreement->setPlan( $new_plan );

		$payer = new Payer();
		$payer->setPaymentMethod( 'credit_card' )
		      ->setPayerInfo( new PayerInfo( array( 'email' => $data_object->get_value( 'customer_email' ) ) ) );

		$card = new CreditCard();

		$card->setType( $data_object->get_value( 'type_of_card' ) )
		     ->setNumber( preg_replace( "/[^0-9]/", "", $data_object->get_value( 'card_number' ) ) )
		     ->setExpireMonth( $expiration['month'] )
		     ->setExpireYear( $expiration['year'] )
		     ->setCvv2( $data_object->get_value( 'card_cvc' ) )
		     ->setFirstName( $data_object->get_value( 'cardholderFirstName' ) )
		     ->setLastName( $data_object->get_value( 'cardholderLastName' ) );

		$fi = new FundingInstrument();
		$fi->setCreditCard( $card );
		$payer->setFundingInstruments( [ $fi ] );

		$agreement->setPayer( $payer );

		try {
			$agreement = $agreement->create( $auth->get_context() );
			$state     = $agreement->getState();
			if ( 'CREATED' == $agreement->getState() ) {
				/**
				 * Update the agreement state to "ACTIVE"
				 */
				$transdata[ $proccesid ]['meta'] = [ 'id'     => $agreement->getId(),
				                                     'amount' => (float) $data_object->get_value( 'amount' )
				];
			} else {
				$data_object->add_error( __( 'Your Card Was Not Approved', 'cf-paypal-pro' ) );
			}

		} catch ( PayPalConnectionException $ex ) {
			$data_object->add_error( __( 'There Was An Error With Your Card Or Billing Information', 'cf-paypal-pro' ) );
		}


		return $data_object;
	}

}