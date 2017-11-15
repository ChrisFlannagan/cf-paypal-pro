<?php

namespace CF_PayPal_Pro\Base;

use CF_PayPal_Pro\PayPal\Process_Rest;
use CF_PayPal_Pro\PayPal\Process_Classic;
use CF_PayPal_Pro\PayPal\Process_PayFlow;

/**
 * Class Base
 * @package CF_PayPal_Pro\Base
 */
class Base extends \Caldera_Forms_Processor_Payment implements \Caldera_Forms_Processor_Interface_Payment {

	private $optional_data;

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
		global $transdata;

		if ( ! isset( $transdata[ $proccesid ]['meta'] ) ) {
			$transdata[ $proccesid ]['meta'] = $this->optional_data;
		}

		return $this->optional_data;
	}

	/**
	 * @param array $config
	 * @param array $form
	 * @param string $proccesid
	 * @param \Caldera_Forms_Processor_Get_Data $data_object
	 *
	 * @return \Caldera_Forms_Processor_Get_Data
	 */
	public function do_payment( array $config, array $form, $proccesid, \Caldera_Forms_Processor_Get_Data $data_object ) {
		$method = $data_object->get_value( 'cf-paypal-pro-restOrClassic' );
		$return = null;

		if( 'rest' === $method ) {
			$this->optional_data = [];
			return Process_Rest::do_payment( $config, $form, $proccesid, $data_object );
		}

		if( 'classic' === $method ) {
			$this->optional_data = [];
			return Process_Classic::do_payment( $config, $form, $proccesid, $data_object );
		}

		if ( 'payflow' === $method || 'payflow-rec' === $method ) {
			$process_data = Process_PayFlow::do_payment( $config, $form, $proccesid, $data_object );
			$this->optional_data = $process_data['meta'];
			return $process_data['data_object'];
		}

		return null;
	}

}