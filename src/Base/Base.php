<?php

namespace CF_PayPal_Pro\Base;

class Base extends \Caldera_Forms_Processor_Payment implements \Caldera_Forms_Processor_Interface_Payment {

	public function pre_processor( array $config, array $form, $proccesid ) {
		return [];
	}

	public function processor( array $config, array $form, $proccesid ) {
		return [];
	}

	public function do_payment( array $config, array $form, $proccesid, \Caldera_Forms_Processor_Get_Data $data_object ) {
		return [];
	}

}
