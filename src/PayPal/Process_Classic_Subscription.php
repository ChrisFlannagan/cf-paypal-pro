<?php

/**
 * Sample: https://github.com/paypal/merchant-sdk-php/blob/master/samples/RecurringPayments/CreateRecurringPaymentsProfile.php
 */

namespace CF_PayPal_Pro\PayPal;

use PayPal\CoreComponentTypes\BasicAmountType;
use PayPal\EBLBaseComponents\ActivationDetailsType;
use PayPal\EBLBaseComponents\AddressType;
use PayPal\EBLBaseComponents\BillingPeriodDetailsType;
use PayPal\EBLBaseComponents\CreateRecurringPaymentsProfileRequestDetailsType;
use PayPal\EBLBaseComponents\CreditCardDetailsType;
use PayPal\EBLBaseComponents\RecurringPaymentsProfileDetailsType;
use PayPal\EBLBaseComponents\ScheduleDetailsType;
use PayPal\PayPalAPI\CreateRecurringPaymentsProfileReq;
use PayPal\PayPalAPI\CreateRecurringPaymentsProfileRequestType;
use PayPal\Service\PayPalAPIInterfaceServiceService;

class Process_Classic_Subscription {

	public static function do_payment( array $config, array $form, $proccesid, \Caldera_Forms_Processor_Get_Data $data_object ) {
		global $transdata;

		$auth = Api_Classic::instance();
		if ( ! $data_object->get_value( 'sandbox' ) ) {
			$auth->set_live();
		}
		$currency   = $auth->prepare_currency( $data_object );
		$expiration = $auth->prepare_expiration( $data_object->get_value( 'card_exp' ) );

		$RPProfileDetails                   = new RecurringPaymentsProfileDetailsType();
		$RPProfileDetails->SubscriberName   = $data_object->get_value( 'cardholderFirstName' ) . ' ' . $data_object->get_value( 'cardholderLastName' );
		$RPProfileDetails->BillingStartDate = date( DATE_ATOM );

		$activationDetails                = new ActivationDetailsType();
		$activationDetails->InitialAmount = new BasicAmountType( $currency, $data_object->get_value( 'amount' ) );

		$paymentBillingPeriod                     = new BillingPeriodDetailsType();
		$paymentBillingPeriod->BillingFrequency   = '1';
		$paymentBillingPeriod->BillingPeriod      = 'Month';
		$paymentBillingPeriod->Amount             = new BasicAmountType( $currency, $data_object->get_value( 'amount' ) );

		$scheduleDetails = new ScheduleDetailsType();
		$scheduleDetails->Description = "Name of Caldera Form Here";
		$scheduleDetails->ActivationDetails = $activationDetails;
		$scheduleDetails->PaymentPeriod = $paymentBillingPeriod;

		$createRPProfileRequestDetail = new CreateRecurringPaymentsProfileRequestDetailsType();

		$creditCard = new CreditCardDetailsType();
		$creditCard->CreditCardNumber = preg_replace( "/[^0-9]/", "", $data_object->get_value( 'card_number' ) );
		$creditCard->CreditCardType = $auth->prepare_card_type( $data_object->get_value( 'type_of_card' ) );
		$creditCard->CVV2 = $data_object->get_value( 'card_cvc' );
		$creditCard->ExpMonth = $expiration['month'];
		$creditCard->ExpYear = $expiration['year'];
		$createRPProfileRequestDetail->CreditCard = $creditCard;

		$createRPProfileRequestDetail->ScheduleDetails = $scheduleDetails;
		$createRPProfileRequestDetail->RecurringPaymentsProfileDetails = $RPProfileDetails;
		$createRPProfileRequest = new CreateRecurringPaymentsProfileRequestType();
		$createRPProfileRequest->CreateRecurringPaymentsProfileRequestDetails = $createRPProfileRequestDetail;
		$createRPProfileReq =  new CreateRecurringPaymentsProfileReq();
		$createRPProfileReq->CreateRecurringPaymentsProfileRequest = $createRPProfileRequest;

		$paypalService = new PayPalAPIInterfaceServiceService( $auth->get_config() );

		try {

			/** @var $createRPProfileResponse \PayPal\PayPalAPI\CreateRecurringPaymentsProfileResponseType */
			$createRPProfileResponse = $paypalService->CreateRecurringPaymentsProfile( $createRPProfileReq );

			$messages = $createRPProfileResponse->Errors;
			if ( is_array( $messages ) && ! empty( $messages ) ) {
				foreach ( $messages as $message ) {
					$data_object->add_error( __( $message->LongMessage, 'cf-paypal-pro' ) );
				}
			}

		} catch ( \PayPal\Exception\PayPalConnectionException $ex ) {
			$data_object->add_error( __( 'There Was An Error With Your Card Or Billing Information', 'cf-paypal-pro' ) );
		}


		if ( isset( $createRPProfileResponse ) ) {
			$transdata[ $proccesid ]['meta'] = [ 'Transaction ID' => $createRPProfileResponse->TransactionID ];
		} else {
			$data_object->add_error( __( 'Your Card Was Not Approved', 'cf-paypal-pro' ) );
		}


		return $data_object;
	}

}