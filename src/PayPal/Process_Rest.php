<?php

namespace CF_PayPal_Pro\PayPal;

use PayPal\Api\Amount;
use PayPal\Api\FundingInstrument;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\PaymentCard;
use PayPal\Api\Transaction;
use PayPal\Exception\PayPalConnectionException;

class Process_Rest {

	public static function do_payment( array $config, array $form, $proccesid, \Caldera_Forms_Processor_Get_Data $data_object ) {
		global $transdata;

		$auth = Api_Context::instance();
		if ( ! $data_object->get_value( 'sandbox' ) ) {
			$auth->set_live();
		}

		$order_id = uniqid();

		$card = new PaymentCard();
		$card->setType( $data_object->get_value( 'type_of_card' ) )
		     ->setNumber( preg_replace("/[^0-9]/","", $data_object->get_value( 'card_number' ) ) )
		     ->setExpireMonth( $data_object->get_value( 'card_exp_month' ) )
		     ->setExpireYear( '20' . $data_object->get_value( 'card_exp_year' ) )
		     ->setCvv2( $data_object->get_value( 'card_cvc' ) )
		     ->setFirstName( $data_object->get_value( 'cardholderFirstName' ) )
			 ->setBillingCountry( $data_object->get_value( 'card_country' ) )
		     ->setLastName( $data_object->get_value( 'cardholderLastName' ) );

		$fi = new FundingInstrument();
		$fi->setPaymentCard( $card );

		$payer = new Payer();
		$payer->setPaymentMethod( 'credit_card' )
		      ->setFundingInstruments( [ $fi ] );

		$item1 = new Item();
		$item1->setName( $form['name'] )
		      ->setDescription( 'PayPal Credit Card Payment' )
		      ->setCurrency( 'USD' )
		      ->setQuantity( 1 )
		      ->setPrice( floatval( $data_object->get_value( 'amount' ) ) );

		$itemList = new ItemList();
		$itemList->setItems( [ $item1 ] );

		$amount = new Amount();
		$amount->setCurrency( 'USD' )
		       ->setTotal( floatval( $data_object->get_value( 'amount' ) ) );

		$transaction = new Transaction();
		$transaction->setAmount( $amount )
		            ->setItemList( $itemList )
		            ->setDescription( $form['name'] )
		            ->setInvoiceNumber( $order_id );

		$payment = new Payment();
		$payment->setIntent( 'sale' )
		        ->setPayer( $payer )
		        ->setTransactions( [ $transaction ] );

		try {

			$payment->create( $auth->get_context() );

			if ( 'approved' == $payment->getState() ) {
				$transdata[ $proccesid ]['meta'] = cf_ppp_prepare_meta( $payment->getTransactions()[0] );
			} else {
				$data_object->add_error( __( 'Your Card Was Not Approved', 'cf-paypal-pro' ) );
			}

		} catch ( PayPalConnectionException $ex ) {
			$data_object->add_error( __( 'There Was An Error With Your Card Or Billing Information', 'cf-paypal-pro' ) );
		}


		return $data_object;
	}

}