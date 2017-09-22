<?php

namespace CF_PayPal_Pro\PayPal;

use PayPal\CoreComponentTypes\BasicAmountType;
use PayPal\EBLBaseComponents\AddressType;
use PayPal\EBLBaseComponents\CreditCardDetailsType;
use PayPal\EBLBaseComponents\DoDirectPaymentRequestDetailsType;
use PayPal\EBLBaseComponents\PayerInfoType;
use PayPal\EBLBaseComponents\PaymentDetailsType;
use PayPal\EBLBaseComponents\PersonNameType;
use PayPal\PayPalAPI\DoDirectPaymentReq;
use PayPal\PayPalAPI\DoDirectPaymentRequestType;
use PayPal\Service\PayPalAPIInterfaceServiceService;

class Process_Classic {

	public static function do_payment( array $config, array $form, $proccesid, \Caldera_Forms_Processor_Get_Data $data_object ) {
		global $transdata;

		$auth = Api_Classic::instance();
		if ( ! $data_object->get_value( 'sandbox' ) ) {
			$auth->set_live();
		}
		$currency = $auth->prepare_currency( $data_object );
		$expiration = $auth->prepare_expiration( $data_object->get_value( 'card_exp' ) );

		$paymentDetails = new PaymentDetailsType();
		$paymentDetails->OrderTotal = new BasicAmountType( (String)$currency, floatval( $data_object->get_value( 'amount' ) ) );

		$personName = new PersonNameType();
		$personName->FirstName = $data_object->get_value( 'cardholderFirstName' );
		$personName->LastName = $data_object->get_value( 'cardholderLastName' );

		$payer = new PayerInfoType();
		$payer->PayerName = $personName;
		$payer->PayerCountry = $data_object->get_value( 'country_code' );

		$cardDetails = new CreditCardDetailsType();
		$cardDetails->CreditCardNumber = preg_replace("/[^0-9]/","", $data_object->get_value( 'card_number' ) );
		$cardDetails->CreditCardType = $auth->prepare_card_type( $data_object->get_value( 'type_of_card' ) );
		$cardDetails->ExpMonth = $expiration['month'];
		$cardDetails->ExpYear = $expiration['year'];
		$cardDetails->CVV2 = $data_object->get_value( 'card_cvc' );
		$cardDetails->CardOwner = $payer;

		$ddReqDetails = new DoDirectPaymentRequestDetailsType();
		$ddReqDetails->CreditCard = $cardDetails;
		$ddReqDetails->PaymentDetails = $paymentDetails;
		$ddReqDetails->PaymentAction = 'Sale';

		$doDirectPaymentReq = new DoDirectPaymentReq();
		$doDirectPaymentReq->DoDirectPaymentRequest = new DoDirectPaymentRequestType($ddReqDetails);

		$paypalService = new PayPalAPIInterfaceServiceService( $auth->get_config() );

		try {

			/** @var $doDirectPaymentResponse \PayPal\PayPalAPI\DoDirectPaymentResponseType */
			$doDirectPaymentResponse = $paypalService->DoDirectPayment($doDirectPaymentReq);

			$messages = $doDirectPaymentResponse->Errors;
			if ( is_array( $messages ) && ! empty( $messages ) ) {
				foreach ( $messages as $message ) {
					$data_object->add_error( __( $message->LongMessage, 'cf-paypal-pro' ) );
				}
			}

		} catch ( \PayPal\Exception\PayPalConnectionException $ex ) {
			$data_object->add_error( __( 'There Was An Error With Your Card Or Billing Information', 'cf-paypal-pro' ) );
		}


		if(isset($doDirectPaymentResponse)) {
			$transdata[ $proccesid ]['meta'] = [ 'Transaction ID' => $doDirectPaymentResponse->TransactionID ];
		} else {
			$data_object->add_error( __( 'Your Card Was Not Approved', 'cf-paypal-pro' ) );
		}


		return $data_object;
	}

}