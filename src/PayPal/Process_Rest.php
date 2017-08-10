<?php

namespace CF_PayPal_Pro\PayPal;

use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\FundingInstrument;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\PaymentCard;
use PayPal\Api\Transaction;

class Process_Rest {

	public static function do_payment( array $config, array $form, $proccesid, \Caldera_Forms_Processor_Get_Data $data_object ) {
		global $transdata;

		$auth = Api_Context::instance();
		if ( ! $data_object->get_value( 'sandbox' ) ) {
			$auth->set_live();
		}

		$card = new PaymentCard();
		$card->setType( $data_object->get_value( 'type_of_card' ) )
		     ->setNumber( preg_replace("/[^0-9]/","", $data_object->get_value( 'card_number' ) ) )
		     ->setExpireMonth( $data_object->get_value( 'card_exp_month' ) )
		     ->setExpireYear( '20' . $data_object->get_value( 'card_exp_year' ) )
		     ->setCvv2( '20' . $data_object->get_value( 'card_exp_year' ) )
		     ->setFirstName( $data_object->get_value( 'cardholderFirstName' ) )
		     ->setLastName( $data_object->get_value( 'cardholderLastName' ) );

		$fi = new FundingInstrument();
		$fi->setPaymentCard( $card );

		$payer = new Payer();
		$payer->setPaymentMethod( "credit_card" )
		      ->setFundingInstruments( array( $fi ) );

		$item1 = new Item();
		$item1->setName( 'Ground Coffee 40 oz' )
		      ->setDescription( 'Ground Coffee 40 oz' )
		      ->setCurrency( 'USD' )
		      ->setQuantity( 1 )
		      ->setTax( 0.3 )
		      ->setPrice( 7.50 );

		/** $item2
		 * $item2 = new Item();
		 * $item2->setName('Granola bars')
		 * ->setDescription('Granola Bars with Peanuts')
		 * ->setCurrency('USD')
		 * ->setQuantity(5)
		 * ->setTax(0.2)
		 * ->setPrice(2);
		 **/

		$itemList = new ItemList();
		$itemList->setItems( array( $item1 /*, $item2 */ ) );

		$details = new Details();
		$details->setShipping( 1.2 )
		        ->setTax( 1.3 )
		        ->setSubtotal( 17.5 );

		$amount = new Amount();
		$amount->setCurrency( "USD" )
		       ->setTotal( 20 )
		       ->setDetails( $details );

		$transaction = new Transaction();
		$transaction->setAmount( $amount )
		            ->setItemList( $itemList )
		            ->setDescription( "Payment description" )
		            ->setInvoiceNumber( uniqid() );

		$payment = new Payment();
		$payment->setIntent( "sale" )
		        ->setPayer( $payer )
		        ->setTransactions( array( $transaction ) );

		try {
			$payment->create( $auth->get_context() );
			$transdata[ $proccesid ][ 'meta' ] = cf_ppp_prepare_meta( $payment );
		} catch ( \Exception $ex ) {

		}


		return $data_object;
	}

}