<?php

namespace CF_PayPal_Pro\Base;

use CF_PayPal_Pro\PayPal\Process_Rest;
use CF_PayPal_Pro\PayPal\Process_Classic;

/**
 * Class Base
 * @package CF_PayPal_Pro\Base
 */
class Base extends \Caldera_Forms_Processor_Payment implements \Caldera_Forms_Processor_Interface_Payment {

	/**
	 * @param array $config
	 * @param array $form
	 * @param string $proccesid
	 *
	 * @return array|null
	 */
	public function pre_processor( array $config, array $form, $proccesid ) {

		$this->set_data_object_initial( $config, $form );

		$values = $this->data_object->get_values();

		if ( ! $values['sandbox'] && ! is_ssl() ) {
			$this->data_object->add_error( __( 'Payment was not be processed over HTTP.', 'cf-paypal-pro' ) );
		}

		$errors = $this->data_object->get_errors();
		if ( ! empty( $errors ) ) {
			return $errors;
		}


		$this->data_object = $this->do_payment( $config, $form, $proccesid, $this->data_object );
		$this->setup_transata( $proccesid );
		$errors = $this->data_object->get_errors();
		if ( ! empty( $errors ) ) {
			return $errors;

		}

	}

	/**
	 * @param array $config
	 * @param array $form
	 * @param string $proccesid
	 *
	 * @return mixed
	 */
	public function processor( array $config, array $form, $proccesid ) {
		$this->setup_transata( $proccesid );
		if ( ! is_object( $this->data_object ) ) {

		}

		$data   = $this->data_object->get_values();
		$fields = $this->data_object->get_fields();

		if ( isset( $config['card_number'] ) && ! empty( $config['card_number'] ) ) {

			$number = $data['card_number'];
			$number = $number = substr( $number, 0, 4 ) . str_repeat( 'X', strlen( $number ) - 4 );
			$field  = $fields['card_number']['config_field'];
			if ( $field ) {
				\Caldera_Forms::set_field_data( $field, $number, $form );
			}
		}

		if ( isset( $config['card_cvc'] ) && ! empty( $config['card_cvc'] ) ) {
			$number = str_repeat( 'X', strlen( $data['card_cvc'] ) );
			$field  = $fields['card_cvc']['config_field'];
			if ( $field ) {
				\Caldera_Forms::set_field_data( $field, $number, $form );
			}
		}

		if ( isset( $config['card_exp_month'] ) && ! empty( $config['card_exp_month'] ) ) {
			$number = 'xx';
			$field  = $fields['card_exp_month']['config_field'];
			if ( $field ) {
				\Caldera_Forms::set_field_data( $field, $number, $form );
			}
		}

		if ( isset( $config['card_exp_year'] ) && ! empty( $config['card_exp_year'] ) ) {
			$number = 'xx';
			$field  = $fields['card_exp_year']['config_field'];
			if ( $field ) {
				\Caldera_Forms::set_field_data( $field, $number, $form );
			}
		}

		if ( ! isset( $transdata[ $proccesid ]['meta'] ) ) {
			$transdata[ $proccesid ]['meta'] = array();
		}

		return $transdata[ $proccesid ]['meta'];
	}

	public function do_payment( array $config, array $form, $proccesid, \Caldera_Forms_Processor_Get_Data $data_object ) {
		if( 'rest' == $data_object->get_value( 'cf-braintree-restOrClassic' ) ){
			return Process_Rest::do_payment( $config, $form, $proccesid, $data_object );
		} else {
			return Process_Classic::do_payment( $config, $form, $proccesid, $data_object );
		}
	}

}